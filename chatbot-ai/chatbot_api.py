from flask import Flask, request, jsonify
from sentence_transformers import SentenceTransformer
from sklearn.metrics.pairwise import cosine_similarity
from sqlalchemy import create_engine
import pandas as pd
import numpy as np
import json
from flask_cors import CORS
from dotenv import load_dotenv
import os

# ==========================================
# LOAD ENV LARAVEL
# ==========================================
load_dotenv('../.env')

DB_HOST = os.getenv('DB_HOST')
DB_PORT = os.getenv('DB_PORT')
DB_DATABASE = os.getenv('DB_DATABASE')
DB_USERNAME = os.getenv('DB_USERNAME')
DB_PASSWORD = os.getenv('DB_PASSWORD')

DATABASE_URL = (
    f"mysql+pymysql://{DB_USERNAME}:{DB_PASSWORD}"
    f"@{DB_HOST}:{DB_PORT}/{DB_DATABASE}"
)

print("Using database:", DB_DATABASE)

engine = create_engine(DATABASE_URL)

# ==========================================
# FLASK APP
# ==========================================
app = Flask(__name__)
CORS(app)

# ==========================================
# MODEL (FAST + STABLE)
# ==========================================
print("Loading model...")

model = SentenceTransformer('firqaaa/indo-sentence-bert-base')

<<<<<<< Updated upstream
=======
# ==========================================
# WARMUP MODEL
# ==========================================
>>>>>>> Stashed changes
print("Warming up model...")
model.encode("warmup text")
print("Model ready!")

# ==========================================
<<<<<<< Updated upstream
# DATABASE
# ==========================================
DB_USER = "root"
DB_PASS = ""
DB_HOST = "127.0.0.1"
DB_NAME = "db_maw_buket"

engine = create_engine(
    f"mysql+pymysql://{DB_USER}:{DB_PASS}@{DB_HOST}/{DB_NAME}"
)

# ==========================================
# CACHE
=======
# CACHE GLOBAL
>>>>>>> Stashed changes
# ==========================================
faq_cache = None
faq_embeddings_cache = None

# ==========================================
# LOAD FAQ (OPTIMIZED)
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

    df = pd.read_sql(query, engine)

    if df.empty:
        return df, np.array([])

    # parse embedding
    embeddings = np.array(
        df["embedding"].apply(json.loads).tolist(),
        dtype=np.float32
    )

    # NORMALIZE (biar cosine lebih stabil & cepat)
    embeddings = embeddings / np.linalg.norm(embeddings, axis=1, keepdims=True)

    return df, embeddings

# ==========================================
# GET CACHE
# ==========================================
def get_faq():

    global faq_cache
    global faq_embeddings_cache

    if faq_cache is None or faq_embeddings_cache is None:
<<<<<<< Updated upstream
        print("Loading FAQ cache...")
=======

        print("Loading FAQ into cache...")

>>>>>>> Stashed changes
        faq_cache, faq_embeddings_cache = load_faq()

        print("FAQ cached!")

    return faq_cache, faq_embeddings_cache

# ==========================================
# REFRESH CACHE
# ==========================================
def refresh_faq():

    global faq_cache
    global faq_embeddings_cache

    faq_cache, faq_embeddings_cache = load_faq()

# ==========================================
# GENERATE EMBEDDING API
# ==========================================
@app.route('/generate-embedding', methods=['POST'])
def generate_embedding():

    data = request.get_json(force=True)

    question = data['question']

    emb = model.encode(question)
    emb = emb / np.linalg.norm(emb)

    return jsonify({
        'embedding': emb.tolist()
    })

# ==========================================
<<<<<<< Updated upstream
# CHAT ENDPOINT (FAST MODE)
=======
# CHAT API
>>>>>>> Stashed changes
# ==========================================
@app.route('/chat', methods=['POST'])
def chat():
    try:

        data = request.get_json(force=True)

        user_message = data['message']

        faq_df, faq_embeddings = get_faq()

        if len(faq_df) == 0:

            return jsonify({
                'reply': 'FAQ masih kosong.',
                'score': 0
            })

<<<<<<< Updated upstream
        # user embedding
=======
        # embedding user
>>>>>>> Stashed changes
        user_embedding = model.encode(user_message)
        user_embedding = user_embedding / np.linalg.norm(user_embedding)

<<<<<<< Updated upstream
        # cosine similarity (lebih cepat dari sklearn)
        similarities = np.dot(faq_embeddings, user_embedding)
=======
        # similarity
        similarities = cosine_similarity(
            [user_embedding],
            faq_embeddings
        )[0]
>>>>>>> Stashed changes

        best_index = int(np.argmax(similarities))

        best_score = float(similarities[best_index])

        # threshold
<<<<<<< Updated upstream
        if best_score < 0.60:
=======
        if best_score < 0.55:

>>>>>>> Stashed changes
            return jsonify({
                'reply': 'Maaf, saya belum menemukan jawaban yang sesuai.',
                'score': best_score
            })

        answer = faq_df.iloc[best_index]['answer']

        return jsonify({
            'reply': answer,
            'score': best_score
        })

    except Exception as e:

        return jsonify({
            'reply': 'Terjadi kesalahan sistem.',
            'error': str(e)
        })

# ==========================================
<<<<<<< Updated upstream
# REFRESH CACHE
=======
# REFRESH FAQ ENDPOINT
>>>>>>> Stashed changes
# ==========================================
@app.route('/refresh-faq', methods=['POST'])
def refresh():

    refresh_faq()
<<<<<<< Updated upstream
    return jsonify({"message": "FAQ cache refreshed"})
=======

    return jsonify({
        'message': 'FAQ cache refreshed'
    })
>>>>>>> Stashed changes

# ==========================================
<<<<<<< Updated upstream
# PRELOAD SAAT START
# ==========================================
print("Preloading FAQ...")
=======
# PRELOAD CACHE
# ==========================================
print("Preloading FAQ cache...")

>>>>>>> Stashed changes
faq_cache, faq_embeddings_cache = load_faq()

print("FAQ ready in memory!")

# ==========================================
# RUN APP
# ==========================================
<<<<<<< Updated upstream
if __name__ == "__main__":
=======
if __name__ == '__main__':

>>>>>>> Stashed changes
    app.run(
        host="0.0.0.0",
        port=5000,
        debug=True,
<<<<<<< Updated upstream
        use_reloader=False
    )
=======
        host='0.0.0.0',
        port=5000
    )
>>>>>>> Stashed changes
