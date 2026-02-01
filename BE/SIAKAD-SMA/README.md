# 🎓 SIAKAD SMA - Backend API

Sistem Informasi Akademik SMA dengan Laravel 12 dan Laravel Sanctum untuk authentication.

## 📋 Fitur

- ✅ Authentication (Login, Register, Logout)
- ✅ Manajemen Role (Admin, BK, Guru, Siswa)
- ✅ Manajemen Admin
- ✅ Manajemen BK (Bimbingan Konseling)
- ✅ Manajemen Kelas
- ✅ Manajemen Mata Pelajaran
- ✅ Manajemen Siswa
- ✅ Manajemen Guru
- ✅ Manajemen Absensi
- ✅ Manajemen Penjadwalan Bimbingan
- ✅ Manajemen Point Pelanggaran
- ✅ Manajemen Bimbingan Konseling

## 🛠️ Tech Stack

- **Framework:** Laravel 12
- **Database:** MySQL
- **Authentication:** Laravel Sanctum
- **PHP Version:** 8.2+

## 📦 Installation

### 1. Clone Repository
```bash
git clone <repository-url>
cd SIAKAD-SMA/BE/SIAKAD-SMA
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Setup Environment
```bash
copy .env.example .env
```

Edit `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=siakad_sma
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Run Migrations
```bash
php artisan migrate
```

### 6. Run Seeders
```bash
php artisan db:seed
```

Ini akan membuat:
- 4 Role (BK, Guru, Admin, Siswa)
- 1 User Admin default
  - Username: `admin`
  - Password: `admin123`

### 7. Start Development Server
```bash
php artisan serve
```

Server akan berjalan di: `http://localhost:8000`

## 📚 API Documentation

Dokumentasi lengkap ada di file: [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

### Base URL
```
http://localhost:8000/api
```

### Authentication
Gunakan Bearer Token di header:
```
Authorization: Bearer {your_token}
```

### Quick Start

1. **Login**
```bash
POST /api/login
Body: {
  "username": "admin",
  "password": "admin123"
}
```

2. **Copy token dari response**

3. **Gunakan token untuk endpoint lain**

## 🧪 Testing dengan Postman

1. Import file `SIAKAD_SMA.postman_collection.json` ke Postman
2. Set variable `base_url` ke `http://localhost:8000`
3. Login dan copy token
4. Set variable `token` dengan token yang didapat
5. Test endpoint lain

## 📁 Project Structure

```
app/
├── Http/
│   └── Controllers/
│       ├── AuthController.php
│       ├── RoleController.php
│       ├── AdminController.php
│       ├── BKController.php
│       ├── KelasController.php
│       ├── MapelController.php
│       ├── SiswaController.php
│       ├── GuruController.php
│       ├── AbsenController.php
│       ├── AbsensiController.php
│       ├── PenjadwalanController.php
│       ├── PointController.php
│       └── BimbinganController.php
└── Models/
    ├── User.php
    ├── Role.php
    ├── Admin.php
    ├── BK.php
    ├── Kelas.php
    ├── Mapel.php
    ├── Siswa.php
    ├── Guru.php
    ├── Absen.php
    ├── Absensi.php
    ├── Penjadwalan.php
    ├── Point.php
    └── Bimbingan.php
```

## 🔑 Default Login

**Username:** `admin`  
**Password:** `admin123`

## 📝 Response Format

### Success
```json
{
  "success": true,
  "message": "Pesan sukses",
  "data": { ... }
}
```

### Error
```json
{
  "success": false,
  "message": "Pesan error"
}
```

## 🚀 Deployment

### Production Mode
```bash
# Set environment
APP_ENV=production
APP_DEBUG=false

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📜 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Developer

Developed with ❤️ for SIAKAD SMA


We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
