<div class="row g-3 mb-4">
  <div class="col-6">
    <div class="card border-0 shadow-sm text-center py-3">
      <div class="fs-3 fw-bold text-success"><?= fmt($totalBidang) ?></div>
      <div class="text-muted small">Total Bidang</div>
    </div>
  </div>
  <div class="col-6">
    <div class="card border-0 shadow-sm text-center py-3">
      <div class="fs-3 fw-bold text-success"><?= fmt($totalLuas) ?> m²</div>
      <div class="text-muted small">Total Luas</div>
    </div>
  </div>
</div>

<div class="card border-0 shadow-sm mb-4">
  <div class="card-body">
    <h6 class="fw-bold text-success mb-3">Per Jenis Tanah</h6>
    <?php if (!$perJenis): ?><p class="text-muted small mb-0">Belum ada data.</p>
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
    <h6 class="fw-bold text-success mb-3">Per Blok / Dusun</h6>
    <?php if (!$perBlok): ?><p class="text-muted small mb-0">Belum ada data.</p>
    <?php else: ?>
      <?php foreach ($perBlok as $b): if (!$b['blok_dusun']) continue; ?>
        <div class="d-flex justify-content-between py-2 border-bottom">
          <span class="fw-semibold"><?= e($b['blok_dusun']) ?></span>
          <span class="text-muted small"><?= fmt($b['jumlah']) ?> bidang · <?= fmt($b['luas']) ?> m²</span>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<div class="card border-0 shadow-sm d-none d-lg-block">
  <div class="table-responsive">
    <table class="table table-bordered mb-0">
      <thead class="table-light"><tr><th>Jenis</th><th>Bidang</th><th>Luas m²</th><th>% Luas</th></tr></thead>
      <tbody>
      <?php foreach ($perJenis as $j): $pct = $totalLuas > 0 ? round($j['luas'] / $totalLuas * 100, 1) : 0; ?>
        <tr><td><?= e(ucfirst($j['jenis'])) ?></td><td><?= fmt($j['jumlah']) ?></td><td><?= fmt($j['luas']) ?></td><td><?= fmt($pct, 1) ?>%</td></tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
