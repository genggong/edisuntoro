<div class="toolbar">
    <form method="get" class="search">
        <input name="q" value="<?= e($_GET['q'] ?? '') ?>" placeholder="Cari nama / No C / persil / blok">
        <button class="btn small">Cari</button>
    </form>
    <a class="btn" href="<?= BASE_URL ?>/tanah/tambah">＋ Tambah</a>
    <a class="btn ghost" href="<?= BASE_URL ?>/ekspor">⬇ CSV</a>
</div>

<?php if (!$tanah): ?>
    <p class="empty card">Belum ada data buku C. Klik "＋ Tambah" untuk mengisi.</p>
<?php else: ?>
    <?php foreach ($tanah as $t): ?>
    <details class="card rec">
        <summary>
            <span class="rec-id">No C: <?= e($t['nomor_c'] ?: '-') ?></span>
            <span class="rec-name"><?= e($t['nama']) ?></span>
            <span class="rec-luas"><?= fmt($t['luas']) ?> m²</span>
        </summary>
        <div class="grid2">
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
        <div class="actions">
            <a class="btn small ghost" href="<?= BASE_URL ?>/tanah/edit/<?= $t['id'] ?>">✎ Edit</a>
            <a class="btn small danger" href="<?= BASE_URL ?>/tanah/hapus/<?= $t['id'] ?>" onclick="return confirm('Hapus data ini?')">🗑 Hapus</a>
        </div>
    </details>
    <?php endforeach; ?>
<?php endif; ?>

<table class="wide">
    <thead><tr>
        <th>No C</th><th>Persil</th><th>Nama</th><th>Blok</th><th>Jenis</th><th>Luas m²</th><th>Koordinat</th><th>Aksi</th>
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
            <td>
                <a href="<?= BASE_URL ?>/tanah/edit/<?= $t['id'] ?>">✎</a>
                <a href="<?= BASE_URL ?>/tanah/hapus/<?= $t['id'] ?>" onclick="return confirm('Hapus?')">🗑</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
