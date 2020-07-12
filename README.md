# Inven BS

Aplikasi inventaris barang sekolah menggunakan Framework Laravel 7

### Prasyarat

Berikut beberapa hal yang perlu diinstal terlebih dahulu:

-   Composer (https://getcomposer.org/)
-   PHP 7.2.x
-   MySQL 14.5.x
-   XAMPP

Jika Anda menggunakan XAMPP, untuk PHP dan MySQL sudah menjadi 1 (bundle) didalam aplikasi XAMPP

### Fitur

-   CRUD Barang
-   Import/export excel barang
-   Print
-   CRUD BOS (Bantuan Operasional Sekolah)
-   CRUD Ruangan

### Preview Gambar

_Tampilan Login_
![Image 1](https://i.imgur.com/RsiRp1O.png)

_Dashboard_
![Image 2](https://i.imgur.com/w8tPYOq.png)

_Daftar Barang_
![Image 3](https://i.imgur.com/On2W9jM.png)

_Daftar Bantuan Operasional Sekolah_
![Image 4](https://i.imgur.com/mEYJc2j.png)

_Daftar Ruangan_
![Image 5](https://i.imgur.com/d7S5IMV.png)

### Langkah-langkah instalasi

-   Clone repository ini

```
https://github.com/mrizkimaulidan/inven-bs.git
```

```
git@github.com:mrizkimaulidan/inven-bs.git
```

-   Install seluruh packages yang dibutuhkan

```
composer install
```

-   Siapkan database dan atur file .env sesuai dengan konfigurasi Anda
-   Jika sudah, migrate seluruh migrasi dan seeding data

```
php artisan migrate --seed
```

-   Jalankan local server

```
php artisan serve
```

-   User default aplikasi untuk login

```
Email       : admin@mail.com
Password    : admin
```

### Dibuat dengan

-   [Laravel](https://laravel.com) - Web Framework

### Kontribusi

Silahkan request melalui kolom `Pull Requests` jika ingin melakukan kontribusi

### Pembuat

-   **Muhammad Rizki Maulidan** - _Programmer_ - [mrizkimaulidan](https://github.com/mrizkimaulidan)

### Lisensi

Aplikasi ini boleh untuk dibagi dan diubah. Mohon tidak untuk diperjualbelikan!

### Ucapan terima kasih

-   Stackoverflow
-   Google
