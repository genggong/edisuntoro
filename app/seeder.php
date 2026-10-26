<?php
/** Seeder data contoh Buku C Desa Sidamulya (idempotent) */
define('BASE_PATH', __DIR__);
require_once BASE_PATH . '/core/Database.php';
Database::migrate();
$pdo = Database::conn();

$rows = [
    ['nomor_c'=>'C-001','persil'=>'PS-12','nama'=>'Warsinem','alamat'=>'Dusun Karanganyar','blok_dusun'=>'Karanganyar','jenis'=>'sawah','luas'=>1200,'batas_utara'=>'jalan poros','batas_timur'=>'sungai kecil','batas_selatan'=>'kebun','batas_barat'=>'rumah','lat'=>-6.9065,'lon'=>109.0240],
    ['nomor_c'=>'C-002','persil'=>'PS-13','nama'=>'Sutarno','alamat'=>'Dusun Karanganyar','blok_dusun'=>'Karanganyar','jenis'=>'sawah','luas'=>850,'batas_utara'=>'Warsinem','batas_timur'=>'parit','batas_selatan'=>'jalan setapak','batas_barat'=>'Sutini','lat'=>-6.9059,'lon'=>109.0250],
    ['nomor_c'=>'C-003','persil'=>'PS-21','nama'=>'Karni','alamat'=>'Dusun Krajan','blok_dusun'=>'Krajan','jenis'=>'tegal','luas'=>400,'batas_utara'=>'jalan desa','batas_timur'=>'sawah','batas_selatan'=>'kebun','batas_barat'=>'jl. raya','lat'=>-6.9030,'lon'=>109.0210],
    ['nomor_c'=>'C-004','persil'=>'PS-22','nama'=>'Jumadi','alamat'=>'Dusun Krajan','blok_dusun'=>'Krajan','jenis'=>'pekarangan','luas'=>225,'batas_utara'=>'rumah','batas_timur'=>'jalan','batas_selatan'=>'kebun','batas_barat'=>'masjid','lat'=>-6.9040,'lon'=>109.0220],
    ['nomor_c'=>'C-005','persil'=>'PS-30','nama'=>'Mulyani','alamat'=>'Dusun Cibuluh','blok_dusun'=>'Cibuluh','jenis'=>'sawah','luas'=>1600,'batas_utara'=>'Slamet','batas_timur'=>'sungai Cibuluh','batas_selatan'=>'tegal','batas_barat'=>'Karno','lat'=>-6.9080,'lon'=>109.0280],
    ['nomor_c'=>'C-006','persil'=>'PS-31','nama'=>'Slamet','alamat'=>'Dusun Cibuluh','blok_dusun'=>'Cibuluh','jenis'=>'sawah','luas'=>950,'batas_utara'=>'jalan','batas_timur'=>'Mulyani','batas_selatan'=>'tegal','batas_barat'=>'Karno','lat'=>-6.9072,'lon'=>109.0288],
    ['nomor_c'=>'C-007','persil'=>'PS-40','nama'=>'Rukiyah','alamat'=>'Dusun Karangjaya','blok_dusun'=>'Karangjaya','jenis'=>'darat','luas'=>310,'batas_utara'=>'jalan desa','batas_timur'=>'pekarangan','batas_selatan'=>'kebun','batas_barat'=>'sawah','lat'=>-6.9000,'lon'=>109.0180],
    ['nomor_c'=>'C-008','persil'=>'PS-41','nama'=>'Suparman','alamat'=>'Dusun Karangjaya','blok_dusun'=>'Karangjaya','jenis'=>'sawah','luas'=>1400,'batas_utara'=>'Parjo','batas_timur'=>'jalan','batas_selatan'=>'Yati','batas_barat'=>'sungai','lat'=>-6.9010,'lon'=>109.0190],
    ['nomor_c'=>'C-009','persil'=>'PS-50','nama'=>'Tasno','alamat'=>'Dusun Kedungbulus','blok_dusun'=>'Kedungbulus','jenis'=>'tegal','luas'=>520,'batas_utara'=>'kebun','batas_timur'=>'sungai','batas_selatan'=>'jalan','batas_barat'=>'sawah','lat'=>-6.9090,'lon'=>109.0300],
    ['nomor_c'=>'C-010','persil'=>'PS-51','nama'=>'Harminto','alamat'=>'Dusun Kedungbulus','blok_dusun'=>'Kedungbulus','jenis'=>'sawah','luas'=>2000,'batas_utara'=>'sawah','batas_timur'=>'jalan desa','batas_selatan'=>'sungai','batas_barat'=>'Tasno','lat'=>-6.9100,'lon'=>109.0308],
    ['nomor_c'=>'C-011','persil'=>'PS-60','nama'=>'Sumiati','alamat'=>'Dusun Karanganyar','blok_dusun'=>'Karanganyar','jenis'=>'pekarangan','luas'=>180,'batas_utara'=>'masjid','batas_timur'=>'jalan','batas_selatan'=>'rumah','batas_barat'=>'warung','lat'=>-6.9048,'lon'=>109.0255],
    ['nomor_c'=>'C-012','persil'=>'PS-61','nama'=>'Painem','alamat'=>'Dusun Krajan','blok_dusun'=>'Krajan','jenis'=>'sawah','luas'=>1750,'batas_utara'=>'Sumarni','batas_timur'=>'tegal','batas_selatan'=>'jalan','batas_barat'=>'parit','lat'=>-6.9020,'lon'=>109.0200],
];

// idempotent: hapus baris contoh saja (nomor_c C-xxx), biarkan data manual pengguna
$pdo->exec("DELETE FROM tanah WHERE nomor_c LIKE 'C-%'");
$cols = "nomor_c, persil, nama, alamat, blok_dusun, jenis, luas, batas_utara, batas_timur, batas_selatan, batas_barat, lat, lon";
$ph = implode(',', array_fill(0, 13, '?'));
$ins = $pdo->prepare("INSERT INTO tanah ($cols) VALUES ($ph)");
foreach ($rows as $r) {
    $ins->execute([
        $r['nomor_c'], $r['persil'], $r['nama'], $r['alamat'], $r['blok_dusun'], $r['jenis'], $r['luas'],
        $r['batas_utara'], $r['batas_timur'], $r['batas_selatan'], $r['batas_barat'], $r['lat'], $r['lon'],
    ]);
}
echo "Seeder ulang selesai.\n";
