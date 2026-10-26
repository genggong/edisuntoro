<?php
// Konfigurasi database.
//
// Driver: 'sqlite' (default, tanpa setup) atau 'mysql' (via phpMyAdmin).
// Untuk 'mysql': buat database + user di cPanel > MySQL Databases,
// lalu isi host/db/user/pass di bawah.

return [
    'driver' => 'sqlite',   // 'sqlite' | 'mysql'

    // --- MySQL (phpMyAdmin) ---
    'mysql_host' => 'localhost',        // biasanya localhost
    'mysql_port' => 3306,
    'mysql_db'   => '',                 // nama database, mis. edisun_bukuc
    'mysql_user' => '',                 // user db, mis. edisun_bukuc
    'mysql_pass' => '',                 // password db
];
