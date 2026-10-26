<div class="card border-0 shadow-sm mb-4">
  <div class="card-body">
    <h5 class="fw-bold text-success">🗺️ Alur Sistem Buku C Digital &amp; Google GIS Integration</h5>
    <p class="text-muted small">
      Menggabungkan digitalisasi Buku C (data tekstual) dengan peta &amp; geometri koordinat Google GIS,
      lengkap dengan validasi spasial, mutasi, dan verifikasi birokrasi desa.
    </p>
    <div class="table-responsive">
      <img src="<?= BASE_URL ?>/assets/flowchart-bukuc-gis.png" alt="Flowchart Buku C Digital & GIS" class="img-fluid rounded border" width="100%">
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100"><div class="card-body">
      <div class="fs-4">🟢</div><h6 class="fw-bold text-success">1. Input &amp; Digitalisasi</h6>
      <p class="text-muted small mb-0">Scan data Buku C → overlay Google Satellite → digitasi polygon bidang → simpan di PostGIS (C_ID ↔ Geom_ID).</p>
    </div></div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100"><div class="card-body">
      <div class="fs-4">🟡</div><h6 class="fw-bold text-warning">2. Validasi Spasial</h6>
      <p class="text-muted small mb-0">Cek overlap (ST_Intersects) &amp; selisih luas Buku C vs GIS; tolak jika bentrok &amp; peringatkan jika <2% / &gt;2%.</p>
    </div></div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100"><div class="card-body">
      <div class="fs-4">🔵</div><h6 class="fw-bold text-primary">3. Mutasi &amp; Verifikasi</h6>
      <p class="text-muted small mb-0">Split/merge polygon utk jual-beli/waris/hibah → kohir anak baru → approval digital Kepala Desa.</p>
    </div></div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card border-0 shadow-sm h-100"><div class="card-body">
      <div class="fs-4">🟣</div><h6 class="fw-bold" style="color:#7b3ff2">4. Output &amp; Integrasi</h6>
      <p class="text-muted small mb-0">Dashboard peta interaktif, cetak kutipan Letter C + situasi, ekspor GeoJSON/SHP untuk BPN Bhumi.</p>
    </div></div>
  </div>
</div>
