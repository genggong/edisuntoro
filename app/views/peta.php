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

    <div class="card border-0 shadow-sm mt-3" >
      <div class="card-body">
        <h6 class="fw-bold text-success mb-2">🛡️ Validasi Spasial (Anti-Overlap &amp; Cek Luas) — STAGE 2</h6>
        <div class="row g-2 align-items-end">
          <div class="col-6 col-md-3">
            <label class="form-label small text-muted mb-0">Luas Buku C (m²)</label>
            <input id="luasBuku" type="number" step="0.01" min="0" class="form-control form-control-sm" placeholder="opsional">
          </div>
          <div class="col-6 col-md-3">
            <button class="btn btn-success btn-sm w-100" id="cekValidasi">Cek Overlap &amp; Luas</button>
          </div>
          <div class="col-12 mt-2">
            <div id="hasilValidasi" class="small"></div>
          </div>
        </div>
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
        if (!t) return;
        // polygon bidang (Anti-Overlap visual)
        if (t.poligon) {
            var ring = [];
            String(t.poligon).split(';').forEach(function (ch) {
                var p = ch.split(',');
                if (p.length >= 2 && !isNaN(p[0]) && !isNaN(p[1])) ring.push([Number(p[0]), Number(p[1])]);
            });
            if (ring.length >= 3) {
                var col = (t.status === 'aktif') ? '#15803d' : (t.status === 'batal' ? '#6b7280' : '#d97706');
                L.polygon(ring, {color:col, weight:2, fill:true, fillOpacity:0.15, dashArray:'6 3'})
                  .addTo(map)
                  .bindTooltip((t.nomor_c||'-') + ' · ' + (t.nama||''));
            }
        }
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
    var polyStr = '';
    map.on(L.Draw.Event.CREATED, function (e) {
        if (!(e.layer instanceof L.Polygon) && !(e.layer instanceof L.Polyline)) return;
        drawn.addLayer(e.layer);
        var g = e.layer.toGeoJSON().geometry || {coordinates: []};
        pts = []; flatCoords(g.coordinates, pts);
        polyStr = pts.join(';');
        document.getElementById('poly').textContent = pts.join(' → ');
    });
    document.getElementById('copyPoly').addEventListener('click', function () {
        if (!pts.length) { alert('Gambar polygon (tool ⎔) dulu.'); return; }
        var p = pts[0].split(',');
        window.open(BASE_URL + '/tanah/tambah?lat=' + p[0].trim() + '&lon=' + (p[1]||'').trim(), '_blank');
    });
    // Anti-Overlap + cek selisih luas (server, satu sumber logika dgn Polygon.php)
    document.getElementById('cekValidasi').addEventListener('click', function () {
        var out = document.getElementById('hasilValidasi');
        if (!polyStr) { out.innerHTML = '<span class="text-danger">Gambar polygon (tool ⎔) dulu sebelum dicek.</span>'; return; }
        var luas = document.getElementById('luasBuku').value;
        var url = BASE_URL + '/peta/cek?poligon=' + encodeURIComponent(polyStr) + (luas !== '' ? '&luas=' + encodeURIComponent(luas) : '');
        out.innerHTML = '<span class="text-muted">⏳ Memeriksa…</span>';
        fetch(url).then(function (r) { return r.json(); }).then(function (d) {
            var h = '';
            if (d.overlap) {
                h += '<div class="alert alert-danger py-2 mb-1">⛔ <b>OVERLAP!</b> Tumpang tindih dgn No C ' + d.overlap.no_c + ' (' + d.overlap.nama + '). Entry basis dilarang.</div>';
            } else {
                h += '<div class="alert alert-success py-2 mb-1">✅ Anti-overlap: <b>AMAN</b> · 0% tumpang tindih. Luas polygon ± <b>' + d.area.toLocaleString('id-ID') + ' m²</b>.</div>';
            }
            if (d.warn) h += '<div class="alert alert-warning py-2 mb-1">⚠️ ' + d.warn + '</div>';
            else if (d.luas_buku) h += '<div class="text-muted">Selisih luas dalam toleransi (≤2%): <b>OK</b>.</div>';
            if (!d.ok && d.pesan) h += '<div class="alert alert-danger py-2 mb-1">' + d.pesan + '</div>';
            out.innerHTML = h || d.pesan;
        }).catch(function () { out.innerHTML = '<span class="text-danger">Gagal memeriksa. Coba lagi.</span>'; });
    });
})();
</script>
