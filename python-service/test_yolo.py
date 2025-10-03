from ultralytics import YOLO

# حمّل الموديل الجاهز (YOLOv8 small مثلاً)
model = YOLO("yolov8n.pt")  # ممكن تغير لـ yolov8s.pt لو عايز أدق

# جرب detection على صورة محلية عندك
results = model("C:/Users/Fujitsu/Downloads/81362749.jpg")
  # غيّر test.jpg لصورة عندك

# اطبع النتايج في الـ terminal
for r in results:
    print(r.boxes)  # الصناديق
    print(r.names)  # أسماء الكلاسات

# لو عايز تحفظ صورة فيها النتائج
results[0].save(filename="output.jpg")
print("✅ Detection done! Check output.jpg")

