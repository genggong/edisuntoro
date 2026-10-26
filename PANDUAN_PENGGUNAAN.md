# Panduan Penggunaan — Buku C Pertanahan

Aplikasi ini dipakai perangkat desa/karang taruna untuk mendata tanah warga (Buku C).

## Akun
| Peran | Username | Password |
|-------|----------|----------|
| Admin | `admin` | `admin123` (ganti setelah login pertama) |

## Alur kerja harian
1. **Login** dengan akun admin.
2. **Beranda** melihat ringkasan: berapa bidang sudah terdata, total luas (m² / Ha), dan rekap jenis tanah.
3. **Buku C** → klik **＋ Tambah** untuk mengisi bidang baru:
   - No. C dan No. Persil (nomor pendaftaran tanah)
   - Nama pemilik & domisili
   - Blok/Dusun tempat tanah berada
   - Jenis tanah: sawah / tegal / pekarangan / darat
   - Luas tanah (m²)
   - Batas-batas: utara, timur, selatan, barat
   - (Opsional) Titik koordinat lat/lon — supaya muncul di menu Peta
   - Keterangan tambahan
   - Klik **💾 Simpan**.
4. Data muncul di daftar **Buku C**. Bisa **✎ Edit** atau **🗑 Hapus** tiap baris, dan **cari** pakai kotak pencarian (nama / No C / persil / blok).
5. **Rekap** menampilkan total dan rincian per jenis tanah serta per blok/dusun — untuk laporan.
6. **Peta** memperlihatkan skema titik koordinat wilayah; setiap bidang yang punya lat/lon tampil sebagai titik biru, pusat desa titik merah.
7. **⬇ CSV** mengekspor seluruh data ke file Excel/Google Sheets.

## Tips
- Koordinat pusat desa Sidamulya: **-6.90535, 109.02330**. Bidang di sekitarnya biasanya bernilai sekitar itu.
- Selalu isi Luas dalam **m²** (misal 1.200 m² = 0,12 Ha).
- Hapus `install.php` setelah instalasi agar tidak bisa dipakai ulang.
