<?php
class PetaController
{
    public function index()
    {
        $pdo = Database::conn();
        $tanah = $pdo->query("SELECT * FROM tanah")->fetchAll();
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

    /** STAGE 2 — Endpoint Anti-Overlap + cek selisih luas dari polygon yang digambar di menu Peta. */
    public function cek()
    {
        require_once BASE_PATH . '/core/Polygon.php';
        $pdo = Database::conn();
        $ring = Polygon::parse($_GET['poligon'] ?? '');
        header('Content-Type: application/json; charset=UTF-8');
        $res = ['ok' => false, 'area' => 0, 'overlap' => null, 'warn' => null, 'point' => count($ring) ];
        if (!$ring) {
            $res['pesan'] = 'Polygon tidak valid / kurang dari 3 titik.';
            echo json_encode($res); exit;
        }
        // luas polygon
        $area = Polygon::areaM2($ring);
        $res['area'] = round($area, 1);
        // overlap vs semua bidang lain
        $st = $pdo->query("SELECT id, nama, nomor_c, poligon FROM tanah WHERE poligon IS NOT NULL AND poligon <> ''");
        foreach ($st->fetchAll() as $r) {
            $o = Polygon::parse($r['poligon']);
            if ($o && Polygon::overlaps($ring, $o)) {
                $res['overlap'] = ['id' => $r['id'], 'nama' => $r['nama'], 'no_c' => $r['nomor_c']];
                $res['pesan'] = 'Overlap terdeteksi dengan bidang ini. Entry basis dilarang.';
                echo json_encode($res); exit;
            }
        }
        // selisih luas bila luas buku C diberikan
        if (isset($_GET['luas']) && is_numeric($_GET['luas']) && (float)$_GET['luas'] > 0 && $area > 0) {
            $lb = (float)$_GET['luas'];
            $selisih = round(abs($area - $lb) / $lb * 100, 1);
            $res['luas_buku'] = $lb;
            $res['selisih_pct'] = $selisih;
            if ($selisih > 2) {
                $res['warn'] = "Selisih luas: Buku C $lb m² vs polygon $area m² (" . $selisih . "% > toleransi 2%). Perlu re-ukur lapangan.";
            }
        }
        $res['ok'] = true;
        $res['pesan'] = $res['overlap'] ? 'Ditemukan tumpang tindih.' : 'Anti-overlap: AMAN · 0% tumpang tindih.';
        echo json_encode($res); exit;
    }
}
