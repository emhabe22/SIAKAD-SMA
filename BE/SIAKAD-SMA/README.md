# 📚 SIAKAD SMA - Sistem Informasi Akademik Sekolah Menengah Atas

![Laravel](https://img.shields.io/badge/Laravel-11.x-red)
![PHP](https://img.shields.io/badge/PHP-8.2-blue)
![MySQL](https://img.shields.io/badge/MySQL-8.0-orange)
![License](https://img.shields.io/badge/License-MIT-green)

Sistem Informasi Akademik berbasis REST API untuk mengelola aktivitas akademik di SMA, mencakup manajemen guru, siswa, jadwal pelajaran, absensi, dan konseling BK.

---

## 🎯 Fitur Utama

### 👨‍💼 Admin
- ✅ Kelola Data Guru (CRUD dengan assign mapel)
- ✅ Kelola Data Siswa (CRUD dengan assign kelas)
- ✅ Kelola Mata Pelajaran
- ✅ Kelola Kelas
- ✅ Kelola Data BK (Bimbingan Konseling)
- ✅ Buat & Kelola Jadwal Pelajaran
- ✅ Kelola Master Point Pelanggaran

### 👨‍🏫 Guru
- ✅ Lihat Jadwal Mengajar (grouped by hari)
- ✅ Buat Sesi Absensi
- ✅ Input Kehadiran Siswa (Hadir/Sakit/Izin/Alpa)
- ✅ Lihat Riwayat Absensi per Kelas/Mapel

### 🧑‍⚖️ BK (Bimbingan Konseling)
- ✅ Lihat Siswa Bermasalah (Top 20 berdasarkan point)
- ✅ Catat Pelanggaran Siswa
- ✅ Lihat Total Point per Siswa
- ✅ Jadwal Konseling dengan Siswa
- ✅ Input Catatan Bimbingan

### 👨‍🎓 Siswa
- ✅ Lihat Jadwal Pelajaran Kelas (grouped by hari)
- ✅ Lihat Riwayat Absensi Pribadi
- ✅ Lihat Point & Riwayat Pelanggaran
- ✅ Lihat Jadwal Konseling dengan BK

---

## 🏗️ Teknologi

- **Backend Framework:** Laravel 11.x
- **Database:** MySQL 8.0
- **Authentication:** Laravel Sanctum (Token-based)
- **Architecture:** RESTful API
- **ORM:** Eloquent
- **Authorization:** Role-Based Access Control (RBAC)

---

## 📋 Prasyarat

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js & NPM (untuk Vite)
- Git

---

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd SIAKAD-SMA/BE/SIAKAD-SMA
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=siakad_sma
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Migrasi & Seeding
```bash
php artisan migrate:fresh --seed
```

### 6. Jalankan Server
```bash
php artisan serve
```

Server akan berjalan di: `http://127.0.0.1:8000`

---

## 🔑 Login Credentials (Seeder)

Setelah menjalankan seeder, gunakan credentials berikut:

| Role    | Username | Password  | Keterangan                    |
|---------|----------|-----------|-------------------------------|
| Admin   | `admin`  | `admin123`| Full access ke semua fitur    |
| BK      | `bk`     | `bk123`   | Konseling & pelanggaran       |
| Guru 1  | `guru1`  | `guru123` | Matematika & Fisika           |
| Guru 2  | `guru2`  | `guru123` | Kimia & Biologi               |
| Guru 3  | `guru3`  | `guru123` | B. Indonesia & B. Inggris     |
| Siswa 1 | `siswa1` | `siswa123`| Kelas X IPA 1                 |
| Siswa 2 | `siswa2` | `siswa123`| Kelas X IPA 1                 |
| Siswa 3 | `siswa3` | `siswa123`| Kelas X IPA 2                 |

---

## 📖 Dokumentasi API

### Authentication
```http
POST /api/login
POST /api/register
POST /api/logout (requires auth)
```

### Endpoint Overview
- **Admin Routes:** `/api/admin/*` (81 endpoints total)
- **Guru Routes:** `/api/guru/*`
- **BK Routes:** `/api/bk/*`
- **Siswa Routes:** `/api/siswa/*`

📄 **Dokumentasi Lengkap:** Lihat [API_DOCUMENTATION.md](API_DOCUMENTATION.md)

---

## 🧪 Testing API

### Menggunakan Postman
1. Import file: `SIAKAD_SMA_Postman_Collection.json`
2. Login terlebih dahulu untuk mendapatkan token
3. Token otomatis tersimpan di environment variable
4. Test endpoint sesuai role yang login

### Contoh Request Login
```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "username": "admin",
    "password": "admin123"
  }'
```

### Contoh Response
```json
{
  "success": true,
  "message": "Login berhasil",
  "token": "1|xxxxxxxxxxxxx",
  "user": {
    "id": 1,
    "username": "admin",
    "role": {
      "id": 1,
      "name": "Admin"
    }
  }
}
```

### Menggunakan Token
```bash
curl -X GET http://127.0.0.1:8000/api/admin/jadwal-pelajaran \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

---

## 📊 Database Schema

### Tabel Utama:
- `users` - User authentication
- `roles` - Role management (Admin, Guru, BK, Siswa)
- `admins` - Data admin
- `gurus` - Data guru
- `siswas` - Data siswa
- `b_k_s` - Data BK
- `kelas` - Data kelas
- `mapels` - Mata pelajaran
- `guru_mapel` - Pivot table guru & mapel (many-to-many)

### Tabel Akademik:
- `jadwal_pelajarans` - Jadwal pelajaran per kelas
- `absens` - Sesi absensi
- `absensis` - Kehadiran siswa per sesi

### Tabel BK:
- `points` - Master point pelanggaran
- `pelanggaran_siswas` - Riwayat pelanggaran siswa
- `penjadwalans` - Jadwal konseling
- `bimbingans` - Catatan bimbingan

📄 **ERD & Detail Schema:** Lihat [RANGKUMAN_PERUBAHAN.md](RANGKUMAN_PERUBAHAN.md)

---

## 🎨 Struktur Project

```
SIAKAD-SMA/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── API/
│   │   │       ├── AuthController.php
│   │   │       ├── AdminController.php
│   │   │       ├── GuruController.php
│   │   │       ├── SiswaController.php
│   │   │       ├── BKController.php
│   │   │       ├── JadwalPelajaranController.php
│   │   │       ├── PelanggaranSiswaController.php
│   │   │       └── ...
│   │   └── Middleware/
│   │       └── CheckRole.php
│   └── Models/
│       ├── User.php
│       ├── Guru.php
│       ├── Siswa.php
│       ├── JadwalPelajaran.php
│       ├── PelanggaranSiswa.php
│       └── ...
├── database/
│   ├── migrations/
│   └── seeders/
│       └── DatabaseSeeder.php
├── routes/
│   └── api.php
├── API_DOCUMENTATION.md
├── RANGKUMAN_PERUBAHAN.md
└── SIAKAD_SMA_Postman_Collection.json
```

---

## 🔐 Authorization

Sistem menggunakan **Role-Based Access Control (RBAC)** dengan middleware `CheckRole`.

### Contoh Implementasi:
```php
// Hanya Admin yang bisa akses
Route::middleware('role:Admin')->group(function () {
    Route::apiResource('guru', GuruController::class);
});

// Admin, Guru, dan Siswa bisa akses
Route::middleware('role:Admin,Guru,Siswa')->group(function () {
    Route::get('/jadwal-pelajaran', [JadwalPelajaranController::class, 'index']);
});
```

---

## 📝 Development Notes

### Perbedaan dengan Struktur Lama:
1. **Guru-Mapel:** Sekarang many-to-many (1 guru bisa ngajar banyak mapel)
2. **Mapel:** Tidak terikat ke 1 kelas (bisa lintas kelas)
3. **Jadwal Pelajaran:** Tabel terpisah dengan jam yang jelas
4. **Absensi:** Lebih detail dengan jam dan kelas
5. **Pelanggaran:** Sistem point terintegrasi dengan BK

### Key Improvements:
- ✅ RESTful API design
- ✅ Proper validation with Validator
- ✅ Consistent response format
- ✅ Eloquent relationships
- ✅ Role-based middleware
- ✅ Token-based authentication

---

## 🔮 Roadmap (Future Features)

### Phase 2:
- [ ] Input Nilai Akademik (UH, UTS, UAS, Raport)
- [ ] Dashboard dengan Grafik & Statistik
- [ ] Export Laporan PDF (Absensi, Nilai, Raport)
- [ ] Notifikasi Email/WhatsApp untuk Orang Tua
- [ ] Wali Kelas Features

### Phase 3:
- [ ] Parent/Orang Tua Portal
- [ ] QR Code Attendance
- [ ] Mobile App (Flutter/React Native)
- [ ] E-Learning/Upload Materi
- [ ] Digital Raport
- [ ] SMS Gateway Integration

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the MIT License.

---

## 👥 Team

- **Developer:** Your Name
- **Project:** Magang Semester 6
- **Institution:** [Your Institution]
- **Year:** 2026

---

## 📞 Support

Jika ada pertanyaan atau butuh bantuan:
- 📧 Email: your.email@example.com
- 💬 Discord/Telegram: @yourusername
- 🐛 Issues: [GitHub Issues](https://github.com/yourusername/siakad-sma/issues)

---

## 🙏 Acknowledgments

- Laravel Framework
- Laravel Sanctum
- All contributors and testers

---

**Made with ❤️ for Indonesian Education System**

**Status:** ✅ Ready for Testing & Frontend Integration (Updated: 4 Feb 2026)
