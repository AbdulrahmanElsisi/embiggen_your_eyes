@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10 text-center text-white">
    <h1 class="text-4xl font-bold mb-6">🔍 Search in Image</h1>

    <div class="mb-4">
        <input type="file" id="imageInput" class="mb-2 p-2 rounded text-black">
        <input type="text" id="objectInput" placeholder="Enter object name (e.g., person)" class="mb-2 p-2 rounded text-black">
        <button id="searchBtn" class="bg-blue-500 px-4 py-2 rounded">Search & Highlight</button>
    </div>

    <h2 class="text-lg mt-4 mb-2">Result:</h2>
    <img id="resultImage" class="w-full h-80 border rounded mx-auto" />
</div>

<script>
document.getElementById("searchBtn").addEventListener("click", async () => {
    const file = document.getElementById("imageInput").files[0];
    const objectName = document.getElementById("objectInput").value;

    if(!file || !objectName){
        alert("Please select an image and enter an object name");
        return;
    }

    const formData = new FormData();
    formData.append("image", file);
    formData.append("object", objectName);

    const res = await fetch("http://127.0.0.1:5002/search", {
        method: "POST",
        body: formData
    });

    const data = await res.json();
    if(data.path){
        // Convert local path to URL (يمكن تستخدم Laravel route بدل)
        document.getElementById("resultImage").src = "http://127.0.0.1:5002/" + data.path;
    } else {
        alert("No objects found or error occurred");
    }
});
</script>
@endsection
