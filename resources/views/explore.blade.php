@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10 text-center text-white">
    <h1 class="text-4xl font-bold mb-6">🛰 Explore {{ $planet ?? 'Dataset' }}</h1>
    <p class="mb-8 text-lg">Zoom, pan, and search across high-resolution space images.</p>

    <div id="openseadragon" style="width:100%; height:600px; border-radius: 12px; background:#000;"></div>

    <div class="flex mt-6 justify-center space-x-2">
        <input id="ai-query" type="text" placeholder="Describe what to search..."
               class="w-1/2 px-4 py-2 rounded-lg text-black" />
        <button onclick="aiSearch()" class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded-lg">🚀 Search</button>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/openseadragon/4.1.0/openseadragon.min.js"></script>
<script>
    const localImage = "{{ asset('images/moon.jpg') }}";
    const demoDzi = "https://openseadragon.github.io/example-images/highsmith/highsmith.dzi";

    function initViewer(tileSource) {
        if (window.viewer && typeof window.viewer.destroy === 'function') {
            window.viewer.destroy();
        }
        window.viewer = OpenSeadragon({
            id: "openseadragon",
            prefixUrl: "https://cdnjs.cloudflare.com/ajax/libs/openseadragon/4.1.0/images/",
            tileSources: tileSource,
            showNavigator: true,
            animationTime: 0.5,
            zoomPerClick: 2
        });

        // بعد ما تفتح الصورة، نزود الـ Annotations
        window.viewer.addHandler('open', function () {
            // Circle
            const circle = document.createElement("div");
            circle.style.width = "60px";
            circle.style.height = "60px";
            circle.style.border = "3px solid red";
            circle.style.borderRadius = "50%";
            circle.style.backgroundColor = "rgba(255,0,0,0.2)";
            viewer.addOverlay({
                element: circle,
                location: new OpenSeadragon.Rect(0.3, 0.4, 0.05, 0.05)
            });

            // Rectangle
            const rect = document.createElement("div");
            rect.style.width = "100px";
            rect.style.height = "50px";
            rect.style.border = "3px solid blue";
            rect.style.backgroundColor = "rgba(0,0,255,0.2)";
            viewer.addOverlay({
                element: rect,
                location: new OpenSeadragon.Rect(0.6, 0.6, 0.08, 0.05)
            });

            // Label
            const label = document.createElement("div");
            label.innerHTML = "Text Here";
            label.style.color = "yellow";
            label.style.fontWeight = "bold";
            label.style.textShadow = "1px 1px 3px black";
            viewer.addOverlay({
                element: label,
                location: new OpenSeadragon.Point(0.45, 0.7)
            });
        });
    }

    fetch(localImage, { method: 'HEAD', cache: 'no-store' })
    .then(res => {
        if (res.ok) {
            initViewer({ type: 'image', url: localImage });
        } else {
            initViewer(demoDzi);
        }
    })
    .catch(err => {
        console.error('Error fetching local image:', err);
        initViewer(demoDzi);
    });

    // AI Search demo
    function aiSearch() {
        let query = document.getElementById("ai-query").value;
        fetch("{{ route('ai.search') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ query })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const rect = new OpenSeadragon.Rect(data.x, data.y, data.width, data.height);
                viewer.viewport.fitBounds(rect, true);
            } else {
                alert('Nothing found by AI.');
            }
        })
        .catch(e => { console.error(e); alert('Search failed. Check console.'); });
    }
</script>
@endsection
