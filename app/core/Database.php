<?php
/** Database - koneksi PDO (SQLite atau MySQL) + migrasi idempotent */
class Database
{
    private static $pdo = null;

    private static function conf()
    {
        static $c = null;
        if ($c === null) {
            $c = require BASE_PATH . '/config.php';
        }
        return $c;
    }

    public static function conn()
    {
        if (self::$pdo === null) {
            $c = self::conf();
            if (($c['driver'] ?? 'sqlite') === 'mysql') {
                $dsn = 'mysql:host=' . $c['mysql_host'] . ';port=' . $c['mysql_port'] . ';dbname=' . $c['mysql_db'] . ';charset=utf8mb4';
                self::$pdo = new PDO($dsn, $c['mysql_user'], $c['mysql_pass']);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } else {
                $dir = BASE_PATH . '/db';
                if (!is_dir($dir)) {
                    mkdir($dir, 0775, true);
                }
                self::$pdo = new PDO('sqlite:' . $dir . '/buku_c.db');
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$pdo->exec('PRAGMA journal_mode=WAL;');
                self::$pdo->exec('PRAGMA foreign_keys=ON;');
            }
        }
        return self::$pdo;
    }

    /** Migrasi — jalankan sekali; aman dijalankan ulang. */
    public static function migrate()
    {
        $pdo = self::conn();
        $mysql = self::is_mysql();
        if ($mysql) {
            $pdo->exec("CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(80) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(20) NOT NULL DEFAULT 'admin',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
            $pdo->exec("CREATE TABLE IF NOT EXISTS tanah (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nomor_c VARCHAR(40),
                persil VARCHAR(40),
                nama VARCHAR(150) NOT NULL,
                alamat VARCHAR(200),
                blok_dusun VARCHAR(100),
                jenis VARCHAR(30) DEFAULT 'sawah',
                luas DECIMAL(12,2) DEFAULT 0,
                batas_utara VARCHAR(150),
                batas_timur VARCHAR(150),
                batas_selatan VARCHAR(150),
                batas_barat VARCHAR(150),
                lat DECIMAL(12,7),
                lon DECIMAL(12,7),
                keterangan TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        } else {
            $pdo->exec("CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE NOT NULL,
                password TEXT NOT NULL,
                role TEXT NOT NULL DEFAULT 'admin',
                created_at TEXT DEFAULT (datetime('now','localtime'))
            )");
            $pdo->exec("CREATE TABLE IF NOT EXISTS tanah (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nomor_c TEXT,
                persil TEXT,
                nama TEXT NOT NULL,
                alamat TEXT,
                blok_dusun TEXT,
                jenis TEXT DEFAULT 'sawah',
                luas REAL DEFAULT 0,
                batas_utara TEXT,
                batas_timur TEXT,
                batas_selatan TEXT,
                batas_barat TEXT,
                lat REAL,
                lon REAL,
                keterangan TEXT,
                created_at TEXT DEFAULT (datetime('now','localtime')),
                updated_at TEXT
            )");
        }
        // seed akun (idempotent)
        $st = $pdo->prepare("INSERT " . ($mysql ? 'IGNORE' : 'OR IGNORE') . " INTO users (username, password, role) VALUES (?,?,?)");
        $st->execute(['admin', password_hash('admin123', PASSWORD_DEFAULT), 'admin']);
        $st->execute(['operator', password_hash('operator123', PASSWORD_DEFAULT), 'operator']);
        $st->execute(['pengguna', password_hash('pengguna123', PASSWORD_DEFAULT), 'pengguna']);
    }

    public static function is_mysql()
    {
        return (self::conf()['driver'] ?? 'sqlite') === 'mysql';
    }
}
