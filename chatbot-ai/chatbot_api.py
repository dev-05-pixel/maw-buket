from flask import Flask, request, jsonify
from sentence_transformers import SentenceTransformer
from sqlalchemy import create_engine, text
from sqlalchemy.exc import SQLAlchemyError
from flask_cors import CORS
from dotenv import load_dotenv

import pandas as pd
import numpy as np
import json
import os

# ==========================================
# LOAD ENV
# ==========================================
load_dotenv('/app/.env')
# ==========================================
# APP CONFIG
# ==========================================
APP_ENV = os.getenv('APP_ENV', 'local')

AI_HOST = os.getenv('AI_HOST', '0.0.0.0')

AI_PORT = int(os.getenv('AI_PORT', 5000))

AI_DEBUG = os.getenv(
    'AI_DEBUG',
    'false'
).lower() == 'true'

AI_MODEL = os.getenv(
    'AI_MODEL',
    'firqaaa/indo-sentence-bert-base'
)

AI_THRESHOLD = float(
    os.getenv('AI_THRESHOLD', 0.60)
)

MODEL_INFO_FILE = 'current_model.txt'

# ==========================================
# DATABASE CONFIG
# ==========================================
DB_HOST = os.getenv('DB_HOST', '127.0.0.1')

DB_PORT = os.getenv('DB_PORT', '3306')

DB_DATABASE = os.getenv('DB_DATABASE')

DB_USERNAME = os.getenv('DB_USERNAME')

DB_PASSWORD = os.getenv('DB_PASSWORD')

if not DB_DATABASE:
    raise Exception(
        "DB_DATABASE tidak ditemukan di .env"
    )

DATABASE_URL = (
    f"mysql+pymysql://{DB_USERNAME}:{DB_PASSWORD}"
    f"@{DB_HOST}:{DB_PORT}/{DB_DATABASE}"
)

# ==========================================
# DATABASE ENGINE
# ==========================================
engine = create_engine(
    DATABASE_URL,
    pool_pre_ping=True,
    pool_recycle=3600,
    echo=False
)

# ==========================================
# INFO
# ==========================================
print(f"ENVIRONMENT : {APP_ENV}")
print(f"DATABASE    : {DB_DATABASE}")
print(f"AI MODEL    : {AI_MODEL}")

# ==========================================
# FLASK APP
# ==========================================
app = Flask(__name__)

CORS(app)

# ==========================================
# LOAD MODEL
# ==========================================
print("\nLoading AI model...")

model = SentenceTransformer(AI_MODEL)

print("Warming up model...")

model.encode(
    "warmup text",
    normalize_embeddings=True
)

print("Model ready!\n")

# ==========================================
# GLOBAL CACHE
# ==========================================
faq_df_cache = None

faq_embeddings_cache = None

# ==========================================
# MODEL TRACKING
# ==========================================
def get_saved_model():

    if not os.path.exists(MODEL_INFO_FILE):
        return None

    with open(MODEL_INFO_FILE, 'r') as file:
        return file.read().strip()


def save_current_model():

    with open(MODEL_INFO_FILE, 'w') as file:
        file.write(AI_MODEL)

# ==========================================
# REGENERATE EMBEDDINGS
# ==========================================
def regenerate_all_embeddings():

    print("\n=== REGENERATING EMBEDDINGS ===")

    try:

        query = text("""
            SELECT id, question
            FROM faq_questions
        """)

        with engine.begin() as conn:

            results = conn.execute(query).fetchall()

            total = len(results)

            print(f"Total FAQ: {total}")

            for index, row in enumerate(results, start=1):

                question_id = row[0]

                question = row[1]

                print(f"[{index}/{total}] {question}")

                embedding = model.encode(
                    question,
                    normalize_embeddings=True
                )

                update_query = text("""
                    UPDATE faq_questions
                    SET embedding = :embedding
                    WHERE id = :id
                """)

                conn.execute(
                    update_query,
                    {
                        'embedding': json.dumps(
                            embedding.tolist()
                        ),
                        'id': question_id
                    }
                )

        print("Embedding regeneration complete!\n")

    except Exception as e:

        print(
            "REGENERATE ERROR:",
            str(e)
        )

# ==========================================
# LOAD FAQ
# ==========================================
def load_faq():

    query = """
    SELECT
        faq_questions.id,
        faq_questions.question,
        faq_questions.embedding,
        faq_answers.answer

    FROM faq_questions

    JOIN faq_answers
        ON faq_questions.answer_id = faq_answers.id
    """

    try:

        df = pd.read_sql(query, engine)

        if df.empty:

            print("FAQ kosong")

            return pd.DataFrame(), np.array([])

        valid_rows = []

        valid_embeddings = []

        for _, row in df.iterrows():

            try:

                emb = json.loads(
                    row['embedding']
                )

                if (
                    isinstance(emb, list)
                    and len(emb) > 0
                ):

                    valid_rows.append(row)

                    valid_embeddings.append(emb)

            except Exception:
                continue

        if not valid_embeddings:

            print("Tidak ada embedding valid")

            return pd.DataFrame(), np.array([])

        clean_df = pd.DataFrame(
            valid_rows
        ).reset_index(drop=True)

        embeddings_array = np.array(
            valid_embeddings,
            dtype=np.float32
        )

        print(
            f"Loaded FAQ: {len(clean_df)}"
        )

        print(
            f"Embedding dimension: {embeddings_array.shape}"
        )

        return clean_df, embeddings_array

    except SQLAlchemyError as e:

        print(
            "Database error:",
            str(e)
        )

        return pd.DataFrame(), np.array([])

# ==========================================
# GET CACHE
# ==========================================
def get_faq():

    global faq_df_cache
    global faq_embeddings_cache

    if (
        faq_df_cache is None
        or faq_embeddings_cache is None
    ):

        print("Loading FAQ cache...")

        faq_df_cache, faq_embeddings_cache = load_faq()

        print("FAQ cached!")

    return faq_df_cache, faq_embeddings_cache

# ==========================================
# REFRESH FAQ
# ==========================================
def refresh_faq():

    global faq_df_cache
    global faq_embeddings_cache

    faq_df_cache, faq_embeddings_cache = load_faq()

    print("FAQ cache refreshed!")

# ==========================================
# HEALTH CHECK
# ==========================================
@app.route('/')
def health():

    return jsonify({
        'status': 'running',
        'environment': APP_ENV,
        'model': AI_MODEL,
        'faq_total': (
            len(faq_df_cache)
            if faq_df_cache is not None
            else 0
        )
    })

# ==========================================
# GENERATE EMBEDDING
# ==========================================
@app.route(
    '/generate-embedding',
    methods=['POST']
)
def generate_embedding():

    try:

        data = request.get_json(force=True)

        question = data.get(
            'question',
            ''
        ).strip()

        if not question:

            return jsonify({
                'error': 'Question wajib diisi'
            }), 400

        embedding = model.encode(
            question,
            normalize_embeddings=True
        )

        return jsonify({
            'embedding': embedding.tolist()
        })

    except Exception as e:

        print(
            "EMBEDDING ERROR:",
            str(e)
        )

        return jsonify({
            'error': str(e)
        }), 500

# ==========================================
# CHAT AI
# ==========================================
@app.route(
    '/chat',
    methods=['POST']
)
def chat():

    try:

        data = request.get_json(force=True)

        user_message = data.get(
            'message',
            ''
        ).strip()

        if not user_message:

            return jsonify({
                'reply': 'Pesan tidak boleh kosong.'
            }), 400

        faq_df, faq_embeddings = get_faq()

        if len(faq_df) == 0:

            return jsonify({
                'reply': 'FAQ masih kosong.',
                'score': 0
            })

        user_embedding = model.encode(
            user_message,
            normalize_embeddings=True
        )

        # VALIDASI DIMENSI
        if faq_embeddings.shape[1] != len(user_embedding):

            return jsonify({
                'reply': 'Embedding model tidak cocok. Regenerate diperlukan.',
                'faq_dimension': int(faq_embeddings.shape[1]),
                'user_dimension': int(len(user_embedding))
            }), 500

        similarities = np.dot(
            faq_embeddings,
            user_embedding
        )

        best_index = int(
            np.argmax(similarities)
        )

        best_score = float(
            similarities[best_index]
        )

        if best_score < AI_THRESHOLD:

            return jsonify({
                'reply': 'Maaf, saya belum menemukan jawaban yang sesuai.',
                'score': round(best_score, 4)
            })

        answer = faq_df.iloc[
            best_index
        ]['answer']

        return jsonify({
            'reply': answer,
            'score': round(best_score, 4)
        })

    except Exception as e:

        print(
            "CHAT ERROR:",
            str(e)
        )

        return jsonify({
            'reply': 'Terjadi kesalahan sistem.',
            'error': str(e)
        }), 500

# ==========================================
# REFRESH FAQ CACHE
# ==========================================
@app.route(
    '/refresh-faq',
    methods=['POST']
)
def refresh():

    try:

        refresh_faq()

        return jsonify({
            'message': 'FAQ cache refreshed'
        })

    except Exception as e:

        return jsonify({
            'error': str(e)
        }), 500

# ==========================================
# AUTO DETECT MODEL CHANGE
# ==========================================
saved_model = get_saved_model()

if saved_model != AI_MODEL:

    print("MODEL CHANGED!")
    print(f"OLD MODEL : {saved_model}")
    print(f"NEW MODEL : {AI_MODEL}")

    regenerate_all_embeddings()

    save_current_model()

    print("All embeddings updated!\n")

else:

    print("Model unchanged\n")

# ==========================================
# PRELOAD FAQ
# ==========================================
print("Preloading FAQ cache...")

faq_df_cache, faq_embeddings_cache = load_faq()

print("FAQ ready in memory!\n")

# ==========================================
# RUN APP
# ==========================================
if __name__ == '__main__':

    app.run(
        host=AI_HOST,
        port=AI_PORT,
        debug=AI_DEBUG,
        use_reloader=False,
        threaded=True
    )
