<?php
class AuthController
{
    public function loginForm()
    {
        require BASE_PATH . '/views/auth/login.php';
    }

    public function login()
    {
        csrf_check();
        $u = trim($_POST['username'] ?? '');
        $p = $_POST['password'] ?? '';
        if (Auth::attempt($u, $p)) {
            redirect('/');
        }
        flash_set('error', 'Username atau password salah.');
        redirect('/login');
    }

    public function logout()
    {
        Auth::logout();
        redirect('/login');
    }
}
