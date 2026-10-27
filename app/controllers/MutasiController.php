<?php
/**
 * MutasiController — STAGE 3: Mutasi (jual/waris/hibah/pecah) + Verifikasi & Approval Kades.
 * Alur flowchart: Mutasi -> catat riwayat (tabel mutasi) -> Approval Kades -> AKTIF & terkunci.
 */
class MutasiController
{
    /** Daftar seluruh riwayat mutasi (untuk admin/operator). */
    public function index()
    {
        $pdo = Database::conn();
        $rows = $pdo->query(
            "SELECT m.*, t.nama AS bidang_nama, t.nomor_c AS no_c
             FROM mutasi m LEFT JOIN tanah t ON t.id = m.tanah_id
             ORDER BY m.id DESC"
        )->fetchAll();
        $title = 'Mutasi & Verifikasi'; $active = 'mutasi'; $view = BASE_PATH . '/views/mutasi/index.php';
        require BASE_PATH . '/views/layout.php';
    }

    /** Form ajukan mutasi untuk satu bidang. */
    public function form($id)
    {
        $st = Database::conn()->prepare("SELECT * FROM tanah WHERE id = ?");
        $st->execute([$id]);
        $row = $st->fetch();
        if (!$row) {
            flash_set('error', 'Bidang tidak ditemukan.');
            redirect('/mutasi');
        }
        $title = 'Ajukan Mutasi'; $active = 'mutasi'; $view = BASE_PATH . '/views/mutasi/form.php';
        require BASE_PATH . '/views/layout.php';
    }

    /** Simpan ajuan mutasi (status pending, menunggu approval Kades/admin). */
    public function store($id)
    {
        csrf_check();
        $pdo = Database::conn();
        $st = $pdo->prepare("SELECT * FROM tanah WHERE id = ?");
        $st->execute([$id]);
        $row = $st->fetch();
        if (!$row) {
            flash_set('error', 'Bidang tidak ditemukan.');
            redirect('/mutasi');
        }

        $jenis = in_array($_POST['jenis'] ?? '', ['jual', 'waris', 'hibah', 'pecah'], true) ? $_POST['jenis'] : 'jual';
        $pemilikBaru = trim($_POST['pemilik_baru'] ?? '');
        if ($pemilikBaru === '') {
            flash_set('error', 'Nama pemilik baru wajib diisi.');
            redirect('/mutasi/' . $id);
        }
        $luasBaru = $jenis === 'pecah'
            ? (float)($_POST['luas_baru'] ?? 0)
            : (float)($row['luas'] ?? 0);
        $ket = trim($_POST['keterangan'] ?? '');

        $ins = $pdo->prepare(
            "INSERT INTO mutasi (tanah_id, jenis, pemilik_lama, pemilik_baru, luas_lama, luas_baru, keterangan, status, dibuat_oleh)
             VALUES (?,?,?,?,?,?,?,?,?)"
        );
        $ins->execute([$id, $jenis, $row['nama'], $pemilikBaru, $row['luas'], $luasBaru, $ket, 'pending', Auth::name()]);
        flash_set('ok', 'Mutasi diajukan. Menunggu persetujuan Kades/Admin.');
        redirect('/mutasi');
    }

    /** Approve oleh Kades: terapkan pemilik/luas baru + status AKTIF (terkunci). */
    public function approve($mid)
    {
        $pdo = Database::conn();
        $st = $pdo->prepare("SELECT * FROM mutasi WHERE id = ?");
        $st->execute([$mid]);
        $m = $st->fetch();
        if (!$m || $m['status'] !== 'pending') {
            flash_set('error', 'Mutasi tidak ditemukan / sudah diproses.');
            redirect('/mutasi');
        }
        $pdo->beginTransaction();
        try {
            $pdo->prepare(
                "UPDATE tanah SET nama = ?, luas = ?, status = 'aktif', updated_at = datetime('now','localtime') WHERE id = ?"
            )->execute([$m['pemilik_baru'], $m['luas_baru'], $m['tanah_id']]);
            $pdo->prepare(
                "UPDATE mutasi SET status = 'disetujui', diproses_oleh = ?, diproses_at = datetime('now','localtime') WHERE id = ?"
            )->execute([Auth::name(), $mid]);
            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
            flash_set('error', 'Gagal menyetujui mutasi.');
            redirect('/mutasi');
        }
        flash_set('ok', 'Mutasi disetujui. Bidang kini AKTIF & terkunci.');
        redirect('/mutasi');
    }

    /** Tolak ajuan oleh Kades. */
    public function reject($mid)
    {
        Database::conn()->prepare(
            "UPDATE mutasi SET status = 'ditolak', diproses_oleh = ?, diproses_at = datetime('now','localtime')
             WHERE id = ? AND status = 'pending'"
        )->execute([Auth::name(), $mid]);
        flash_set('ok', 'Ajuan mutasi ditolak.');
        redirect('/mutasi');
    }
}
