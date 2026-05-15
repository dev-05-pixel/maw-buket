from flask import Flask, request, jsonify
from sentence_transformers import SentenceTransformer
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
# MODEL
# ==========================================
print("Loading model...")

model = SentenceTransformer('firqaaa/indo-sentence-bert-base')

# ==========================================
# WARMUP MODEL
# ==========================================
print("Warming up model...")

model.encode("warmup text")

print("Model ready!")

# ==========================================
# CACHE GLOBAL
# ==========================================
faq_cache = None
faq_embeddings_cache = None

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

    df = pd.read_sql(query, engine)

    if df.empty:
        return df, np.array([])

    embeddings = np.array(
        df["embedding"].apply(json.loads).tolist(),
        dtype=np.float32
    )

    # normalize embedding
    embeddings = embeddings / np.linalg.norm(
        embeddings,
        axis=1,
        keepdims=True
    )

    return df, embeddings

# ==========================================
# GET CACHE
# ==========================================
def get_faq():

    global faq_cache
    global faq_embeddings_cache

    if faq_cache is None or faq_embeddings_cache is None:

        print("Loading FAQ into cache...")

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

    embedding = model.encode(question)

    embedding = embedding / np.linalg.norm(embedding)

    return jsonify({
        'embedding': embedding.tolist()
    })

# ==========================================
# CHAT API
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

        # embedding user
        user_embedding = model.encode(user_message)

        user_embedding = (
            user_embedding /
            np.linalg.norm(user_embedding)
        )

        # cosine similarity fast mode
        similarities = np.dot(
            faq_embeddings,
            user_embedding
        )

        best_index = int(np.argmax(similarities))

        best_score = float(similarities[best_index])

        # threshold
        if best_score < 0.60:

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
# REFRESH FAQ ENDPOINT
# ==========================================
@app.route('/refresh-faq', methods=['POST'])
def refresh():

    refresh_faq()

    return jsonify({
        'message': 'FAQ cache refreshed'
    })

# ==========================================
# PRELOAD CACHE
# ==========================================
print("Preloading FAQ cache...")

faq_cache, faq_embeddings_cache = load_faq()

print("FAQ ready in memory!")

# ==========================================
# RUN APP
# ==========================================
if __name__ == '__main__':

    app.run(
        host='0.0.0.0',
        port=5000,
        debug=True,
        use_reloader=False
    )
