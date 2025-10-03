<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>YOLO Image Search</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        #preview { max-width: 400px; margin: 20px 0; }
        #result { background: #f9f9f9; padding: 10px; border: 1px solid #ddd; white-space: pre-wrap; }
    </style>
</head>
<body>
    <h2>Upload an Image for Object Detection</h2>

    <form id="uploadForm" enctype="multipart/form-data">
        <input type="file" name="image" id="imageInput" accept="image/*" />
        <button type="submit">Upload</button>
    </form>

    <div>
        <img id="preview" src="" alt="Preview" style="display:none;">
    </div>

    <h3>Detections:</h3>
    <pre id="result"></pre>

    <script>
        const form = document.getElementById("uploadForm");
        const input = document.getElementById("imageInput");
        const preview = document.getElementById("preview");
        const result = document.getElementById("result");

        // Preview image before upload
        input.addEventListener("change", () => {
            const file = input.files[0];
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = "block";
            }
        });

        // Handle form submit
        form.addEventListener("submit", async (e) => {
            e.preventDefault();
            const formData = new FormData();
            formData.append("image", input.files[0]);

            const res = await fetch("{{ url('/nasa/search-image') }}", {
                method: "POST",
                body: formData
            });

            const data = await res.json();
            result.textContent = JSON.stringify(data, null, 2);
        });
    </script>
</body>
</html>
