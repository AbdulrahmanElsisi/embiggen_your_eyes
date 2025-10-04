@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10 text-center text-white">

    <h1 class="text-4xl font-bold mb-6">🛰 {{ ucfirst($planet ?? 'Planet') }} Map</h1>
    <p class="mb-8 text-lg">Explore high-resolution satellite imagery from NASA.</p>

    <!-- Map Container -->
    <div id="map" style="width:100%; height:600px; border-radius:12px;"></div>

</div>

<!-- Leaflet JS & CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    const map = L.map('map').setView([0,0], 2);

    let tileUrl = '';

    @if(strtolower($planet ?? '') === 'mars')
        tileUrl = 'https://astrogeology.usgs.gov/ckan/dataset/daa79b13-f5e0-462e-8b7d-c94d9d2907c3/resource/ae080c7e-c4b7-460b-8059-0fa807aa8087/download/full.jpg';
    @elseif(strtolower($planet ?? '') === 'moon')
    tileUrl = 'https://images-assets.nasa.gov/image/PIA00404/PIA00404~large.jpg';
    @elseif(strtolower($planet ?? '') === 'jupiter')
    tileUrl = 'https://astrogeology.usgs.gov/ckan/dataset/daa79b13-f5e0-462e-8b7d-c94d9d2907c3/resource/ae080c7e-c4b7-460b-8059-0fa807aa8087/download/full.jpg';
    @elseif(strtolower($planet ?? '') === 'saturn')
    tileUrl = 'https://astrogeology.usgs.gov/ckan/dataset/daa79b13-f5e0-462e-8b7d-c94d9d2907c3/resource/ae080c7e-c4b7-460b-8059-0fa807aa8087/download/full.jpg';
    @else
        // خريطة الأرض
        const today = new Date();
        today.setDate(today.getDate() - 1); // يوم قبلي
        const yyyy = today.getFullYear();
        const mm = String(today.getMonth()+1).padStart(2,'0');
        const dd = String(today.getDate()).padStart(2,'0');
        const selectedDate = `${yyyy}-${mm}-${dd}`;
        tileUrl = `https://gibs.earthdata.nasa.gov/wmts/epsg4326/best/MODIS_Terra_CorrectedReflectance_TrueColor/default/${selectedDate}/250m/{z}/{y}/{x}.jpg`;
    @endif

    const tileLayer = L.tileLayer(tileUrl, { attribution: 'NASA GIBS' }).addTo(map);
</script>
@endsection
