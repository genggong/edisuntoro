<div class="stat-grid">
    <div class="stat"><span class="v"><?= fmt($totalBidang) ?></span><span class="l">Bidang Tanah</span></div>
    <div class="stat green"><span class="v"><?= fmt($totalLuas) ?> m²</span><span class="l">Total Luas</span></div>
    <div class="stat amber"><span class="v"><?= fmt($totalLuas/10000, 2) ?> Ha</span><span class="l">≈ Hektare</span></div>
</div>

<section class="card">
    <h2>Rekap per Jenis Tanah</h2>
    <?php if (!$perJenis): ?>
        <p class="empty">Belum ada data. Tambahkan data buku C dulu.</p>
    <?php else: ?>
        <?php foreach ($perJenis as $j): ?>
            <div class="row"><span><?= e(ucfirst($j['jenis'])) ?></span><span class="muted"><?= fmt($j['jumlah']) ?> bidang · <?= fmt($j['luas']) ?> m²</span></div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<section class="card">
    <h2>Data Terbaru</h2>
    <?php if (!$terbaru): ?>
        <p class="empty">Belum ada catatan.</p>
    <?php else: ?>
        <?php foreach ($terbaru as $t): ?>
            <div class="row">
                <span><strong><?= e($t['nama']) ?></strong><br><small class="muted">No C <?= e($t['nomor_c'] ?: '-') ?> · <?= e($t['jenis']) ?></small></span>
                <span class="muted"><?= fmt($t['luas']) ?> m²</span>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<a class="btn fab" href="<?= BASE_URL ?>/tanah/tambah">＋ Tambah Buku C</a>
