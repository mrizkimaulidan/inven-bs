# Inven BS

Aplikasi inventaris barang sekolah menggunakan Framework Laravel 10. Aplikasi ini cocok untuk digunakan untuk di sekolah.

Beberapa CRUD menggunakan modal dan AJAX untuk pengambilan data agar mengurangi penggunaan pindah halaman.

### Prasyarat

Berikut beberapa hal yang perlu diinstal terlebih dahulu:

-   Composer (https://getcomposer.org/)
-   PHP ^8.1
-   MySQL
-   XAMPP

Jika Anda menggunakan XAMPP, untuk PHP dan MySQL sudah menjadi 1 (bundle) di dalam aplikasi XAMPP

### Fitur

-   CRUD Data Barang
-   Import/export excel barang
-   Print barang (seluruh/individual)
-   CRUD Data BOS (Bantuan Operasional Sekolah)
-   CRUD Data Ruangan
-   CRUD Data Pengguna
-   Pengaturan Profil

### Preview Gambar

_Tampilan Login_
![Image 1](https://i.imgur.com/kD6P7BF.png)

_Dashboard_
![Image 2](https://i.imgur.com/VJ0gCEv.png)

_Daftar Barang_
![Image 3](https://i.imgur.com/3AaIzxz.png)

_Print_
![Image 4](https://i.imgur.com/a7yj6Or.png)

_Print Individual_
![Image 5](https://i.imgur.com/Spjtxpv.png)

_Daftar Bantuan Operasional Sekolah_
![Image 6](https://i.imgur.com/zUruox1.png)

_Daftar Ruangan_
![Image 7](https://i.imgur.com/CrYTczu.png)

_Daftar Pengguna_
![Image 8](https://i.imgur.com/dF2tSet.png)

_Pengaturan Profil_
![Image 9](https://i.imgur.com/WbHIVPG.png)

_Daftar Peran dan Hak Akses_
![Image 10](https://i.imgur.com/5vlJQHL.png)

### Langkah-langkah instalasi

-   Clone repository ini

```bash
$ git clone https://github.com/mrizkimaulidan/inven-bs.git
```

-   Install seluruh packages yang dibutuhkan

```bash
$ composer install
```

-   Siapkan database dan atur file .env sesuai dengan konfigurasi Anda

-   Masukan nama sekolah pada konfigurasi .env untuk menampilkan nama sekolah pada print barang. Berikan tanda kutip jika nama sekolah mengandung spasi

Contoh:

```
NAMA_SEKOLAH="SD Negeri 001 Ciledug"
```

-   Jika sudah, migrate seluruh migrasi dan seeding data

```bash
$ php artisan migrate --seed
```

-   Jalankan local server

```
$ php artisan serve
```

-   User default aplikasi untuk login

Administrator

```
Email       : admin@mail.com
Password    : secret
```

Staff TU (Tata Usaha)

```
Email       : stafftu@mail.com
Password    : secret
```

### Dibuat dengan

-   [Laravel](https://laravel.com) - Web Framework
