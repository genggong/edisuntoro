<?php
class StatistikController
{
    public function index()
    {
        $pdo = Database::conn();
        $totalBidang = (int)$pdo->query("SELECT COUNT(*) c FROM tanah")->fetch()['c'];
        $totalLuas = (float)$pdo->query("SELECT COALESCE(SUM(luas),0) s FROM tanah")->fetch()['s'];
        $perJenis = $pdo->query("SELECT jenis, COUNT(*) jumlah, COALESCE(SUM(luas),0) luas FROM tanah GROUP BY jenis")->fetchAll();
        $perBlok = $pdo->query("SELECT blok_dusun, COUNT(*) jumlah, COALESCE(SUM(luas),0) luas FROM tanah GROUP BY blok_dusun")->fetchAll();
        $title = 'Rekap'; $active = 'statistik'; $view = BASE_PATH . '/views/statistik.php';
        require BASE_PATH . '/views/layout.php';
    }
}
