@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10 text-center text-white">

    <!-- Timeline -->
    <h1 class="text-4xl font-bold mb-6">📅 {{ ucfirst($planet) }} Timeline</h1>
    <p class="mb-8 text-lg">Explore historical images of {{ $planet }} over time.</p>

    <!-- Map Container -->
    <div id="map" style="width:100%; height:600px; border-radius:12px;"></div>

    <!-- Timeline Slider -->
    <div class="mt-6" id="timeline-container">
        <input type="range" id="timeline-slider" min="0" max="6" step="1" value="6" class="w-full">
        <div class="flex justify-between mt-2 text-sm" id="timeline-labels">
            <!-- الأيام السبعة ستملأ بالـ JS -->
        </div>
        <p class="mt-2 text-lg">
            Selected Date: <span id="selected-date"></span>
        </p>
    </div>

    <!-- Compare Section -->
    <div class="p-4 border-2 border-dashed border-white rounded text-white mb-2 mt-10">
        Compare Images
    </div>

    <div class="mt-6 grid grid-cols-2 gap-4">
        <div>
            <div class="drop-zone p-4 border-2 border-dashed border-white rounded text-white mb-2">
                Drag & Drop / Paste file here for Left
            </div>
            <img id="preview1" class="w-full h-40 border rounded mt-2" />
        </div>
        <div>
            <div class="drop-zone p-4 border-2 border-dashed border-white rounded text-white mb-2">
                Drag & Drop / Paste file here for Right
            </div>
            <img id="preview2" class="w-full h-40 border rounded mt-2" />
        </div>
    </div>

    <!-- Select Files Button -->
    <button id="selectFilesBtn" class="bg-blue-500 px-4 py-2 rounded mt-6">Select Files</button>

    <!-- Hidden file inputs -->
    <input type="file" id="fileInput1" class="hidden">
    <input type="file" id="fileInput2" class="hidden">

    <!-- Compare Button -->
    <button id="compareBtn" class="bg-green-500 px-4 py-2 rounded mt-6">Compare</button>

    <!-- Result -->
    <h2 class="mt-6 text-lg mb-2">Result:</h2>
    <iframe id="resultFrame" class="w-full h-80 border rounded mx-auto"></iframe>

</div>

<!-- Leaflet JS & CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    // ======================
    // إعداد خريطة Leaflet
    // ======================
    const map = L.map('map').setView([0,0], 2);
    let tileLayer;

    const today = new Date();
    const dates = [];
    // الأيام من يوم قبلي حتى أسبوع فات
    for(let i=7; i>=1; i--){
        const d = new Date();
        d.setDate(today.getDate() - i);
        const yyyy = d.getFullYear();
        const mm = String(d.getMonth()+1).padStart(2,'0');
        const dd = String(d.getDate()).padStart(2,'0');
        dates.push(`${yyyy}-${mm}-${dd}`);
    }

    // ملء الـ labels تحت الـ slider
    const timelineLabels = document.getElementById('timeline-labels');
    timelineLabels.innerHTML = dates.map(d => `<span>${d}</span>`).join('');

    const selectedDateEl = document.getElementById('selected-date');
    const timelineSlider = document.getElementById('timeline-slider');

    function showDate(idx){
        const selectedDate = dates[idx];
        selectedDateEl.textContent = selectedDate;

        if(tileLayer){
            map.removeLayer(tileLayer);
        }
        tileLayer = L.tileLayer(
            `https://gibs.earthdata.nasa.gov/wmts/epsg4326/best/MODIS_Terra_CorrectedReflectance_TrueColor/default/${selectedDate}/250m/{z}/{y}/{x}.jpg`,
            { attribution: 'NASA GIBS' }
        ).addTo(map);
    }

    // عرض أول يوم
    showDate(dates.length - 1);

    timelineSlider.addEventListener('input', (e)=>{
        showDate(parseInt(e.target.value));
    });

    // ======================
    // Drag & Drop + Paste
    // ======================
    let file1 = null, file2 = null;
    const preview1 = document.getElementById('preview1');
    const preview2 = document.getElementById('preview2');

    document.querySelectorAll('.drop-zone').forEach((zone, idx) => {
        zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('bg-gray-700'); });
        zone.addEventListener('dragleave', e => { e.preventDefault(); zone.classList.remove('bg-gray-700'); });
        zone.addEventListener('drop', e => {
            e.preventDefault(); zone.classList.remove('bg-gray-700');
            const file = e.dataTransfer.files[0];
            if(file){
                if(idx===0){ file1 = file; preview1.src = URL.createObjectURL(file); }
                else { file2 = file; preview2.src = URL.createObjectURL(file); }
            }
        });

        // Paste
        zone.addEventListener('paste', e => {
            e.preventDefault();
            const items = e.clipboardData.items;
            for(let i=0;i<items.length;i++){
                if(items[i].kind==='file'){
                    const blob = items[i].getAsFile();
                    if(blob){
                        if(idx===0){ file1 = blob; preview1.src = URL.createObjectURL(blob); }
                        else { file2 = blob; preview2.src = URL.createObjectURL(blob); }
                    }
                }
            }
        });
    });

    // Select Files Button
    document.getElementById('selectFilesBtn').addEventListener('click', ()=>{
        document.getElementById('fileInput1').click();
        document.getElementById('fileInput2').click();
    });

    document.getElementById('fileInput1').addEventListener('change', ()=>{
        if(document.getElementById('fileInput1').files.length){
            file1 = document.getElementById('fileInput1').files[0];
            preview1.src = URL.createObjectURL(file1);
        }
    });
    document.getElementById('fileInput2').addEventListener('change', ()=>{
        if(document.getElementById('fileInput2').files.length){
            file2 = document.getElementById('fileInput2').files[0];
            preview2.src = URL.createObjectURL(file2);
        }
    });

    // Compare Button
    document.getElementById('compareBtn').addEventListener('click', ()=>{
        if(!file1 || !file2){ alert("Please provide both files!"); return; }

        const formData = new FormData();
        formData.append("file1", file1);
        formData.append("file2", file2);

        fetch("{{ route('compare') }}", {
            method: "POST",
            body: formData,
            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"}
        })
        .then(res => res.json())
        .then(data => {
            if(data.output){ document.getElementById('resultFrame').src = data.output; }
            else{ alert("Error in comparison"); }
        })
        .catch(err => console.error(err));
    });

</script>
@endsection






{{--
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-10 text-center text-white">

    <!-- Timeline -->
    <h1 class="text-4xl font-bold mb-6">📅 {{ ucfirst($planet) }} Timeline</h1>
    <p class="mb-8 text-lg">Explore historical images of {{ $planet }} over time.</p>

    <div id="openseadragon" style="width:100%; height:600px; border-radius:12px; background:#000;"></div>

    <div class="mt-6">
        <input type="range" id="year-slider"
               min="0"
               max="{{ count($timelineData)-1 }}"
               value="0"
               step="1"
               class="w-full">
        <div class="flex justify-between mt-2 text-sm">
            @foreach(array_keys($timelineData) as $year)
                <span>{{ $year }}</span>
            @endforeach
        </div>
        <p class="mt-2 text-lg">
            Selected Year: <span id="selected-year">{{ array_keys($timelineData)[0] }}</span>
        </p>
    </div>

    <!-- Compare Section -->
    <div class="p-4 border-2 border-dashed border-white rounded text-white mb-2 mt-10">
        Compare Images
    </div>

    <div class="mt-6 grid grid-cols-2 gap-4">
        <div>
            <div class="drop-zone p-4 border-2 border-dashed border-white rounded text-white mb-2">
                Drag & Drop / Paste file here for Left
            </div>
            <img id="preview1" class="w-full h-40 border rounded mt-2" />
        </div>
        <div>
            <div class="drop-zone p-4 border-2 border-dashed border-white rounded text-white mb-2">
                Drag & Drop / Paste file here for Right
            </div>
            <img id="preview2" class="w-full h-40 border rounded mt-2" />
        </div>
    </div>

    <!-- Select Files Button -->
    <button id="selectFilesBtn" class="bg-blue-500 px-4 py-2 rounded mt-6">Select Files</button>

    <!-- Hidden file inputs -->
    <input type="file" id="fileInput1" class="hidden">
    <input type="file" id="fileInput2" class="hidden">

    <!-- Compare Button -->
    <button id="compareBtn" class="bg-green-500 px-4 py-2 rounded mt-6">Compare</button>

    <!-- Result -->
    <h2 class="mt-6 text-lg mb-2">Result:</h2>
    <iframe id="resultFrame" class="w-full h-80 border rounded mx-auto"></iframe>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/openseadragon/4.1.0/openseadragon.min.js"></script>
<script>
const timelineData = @json($timelineData);
const years = Object.keys(timelineData);
let currentYear = years[0];

// OpenSeadragon viewer
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
}

initViewer(timelineData[currentYear]);

// Slider
const slider = document.getElementById('year-slider');
const yearLabel = document.getElementById('selected-year');
slider.addEventListener('input', function() {
    currentYear = years[this.value];
    yearLabel.textContent = currentYear;
    initViewer(timelineData[currentYear]);
});

// Drag & Drop + Paste
let file1 = null, file2 = null;
const preview1 = document.getElementById('preview1');
const preview2 = document.getElementById('preview2');

document.querySelectorAll('.drop-zone').forEach((zone, idx) => {
    zone.addEventListener('dragover', e => { e.preventDefault(); zone.classList.add('bg-gray-700'); });
    zone.addEventListener('dragleave', e => { e.preventDefault(); zone.classList.remove('bg-gray-700'); });
    zone.addEventListener('drop', e => {
        e.preventDefault(); zone.classList.remove('bg-gray-700');
        const file = e.dataTransfer.files[0];
        if(file){
            if(idx===0){ file1 = file; preview1.src = URL.createObjectURL(file); }
            else { file2 = file; preview2.src = URL.createObjectURL(file); }
        }
    });

    // Paste
    zone.addEventListener('paste', e => {
        e.preventDefault();
        const items = e.clipboardData.items;
        for(let i=0;i<items.length;i++){
            if(items[i].kind==='file'){
                const blob = items[i].getAsFile();
                if(blob){
                    if(idx===0){ file1 = blob; preview1.src = URL.createObjectURL(blob); }
                    else { file2 = blob; preview2.src = URL.createObjectURL(blob); }
                }
            }
        }
    });
});

// Select Files Button
document.getElementById('selectFilesBtn').addEventListener('click', ()=>{
    document.getElementById('fileInput1').click();
    document.getElementById('fileInput2').click();
});

document.getElementById('fileInput1').addEventListener('change', ()=>{
    if(document.getElementById('fileInput1').files.length){
        file1 = document.getElementById('fileInput1').files[0];
        preview1.src = URL.createObjectURL(file1);
    }
});
document.getElementById('fileInput2').addEventListener('change', ()=>{
    if(document.getElementById('fileInput2').files.length){
        file2 = document.getElementById('fileInput2').files[0];
        preview2.src = URL.createObjectURL(file2);
    }
});

// Compare Button
document.getElementById('compareBtn').addEventListener('click', ()=>{
    if(!file1 || !file2){ alert("Please provide both files!"); return; }

    const formData = new FormData();
    formData.append("file1", file1);
    formData.append("file2", file2);

    fetch("{{ route('compare') }}", {
        method: "POST",
        body: formData,
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"}
    })
    .then(res => res.json())
    .then(data => {
        if(data.output){ document.getElementById('resultFrame').src = data.output; }
        else{ alert("Error in comparison"); }
    })
    .catch(err => console.error(err));
});
</script>
@endsection --}}
