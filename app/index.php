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
    ['GET', '/', 'DashboardController', 'index', ['admin']],
    ['GET', '/login', 'AuthController', 'loginForm', ['guest']],
    ['POST', '/login', 'AuthController', 'login', ['guest']],
    ['GET', '/logout', 'AuthController', 'logout', ['admin']],
    ['GET', '/tanah', 'TanahController', 'index', ['admin']],
    ['GET', '/tanah/tambah', 'TanahController', 'create', ['admin']],
    ['POST', '/tanah/tambah', 'TanahController', 'store', ['admin']],
    ['GET', '/tanah/edit/:id', 'TanahController', 'edit', ['admin']],
    ['POST', '/tanah/update/:id', 'TanahController', 'update', ['admin']],
    ['GET', '/tanah/hapus/:id', 'TanahController', 'delete', ['admin']],
    ['GET', '/statistik', 'StatistikController', 'index', ['admin']],
    ['GET', '/peta', 'PetaController', 'index', ['admin']],
    ['GET', '/ekspor', 'TanahController', 'export', ['admin']],
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
