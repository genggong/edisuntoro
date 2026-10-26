<?php
class UserController
{
    public function index()
    {
        $pdo = Database::conn();
        $users = $pdo->query("SELECT id, username, role, created_at FROM users ORDER BY id")->fetchAll();
        $title = 'Pengguna'; $active = 'pengguna'; $view = BASE_PATH . '/views/pengguna.php';
        require BASE_PATH . '/views/layout.php';
    }

    public function create()
    {
        $u = ['id' => null, 'username' => '', 'role' => 'operator', 'password' => ''];
        $title = 'Tambah Pengguna'; $active = 'pengguna'; $view = BASE_PATH . '/views/pengguna-form.php';
        require BASE_PATH . '/views/layout.php';
    }

    public function store()
    {
        csrf_check();
        $u = trim($_POST['username'] ?? '');
        $p = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'operator';
        if ($u === '' || $p === '') {
            flash_set('error', 'Username & password wajib diisi.');
            redirect('/pengguna/tambah');
        }
        if (!in_array($role, ['admin', 'operator', 'pengguna'], true)) {
            $role = 'operator';
        }
        $st = Database::conn()->prepare("INSERT INTO users (username, password, role) VALUES (?,?,?)");
        try {
            $st->execute([$u, password_hash($p, PASSWORD_DEFAULT), $role]);
            flash_set('ok', 'Akun ' . $u . ' dibuat.');
        } catch (Exception $ex) {
            flash_set('error', 'Username sudah dipakai.');
        }
        redirect('/pengguna');
    }

    public function edit($id)
    {
        $st = Database::conn()->prepare("SELECT id, username, role FROM users WHERE id = ?");
        $st->execute([$id]);
        $u = $st->fetch();
        if (!$u) {
            flash_set('error', 'Akun tidak ditemukan.');
            redirect('/pengguna');
        }
        $u['password'] = '';
        $title = 'Edit Pengguna'; $active = 'pengguna'; $view = BASE_PATH . '/views/pengguna-form.php';
        require BASE_PATH . '/views/layout.php';
    }

    public function update($id)
    {
        csrf_check();
        if ($id === (int)Auth::uid()) {
            flash_set('error', 'Tidak bisa mengubah akun Anda sendiri di sini.');
            redirect('/pengguna');
        }
        $pdo = Database::conn();
        $role = $_POST['role'] ?? 'operator';
        if (!in_array($role, ['admin', 'operator', 'pengguna'], true)) {
            $role = 'operator';
        }
        $pw = $_POST['password'] ?? '';
        if ($pw !== '') {
            $st = $pdo->prepare("UPDATE users SET role = ?, password = ? WHERE id = ?");
            $st->execute([$role, password_hash($pw, PASSWORD_DEFAULT), $id]);
        } else {
            $st = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
            $st->execute([$role, $id]);
        }
        flash_set('ok', 'Akun diperbarui.');
        redirect('/pengguna');
    }

    public function delete($id)
    {
        if ($id === (int)Auth::uid()) {
            flash_set('error', 'Tidak bisa menghapus akun sendiri.');
            redirect('/pengguna');
        }
        $st = Database::conn()->prepare("DELETE FROM users WHERE id = ?");
        $st->execute([$id]);
        flash_set('ok', 'Akun dihapus.');
        redirect('/pengguna');
    }
}
