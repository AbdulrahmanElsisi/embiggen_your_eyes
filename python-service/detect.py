# python-service/detect.py
from flask import Flask, request, jsonify, send_file
from ultralytics import YOLO
import os
import cv2

# 1️⃣ إنشاء الـ Flask app
app = Flask(__name__)

# 2️⃣ تحميل موديل YOLO
model = YOLO("yolov8n.pt")  # تأكد أن الموديل موجود في نفس الفولدر أو غيّر المسار

# 3️⃣ إعداد مجلدات التحميل والنتيجة
UPLOAD_FOLDER = "uploads"
OUTPUT_FOLDER = "outputs"
os.makedirs(UPLOAD_FOLDER, exist_ok=True)
os.makedirs(OUTPUT_FOLDER, exist_ok=True)

# 4️⃣ Route للـ search
@app.route("/search", methods=["POST"])
def search_object():
    if "image" not in request.files or "object" not in request.form:
        return jsonify({"error": "No image or object specified"}), 400

    file = request.files["image"]
    obj_name = request.form["object"].lower()

    # حفظ الصورة
    filepath = os.path.join(UPLOAD_FOLDER, file.filename)
    file.save(filepath)

    # عمل prediction على الصورة
    results = model.predict(filepath, conf=0.25)

    # قراءة الصورة باستخدام OpenCV
    img = cv2.imread(filepath)

    # عمل highlight لكل object مطابق للاسم
    for r in results:
        for box, cls in zip(r.boxes.xyxy, r.boxes.cls):
            class_name = model.names[int(cls)]
            if obj_name in class_name.lower():
                x1, y1, x2, y2 = map(int, box)
                cv2.rectangle(img, (x1, y1), (x2, y2), (0,0,255), 2)
                cv2.putText(img, class_name, (x1, y1-10), cv2.FONT_HERSHEY_SIMPLEX, 1, (0,0,255), 2)

    # حفظ الصورة بعد الـ highlight
    output_path = os.path.join(OUTPUT_FOLDER, "highlighted_" + file.filename)
    cv2.imwrite(output_path, img)

    return jsonify({"path": output_path})

# 5️⃣ تشغيل السيرفر
if __name__ == "__main__":
    app.run(port=5002, debug=True)
