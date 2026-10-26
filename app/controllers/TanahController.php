<?php
class TanahController
{
    private function data($pdo)
    {
        return [
            'nomor_c' => trim($_POST['nomor_c'] ?? ''),
            'persil' => trim($_POST['persil'] ?? ''),
            'nama' => trim($_POST['nama'] ?? ''),
            'alamat' => trim($_POST['alamat'] ?? ''),
            'blok_dusun' => trim($_POST['blok_dusun'] ?? ''),
            'jenis' => trim($_POST['jenis'] ?? 'sawah'),
            'luas' => (float)($_POST['luas'] ?? 0),
            'batas_utara' => trim($_POST['batas_utara'] ?? ''),
            'batas_timur' => trim($_POST['batas_timur'] ?? ''),
            'batas_selatan' => trim($_POST['batas_selatan'] ?? ''),
            'batas_barat' => trim($_POST['batas_barat'] ?? ''),
            'lat' => $_POST['lat'] !== '' ? (float)$_POST['lat'] : null,
            'lon' => $_POST['lon'] !== '' ? (float)$_POST['lon'] : null,
            'keterangan' => trim($_POST['keterangan'] ?? ''),
        ];
    }

    public function index()
    {
        $pdo = Database::conn();
        $q = $_GET['q'] ?? '';
        $sql = "SELECT * FROM tanah";
        $params = [];
        if ($q !== '') {
            $sql .= " WHERE nama LIKE ? OR nomor_c LIKE ? OR persil LIKE ? OR blok_dusun LIKE ?";
            $like = "%$q%";
            $params = [$like, $like, $like, $like];
        }
        $sql .= " ORDER BY id DESC";
        $st = $pdo->prepare($sql);
        $st->execute($params);
        $tanah = $st->fetchAll();
        $title = 'Buku C'; $active = 'tanah'; $view = BASE_PATH . '/views/tanah/index.php';
        require BASE_PATH . '/views/layout.php';
    }

    public function create()
    {
        $row = null;
        $title = 'Tambah Buku C'; $active = 'tanah'; $view = BASE_PATH . '/views/tanah/form.php';
        require BASE_PATH . '/views/layout.php';
    }

    public function store()
    {
        csrf_check();
        $d = $this->data(Database::conn());
        if ($d['nama'] === '') {
            flash_set('error', 'Nama pemilik wajib diisi.');
            redirect('/tanah/tambah');
        }
        $st = Database::conn()->prepare(
            "INSERT INTO tanah (nomor_c, persil, nama, alamat, blok_dusun, jenis, luas, batas_utara, batas_timur, batas_selatan, batas_barat, lat, lon, keterangan)
             VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)"
        );
        $st->execute([
            $d['nomor_c'], $d['persil'], $d['nama'], $d['alamat'], $d['blok_dusun'], $d['jenis'], $d['luas'],
            $d['batas_utara'], $d['batas_timur'], $d['batas_selatan'], $d['batas_barat'], $d['lat'], $d['lon'], $d['keterangan']
        ]);
        flash_set('ok', 'Data buku C berhasil disimpan.');
        redirect('/tanah');
    }

    public function edit($id)
    {
        $st = Database::conn()->prepare("SELECT * FROM tanah WHERE id = ?");
        $st->execute([$id]);
        $row = $st->fetch();
        if (!$row) {
            flash_set('error', 'Data tidak ditemukan.');
            redirect('/tanah');
        }
        $title = 'Edit Buku C'; $active = 'tanah'; $view = BASE_PATH . '/views/tanah/form.php';
        require BASE_PATH . '/views/layout.php';
    }

    public function update($id)
    {
        csrf_check();
        $d = $this->data(Database::conn());
        $st = Database::conn()->prepare(
            "UPDATE tanah SET nomor_c=?, persil=?, nama=?, alamat=?, blok_dusun=?, jenis=?, luas=?, batas_utara=?, batas_timur=?, batas_selatan=?, batas_barat=?, lat=?, lon=?, keterangan=?, updated_at=datetime('now','localtime') WHERE id=?"
        );
        $st->execute([
            $d['nomor_c'], $d['persil'], $d['nama'], $d['alamat'], $d['blok_dusun'], $d['jenis'], $d['luas'],
            $d['batas_utara'], $d['batas_timur'], $d['batas_selatan'], $d['batas_barat'], $d['lat'], $d['lon'], $d['keterangan'], $id
        ]);
        flash_set('ok', 'Data berhasil diperbarui.');
        redirect('/tanah');
    }

    public function delete($id)
    {
        $st = Database::conn()->prepare("DELETE FROM tanah WHERE id = ?");
        $st->execute([$id]);
        flash_set('ok', 'Data dihapus.');
        redirect('/tanah');
    }

    public function export()
    {
        $pdo = Database::conn();
        $tanah = $pdo->query("SELECT * FROM tanah ORDER BY id")->fetchAll();
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="buku-c-pertanahan-sidamulya.csv"');
        $out = fopen('php://output', 'w');
        fputcsv($out, ['No', 'No C', 'Persil', 'Nama', 'Alamat', 'Blok/Dusun', 'Jenis', 'Luas (m2)', 'Utara', 'Timur', 'Selatan', 'Barat', 'Lat', 'Lon', 'Keterangan']);
        foreach ($tanah as $i => $t) {
            fputcsv($out, [$i + 1, $t['nomor_c'], $t['persil'], $t['nama'], $t['alamat'], $t['blok_dusun'], $t['jenis'], $t['luas'], $t['batas_utara'], $t['batas_timur'], $t['batas_selatan'], $t['batas_barat'], $t['lat'], $t['lon'], $t['keterangan']]);
        }
        exit;
    }
}
