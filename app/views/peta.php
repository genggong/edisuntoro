<div class="card border-0 shadow-sm mb-4">
  <div class="card-body">
    <h5 class="fw-bold text-success">🗺️ Peta Interaktif Desa Sidamulya</h5>
    <p class="text-muted small mb-2">
      Base layer <strong>satelit</strong> &amp; <strong>jalan</strong>. Klik peta untuk <strong>digitasi titik lahan</strong>,
      atau tool ⎔ untuk <strong>menggambar batas (polygon)</strong>. Titik/koordinat bisa langsung diteruskan ke form Tambah.
    </p>
    <div id="map" style="height:440px;border-radius:12px;overflow:hidden"></div>

    <div class="row g-2 mt-3">
      <div class="col-12 col-md-6">
        <div class="card border-light bg-light"><div class="card-body py-3">
          <div class="text-muted small">📍 Koordinat dipilih</div>
          <div id="pick" class="mono fs-6 fw-semibold" style="word-break:break-all">Klik peta untuk memilih titik</div>
          <a id="pickAdd" class="btn btn-success btn-sm mt-2" style="display:none" href="#">＋ Tambah Titik Lahan</a>
        </div></div>
      </div>
      <div class="col-12 col-md-6">
        <div class="card border-light bg-light"><div class="card-body py-3">
          <div class="text-muted small" style="color:#6b7280">⎔ Polygon batas lahan</div>
          <div id="poly" class="small text-muted" style="word-break:break-all">Gambar polygon dulu (tool ⎔ kiri).</div>
          <button class="btn btn-outline-success btn-sm mt-2" id="copyPoly">Use titik awal ke form</button>
        </div></div>
      </div>
    </div>
  </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.css">
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-draw@1.0.4/dist/leaflet.draw.js"></script>
<script>
(function () {
    var BASE_URL = <?= json_encode(BASE_URL) ?>;
    var tanah = <?= json_encode($tanah) ?>;
    var pusat = [-6.90535, 109.02330];
    var map = L.map('map').setView(pusat, 15);

    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom:19, attribution:'© OpenStreetMap'});
    var sat = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {maxZoom:19, attribution:'Esri'});
    sat.addTo(map);
    L.control.layers({'🛰 Satelit': sat, '🗺 Jalan (OSM)': osm}).addTo(map);

    var drawn = L.featureGroup().addTo(map);

    tanah.forEach(function (t) {
        if (t.lat === null || t.lon === null) return;
        L.marker([Number(t.lat), Number(t.lon)]).addTo(map)
          .bindPopup('<b>' + (t.nama||'') + '</b><br>No C: ' + (t.nomor_c||'-') + '<br>Jenis: ' + t.jenis + '<br>Luas: ' + t.luas + ' m²');
    });
    L.marker(pusat, {icon: L.divIcon({className:'', html:'<div style="width:14px;height:14px;background:#dc2626;border:2px solid #fff;border-radius:50%;box-shadow:0 0 0 2px rgba(0,0,0,.3)"></div>'})}).addTo(map).bindPopup('Pusat Desa');

    // ---- klik pilih titik ----
    var pickTmp = null;
    map.on('click', function (e) {
        if (pickTmp) map.removeLayer(pickTmp);
        pickTmp = L.marker(e.latlng).addTo(map);
        var lat = e.latlng.lat.toFixed(7), lon = e.latlng.lng.toFixed(7);
        document.getElementById('pick').textContent = lat + ', ' + lon;
        var a = document.getElementById('pickAdd');
        a.style.display = 'inline-block';
        a.href = BASE_URL + '/tanah/tambah?lat=' + lat + '&lon=' + lon;
    });

    // ---- draw polygon (digitasi batas) ----
    var drawControl = new L.Control.Draw({
        edit: {featureGroup: drawn},
        draw: {polyline:false, rectangle:false, circle:false, circlemarker:false, marker:false}
    });
    map.addControl(drawControl);

    function flatCoords(coords, out) {
        if (!Array.isArray(coords)) return;
        coords.forEach(function (c) {
            if (typeof c[0] === 'number') { out.push(c[1].toFixed(6) + ',' + c[0].toFixed(6)); }
            else flatCoords(c, out);
        });
    }
    var pts = [];
    map.on(L.Draw.Event.CREATED, function (e) {
        if (!(e.layer instanceof L.Polygon) && !(e.layer instanceof L.Polyline)) return;
        drawn.addLayer(e.layer);
        var g = e.layer.toGeoJSON().geometry || {coordinates: []};
        pts = []; flatCoords(g.coordinates, pts);
        document.getElementById('poly').textContent = pts.join(' → ');
    });
    document.getElementById('copyPoly').addEventListener('click', function () {
        if (!pts.length) { alert('Gambar polygon (tool ⎔) dulu.'); return; }
        var p = pts[0].split(',');
        window.open(BASE_URL + '/tanah/tambah?lat=' + p[0].trim() + '&lon=' + (p[1]||'').trim(), '_blank');
    });
})();
</script>
