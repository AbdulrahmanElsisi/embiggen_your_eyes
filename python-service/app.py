from flask import Flask, request, jsonify
from ultralytics import YOLO
import os

# 1. نعرف الـ Flask app
app = Flask(__name__)

# 2. نحمل الموديل
model = YOLO("yolov8n.pt")  # موديل خفيف متدرب على COCO (80 كلاس)

UPLOAD_FOLDER = "uploads"
os.makedirs(UPLOAD_FOLDER, exist_ok=True)

# 3. نضيف الـ route
@app.route("/detect", methods=["POST"])
def detect_objects():
    if "image" not in request.files:
        return jsonify({"error": "No image uploaded"}), 400

    file = request.files["image"]
    filepath = os.path.join(UPLOAD_FOLDER, file.filename)
    file.save(filepath)

    # نعمل detection
    results = model.predict(filepath, save=True, save_txt=True, conf=0.25)

    detections = []
    for r in results:
        for box in r.boxes:
            detections.append({
                "class": model.names[int(box.cls)],
                "confidence": float(box.conf),
                "bbox": box.xyxy[0].tolist()
            })

    return jsonify({"detections": detections})

# 4. نشغل السيرفر
if __name__ == "__main__":
    app.run(port=5001, debug=True)
