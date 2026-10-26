<?php
/** Database - koneksi PDO SQLite + migrasi idempotent */
class Database
{
    private static $pdo = null;

    public static function conn()
    {
        if (self::$pdo === null) {
            $dir = BASE_PATH . '/db';
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }
            $file = $dir . '/buku_c.db';
            self::$pdo = new PDO('sqlite:' . $file);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            self::$pdo->exec('PRAGMA journal_mode=WAL;');
            self::$pdo->exec('PRAGMA foreign_keys=ON;');
        }
        return self::$pdo;
    }

    public static function migrate()
    {
        $pdo = self::conn();
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
        // seed admin (idempotent)
        $st = $pdo->prepare("INSERT OR IGNORE INTO users (username, password, role) VALUES (?,?,?)");
        $st->execute(['admin', password_hash('admin123', PASSWORD_DEFAULT), 'admin']);
        $st->execute(['operator', password_hash('operator123', PASSWORD_DEFAULT), 'operator']);
        $st->execute(['pengguna', password_hash('pengguna123', PASSWORD_DEFAULT), 'pengguna']);
    }
}
