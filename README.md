<h1>NASA Timeline Viewer & File Comparison</h1>
<p>A web project to explore historical images of planets over time using <strong>OpenSeadragon</strong> and Smart Tiling using <strong>Leaflet </strong>, with support for <strong>drag & drop / paste file comparison</strong> in iframes. Built with <strong>Laravel (PHP)</strong> and <strong>JavaScript</strong>.</p>

<section>
<h2>🏗 Features</h2>
<ul>
    <li><strong>OpenSeadragon Viewer:</strong> Zoomable, pannable viewer for high-resolution planet images with a slider to navigate between different years.</li>
    <li><strong>File Comparison:</strong>
        <ul>
            <li>Two independent iframes to compare uploaded files.</li>
            <li>Each iframe has its own Drop Zone: Drag & Drop files or Paste from clipboard.</li>
            <li>Optional Modal for file selection.</li>
        </ul>
    </li>
    <li><strong>Interactive UI:</strong> Slider for year selection, selected year displayed dynamically, responsive layout.</li>
    <li><strong>Smart Tiling with Leaflet:</strong>
        <ul>
            <li>Load very large images efficiently by splitting them into tiles.</li>
            <li>Only necessary tiles are loaded based on zoom & pan.</li>
            <li>Example setup:</li>
            <pre><code>
const map = L.map('map', { crs: L.CRS.Simple, minZoom: 0, maxZoom: 5 });
const w = 8000, h = 6000;
const bounds = L.latLngBounds(map.unproject([0,h], map.getMaxZoom()), map.unproject([w,0], map.getMaxZoom()));

L.tileLayer('tiles/{z}/{x}/{y}.png', { bounds: bounds, noWrap: true }).addTo(map);
map.setMaxBounds(bounds);
map.fitBounds(bounds);
            </code></pre>
            <li>Supports overlays, markers, annotations.</li>
        </ul>
    </li>
</ul>
</section>

<section>
<h2>🗂 Project Structure</h2>
<pre><code>
project/
├─ resources/views/
│   ├─ timeline.blade.php    # Main page with viewer and comparison section
├─ public/
│   └─ tiles/               # Smart Tiles for Leaflet
├─ routes/web.php            # Laravel routes
├─ app/Http/Controllers/
│   └─ TimelineController.php
└─ README.md
</code></pre>
</section>

<section>
<h2>⚙ Setup Instructions</h2>
<ol>
    <li><strong>Clone the repository:</strong>
    <pre><code>git clone &lt;repo-url&gt;
cd project</code></pre>
    </li>
    <li><strong>Install dependencies:</strong>
    <pre><code>composer install
npm install
npm run dev</code></pre>
    </li>
    <li><strong>Set up Laravel environment:</strong>
    <pre><code>cp .env.example .env
php artisan key:generate</code></pre>
    </li>
    <li><strong>Serve the application:</strong>
    <pre><code>php artisan serve</code></pre>
    Open your browser at <a href="http://127.0.0.1:8000/timeline">http://127.0.0.1:8000/timeline</a>
    </li>
</ol>
</section>

<section>
<h2>🖥 Usage</h2>
<ol>
    <li>Navigate to the timeline page.</li>
    <li>Use the <strong>slider</strong> to select the year and update the viewer.</li>
    <li>For file comparison:
        <ul>
            <li>Drag & drop or paste files into Left and Right Drop Zones.</li>
            <li>Or click "Select Files via Modal" to choose files manually.</li>
        </ul>
    </li>
    <li>Compare files instantly in the iframes below the viewer.</li>
    <li>Use Leaflet Smart Tiling section for high-resolution image exploration.</li>
</ol>
</section>

<section>
<h2>🛠 Technologies Used</h2>
<ul>
    <li>Backend: Laravel (PHP)</li>
    <li>Frontend: JavaScript, Tailwind CSS</li>
    <li>Viewer: OpenSeadragon</li>
    <li>Mapping / Tiling: Leaflet JS with Smart Tiles</li>
    <li>File Handling: Drag & Drop + Clipboard Paste support</li>
    <li>Optional: Modal for manual file selection</li>
</ul>
</section>

<section>
<h2>🔮 Future Improvements</h2>
<ul>
    <li>Add Reset buttons for each Drop Zone/iframe.</li>
    <li>Integrate Python AI microservice for automatic comparison/highlighting.</li>
    <li>Support multi-file comparison.</li>
    <li>Add annotations / drawing on viewer.</li>
</ul>
</section>
