<div class="card border-0 shadow-sm">
  <div class="card-body">
    <h6 class="fw-bold text-success">✚ Ajukan Mutasi — <?= e($row['nama']) ?></h6>
    <p class="text-muted small mb-3">
      No C: <b><?= e($row['nomor_c'] ?: '-') ?></b> · Blok: <b><?= e($row['blok_dusun'] ?: '-') ?></b> ·
      Luas saat ini: <b><?= fmt($row['luas']) ?> m²</b> · Status: <?= status_label($row['status']) ?>
    </p>
    <form method="post" action="<?= BASE_URL ?>/mutasi/<?= $row['id'] ?>">
      <?= csrf_field() ?>
      <div class="mb-3">
        <label class="form-label fw-semibold">Jenis Mutasi</label>
        <select name="jenis" class="form-select">
          <option value="jual">Jual Beli</option>
          <option value="waris">Waris</option>
          <option value="hibah">Hibah</option>
          <option value="pecah">Pemecahan (Split)</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label fw-semibold">Pemilik Baru</label>
        <input name="pemilik_baru" class="form-control" required placeholder="Nama pemilik baru">
      </div>
      <div class="mb-3">
        <label class="form-label fw-semibold">Luas Baru (m²) <small class="text-muted">— wajib untuk Pemecahan</small></label>
        <input name="luas_baru" type="number" step="0.01" min="0" class="form-control" value="<?= $row['luas'] ?>">
      </div>
      <div class="mb-3">
        <label class="form-label fw-semibold">Keterangan</label>
        <textarea name="keterangan" rows="3" class="form-control" placeholder="Catatan / dasar mutasi, lampiran, dsb."></textarea>
      </div>
      <button class="btn btn-success">Ajukan &amp; Tunggu Persetujuan Kades</button>
      <a class="btn btn-outline-secondary" href="<?= BASE_URL ?>/mutasi">Batal</a>
    </form>
  </div>
</div>
