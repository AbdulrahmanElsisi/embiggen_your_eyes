from flask import Flask, request, jsonify
from ultralytics import YOLO
import cv2
import numpy as np
from io import BytesIO
from PIL import Image
import base64

app = Flask(__name__)
model = YOLO("yolov8n.pt")  # YOLOv8 small model

@app.route("/search", methods=["POST"])
def search_image():
    query = request.form.get("query")
    image_file = request.files.get("image")

    if not query or not image_file:
        return jsonify({"error": "Missing query or image"}), 400

    # افتح الصورة
    img = Image.open(BytesIO(image_file.read())).convert("RGB")
    cv_img = cv2.cvtColor(np.array(img), cv2.COLOR_RGB2BGR)

    # شغّل YOLO detection
    results = model(cv_img)

    output_img = cv_img.copy()
    found = False

    for r in results:
        for box in r.boxes:
            cls_id = int(box.cls[0])
            label = model.names[cls_id]
            if query.lower() in label.lower():  # لو label بيساوي الكلمة المطلوبة
                found = True
                x1, y1, x2, y2 = map(int, box.xyxy[0])
                cv2.rectangle(output_img, (x1, y1), (x2, y2), (0, 255, 0), 3)
                cv2.putText(output_img, label, (x1, y1 - 10),
                            cv2.FONT_HERSHEY_SIMPLEX, 0.9, (0, 255, 0), 2)

    # حول الصورة لـ base64 عشان نرجعها للـ frontend
    _, buffer = cv2.imencode(".jpg", output_img)
    img_base64 = base64.b64encode(buffer).decode("utf-8")

    return jsonify({
        "query": query,
        "found": found,
        "image": img_base64
    })

if __name__ == "__main__":
    app.run(port=8000)
