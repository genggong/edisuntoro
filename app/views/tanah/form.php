<?php
// $row tersedia saat edit, null saat tambah.
$r = $row ?: [
    'nomor_c' => '', 'persil' => '', 'nama' => '', 'alamat' => '', 'blok_dusun' => '',
    'jenis' => 'sawah', 'luas' => 0, 'batas_utara' => '', 'batas_timur' => '', 'batas_selatan' => '',
    'batas_barat' => '', 'lat' => null, 'lon' => null, 'keterangan' => '', 'id' => null,
];
$action = $r['id'] ? BASE_URL . '/tanah/update/' . $r['id'] : BASE_URL . '/tanah/tambah';
?>
<form method="post" action="<?= $action ?>" class="form">
    <?= csrf_field() ?>
    <h2><?= $r['id'] ? 'Edit Buku C #' . $r['id'] : 'Tambah Buku C' ?></h2>

    <div class="field"><label>Nama pemilik *</label><input name="nama" value="<?= e($r['nama']) ?>" required></div>
    <div class="grid2">
        <div class="field"><label>No. C</label><input name="nomor_c" value="<?= e($r['nomor_c']) ?>"></div>
        <div class="field"><label>No. Persil</label><input name="persil" value="<?= e($r['persil']) ?>"></div>
    </div>
    <div class="grid2">
        <div class="field"><label>Blok / Dusun</label><input name="blok_dusun" value="<?= e($r['blok_dusun']) ?>" placeholder="contoh: Blok Karanganyar"></div>
        <div class="field"><label>Jenis tanah</label>
            <select name="jenis">
                <?php foreach (['sawah', 'tegal', 'pekarangan', 'darat'] as $j): ?>
                    <option value="<?= $j ?>" <?= $r['jenis'] === $j ? 'selected' : '' ?>><?= ucfirst($j) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    <div class="field"><label>Luas (m²)</label><input name="luas" type="number" step="0.01" min="0" value="<?= e($r['luas']) ?>"></div>
    <div class="field"><label>Alamat / domisili</label><input name="alamat" value="<?= e($r['alamat']) ?>"></div>
    <h3>Batas-batas tanah</h3>
    <div class="grid2">
        <div class="field"><label>Utara</label><input name="batas_utara" value="<?= e($r['batas_utara']) ?>"></div>
        <div class="field"><label>Timur</label><input name="batas_timur" value="<?= e($r['batas_timur']) ?>"></div>
        <div class="field"><label>Selatan</label><input name="batas_selatan" value="<?= e($r['batas_selatan']) ?>"></div>
        <div class="field"><label>Barat</label><input name="batas_barat" value="<?= e($r['batas_barat']) ?>"></div>
    </div>
    <h3>Titik koordinat (opsional, untuk peta)</h3>
    <div class="grid2">
        <div class="field"><label>Latitude</label><input name="lat" type="number" step="any" value="<?= $r['lat'] !== null ? e($r['lat']) : '' ?>" placeholder="-6.90535"></div>
        <div class="field"><label>Longitude</label><input name="lon" type="number" step="any" value="<?= $r['lon'] !== null ? e($r['lon']) : '' ?>" placeholder="109.02330"></div>
    </div>
    <p class="hint">Koordinat pusat desa Sidamulya: -6.90535, 109.02330. Titik tanah bisa ditambahkan sekitarnya.</p>
    <div class="field"><label>Keterangan</label><textarea name="keterangan" rows="2"><?= e($r['keterangan']) ?></textarea></div>

    <div class="form-actions">
        <button type="submit" class="btn">💾 Simpan</button>
        <a class="btn ghost" href="<?= BASE_URL ?>/tanah">Batal</a>
    </div>
</form>
