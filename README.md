# NASA Timeline Viewer & File Comparison

A web project to explore historical images of planets over time using **OpenSeadragon**, with support for **drag & drop / paste file comparison** in iframes. Built with **Laravel (PHP)** and **JavaScript**.

---

## 🏗 Features

1. **OpenSeadragon Viewer**
   - Zoomable, pannable viewer for high-resolution planet images.
   - Slider to navigate between different years.

2. **File Comparison**
   - Two independent iframes to compare uploaded files.
   - Each iframe has its own **Drop Zone**:
     - Drag & Drop files directly.
     - Paste images/files from clipboard.
   - Optional **Modal** for file selection.

3. **Interactive UI**
   - Slider for year selection.
   - Selected year displayed dynamically.
   - Clean, responsive layout.

4. **Smart Tiling with Leaflet**
   - Load very large images efficiently by splitting them into **tiles**.
   - Only necessary tiles are loaded based on zoom & pan.
   - Works for maps, satellite images, or any high-resolution picture.
   - Example setup:
     ```javascript
     const map = L.map('map', { crs: L.CRS.Simple, minZoom: 0, maxZoom: 5 });
     const w = 8000, h = 6000;
     const bounds = L.latLngBounds(map.unproject([0,h], map.getMaxZoom()), map.unproject([w,0], map.getMaxZoom()));

     L.tileLayer('tiles/{z}/{x}/{y}.png', { bounds: bounds, noWrap: true }).addTo(map);
     map.setMaxBounds(bounds);
     map.fitBounds(bounds);
     ```
   - Can be combined with overlays, markers, or annotations.

---

## 🗂 Project Structure

project/
├─ resources/views/
│ ├─ timeline.blade.php # Main page with viewer and comparison section
├─ public/
│ └─ tiles/ # Smart Tiles for Leaflet
├─ routes/web.php # Laravel routes
├─ app/Http/Controllers/
│ └─ TimelineController.php
└─ README.md

yaml
Copy code

---

## ⚙ Setup Instructions

1. **Clone the repository**

```bash
git clone <repo-url>
cd project
Install dependencies

bash
Copy code
composer install
npm install
npm run dev
Set up Laravel environment

bash
Copy code
cp .env.example .env
php artisan key:generate
Serve the application

bash
Copy code
php artisan serve
Open your browser at http://127.0.0.1:8000/timeline.

🖥 Usage
Navigate to the timeline page.

Use the slider to select the year and update the viewer.

For file comparison:

Drag & drop or paste files into Left and Right Drop Zones.

Or click Select Files via Modal to choose files manually.

Compare files instantly in the iframes below the viewer.

Use Leaflet Smart Tiling section for high-resolution image exploration.

🛠 Technologies Used
Backend: Laravel (PHP)

Frontend: JavaScript, Tailwind CSS

Viewer: OpenSeadragon

Mapping / Tiling: Leaflet JS with Smart Tiles

File Handling: Drag & Drop + Clipboard Paste support

Optional: Modal for manual file selection

🔮 Future Improvements
Add Reset buttons for each Drop Zone/iframe.

Integrate Python AI microservice for automatic comparison/highlighting.

Support multi-file comparison.

Add annotations / drawing on viewer.
