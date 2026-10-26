<?php
class DashboardController
{
    public function index()
    {
        $pdo = Database::conn();
        $totalBidang = (int)$pdo->query("SELECT COUNT(*) c FROM tanah")->fetch()['c'];
        $totalLuas  = (float)$pdo->query("SELECT COALESCE(SUM(luas),0) s FROM tanah")->fetch()['s'];
        $perJenis = $pdo->query("SELECT jenis, COUNT(*) jumlah, COALESCE(SUM(luas),0) luas FROM tanah GROUP BY jenis")->fetchAll();
        $terbaru = $pdo->query("SELECT * FROM tanah ORDER BY id DESC LIMIT 5")->fetchAll();
        $title = 'Beranda'; $active = 'dashboard'; $view = BASE_PATH . '/views/dashboard.php';
        require BASE_PATH . '/views/layout.php';
    }
}
