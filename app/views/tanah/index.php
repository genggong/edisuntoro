<?php
$canEdit = in_array(Auth::role(), ['admin', 'operator'], true);
$canDelete = Auth::role() === 'admin';
?>
<div class="d-flex flex-wrap gap-2 mb-3">
    <form method="get" class="d-flex flex-grow-1 gap-2">
        <input name="q" value="<?= e($_GET['q'] ?? '') ?>" class="form-control" placeholder="Cari nama / No C / persil / blok">
        <button class="btn btn-outline-success">Cari</button>
    </form>
    <?php if ($canEdit): ?><a class="btn btn-success" href="<?= BASE_URL ?>/tanah/tambah">＋ Tambah</a><?php endif; ?>
    <?php if ($canEdit): ?><a class="btn btn-outline-success" href="<?= BASE_URL ?>/ekspor">⬇ CSV</a><?php endif; ?>
</div>

<?php if (!$tanah): ?>
    <div class="card border-0 shadow-sm"><div class="card-body text-muted">Belum ada data buku C. Klik "＋ Tambah" untuk mengisi.</div></div>
<?php else: ?>
    <?php foreach ($tanah as $t): ?>
    <div class="card shadow-sm mb-2">
        <details class="rec p-0">
            <summary class="d-flex flex-wrap align-items-center gap-2 p-3">
                <span class="rec-id">No C: <?= e($t['nomor_c'] ?: '-') ?></span>
                <span class="rec-name"><?= e($t['nama']) ?></span>
                <span class="rec-luas"><?= fmt($t['luas']) ?> m²</span>
            </summary>
            <div class="border-top px-3 pt-3 pb-0">
                <div class="grid2 pb-2">
                    <span><small>Persil</small><b><?= e($t['persil'] ?: '-') ?></b></span>
                    <span><small>Blok / Dusun</small><b><?= e($t['blok_dusun'] ?: '-') ?></b></span>
                    <span><small>Jenis</small><b><?= e(ucfirst($t['jenis'])) ?></b></span>
                    <span><small>Alamat</small><b><?= e($t['alamat'] ?: '-') ?></b></span>
                    <span><small>Batas Utara</small><b><?= e($t['batas_utara'] ?: '-') ?></b></span>
                    <span><small>Batas Selatan</small><b><?= e($t['batas_selatan'] ?: '-') ?></b></span>
                    <span><small>Batas Timur</small><b><?= e($t['batas_timur'] ?: '-') ?></b></span>
                    <span><small>Batas Barat</small><b><?= e($t['batas_barat'] ?: '-') ?></b></span>
                    <span><small>Koordinat</small><b><?= $t['lat'] !== null ? number_format($t['lat'],6,',','.') . ', ' . number_format($t['lon'],6,',','.') : '-' ?></b></span>
                    <span><small>Ditambahkan</small><b><?= e($t['created_at']) ?></b></span>
                </div>
                <div class="rec-actions pb-3">
                    <?php if ($canEdit): ?><a class="btn btn-sm btn-outline-success" href="<?= BASE_URL ?>/tanah/edit/<?= $t['id'] ?>">✎ Edit</a><?php endif; ?>
                    <?php if ($canDelete): ?><a class="btn btn-sm btn-outline-danger" href="<?= BASE_URL ?>/tanah/hapus/<?= $t['id'] ?>" onclick="return confirm('Hapus data ini?')">🗑 Hapus</a><?php endif; ?>
                </div>
            </div>
        </details>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<div class="card border-0 shadow-sm d-none d-lg-block">
  <div class="table-responsive">
    <table class="table table-bordered align-middle mb-0">
        <thead class="table-light"><tr>
            <th>No C</th><th>Persil</th><th>Nama</th><th>Blok</th><th>Jenis</th><th>Luas m²</th><th>Koordinat</th><th class="text-end">Aksi</th>
        </tr></thead>
        <tbody>
        <?php foreach ($tanah as $i => $t): ?>
            <tr>
                <td><?= e($t['nomor_c'] ?: '-') ?></td>
                <td><?= e($t['persil'] ?: '-') ?></td>
                <td><?= e($t['nama']) ?></td>
                <td><?= e($t['blok_dusun'] ?: '-') ?></td>
                <td><?= e(ucfirst($t['jenis'])) ?></td>
                <td><?= fmt($t['luas']) ?></td>
                <td class="mono"><?= $t['lat'] !== null ? number_format($t['lat'],5,'.','') . ', ' . number_format($t['lon'],5,'.','') : '-' ?></td>
                <td class="text-end text-nowrap">
                    <?php if ($canEdit): ?><a class="text-success me-2" href="<?= BASE_URL ?>/tanah/edit/<?= $t['id'] ?>">✎</a><?php endif; ?>
                    <?php if ($canDelete): ?><a class="text-danger" href="<?= BASE_URL ?>/tanah/hapus/<?= $t['id'] ?>" onclick="return confirm('Hapus?')">🗑</a><?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
  </div>
</div>
