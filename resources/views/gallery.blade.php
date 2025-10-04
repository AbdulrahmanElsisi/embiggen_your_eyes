@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10 text-white">
    <h1 class="text-4xl font-bold mb-6 text-center">🪐 Planet & Moon Gallery</h1>

    <!-- Search + Filter -->
    <form method="GET" class="flex flex-col md:flex-row gap-4 justify-center mb-6">
        <input type="text" name="search" placeholder="Search by name..." value="{{ $search }}"
               class="px-4 py-2 rounded w-full md:w-1/3 text-black">
        <select name="filter" class="px-4 py-2 rounded w-full md:w-1/3 text-black">
            <option value="">All</option>
            <option value="moon" {{ $filter=='moon'?'selected':'' }}>Moon</option>
            <option value="mars" {{ $filter=='mars'?'selected':'' }}>Mars</option>
            <option value="earth" {{ $filter=='earth'?'selected':'' }}>Earth</option>
            <option value="jupiter" {{ $filter=='jupiter'?'selected':'' }}>Jupiter</option>
        </select>
        <button type="submit" class="bg-blue-500 px-4 py-2 rounded">Apply</button>
    </form>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($planets as $planet)
            <div class="rounded-lg overflow-hidden shadow-lg hover:scale-105 transition transform cursor-pointer"
                 onclick="openOSD('{{ $planet['image'] }}')">
                <img src="{{ $planet['thumb'] }}" alt="{{ $planet['name'] }}" class="w-full h-48 object-cover">
                <div class="p-2 text-center font-bold">{{ ucfirst($planet['name']) }}</div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @php
        $totalPages = ceil($total / $perPage);
    @endphp
    <div class="flex justify-center mt-6 gap-2">
        @for($i=1;$i<=$totalPages;$i++)
            <a href="?page={{$i}}&search={{$search}}&filter={{$filter}}"
               class="px-3 py-1 rounded {{ $i==$page?'bg-blue-500':'bg-gray-700' }}">{{ $i }}</a>
        @endfor
    </div>

    <!-- OpenSeadragon Viewer -->
    <div id="osd-viewer" style="width:100%; height:600px; margin-top:20px; display:none;"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/openseadragon/4.1.0/openseadragon.min.js"></script>
<script>
let viewer;
function openOSD(imageUrl){
    document.getElementById('osd-viewer').style.display = 'block';
    if(viewer && typeof viewer.destroy === 'function') viewer.destroy();
    viewer = OpenSeadragon({
        id: "osd-viewer",
        prefixUrl: "https://cdnjs.cloudflare.com/ajax/libs/openseadragon/4.1.0/images/",
        tileSources: { type: 'image', url: imageUrl },
        showNavigator: true,
        animationTime: 0.5,
        zoomPerClick: 2
    });
    viewer.viewport.goHome();
}
</script>
@endsection
