<?php
$isEdit = !empty($u['id']);
$action = $isEdit ? BASE_URL . '/pengguna/update/' . $u['id'] : BASE_URL . '/pengguna/tambah';
?>
<form method="post" action="<?= $action ?>" class="form">
    <?= csrf_field() ?>
    <h2><?= $isEdit ? 'Edit Akun: ' . e($u['username']) : 'Tambah Akun Baru' ?></h2>

    <div class="field"><label>Username *</label>
        <input name="username" value="<?= e($u['username']) ?>" <?= $isEdit ? 'disabled' : 'required' ?>>
        <?php if ($isEdit): ?><p class="hint">Username tidak bisa diubah.</p><?php endif; ?>
    </div>
    <div class="field"><label>Password <?= $isEdit ? '(kosongkan jika tetap)' : '*' ?></label>
        <input name="password" type="password" <?= $isEdit ? '' : 'required' ?> autocomplete="new-password">
    </div>
    <div class="field"><label>Role akses</label>
        <select name="role">
            <?php foreach (['operator' => 'Operator (tambah/edit data)', 'pengguna' => 'Pengguna (lihat saja)', 'admin' => 'Admin (penuh)'] as $v => $lb): ?>
                <option value="<?= $v ?>" <?= $u['role'] === $v ? 'selected' : '' ?>><?= $lb ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn">💾 Simpan</button>
        <a class="btn ghost" href="<?= BASE_URL ?>/pengguna">Batal</a>
    </div>
</form>
