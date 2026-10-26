<?php
$isEdit = !empty($u['id']);
$action = $isEdit ? BASE_URL . '/pengguna/update/' . $u['id'] : BASE_URL . '/pengguna/tambah';
?>
<div class="card border-0 shadow-sm">
  <div class="card-body">
    <h5 class="fw-bold text-success mb-4"><?= $isEdit ? 'Edit Akun: ' . e($u['username']) : 'Tambah Akun Baru' ?></h5>
    <form method="post" action="<?= $action ?>">
      <?= csrf_field() ?>
      <div class="mb-3">
        <label class="form-label">Username *</label>
        <input name="username" value="<?= e($u['username']) ?>" class="form-control" <?= $isEdit ? 'disabled' : 'required' ?>>
        <?php if ($isEdit): ?><p class="text-muted small">Username tidak bisa diubah.</p><?php endif; ?>
      </div>
      <div class="mb-3">
        <label class="form-label">Password <?= $isEdit ? '(kosongkan jika tetap)' : '*' ?></label>
        <input name="password" type="password" class="form-control" <?= $isEdit ? '' : 'required' ?> autocomplete="new-password">
      </div>
      <div class="mb-4">
        <label class="form-label">Role akses</label>
        <select name="role" class="form-select">
            <?php foreach (['operator' => 'Operator (tambah/edit data)', 'pengguna' => 'Pengguna (lihat saja)', 'admin' => 'Admin (penuh)'] as $v => $lb): ?>
                <option value="<?= $v ?>" <?= $u['role'] === $v ? 'selected' : '' ?>><?= $lb ?></option>
            <?php endforeach; ?>
        </select>
      </div>
      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-success">💾 Simpan</button>
        <a class="btn btn-outline-secondary" href="<?= BASE_URL ?>/pengguna">Batal</a>
      </div>
    </form>
  </div>
</div>
