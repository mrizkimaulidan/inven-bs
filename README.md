# Inven BS

Aplikasi inventaris barang sekolah berbasis Laravel dan Livewire. Aplikasi ini membantu pengelolaan barang, data referensi, pengguna, serta hak akses.

## Fitur

- Dashboard dengan ringkasan dan grafik inventaris.
- Pengelolaan barang, termasuk unggah foto, pencarian, dan filter.
- Kode QR untuk melihat informasi dan memverifikasi barang.
- Cetak daftar barang dan dokumen barang individual dalam PDF.
- Impor dan ekspor data barang.
- Pengelolaan data perolehan, ruangan, merek, bahan, pengguna, dan peran.
- Hak akses berdasarkan peran.
- Pengaturan profil pengguna.

## Teknologi

- PHP `^8.3`
- Laravel `^13.17`
- Livewire `^4.4`
- MySQL/MariaDB atau SQLite
- Node.js dan npm untuk membangun aset frontend

## Instalasi

### Prasyarat

- PHP 8.3 atau lebih baru yang memenuhi constraint `^8.3`.
- Composer.
- Node.js `^20.19` atau `>=22.12` dan npm.
- MySQL/MariaDB atau SQLite.

XAMPP dapat digunakan untuk menyediakan PHP dan MySQL/MariaDB di lingkungan lokal.

### Langkah setup

1. Clone repository dan masuk ke direktori proyek:

   ```bash
   git clone https://github.com/mrizkimaulidan/inven-bs.git
   cd inven-bs
   ```

2. Pasang dependensi PHP dan siapkan konfigurasi:

   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

   Pada Windows PowerShell, gunakan `Copy-Item .env.example .env` sebagai pengganti `cp`.

3. Siapkan database melalui `.env`. Konfigurasi contoh sudah menggunakan SQLite. Pastikan `database/database.sqlite` tersedia; buat file kosong jika belum ada:

   ```bash
   touch database/database.sqlite
   ```

   Di Windows PowerShell:

   ```powershell
   if (!(Test-Path database/database.sqlite)) { New-Item database/database.sqlite -ItemType File }
   ```

   Jika menggunakan MySQL/MariaDB, buat database terlebih dahulu lalu sesuaikan konfigurasi berikut:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=inven_bs
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. Pasang dependensi frontend dan bangun aset:

   ```bash
   npm ci
   npm run build
   ```

5. Buat symbolic link untuk foto barang, lalu jalankan migrasi dan data awal:

   ```bash
   php artisan storage:link
   php artisan migrate --seed
   ```

6. Jalankan server lokal:

   ```bash
   php artisan serve
   ```

   Buka `http://127.0.0.1:8000`. Halaman `/` akan mengarahkan pengguna yang belum login ke halaman login; setelah login, pengguna diarahkan ke `/beranda`.

### Akun demo

Seeder menyediakan akun berikut:

| Peran | Email | Kata sandi |
|---|---|---|
| Administrator | `admin@mail.com` | `secret` |
| Staff TU | `stafftu@mail.com` | `secret` |

Seeder juga membuat data contoh, termasuk 1.000 barang dan 50 pengguna tambahan. Gunakan akun demo hanya untuk pengembangan lokal; ganti kredensial dan jangan gunakan data seeder di produksi.

## Pengembangan dan pengujian

Untuk menjalankan Vite dalam mode pengembangan:

```bash
npm run dev
```

Jalankan pengujian aplikasi dengan:

```bash
php artisan test
```

## Tangkapan layar

| Halaman | Pratinjau |
|---|---|
| Login | [Lihat gambar](https://i.imgur.com/AGhOYoI.jpeg) |
| Beranda | [Lihat gambar](https://i.imgur.com/E6nX2az.jpeg) |
| Daftar barang | [Lihat gambar](https://i.imgur.com/cM1nqA7.jpeg) |
| Cetak daftar barang | [Lihat gambar](https://i.imgur.com/sxtWCBX.png) |
| Cetak barang individual | [Lihat gambar](https://i.imgur.com/ZSZaqcW.png) |
| Kode QR | [Lihat gambar](https://i.imgur.com/vdfEaiU.png) |
| Daftar perolehan | [Lihat gambar](https://i.imgur.com/7mtWj3K.jpeg) |
| Daftar ruangan | [Lihat gambar](https://i.imgur.com/s5PTRrs.jpeg) |
| Daftar merek | [Lihat gambar](https://i.imgur.com/uidq6oW.jpeg) |
| Daftar bahan | [Lihat gambar](https://i.imgur.com/EQpLa36.jpeg) |
| Daftar pengguna | [Lihat gambar](https://i.imgur.com/19hBiBC.jpeg) |
| Pengaturan profil | [Lihat gambar](https://i.imgur.com/QRpiOot.jpeg) |
| Daftar peran dan hak akses | [Lihat gambar](https://i.imgur.com/44f7P1Q.jpeg) |
| Verifikasi barang | [Lihat gambar](https://i.imgur.com/RKX6ysA.jpeg) |

## Catatan

- Nama aplikasi pada antarmuka dapat diatur melalui `APP_NAME` di `.env`.
- Atur `APP_URL` sesuai alamat aplikasi agar tautan verifikasi pada kode QR mengarah ke host yang benar.
- Foto yang diunggah disimpan pada disk publik Laravel; jalankan `php artisan storage:link` agar dapat diakses dari browser.
- Sebelum deployment, gunakan konfigurasi produksi yang aman dan jangan aktifkan `APP_DEBUG`.
