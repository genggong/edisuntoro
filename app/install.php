<?php
/** Install - buat DB + seed admin. HAPUS file ini setelah dipakai. */
define('BASE_PATH', __DIR__);
require_once BASE_PATH . '/core/Database.php';
Database::migrate();
echo "Instalasi selesai. DB: db/buku_c.db<br>";
echo "Akun admin: <b>admin</b> / <b>admin123</b> (segera ganti password).<br>";
echo 'Silakan <a href="index.php">buka aplikasi</a> dan login.';
