<div class="row g-3 mb-4">
  <div class="col-4">
    <div class="card border-0 shadow-sm text-center py-3">
      <div class="fs-3 fw-bold text-success"><?= fmt($totalBidang) ?></div>
      <div class="text-muted small">Bidang Tanah</div>
    </div>
  </div>
  <div class="col-4">
    <div class="card border-0 shadow-sm text-center py-3">
      <div class="fs-3 fw-bold text-success"><?= fmt($totalLuas) ?> m²</div>
      <div class="text-muted small">Total Luas</div>
    </div>
  </div>
  <div class="col-4">
    <div class="card border-0 shadow-sm text-center py-3">
      <div class="fs-3 fw-bold text-warning"><?= fmt($totalLuas/10000, 2) ?> Ha</div>
      <div class="text-muted small">≈ Hektare</div>
    </div>
  </div>
</div>

<div class="card border-0 shadow-sm mb-4">
  <div class="card-body">
    <h6 class="fw-bold text-success mb-3">Rekap per Jenis Tanah</h6>
    <?php if (!$perJenis): ?>
      <p class="text-muted small mb-0">Belum ada data. Tambahkan data buku C dulu.</p>
    <?php else: ?>
      <?php foreach ($perJenis as $j): ?>
        <div class="d-flex justify-content-between py-2 border-bottom">
          <span class="fw-semibold"><?= e(ucfirst($j['jenis'])) ?></span>
          <span class="text-muted small"><?= fmt($j['jumlah']) ?> bidang · <?= fmt($j['luas']) ?> m²</span>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<div class="card border-0 shadow-sm mb-4">
  <div class="card-body">
    <h6 class="fw-bold text-success mb-3">Data Terbaru</h6>
    <?php if (!$terbaru): ?>
      <p class="text-muted small mb-0">Belum ada catatan.</p>
    <?php else: ?>
      <?php foreach ($terbaru as $t): ?>
        <div class="d-flex justify-content-between py-2 border-bottom">
          <span><strong><?= e($t['nama']) ?></strong><br><small class="text-muted">No C <?= e($t['nomor_c'] ?: '-') ?> · <?= e($t['jenis']) ?></small></span>
          <span class="text-muted align-self-center"><?= fmt($t['luas']) ?> m²</span>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<?php if (in_array(Auth::role(), ['admin','operator'], true)): ?>
  <a href="<?= BASE_URL ?>/tanah/tambah" class="btn btn-success btn-lg rounded-pill shadow w-100">＋ Tambah Buku C</a>
<?php endif; ?>
