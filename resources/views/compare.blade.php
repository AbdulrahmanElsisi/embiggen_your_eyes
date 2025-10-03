@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10 text-white">
    <h1 class="text-3xl font-bold mb-6">🆚 Compare {{ ucfirst($planet) }}</h1>
    <p class="mb-8 text-lg">Comparing <b>{{ $year1 }}</b> vs <b>{{ $year2 }}</b></p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h2 class="text-xl mb-2">📅 {{ $year1 }}</h2>
            <div id="viewer1" style="width:100%; height:500px; background:#000;"></div>
        </div>
        <div>
            <h2 class="text-xl mb-2">📅 {{ $year2 }}</h2>
            <div id="viewer2" style="width:100%; height:500px; background:#000;"></div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/openseadragon/4.1.0/openseadragon.min.js"></script>
<script>
    const year1 = "{{ $year1 }}";
    const year2 = "{{ $year2 }}";
    const planet = "{{ $planet }}";
    const timelineData = @json($timelineData);
    const rect = JSON.parse(decodeURIComponent(`{!! $rect !!}`)); // نفس المستطيل اللي جاي من الصفحة الأولى

    // Initialize viewers
    const viewer1 = OpenSeadragon({
        id: "viewer1",
        prefixUrl: "https://cdnjs.cloudflare.com/ajax/libs/openseadragon/4.1.0/images/",
        tileSources: timelineData[year1],
        showNavigator: true,
    });

    const viewer2 = OpenSeadragon({
        id: "viewer2",
        prefixUrl: "https://cdnjs.cloudflare.com/ajax/libs/openseadragon/4.1.0/images/",
        tileSources: timelineData[year2],
        showNavigator: true,
    });

    // بعد ما تفتح الصور، أعمل نفس الزوم على الـ rect
    function focusOnRect(viewer) {
        const osdRect = new OpenSeadragon.Rect(rect.x, rect.y, rect.width, rect.height);
        viewer.addOnceHandler('open', () => {
            viewer.viewport.fitBounds(osdRect, true);
            // كمان نعرض الـ rect على الصورة
            const overlay = document.createElement("div");
            overlay.style.border = "2px solid red";
            viewer.addOverlay({ element: overlay, location: osdRect });
        });
    }

    focusOnRect(viewer1);
    focusOnRect(viewer2);
</script>
@endsection
