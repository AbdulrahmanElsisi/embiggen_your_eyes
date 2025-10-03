<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image Search</title>
</head>
<body style="font-family: Arial; margin: 40px;">
    <h1>🔍 Search Inside Image</h1>
    <form id="uploadForm">
        <input type="text" name="query" id="query" placeholder="Enter search term (e.g., person, car)" required>
        <br><br>
        <input type="file" name="image" id="image" accept="image/*" required>
        <br><br>
        <button type="submit">Upload & Search</button>
    </form>

    <h2>Results:</h2>
    <div id="result"></div>

    <script>
    document.getElementById("uploadForm").addEventListener("submit", async function(e) {
        e.preventDefault();

        const formData = new FormData();
        formData.append("query", document.getElementById("query").value);
        formData.append("image", document.getElementById("image").files[0]);

        const res = await fetch("/image/search", {
            method: "POST",
            body: formData
        });

        const data = await res.json();
        console.log(data);

        if (data.image) {
            document.getElementById("result").innerHTML = `
                <p>Match: ${data.found ? "✅ Found" : "❌ Not Found"}</p>
                <img src="data:image/jpeg;base64,${data.image}" style="max-width:600px; border:1px solid #333;">
            `;
        } else {
            document.getElementById("result").innerHTML = "<p>Error: " + (data.error || "Something went wrong") + "</p>";
        }
    });
    </script>
</body>
</html>
