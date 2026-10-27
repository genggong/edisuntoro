<?php $isAdmin = Auth::role() === 'admin'; ?>
<div class="d-flex flex-wrap gap-2 mb-3 align-items-center">
    <h6 class="mb-0 fw-bold text-success">📋 Riwayat Mutasi &amp; Verifikasi Kades</h6>
    <a class="btn btn-sm btn-outline-success" href="<?= BASE_URL ?>/tanah">← Kembali ke Buku C</a>
</div>

<?php if (!$rows): ?>
    <div class="card border-0 shadow-sm"><div class="card-body text-muted">
        Belum ada mutasi. Ajukan dari halaman Buku C (tombol <b>✚ Mutasi</b> pada tiap bidang).
    </div></div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered align-middle bg-white shadow-sm">
            <thead class="table-light"><tr>
                <th>ID</th><th>Bidang</th><th>Jenis</th><th>Pemilik (lama → baru)</th>
                <th>Luas (lama→baru)</th><th>Status</th><th>Pengaju</th><th>Tanggal</th><th class="text-end">Aksi</th>
            </tr></thead>
            <tbody>
            <?php foreach ($rows as $m): ?>
                <tr>
                    <td>#<?= $m['id'] ?></td>
                    <td><?= e($m['no_c'] ?: '-') ?><br><small class="text-muted"><?= e($m['bidang_nama'] ?: '-') ?></small></td>
                    <td><?= e(mutasi_jenis($m['jenis'])) ?></td>
                    <td><?= e($m['pemilik_lama']) ?> → <b><?= e($m['pemilik_baru']) ?></b></td>
                    <td><?= fmt($m['luas_lama']) ?> → <?= fmt($m['luas_baru']) ?> m²</td>
                    <td><?= status_label($m['status']) ?></td>
                    <td><?= e($m['dibuat_oleh']) ?></td>
                    <td class="mono small"><?= e($m['created_at']) ?></td>
                    <td class="text-end text-nowrap">
                        <?php if ($isAdmin && $m['status'] === 'pending'): ?>
                            <a class="btn btn-sm btn-success" href="<?= BASE_URL ?>/mutasi/setujui/<?= $m['id'] ?>" onclick="return confirm('Setujui mutasi ini? Bidang akan jadi AKTIF & terkunci.')">✓ Setujui</a>
                            <a class="btn btn-sm btn-outline-danger" href="<?= BASE_URL ?>/mutasi/tolak/<?= $m['id'] ?>" onclick="return confirm('Tolak mutasi ini?')">✗ Tolak</a>
                        <?php else: ?>
                            <span class="text-muted small"><?= $m['diproses_oleh'] ? 'oleh ' . e($m['diproses_oleh']) : '-' ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
