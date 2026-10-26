<div class="d-flex mb-3">
    <a class="btn btn-success" href="<?= BASE_URL ?>/pengguna/tambah">＋ Tambah Akun</a>
</div>

<div class="card border-0 shadow-sm mb-4">
  <div class="card-body">
    <h6 class="fw-bold text-success mb-2">Manajemen Akun &amp; Role Akses</h6>
    <p class="text-muted small mb-3">
      <span class="role-tag a">Admin</span> kelola penuh + akun
      <span class="role-tag o">Operator</span> tambah/edit data
      <span class="role-tag p">Pengguna</span> lihat saja
    </p>
    <?php foreach ($users as $u): ?>
    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
        <span>
            <strong><?= e($u['username']) ?></strong>
            <span class="role-tag <?= e($u['role'][0]) ?>"><?= e(role_label($u['role'])) ?></span>
            <br><small class="text-muted">dibuat <?= e($u['created_at']) ?></small>
        </span>
        <span class="text-nowrap">
            <a class="btn btn-sm btn-outline-success" href="<?= BASE_URL ?>/pengguna/edit/<?= $u['id'] ?>">✎</a>
            <?php if ((int)$u['id'] !== (int)Auth::uid()): ?>
            <a class="btn btn-sm btn-outline-danger" href="<?= BASE_URL ?>/pengguna/hapus/<?= $u['id'] ?>" onclick="return confirm('Hapus akun <?= e($u['username']) ?>?')">🗑</a>
            <?php endif; ?>
        </span>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="card border-0 shadow-sm d-none d-lg-block">
  <div class="table-responsive">
    <table class="table table-bordered mb-0">
        <thead class="table-light"><tr><th>Username</th><th>Role</th><th>Dibuat</th><th class="text-end">Aksi</th></tr></thead>
        <tbody>
        <?php foreach ($users as $u): ?>
            <tr>
                <td><?= e($u['username']) ?></td>
                <td><?= e(role_label($u['role'])) ?></td>
                <td><?= e($u['created_at']) ?></td>
                <td class="text-end text-nowrap">
                    <a class="text-success me-2" href="<?= BASE_URL ?>/pengguna/edit/<?= $u['id'] ?>">✎</a>
                    <?php if ((int)$u['id'] !== (int)Auth::uid()): ?>
                    <a class="text-danger" href="<?= BASE_URL ?>/pengguna/hapus/<?= $u['id'] ?>" onclick="return confirm('Hapus akun?')">🗑</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
  </div>
</div>
