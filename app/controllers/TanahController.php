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

    /* ---------- EKSPOR ---------- */

    public function exportExcel()
    {
        $tanah = Database::conn()->query("SELECT * FROM tanah ORDER BY id")->fetchAll();
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
        header('Content-Disposition: attachment; filename="buku-c-pertanahan-sidamulya.xls"');
        echo "\xEF\xBB\xBF"; // UTF-8 BOM agar Excel kenal
        echo '<html><head><meta charset="UTF-8"></head><body><table border="1">';
        echo '<tr><th>No</th><th>No C</th><th>Persil</th><th>Nama</th><th>Alamat</th><th>Blok/Dusun</th><th>Jenis</th><th>Luas (m2)</th><th>Utara</th><th>Timur</th><th>Selatan</th><th>Barat</th><th>Lat</th><th>Lon</th><th>Ket</th></tr>';
        foreach ($tanah as $i => $t) {
            echo '<tr><td>'.($i+1).'</td><td>'.htmlspecialchars($t['nomor_c']).'</td><td>'.htmlspecialchars($t['persil']).'</td><td>'.htmlspecialchars($t['nama']).'</td><td>'.htmlspecialchars($t['alamat']).'</td><td>'.htmlspecialchars($t['blok_dusun']).'</td><td>'.htmlspecialchars($t['jenis']).'</td><td>'.$t['luas'].'</td><td>'.htmlspecialchars($t['batas_utara']).'</td><td>'.htmlspecialchars($t['batas_timur']).'</td><td>'.htmlspecialchars($t['batas_selatan']).'</td><td>'.htmlspecialchars($t['batas_barat']).'</td><td>'.$t['lat'].'</td><td>'.$t['lon'].'</td><td>'.htmlspecialchars($t['keterangan']).'</td></tr>';
        }
        echo '</table></body></html>';
        exit;
    }

    public function exportPdf()
    {
        require_once BASE_PATH . '/core/SimplePdf.php';
        $tanah = Database::conn()->query("SELECT * FROM tanah ORDER BY id")->fetchAll();
        $pdf = new SimplePdf();
        $pdf->addTitle('Buku C Pertanahan', 'Desa Sidamulya · Kec. Wanasari · Kab. Brebes');
        $headers = ['No','No C','Persil','Nama','Blok','Jenis','Luas m2','Lat','Lon'];
        $rows = [];
        foreach ($tanah as $i => $t) {
            $rows[] = [$i + 1, $t['nomor_c'], $t['persil'], $t['nama'], $t['blok_dusun'], $t['jenis'], $t['luas'], $t['lat'], $t['lon']];
        }
        $pdf->table($headers, $rows);
        $pdf->note('Total: ' . count($tanah) . ' bidang · Dihasilkan otomatis oleh Aplikasi Buku C Pertanahan.');
        $pdf->output('buku-c-pertanahan-sidamulya.pdf');
    }

    public function exportGeojson()
    {
        $tanah = Database::conn()->query("SELECT * FROM tanah ORDER BY id")->fetchAll();
        $fc = ['type' => 'FeatureCollection', 'name' => 'Buku C Pertanahan Desa Sidamulya', 'features' => []];
        foreach ($tanah as $t) {
            $props = [
                'No C' => $t['nomor_c'], 'Persil' => $t['persil'], 'Pemilik' => $t['nama'],
                'Blok' => $t['blok_dusun'], 'Jenis' => $t['jenis'], 'Luas m2' => $t['luas'],
            ];
            if ($t['lat'] !== null && $t['lon'] !== null) {
                $fc['features'][] = [
                    'type' => 'Feature',
                    'properties' => $props,
                    'geometry' => ['type' => 'Point', 'coordinates' => [(float)$t['lon'], (float)$t['lat']]],
                ];
            } else {
                $fc['features'][] = ['type' => 'Feature', 'properties' => $props, 'geometry' => null];
            }
        }
        header('Content-Type: application/geo+json; charset=UTF-8');
        header('Content-Disposition: attachment; filename="buku-c-pertanahan-sidamulya.geojson"');
        echo json_encode($fc, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    /* ---------- IMPORT ---------- */

    public function importForm()
    {
        $title = 'Import Buku C'; $active = 'tanah'; $view = BASE_PATH . '/views/tanah/import.php';
        require BASE_PATH . '/views/layout.php';
    }

    public function importTemplate()
    {
        $upf = "\xEF\xBB\xBF";
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="contoh-import-buku-c.csv"');
        echo $upf;
        $cols = ['nomor_c','persil','nama','alamat','blok_dusun','jenis','luas','batas_utara','batas_timur','batas_selatan','batas_barat','lat','lon','keterangan'];
        $cols2 = ['No C','Persil','Nama','Alamat','Blok/Dusun','Jenis','Luas (m2)','Utara','Timur','Selatan','Barat','Lat','Lon','Keterangan'];
        $fh = fopen('php://output', 'w');
        fputcsv($fh, $cols2);
        fputcsv($fh, ['C-100','PS-90','Contoh Pemilik','Desa Sidamulya','Blok Karanganyar','sawah',900,'jalan','parit','kebun','rumah',-6.9065,109.024,'contoh baris 1']);
        fputcsv($fh, ['C-101','PS-91','Contoh Kedua','Desa Sidamulya','Blok Krajan','tegal',500,'sawah','jalan','sungai kecil','kebun',-6.9030,109.0210]);
        fclose($fh);
        exit;
    }

    public function importDo()
    {
        csrf_check();
        $uploads = isset($_FILES['file']) ? $_FILES['file'] : null;
        if (!$uploads || ($uploads['error'] ?? 1) !== UPLOAD_ERR_OK) {
            flash_set('error', 'Pilih file CSV/Excel untuk diimport.');
            redirect('/tanah/import');
        }
        $data = file_get_contents($uploads['tmp_name']);
        $data = preg_replace('/^\xEF\xBB\xBF/', '', $data);   // strip BOM
        $data = str_replace(["\r\n", "\r"], "\n", $data);      // normalize newline

        $rows = [];
        // deteksi delimiter: koma atau tab
        $firstLine = strtok($data, "\n");
        $delim = (substr_count($firstLine, "\t") > substr_count($firstLine, ',')) ? "\t" : ',';
        $lines = array_filter(explode("\n", $data), fn($l) => trim($l) !== '');

        // kolom wajib per urutan (selaras template)
        $keys = ['nomor_c','persil','nama','alamat','blok_dusun','jenis','luas','batas_utara','batas_timur','batas_selatan','batas_barat','lat','lon','keterangan'];
        $ok = 0; $skip = 0; $dupe = 0;
        $st = Database::conn()->prepare("INSERT INTO tanah (nomor_c, persil, nama, alamat, blok_dusun, jenis, luas, batas_utara, batas_timur, batas_selatan, batas_barat, lat, lon, keterangan) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

        $first = true;
        foreach ($lines as $line) {
            $c = str_getcsv($line, $delim);
            if ($first) { $first = false; continue; } // lewati baris header
            if (count($c) < 3) { $skip++; continue; }
            if (trim($c[2] ?? '') === '') { $skip++; continue; } // nama kosong
            $r = array_pad($c, 14, '');
            try {
                $st->execute([
                    trim($r[0]), trim($r[1]), trim($r[2]), trim($r[3]), trim($r[4]),
                    !in_array(trim($r[5]), ['sawah','tegal','pekarangan','darat']) ? 'sawah' : trim($r[5]),
                    (float)$r[6], trim($r[7]), trim($r[8]), trim($r[9]), trim($r[10]),
                    $r[11] !== '' ? (float)$r[11] : null,
                    $r[12] !== '' ? (float)$r[12] : null,
                    trim($r[13])
                ]);
                $ok++;
            } catch (Exception $ex) {
                $dupe++;
            }
        }
        flash_set('ok', "Import selesai: $ok baris sukses, $skip dilewati (baris kosong/tanpa nama), $dupe gagal (ganda/masalah).");
        redirect('/tanah');
    }

    /* ---------- IMPORT GIS / GeoJSON (Google) ---------- */

    public function gisTemplate()
    {
        $sample = [
            'type' => 'FeatureCollection',
            'name' => 'Contoh Import Buku C',
            'features' => [
                ['type' => 'Feature', 'properties' => ['No C' => 'C-300', 'Pemilik' => 'Contoh GIS 1', 'Blok' => 'Blok Karanganyar', 'Jenis' => 'sawah', 'Luas m2' => 750], 'geometry' => ['type' => 'Point', 'coordinates' => [109.0240, -6.9065]]],
                ['type' => 'Feature', 'properties' => ['No C' => 'C-301', 'Pemilik' => 'Contoh GIS 2', 'Blok' => 'Blok Krajan', 'Jenis' => 'tegal', 'Luas m2' => 400], 'geometry' => ['type' => 'Point', 'coordinates' => [109.0210, -6.9030]]],
            ],
        ];
        header('Content-Type: application/geo+json; charset=UTF-8');
        header('Content-Disposition: attachment; filename="contoh-import-gis.geojson"');
        echo json_encode($sample, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit;
    }

    public function importGeojsonDo()
    {
        csrf_check();
        $up = $_FILES['file_gis'] ?? null;
        if (!$up || ($up['error'] ?? 1) !== UPLOAD_ERR_OK) {
            flash_set('error', 'Pilih file GeoJSON (.geojson / .json).');
            redirect('/tanah/import');
        }
        $json = file_get_contents($up['tmp_name']);
        $data = json_decode($json, true);
        if (!is_array($data) || !isset($data['type'])) {
            flash_set('error', 'File bukan GeoJSON valid.');
            redirect('/tanah/import');
        }

        $features = $data['type'] === 'FeatureCollection' ? ($data['features'] ?? []) : ($data['type'] === 'Feature' ? [$data] : []);
        if (!$features) {
            flash_set('error', 'Tidak ada fitur (Feature/Point) di dalam GeoJSON.');
            redirect('/tanah/import');
        }

        $st = Database::conn()->prepare("INSERT INTO tanah (nomor_c, nama, blok_dusun, jenis, luas, lat, lon) VALUES (?,?,?,?,?,?,?)");
        $ok = 0; $skip = 0;
        foreach ($features as $f) {
            $geom = $f['geometry'] ?? null;
            if (!$geom || ($geom['type'] ?? '') !== 'Point') { $skip++; continue; }
            $c = $geom['coordinates'] ?? null;
            if (!is_array($c) || count($c) < 2) { $skip++; continue; }
            $lon = (float)$c[0]; $lat = (float)$c[1];
            $p = $f['properties'] ?? [];
            $nama = $p['Pemilik'] ?? $p['Nama'] ?? $p['nama'] ?? $p['name'] ?? '';
            if ($nama === '') { $skip++; continue; }
            $noC = (string)($p['No C'] ?? $p['no_c'] ?? $p['No_C'] ?? $p['nomor_c'] ?? '');
            $blok = (string)($p['Blok'] ?? $p['blok_dusun'] ?? $p['Blok/Dusun'] ?? '');
            $jenisIn = (string)($p['Jenis'] ?? $p['jenis'] ?? 'sawah');
            $jenis = in_array($jenisIn, ['sawah','tegal','pekarangan','darat']) ? $jenisIn : 'sawah';
            $luas = (float)($p['Luas m2'] ?? $p['luas'] ?? 0);
            try {
                $st->execute([$noC, $nama, $blok, $jenis, $luas, $lat, $lon]);
                $ok++;
            } catch (Exception $e) { $skip++; }
        }
        flash_set('ok', "Import GIS selesai: $ok titik masuk, $skip dilewati (bukan Point / tanpa nama).");
        redirect('/tanah');
    }
}
