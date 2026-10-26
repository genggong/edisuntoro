<div class="toolbar">
    <a class="btn" href="<?= BASE_URL ?>/pengguna/tambah">＋ Tambah Akun</a>
</div>

<section class="card">
    <h2>Manajemen Akun &amp; Role Akses</h2>
    <div class="legend nh">
        <span class="role-tag a">Admin</span> kelola penuh + akun
        <span class="role-tag o">Operator</span> tambah/edit data
        <span class="role-tag p">Pengguna</span> lihat saja
    </div>
    <?php foreach ($users as $u): ?>
    <div class="row">
        <span>
            <strong><?= e($u['username']) ?></strong>
            <span class="role-tag <?= $u['role'][0] ?>"><?= e(role_label($u['role'])) ?></span>
            <br><small class="muted">dibuat <?= e($u['created_at']) ?></small>
        </span>
        <span class="actions-inline">
            <a class="btn small ghost" href="<?= BASE_URL ?>/pengguna/edit/<?= $u['id'] ?>">✎</a>
            <?php if ((int)$u['id'] !== (int)Auth::uid()): ?>
            <a class="btn small danger" href="<?= BASE_URL ?>/pengguna/hapus/<?= $u['id'] ?>" onclick="return confirm('Hapus akun <?= e($u['username']) ?>?')">🗑</a>
            <?php endif; ?>
        </span>
    </div>
    <?php endforeach; ?>
</section>

<table class="wide">
    <thead><tr><th>Username</th><th>Role</th><th>Dibuat</th><th>Aksi</th></tr></thead>
    <tbody>
    <?php foreach ($users as $u): ?>
        <tr>
            <td><?= e($u['username']) ?></td>
            <td><?= e(role_label($u['role'])) ?></td>
            <td><?= e($u['created_at']) ?></td>
            <td>
                <a href="<?= BASE_URL ?>/pengguna/edit/<?= $u['id'] ?>">✎</a>
                <?php if ((int)$u['id'] !== (int)Auth::uid()): ?>
                <a href="<?= BASE_URL ?>/pengguna/hapus/<?= $u['id'] ?>" onclick="return confirm('Hapus akun?')">🗑</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
