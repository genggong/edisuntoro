<?php
/** Front controller + router */
define('BASE_PATH', __DIR__);
define('BASE_URL', str_replace('\\', '/', rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/')) ?: '');

require_once BASE_PATH . '/core/Database.php';
require_once BASE_PATH . '/core/Auth.php';
require_once BASE_PATH . '/core/Helper.php';

foreach (glob(BASE_PATH . '/controllers/*.php') as $f) {
    require_once $f;
}

Auth::start();

// Route table [method, pattern, controller, action, roles]
$routes = [
    ['GET', '/', 'DashboardController', 'index', ['admin', 'operator', 'pengguna']],
    ['GET', '/login', 'AuthController', 'loginForm', ['guest']],
    ['POST', '/login', 'AuthController', 'login', ['guest']],
    ['GET', '/logout', 'AuthController', 'logout', ['admin', 'operator', 'pengguna']],
    ['GET', '/tanah', 'TanahController', 'index', ['admin', 'operator', 'pengguna']],
    ['GET', '/tanah/tambah', 'TanahController', 'create', ['admin', 'operator']],
    ['POST', '/tanah/tambah', 'TanahController', 'store', ['admin', 'operator']],
    ['GET', '/tanah/edit/:id', 'TanahController', 'edit', ['admin', 'operator']],
    ['POST', '/tanah/update/:id', 'TanahController', 'update', ['admin', 'operator']],
    ['GET', '/tanah/hapus/:id', 'TanahController', 'delete', ['admin']],
    ['GET', '/statistik', 'StatistikController', 'index', ['admin', 'operator', 'pengguna']],
    ['GET', '/peta', 'PetaController', 'index', ['admin', 'operator', 'pengguna']],
    ['GET', '/ekspor', 'TanahController', 'export', ['admin', 'operator']],
    ['GET', '/pengguna', 'UserController', 'index', ['admin']],
    ['GET', '/pengguna/tambah', 'UserController', 'create', ['admin']],
    ['POST', '/pengguna/tambah', 'UserController', 'store', ['admin']],
    ['GET', '/pengguna/edit/:id', 'UserController', 'edit', ['admin']],
    ['POST', '/pengguna/update/:id', 'UserController', 'update', ['admin']],
    ['GET', '/pengguna/hapus/:id', 'UserController', 'delete', ['admin']],
];

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = BASE_URL;
if ($base && strpos($path, $base) === 0) {
    $path = substr($path, strlen($base));
}
$path = '/' . ltrim($path, '/');

foreach ($routes as $r) {
    list($rm, $pat, $ctrl, $act, $roles) = $r;
    if ($method !== $rm) {
        continue;
    }
    $regex = '#^' . preg_replace('#:id#', '([0-9]+)', $pat) . '$#';
    if (preg_match($regex, $path, $m)) {
        Auth::requireRole($roles);
        $c = new $ctrl();
        if (isset($m[1])) {
            $c->$act((int)$m[1]);
        } else {
            $c->$act();
        }
        exit;
    }
}

http_response_code(404);
echo 'Halaman tidak ditemukan.';
