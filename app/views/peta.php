<div class="card border-0 shadow-sm">
  <div class="card-body">
    <h5 class="fw-bold text-success">Skema Peta Desa Sidamulya</h5>
    <p class="text-muted small">Wilayah (kotak) + titik koordinat bidang tanah yang sudah diisi lat/lon. Biru = titik bidang, merah = pusat desa.</p>
    <div class="table-responsive">
        <canvas id="map" width="720" height="560"></canvas>
    </div>
    <div class="legend">
        <span><i class="dot dot-green"></i> Pusat desa -6.90535, 109.02330</span>
        <span><i class="dot dot-blue"></i> Bidang tanah (lat/lon terisi)</span>
    </div>
  </div>
</div>

<script>
(function () {
    const wilayah = <?= json_encode($wilayah) ?>;
    const tanah = <?= json_encode($tanah) ?>;
    const pusat = <?= json_encode($pusat) ?>;
    const cv = document.getElementById('map');
    const ctx = cv.getContext('2d');
    const W = cv.width, H = cv.height;
    const PAD = 60;

    const all = [...wilayah, ...tanah.map(t => ({ lat: +t.lat, lon: +t.lon })), pusat];
    let minLat = Math.min(...all.map(p => p.lat));
    let maxLat = Math.max(...all.map(p => p.lat));
    let minLon = Math.min(...all.map(p => p.lon));
    let maxLon = Math.max(...all.map(p => p.lon));
    const spanLat = (maxLat - minLat) || 0.01;
    const spanLon = (maxLon - minLon) || 0.01;
    const k = Math.min((W - 2 * PAD) / spanLon, (H - 2 * PAD) / spanLat);

    function X(lon) { return (W / 2) + (lon - (minLon + maxLon) / 2) * k; }
    function Y(lat) { return (H / 2) - (lat - (minLat + maxLat) / 2) * k; }

    ctx.fillStyle = '#eef7ee';
    ctx.fillRect(0, 0, W, H);
    ctx.strokeStyle = '#d6e6d6';
    ctx.lineWidth = 1;
    for (let g = 0; g <= 8; g++) {
        ctx.beginPath(); ctx.moveTo(PAD + g * (W - 2 * PAD) / 8, PAD); ctx.lineTo(PAD + g * (W - 2 * PAD) / 8, H - PAD); ctx.stroke();
        ctx.beginPath(); ctx.moveTo(PAD, PAD + g * (H - 2 * PAD) / 8); ctx.lineTo(W - PAD, PAD + g * (H - 2 * PAD) / 8); ctx.stroke();
    }
    ctx.beginPath();
    wilayah.forEach((p, i) => { i ? ctx.lineTo(X(p.lon), Y(p.lat)) : ctx.moveTo(X(p.lon), Y(p.lat)); });
    ctx.closePath();
    ctx.fillStyle = 'rgba(20,83,45,0.06)';
    ctx.fill();
    ctx.strokeStyle = '#14532d';
    ctx.lineWidth = 2;
    ctx.stroke();
    ctx.fillStyle = '#14532d';
    ctx.font = '11px sans-serif';
    ctx.fillText('109.003, -6.925', 6, H - PAD + 16);
    ctx.fillText('109.043, -6.885', W - 150, 14);
    ctx.beginPath(); ctx.arc(X(pusat.lon), Y(pusat.lat), 8, 0, Math.PI * 2);
    ctx.fillStyle = '#dc2626'; ctx.fill();
    ctx.strokeStyle = '#fff'; ctx.lineWidth = 2; ctx.stroke();
    ctx.fillText('Pusat Desa', X(pusat.lon) + 12, Y(pusat.lat) - 10);
    tanah.forEach(t => {
        ctx.beginPath(); ctx.arc(X(+t.lon), Y(+t.lat), 6, 0, Math.PI * 2);
        ctx.fillStyle = '#2563eb'; ctx.fill();
        ctx.strokeStyle = '#fff'; ctx.lineWidth = 1.5; ctx.stroke();
    });
    ctx.fillStyle = '#374151';
    ctx.fillText('Koordinat wilayah Desa Sidamulya · Kec. Wanasari · Kab. Brebes (skema)', 10, H - 6);
})();
</script>
