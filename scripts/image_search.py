# # scripts/image_search.py
# import sys
# import pytesseract
# from PIL import Image

# if len(sys.argv) < 3:
#     print("Usage: image_search.py <image_path> <query>")
#     sys.exit(1)

# image_path = sys.argv[1]
# query = sys.argv[2].lower()

# # قراءة النص من الصورة
# text = pytesseract.image_to_string(Image.open(image_path)).lower()

# # ابحث عن الكلمة
# if query in text:
#     print(f"✅ Found '{query}' in image!")
# else:
#     print(f"❌ '{query}' not found in image.")


from flask import Flask, request, jsonify
from ultralytics import YOLO
import os

app = Flask(__name__)

# Load YOLOv8 model (pretrained on COCO dataset)
model = YOLO("yolov8n.pt")  # النسخة الخفيفة عشان السرعة

UPLOAD_FOLDER = "uploads"
os.makedirs(UPLOAD_FOLDER, exist_ok=True)

@app.route("/detect", methods=["POST"])
def detect_objects():
    if "image" not in request.files:
        return jsonify({"error": "No image uploaded"}), 400

    file = request.files["image"]
    filepath = os.path.join(UPLOAD_FOLDER, file.filename)
    file.save(filepath)

    # Run YOLO detection
    results = model.predict(filepath, save=True, save_txt=True)

    detections = []
    for r in results:
        for box in r.boxes:
            detections.append({
                "class": model.names[int(box.cls)],
                "confidence": float(box.conf),
                "bbox": box.xyxy[0].tolist()
            })

    return jsonify({"detections": detections})

if __name__ == "__main__":
    app.run(port=5001, debug=True)
