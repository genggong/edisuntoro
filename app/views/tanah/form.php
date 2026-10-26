<?php
// $row tersedia saat edit, null saat tambah.
$r = $row ?: [
    'nomor_c' => '', 'persil' => '', 'nama' => '', 'alamat' => '', 'blok_dusun' => '',
    'jenis' => 'sawah', 'luas' => 0, 'batas_utara' => '', 'batas_timur' => '', 'batas_selatan' => '',
    'batas_barat' => '', 'lat' => null, 'lon' => null, 'keterangan' => '', 'id' => null,
];
$action = $r['id'] ? BASE_URL . '/tanah/update/' . $r['id'] : BASE_URL . '/tanah/tambah';
?>
<div class="card border-0 shadow-sm">
  <div class="card-body">
    <h5 class="fw-bold text-success mb-4"><?= $r['id'] ? 'Edit Buku C #' . $r['id'] : 'Tambah Buku C' ?></h5>
    <form method="post" action="<?= $action ?>">
      <?= csrf_field() ?>
      <div class="mb-3">
        <label class="form-label">Nama pemilik *</label>
        <input name="nama" value="<?= e($r['nama']) ?>" class="form-control" required>
      </div>
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label">No. C</label><input name="nomor_c" value="<?= e($r['nomor_c']) ?>" class="form-control"></div>
        <div class="col-md-6"><label class="form-label">No. Persil</label><input name="persil" value="<?= e($r['persil']) ?>" class="form-control"></div>
        <div class="col-md-6"><label class="form-label">Blok / Dusun</label><input name="blok_dusun" value="<?= e($r['blok_dusun']) ?>" class="form-control" placeholder="contoh: Blok Karanganyar"></div>
        <div class="col-md-6"><label class="form-label">Jenis tanah</label>
            <select name="jenis" class="form-select">
                <?php foreach (['sawah', 'tegal', 'pekarangan', 'darat'] as $j): ?>
                    <option value="<?= $j ?>" <?= $r['jenis'] === $j ? 'selected' : '' ?>><?= ucfirst($j) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6"><label class="form-label">Luas (m²)</label><input name="luas" type="number" step="0.01" min="0" value="<?= e($r['luas']) ?>" class="form-control"></div>
        <div class="col-md-6"><label class="form-label">Alamat / domisili</label><input name="alamat" value="<?= e($r['alamat']) ?>" class="form-control"></div>
      </div>

      <h6 class="fw-bold text-success mt-4">Batas-batas tanah</h6>
      <div class="row g-3">
        <div class="col-6 col-md-3"><label class="form-label">Utara</label><input name="batas_utara" value="<?= e($r['batas_utara']) ?>" class="form-control"></div>
        <div class="col-6 col-md-3"><label class="form-label">Timur</label><input name="batas_timur" value="<?= e($r['batas_timur']) ?>" class="form-control"></div>
        <div class="col-6 col-md-3"><label class="form-label">Selatan</label><input name="batas_selatan" value="<?= e($r['batas_selatan']) ?>" class="form-control"></div>
        <div class="col-6 col-md-3"><label class="form-label">Barat</label><input name="batas_barat" value="<?= e($r['batas_barat']) ?>" class="form-control"></div>
      </div>

      <h6 class="fw-bold text-success mt-4">Titik koordinat (opsional, untuk peta)</h6>
      <div class="row g-3">
        <div class="col-md-6"><label class="form-label">Latitude</label><input name="lat" type="number" step="any" value="<?= $r['lat'] !== null ? e($r['lat']) : '' ?>" class="form-control" placeholder="-6.90535"></div>
        <div class="col-md-6"><label class="form-label">Longitude</label><input name="lon" type="number" step="any" value="<?= $r['lon'] !== null ? e($r['lon']) : '' ?>" class="form-control" placeholder="109.02330"></div>
      </div>
      <p class="text-muted small mt-2">Koordinat pusat desa Sidamulya: -6.90535, 109.02330. Titik tanah bisa ditambahkan sekitarnya.</p>
      <div class="mb-3"><label class="form-label">Keterangan</label><textarea name="keterangan" rows="2" class="form-control"><?= e($r['keterangan']) ?></textarea></div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success">💾 Simpan</button>
        <a class="btn btn-outline-secondary" href="<?= BASE_URL ?>/tanah">Batal</a>
      </div>
    </form>
  </div>
</div>
