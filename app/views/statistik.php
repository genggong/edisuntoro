<div class="stat-grid">
    <div class="stat"><span class="v"><?= fmt($totalBidang) ?></span><span class="l">Total Bidang</span></div>
    <div class="stat green"><span class="v"><?= fmt($totalLuas) ?> m²</span><span class="l">Total Luas</span></div>
</div>

<section class="card">
    <h2>Per Jenis Tanah</h2>
    <?php if (!$perJenis): ?><p class="empty">Belum ada data.</p>
    <?php else: ?>
        <?php foreach ($perJenis as $j): ?>
        <div class="row">
            <span><strong><?= e(ucfirst($j['jenis'])) ?></strong></span>
            <span class="muted"><?= fmt($j['jumlah']) ?> bidang · <?= fmt($j['luas']) ?> m²</span>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<section class="card">
    <h2>Per Blok / Dusun</h2>
    <?php if (!$perBlok): ?><p class="empty">Belum ada data.</p>
    <?php else: ?>
        <?php foreach ($perBlok as $b): if (!$b['blok_dusun']) continue; ?>
        <div class="row">
            <span><strong><?= e($b['blok_dusun']) ?></strong></span>
            <span class="muted"><?= fmt($b['jumlah']) ?> bidang · <?= fmt($b['luas']) ?> m²</span>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<div class="wide-holder">
<table class="wide">
    <thead><tr><th>Jenis</th><th>Bidang</th><th>Luas m²</th><th>% Luas</th></tr></thead>
    <tbody>
    <?php foreach ($perJenis as $j): $pct = $totalLuas > 0 ? round($j['luas'] / $totalLuas * 100, 1) : 0; ?>
        <tr><td><?= e(ucfirst($j['jenis'])) ?></td><td><?= fmt($j['jumlah']) ?></td><td><?= fmt($j['luas']) ?></td><td><?= fmt($pct, 1) ?>%</td></tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
