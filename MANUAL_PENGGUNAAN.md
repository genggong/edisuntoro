# 📘 MANUAL PENGGUNAAN — Buku C Pertanahan Desa Sidamulya

**Aplikasi** : Buku C (Letter C) Pertanahan — Desa Sidamulya, Kec. Wanasari, Kab. Brebes, Jawa Tengah
**Akses** : `https://edisuntoro.web.id/vantera/pertanahan`
**Versi dokumen** : 1.0 (STAGE 1 · STAGE 2 GPS/Validasi · STAGE 3 Mutasi & Verifikasi)

---

## DAFTAR ISI
1. [Login & Akun](#1-login--akun)
2. [Ringkasan Hak Akses per Peran](#2-ringkasan-hak-akses-per-peran)
3. [Beranda (Dashboard)](#3-beranda-dashboard)
4. [Buku C — Kelola Data Tanah (Tambah / Edit / Hapus / Cari)](#4-buku-c--kelola-data-tanah)
5. [Form Isian Bidang Secara Lengkap](#5-form-isian-bidang-secara-lengkap)
6. [Validasi Spasial Otomatis saat Simpan](#6-validasi-spasial-otomatis-saat-simpan)
7. [Peta Interaktif (khusus & akses admin)](#7-peta-interaktif-khusus--akses-admin)
8. [Anti-Overlap & Cek Luas di Peta](#8-anti-overlap--cek-luas-di-peta)
9. [Mutasi & Verifikasi Kades](#9-mutasi--verifikasi-kades)
10. [Rekap / Statistik](#10-rekap--statistik)
11. [Import Data (CSV & GeoJSON)](#11-import-data-csv--geojson)
12. [Ekspor Data (CSV / Excel / PDF / GeoJSON)](#12-ekspor-data)
13. [Pengaturan Akun Pengguna (admin)](#13-pengaturan-akun-pengguna-admin)
14. [Alur Sistem (Flowchart)](#14-alur-sistem-flowchart)
15. [Tips & Pemecahan Masalah](#15-tips--pemecahan-masalah)

---

## 1. Login & Akun

1. Buka `https://edisuntoro.web.id/vantera/pertanahan/`
2. Halaman **Masuk** muncul. Isi **Username** dan **Password**, klik **Masuk**.
3. Berhasil → masuk ke halaman **Beranda**. Gagal → muncul peringatan, cek lagi.

> Ganti semua password default setelah penggunaan pertama (menu **Pengguna** → edit → isi password baru).

---

## 2. Ringkasan Hak Akses per Peran

| Menu / Aksi | **Admin** | **Operator** | **Pengguna** |
|---|:---:|:---:|:---:|
| Beranda | ✅ | ✅ | ✅ |
| Buku C (lihat & cari) | ✅ | ✅ | ✅ |
| Tambah / Edit bidang | ✅ | ✅ | ✅ |
| Gambar polygon & validasi di Peta | ✅ | ✅ | ❌ |
| Anti-Overlap / Cek Luas | ✅ | ✅ | ❌ |
| Hapus bidang | ✅ | ✅ (hanya yang bukan AKTIF)* | ❌ |
| Edit/Hapus bidang berstatus **Aktif · Terkunci** | ✅ | ❌ (diblokir) | ❌ |
| Ajukan Mutasi | ✅ | ✅ | ❌ |
| **Setujui / Tolak (Verifikasi Kades)** | ✅ | ❌ | ❌ |
| Rekap / Statistik | ✅ | ✅ | ✅ |
| Import CSV & GeoJSON | ✅ | ✅ | ❌ |
| Ekspor (CSV/Excel/PDF/GeoJSON) | ✅ | ✅ (PDF/CSV)* | ❌ |
| Kelola Akun Pengguna | ✅ | ❌ | ❌ |

_\* Detail pembatasan bisa berbeda — lihat bagian masing-masing._

---

## 3. Beranda (Dashboard)

Setelah login, halaman **Beranda** menampilkan ringkasan:
- **Jumlah bidang** tanah yang sudah terdata.
- **Total luas** dalam m² dan Ha.
- **Rekap per jenis** (sawah / tegal / pekarangan / darat) — jumlah bidang & luas.
- **Data terbaru** yang baru saja diinput.

Navbar atas berisi menu: **Beranda · Buku C · Rekap · Peta · Mutasi · Alur · Pengguna** (tampil menyesuaikan peran).

---

## 4. Buku C — Kelola Data Tanah

Menu **Buku C** adalah inti pendataan.

### Melihat & Mencari
- Daftar tampil sebagai **kartu** (ponsel) dan **tabel** (layar lebar).
- Kolom: No C · Persil · Nama · Blok · Jenis · Luas · **Status** · Aksi.
- **Cari** dengan kotak di atas daftar (cari nama / No C / persil / blok), tekan **Cari**.
- **Status bidang** tampil sebagai badge: `Draft` (kuning) / `Aktif · Terkunci` (hijau) / `Batal` (abu-abu).

### Tambah Bidang Baru
1. Klik tombol **＋ Tambah** (hijau).
2. Isi form (lihat [Bagian 5](#5-form-isian-bidang-secara-lengkap)).
3. Klik **💾 Simpan**.

### Edit
- Klik **✎ Edit** pada baris/kartu.
- Bila status bidang `Aktif · Terkunci`, hanya **Admin** yang bisa edit; operator akan diblokir.

### Hapus
- Klik **🗑 Hapus**, konfirmasi pada kotak dialog.
- Bidang `Aktif · Terkunci` hanya bisa dihapus **Admin**.

### Verifikasi Status oleh Kades (Admin)
- Pada bidang berstatus **Draft**, muncul tombol **✓ Setujui** dan **✗ Tolak**.
- **✓ Setujui** → status berubah **Aktif · Terkunci** (data resmi, terkunci).
- **✗ Tolak** → status berubah **Batal**.
- Untuk bidang yang sudah diproses, tombol **↺ Kunci Aktif** dipakai admin untuk mengembalikan ke status *Aktif · Terkunci*.

---

## 5. Form Isian Bidang Secara Lengkap

Kolom yang bisa diisi saat **Tambah / Edit**:

| Kolom | Keterangan | Wajib | Keterangan singkat |
|---|---|---:|---|
| **No. C** | Nomor Kohir | — | Nomor pendaftaran tanah |
| **No. Persil** | Nomor persil | — | |
| **Nama Pemilik** | Nama warga | ✅ | |
| **Alamat / Domisili** | Alamat pemilik | — | |
| **Blok / Dusun** | Blok/dusun lokasi tanah | — | |
| **Jenis** | sawah / tegal / pekarangan / darat | — | |
| **Luas (m²)** | Luas menurut Buku C | — | Begitu luas diisi saat ada polygon → dicek selisih |
| **Batas Utara/Timur/Selatan/Barat** | Batas-batas lahan | — | |
| **Koordinat (Lat / Lon)** | Titik pusat lahan | — | Diisi manual atau pakai **Peta** |
| **Poligon** | Koordinat batas lahan | — | Dipakai validasi overlap & luas |
| **Keterangan** | Catatan tambahan | — | |

> Polygonya ditulis sebagai pasangan koordinat `lat,lon;lat,lon;...` (paling sedikit 3 titik). Cara termudah: gambarlah di **menu Peta**.

---

## 6. Validasi Spasial Otomatis saat Simpan

Saat **Tambah/Edit** yang punya kolom **poligon** diisi, sistem otomatis:
1. **Cek tumpang tindih (overlap)** terhadap semua bidang lain → kalau tumpang tindih, **simpan DITOLAK** dan muncul pesan siapa bidang yang bertabrakan.
2. **Cek selisih luas** Buku C vs luas polygon → kalau selisih **>2%**, data tetap disimpan tapi muncul **peringatan** untuk re-ukur lapangan.

Ini menjamin dua bidang tidak boleh menempati lahan yang sama.

---

## 7. Peta Interaktif (khusus & akses admin)

Menu **Peta** adalah peta satelit interaktif untuk digitasi lokasi & batas lahan.

### 7.1 Cara Akses
- Menu **Peta** → klik **Peta** di nav. Tampil peta satelit (Esri) + lapisan peta jalan (OpenStreetMap) — pindah layer lewat ikon lapisan di kiri peta.
- **Pengguna** (role pengguna) **bisa melihat peta**; untuk **menggambar/validasi** butuh **Admin/Operator**.

### 7.2 Elemen Peta
- **Marker titik** = lokasi tiap bidang yang punya koordinat (klik untuk popup: No C, Nama, Jenis, Luas).
- **Polygon (garis putus-putus)** = batas lahan tiap bidang yang sudah digambar. Warna menunjukkan status:
  - **Oranye** = Draft
  - **Hijau** = Aktif · Terkunci
  - **Abu-abu** = Batal
  - Arahkan kursor ke polygon untuk tooltip (No C · Nama).
- **Titik merah** = pusat desa Sidamulya.

### 7.3 Digitasi Titik (koordinat lahan) — admin/operator
1. Klik **tepat di lokasi lahan** pada peta → muncul penanda titik.
2. Kotak *"Koordinat dipilih"* menampilkan nilai `lat, lon`.
3. Tombol **＋ Tambah Titik Lahan** muncul → klik untuk **membuka form Tambah** dengan koordinat terisi otomatis.

### 7.4 Menggambar Batas Lahan (Polygon) — admin/operator
1. Pada peta, klik ikon ⎔ (di toolbar kiri) untuk **mode menggambar bentuk**.
2. Klik peta titik demi titik mengelilingi lahan, sampai klik titik awal untuk menutup bentuk.
3. Koordinat polygon tampil di panel *"Polygon batas lahan"*.
4. Tombol **Use titik awal ke form** → membuka form Tambah dengan titik awal jadi koordinat.
5. Untuk meningkatkan presisi & membuat validasi luas akurat, salin koordinat polygon ke kolom **Poligon** di form Tambah.

### 7.5 Menampilkan & Mengelola dari Peta
- Klik marker/polygon bidang → popup info.
- Admin/operator bisa langsung **Cek Overlap & Luas** untuk lahan yang baru digambar (lihat Bagian 8) sebelum disimpan.

---

## 8. Anti-Overlap & Cek Luas di Peta

Panel **🛡️ Validasi Spasial** ada di bawah peta (hanya untuk admin/operator).

Langkah:
1. **Gambar polygon** lahan (tool ⎔) — wajib sebelum dicek.
2. (Opsional) isi **Luas Buku C (m²)** untuk ikut cek selisih luas.
3. Klik **Cek Overlap & Luas**.
4. Hasil:
   - **✅ AMAN** → tidak ada tumpang tindih, dan menampilkan luas polygon yang dihitung (m²).
   - **⛔ OVERLAP** → tumpang tindih dengan bidang (No C + nama). Entry basis dilarang, geser/kecilkan polygon.
   - **⚠️ Peringatan** → selisih luas Buku C vs polygon >2%, sarankan re-ukur lapangan.
   - Dalam toleransi (≤2%) → **OK**.

> Peta otomatis menampilkan polygon semua bidang yang sudah ada — jadi admin bisa langsung melihat area mana yang masih kosong (aman digambar) dan mana yang sudah terisi.

---

## 9. Mutasi & Verifikasi Kades

**Menu Mutasi** (admin & operator) mencatat perubahan pemilikan/batas tanah sesuai alur resmi.

### 9.1 Mengajukan Mutasi (operator/admin)
1. Dari **Buku C**, pada kartu bidang klik **✚ Mutasi**.
2. Isi **Jenis Mutasi**: Jual Beli / Waris / Hibah / Pemecahan (Split).
3. Isi **Pemilik Baru** (wajib), **Luas Baru** (wajib untuk Pemecahan), dan **Keterangan**.
4. Klik **Ajukan & Tunggu Persetujuan Kades** → masuk daftar riwayat berstatus **Pending**.

### 9.2 Menyetujui / Menolak (Kades = Admin)
1. Buka menu **Mutasi**.
2. Pada baris berstatus **Pending**, klik **✓ Setujui** atau **✗ Tolak**.
3. **Setujui** → pemilik & luas bidang ikut ter-update, status bidang jadi **Aktif · Terkunci**, tercatat siapa penanggap & kapan.
4. **Tolak** → riwayat ditandai **Ditolak**.

Riwayat lengkap tersimpan (pengaju, penanggap, waktu) = jejak audit.

---

## 10. Rekap / Statistik

Menu **Rekap** menampilkan ringkasan untuk laporan:
- Total bidang & total luas.
- Rincian **per jenis** tanah: jumlah bidang + luas.
- Rincian **per blok/dusun**: jumlah bidang + luas.

---

## 11. Import Data (CSV & GeoJSON)

Menu **Buku C → 📥 Import** (admin/operator) untuk memasukkan data massal.

| Tab/Area | Isi |
|---|---|
| **Import CSV** | Pilih file CSV/Excel. Format mengikuti **Contoh Import** (tombol di halaman). Kolom: No C, Persil, Nama, Alamat, Blok/Dusun, Jenis, Luas (m²), Utara, Timur, Selatan, Barat, Lat, Lon, Keterangan. |
| **Import GIS/GeoJSON** | Pilih file `.geojson`/`.json` (fitur Point). Tiap titik → satu bidang. Contoh: **Contoh Import GIS**. Untuk titik tanpa polygon, cukup Nama + koordinat. |

- Hasil impor dilaporkan: berapa baris **sukses**, **dilewati** (kosong/tanpa nama), **gagal** (ganda/masalah).
- **Template** tersedia di halaman Import (tombol unduh CSV & GeoJSON contoh).

---

## 12. Ekspor Data

Menu **Buku C → ⬇ Export** (admin/operator) → pilih format:
- **CSV** — untuk Excel/Google Sheets.
- **Excel (.xls)** — langsung buka di Excel.
- **PDF** — dokumen cetak/laporan PDF otomatis.
- **GIS / GeoJSON** — standar untuk aplikasi peta & BPN Bhumi (coordinate point lahan).

---

## 13. Pengaturan Akun Pengguna (admin)

Menu **Pengguna** (hanya admin):
- **＋ Tambah** akun baru (username + password + peran).
- **✎ Edit** akun (termasuk ganti password & peran).
- **🗑 Hapus** akun.
- Peran: **admin** (penuh), **operator** (tambah/edit/import/mutasi), **pengguna** (lihat saja).

> Ganti password default `admin123/operator123/pengguna123` lewat sini.

---

## 14. Alur Sistem (Flowchart)

Menu **Alur** menampilkan diagram alur resmi Buku C Digital & GIS Integration 3 tahap:
- **STAGE 1 · Digitalisasi & Input Buku C** — scan dokumen → input No Kohir, pemilik, luas, kelas persil → database (C_ID & Geom_ID).
- **STAGE 2 · Validasi Spasial/GIS** — overlay peta satelit, digitasi polygon, anti-overlap (ditolak bila tumpang tindih), cek selisih luas (re-ukur bila >2%, draft bila aman).
- **STAGE 3 · Mutasi & Verifikasi** — mutasi (jual/waris/hibah), split/merge polygon → kohir anak + histori → verifikasi & TTD digital Kades → **AKTIF & Terkunci** → output: dashboard peta, cetak kutipan Letter C & situasi, ekspor GeoJSON/SHP BPN.

---

## 15. Tips & Pemecahan Masalah

### Tips
- Koordinat pusat desa Sidamulya: **-6.90535, 109.02330**. Bidang sekitarnya kira-kira bernilai serupa.
- Luas diisi dalam **m²** (1.200 m² = 0,12 Ha).
- Pakai **Peta** untuk mengisi koordinat/polygon — lebih akurat daripada mengetik manual.
- Cek **Anti-Overlap** sebelum menyimpan lahan agar tidak ditolak.

### Pemecahan Masalah
| Gejala | Penyebab / Solusi |
|---|---|
| "Overlap / tumpang tindih" saat simpan | Polygon bertabrakan dgn bidang lain. Pindah/perkecil di Peta, lalu simpan ulang. |
| Peringatan selisih luas >2% | Luas Buku C ≠ luas polygon. Cek ulang ukur lapangan, sesuaikan angka atau polygon. |
| Tidak bisa edit/hapus bidang | Status **Aktif · Terkunci** — hanya admin yang bisa; operator diblokir. |
| Tombol Setujui/Tolak tidak muncul | Harus login sebagai **admin** (Kades). |
| Menu Mutasi tidak muncul | Perlu role **admin/operator**. |
| Data tidak muncul di Peta | Pastikan bidang punya koordinat lat/lon atau polygon. |
| Error `require_once(core/Polygon.php)` | File `core/Polygon.php` belum ter-deploy — tarik dari GitHub (lihat catatan deploy). |
| Lupa password | Minta reset via admin (menu Pengguna → edit). |

---

_Manual disusun untuk **Buku C Pertanahan Desa Sidamulya**. Untuk bantuan teknis/update, hubungi admin aplikasi._
