<?php
class PetaController
{
    public function index()
    {
        $pdo = Database::conn();
        $tanah = $pdo->query("SELECT * FROM tanah WHERE lat IS NOT NULL AND lon IS NOT NULL")->fetchAll();
        // titik wilayah (poligon kira-kira) Desa Sidamulya
        $wilayah = [
            ['lat' => -6.92535, 'lon' => 109.00330],
            ['lat' => -6.88535, 'lon' => 109.00330],
            ['lat' => -6.88535, 'lon' => 109.04330],
            ['lat' => -6.92535, 'lon' => 109.04330],
        ];
        $pusat = ['lat' => -6.90535, 'lon' => 109.02330];
        $title = 'Peta'; $active = 'peta'; $view = BASE_PATH . '/views/peta.php';
        require BASE_PATH . '/views/layout.php';
    }
}
