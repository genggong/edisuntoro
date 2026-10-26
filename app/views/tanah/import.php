<div class="card border-0 shadow-sm mb-4">
  <div class="card-body">
    <h6 class="fw-bold text-success mb-3">📥 Import Buku C (CSV / Excel)</h6>
    <p class="text-muted small mb-3">
      Unggah file CSV (bisa dari Excel — cukup <em>Save As → CSV</em>). Kolom harus sebaris dengan template.
    </p>
    <div class="d-flex flex-wrap gap-2 mb-3">
      <a class="btn btn-outline-success" href="<?= BASE_URL ?>/tanah/import/template">⬇ Contoh Format (Excel/CSV)</a>
    </div>
    <form method="post" action="<?= BASE_URL ?>/tanah/import" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="mb-2">
        <label class="form-label">Pilih file (.csv / .txt / .tab)</label>
        <input type="file" name="file" accept=".csv,.txt,.tab,.xls" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success">📤 Import Sekarang</button>
    </form>
  </div>
</div>

<div class="card border-0 shadow-sm mb-4">
  <div class="card-body">
    <h6 class="fw-bold text-success mb-3">🗺️ Import GIS / GeoJSON (Google)</h6>
    <p class="text-muted small mb-3">
      Untuk titik koordinat dari <strong>Google My Maps / Google Earth / QGIS</strong>. Ekspor titik sebagai
      <em>GeoJSON/KML</em>, lalu upload di sini. Property yang dikenali: <code>Pemilik</code>, <code>No C</code>,
      <code>Blok</code>, <code>Jenis</code>, <code>Luas m2</code>. Geometri <code>Point</code> (lon, lat).
    </p>
    <div class="d-flex flex-wrap gap-2 mb-3">
      <a class="btn btn-outline-success" href="<?= BASE_URL ?>/tanah/import/gis-template">⬇ Contoh GeoJSON</a>
    </div>
    <form method="post" action="<?= BASE_URL ?>/tanah/import/gis" enctype="multipart/form-data">
      <?= csrf_field() ?>
      <div class="mb-2">
        <label class="form-label">Pilih file (.geojson / .json)</label>
        <input type="file" name="file_gis" accept=".geojson,.json" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-success">🗺️ Import Titik GIS</button>
    </form>
  </div>
</div>

<div class="card border-0 shadow-sm">
  <div class="card-body">
    <h6 class="fw-bold text-success mb-2">Format Kolom (urutan penting)</h6>
    <div class="table-responsive">
      <table class="table table-sm table-bordered mb-0">
        <thead class="table-light"><tr>
          <th>#</th><th>Kolom</th><th>Contoh</th><th>Keterangan</th>
        </tr></thead>
        <tbody>
          <tr><td>1</td><td>No C</td><td>C-100</td><td>Nomor register</td></tr>
          <tr><td>2</td><td>Persil</td><td>PS-90</td><td>Nomor persil</td></tr>
          <tr><td>3</td><td>Nama *</td><td>Warsinem</td><td>Nama pemilik (wajib)</td></tr>
          <tr><td>4</td><td>Alamat</td><td>Desa Sidamulya</td><td></td></tr>
          <tr><td>5</td><td>Blok/Dusun</td><td>Blok Karanganyar</td><td></td></tr>
          <tr><td>6</td><td>Jenis</td><td>sawah</td><td>sawah / tegal / pekarangan / darat</td></tr>
          <tr><td>7</td><td>Luas (m2)</td><td>900</td><td>Angka</td></tr>
          <tr><td>8</td><td>Utara</td><td>jalan</td><td>Batas utara</td></tr>
          <tr><td>9</td><td>Timur</td><td>parit</td><td>Batas timur</td></tr>
          <tr><td>10</td><td>Selatan</td><td>kebun</td><td>Batas selatan</td></tr>
          <tr><td>11</td><td>Barat</td><td>rumah</td><td>Batas barat</td></tr>
          <tr><td>12</td><td>Lat</td><td>-6.9065</td><td>Koordinat lintang (opsional)</td></tr>
          <tr><td>13</td><td>Lon</td><td>109.0240</td><td>Koordinat bujur (opsional)</td></tr>
          <tr><td>14</td><td>Keterangan</td><td>-</td><td></td></tr>
        </tbody>
      </table>
    </div>
    <p class="text-muted small mt-2 mb-0">Baris pertama dipakai sebagai judul kepala (header) dan dilewati. Baris tanpa nama ditolak.</p>
  </div>
</div>
