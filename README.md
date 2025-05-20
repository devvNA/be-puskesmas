<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development/)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# Aplikasi Puskesmas Kluwung

Aplikasi manajemen Puskesmas Kluwung untuk memudahkan pelayanan kesehatan.

## Fitur Utama

- **Pendaftaran pasien online** - Pasien dapat mendaftar secara online untuk layanan kesehatan
- **Rekam medis digital** - Pencatatan dan akses rekam medis secara digital
- **Manajemen anggota keluarga** - Pengelolaan data anggota keluarga
- **Jadwal dokter dan poli** - Informasi jadwal dokter dan poli yang tersedia
- **Autentikasi PIN** - Fitur keamanan tambahan menggunakan PIN 6 digit
- **Login Tanpa Password** - Login hanya dengan email dan PIN

## Autentikasi PIN

Aplikasi ini dilengkapi dengan sistem autentikasi menggunakan PIN 6 digit untuk meningkatkan keamanan akses pengguna. Fitur PIN mencakup:

1. **Login dengan PIN** - Pengguna dapat login menggunakan email dan PIN 6 digit
2. **Pembuatan PIN** - Pengguna dapat membuat PIN baru
3. **Verifikasi PIN** - Verifikasi PIN untuk akses fitur sensitif
4. **Pengubahan PIN** - Pengguna dapat mengubah PIN yang sudah ada
5. **Penghapusan PIN** - Pengguna dapat menghapus PIN

## Login Tanpa Password

Aplikasi ini mendukung alur login tanpa perlu memasukkan password dengan memanfaatkan PIN:

1. **Verifikasi Email** - Pengguna hanya perlu memasukkan email
2. **Pengecekan Metode Autentikasi** - Sistem mendeteksi metode login yang tersedia
3. **Login dengan PIN** - Jika PIN tersedia, pengguna dapat login hanya dengan PIN 6 digit

Untuk detail lengkap tentang alur login tanpa password, lihat [dokumentasi alur login](docs/screenshot_alur_login.md).

Untuk dokumentasi API PIN lebih lengkap, silakan lihat [dokumentasi API PIN](docs/api_pin.md).

## Pengembangan

### Prasyarat

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Laravel 10

### Instalasi

1. Clone repositori ini
2. Jalankan `composer install`
3. Salin `.env.example` ke `.env` dan konfigurasi database
4. Jalankan `php artisan key:generate`
5. Jalankan `php artisan migrate`
6. Jalankan `php artisan serve`

### Migrasi Database PIN

Untuk menambahkan kolom PIN ke tabel users, jalankan migrasi:

```bash
php artisan migrate
```

### Membuat User dengan PIN

Gunakan perintah artisan untuk membuat user dengan PIN secara langsung:

```bash
php artisan users:create-default --name="Nama User" --email="user@example.com" --password="password" --pin="123456"
```

## Dokumentasi API

API dokumentasi lengkap tersedia di:

- [Dokumentasi API PIN](docs/api_pin.md)
- [Alur Login Tanpa Password](docs/screenshot_alur_login.md)

## Kontributor

- Tim Pengembang Puskesmas Kluwung
