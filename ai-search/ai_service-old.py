from flask import Flask, request, jsonify
from sentence_transformers import SentenceTransformer

app = Flask(__name__)
model = SentenceTransformer("all-MiniLM-L6-v2")

@app.route("/ai-search", methods=["POST"])
def ai_search():
    query = request.json.get("query", "")
    embedding = model.encode([query]).tolist()

    # هنا ممكن تضيف matching مع بيانات NASA لو عندك embeddings
    results = [
        {"title": "Amazon 2000", "url": "https://example.com/amazon2000.jpg"},
        {"title": "Amazon 2020", "url": "https://example.com/amazon2020.jpg"}
    ]
    return jsonify({"images": results})

if __name__ == "__main__":
    app.run(port=8000)
