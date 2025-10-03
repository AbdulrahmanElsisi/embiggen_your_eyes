import sys
import cv2
import os

if len(sys.argv) != 4:
    print("Usage: python compare.py <img1> <img2> <output>")
    sys.exit(1)

img1_path = sys.argv[1]
img2_path = sys.argv[2]
output_path = sys.argv[3]

if not os.path.exists(img1_path) or not os.path.exists(img2_path):
    print("One or both input images do not exist.")
    sys.exit(1)

# Read images
img1 = cv2.imread(img1_path)
img2 = cv2.imread(img2_path)

# Resize img2 to match img1
img2 = cv2.resize(img2, (img1.shape[1], img1.shape[0]))

# Convert to grayscale
gray1 = cv2.cvtColor(img1, cv2.COLOR_BGR2GRAY)
gray2 = cv2.cvtColor(img2, cv2.COLOR_BGR2GRAY)

# Compute difference
diff = cv2.absdiff(gray1, gray2)
_, thresh = cv2.threshold(diff, 30, 255, cv2.THRESH_BINARY)
contours, _ = cv2.findContours(thresh, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)

# Draw contours
output = img2.copy()
cv2.drawContours(output, contours, -1, (0, 0, 255), 2)

# Save output
cv2.imwrite(output_path, output)
