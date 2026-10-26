<?php
/** Auth - sesi, login, guard role */
class Auth
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function attempt($username, $password)
    {
        $st = Database::conn()->prepare("SELECT * FROM users WHERE username = ?");
        $st->execute([$username]);
        $u = $st->fetch();
        if ($u && password_verify($password, $u['password'])) {
            session_regenerate_id(true);
            $_SESSION['uid'] = (int)$u['id'];
            $_SESSION['name'] = $u['username'];
            $_SESSION['role'] = $u['role'];
            return true;
        }
        return false;
    }

    public static function check()
    {
        return isset($_SESSION['uid']);
    }

    public static function role()
    {
        return $_SESSION['role'] ?? null;
    }

    public static function name()
    {
        return $_SESSION['name'] ?? '';
    }

    public static function uid()
    {
        return $_SESSION['uid'] ?? null;
    }

    public static function logout()
    {
        $_SESSION = [];
        session_destroy();
    }

    public static function requireRole($roles)
    {
        $roles = (array)$roles;
        if (!self::check()) {
            if (in_array('guest', $roles, true)) {
                return; // halaman publik untuk tamu
            }
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        if (!in_array(self::role(), $roles, true)) {
            http_response_code(403);
            exit('Akses ditolak.');
        }
    }
}
