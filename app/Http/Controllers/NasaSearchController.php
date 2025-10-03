# python-scripts/detect.py
from flask import Flask, request, jsonify, send_file
from ultralytics import YOLO
import os
import cv2

app = Flask(__name__)
model = YOLO("yolov8n.pt")  # تأكد ان الموديل موجود
UPLOAD_FOLDER = "uploads"
os.makedirs(UPLOAD_FOLDER, exist_ok=True)
OUTPUT_FOLDER = "outputs"
os.makedirs(OUTPUT_FOLDER, exist_ok=True)

@app.route("/search", methods=["POST"])
def search_object():
    if "image" not in request.files or "object" not in request.form:
        return jsonify({"error": "No image or object specified"}), 400

    file = request.files["image"]
    obj_name = request.form["object"].lower()

    filepath = os.path.join(UPLOAD_FOLDER, file.filename)
    file.save(filepath)

    results = model.predict(filepath, conf=0.25)

    # Load image
    img = cv2.imread(filepath)

    for r in results:
        for box, cls in zip(r.boxes.xyxy, r.boxes.cls):
            class_name = model.names[int(cls)]
            if obj_name in class_name.lower():
                x1, y1, x2, y2 = map(int, box)
                cv2.rectangle(img, (x1, y1), (x2, y2), (0,0,255), 2)
                cv2.putText(img, class_name, (x1, y1-10), cv2.FONT_HERSHEY_SIMPLEX, 1, (0,0,255), 2)

    output_path = os.path.join(OUTPUT_FOLDER, "highlighted_" + file.filename)
    cv2.imwrite(output_path, img)

    return jsonify({"path": output_path})

if __name__ == "__main__":
    app.run(port=5002, debug=True)
