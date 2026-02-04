# 📚 SIAKAD SMA - Rangkuman Perubahan & Perbaikan

## 🎯 Overview
Sistem Informasi Akademik (SIAKAD) untuk SMA dengan 4 role utama: **Admin**, **Guru**, **BK**, dan **Siswa**.

---

## ✅ Yang Telah Dikerjakan

### 1. **Database Schema - Perbaikan & Penambahan**

#### 📋 Tabel Baru:
1. **`guru_mapel`** - Pivot table untuk relasi many-to-many Guru & Mapel
   - Satu guru bisa mengajar banyak mapel
   - Satu mapel bisa diajar oleh banyak guru

2. **`jadwal_pelajarans`** - Jadwal pelajaran per kelas
   - Hari (Senin-Sabtu)
   - Jam mulai & selesai
   - Relasi ke Kelas, Mapel, Guru
   - Ruangan (opsional)

3. **`pelanggaran_siswas`** - Tracking pelanggaran siswa
   - Relasi ke Siswa, Point, BK
   - Tanggal kejadian
   - Keterangan pelanggaran

#### 🔧 Tabel Diupdate:
1. **`gurus`** 
   - ❌ Removed: `mapel_id` (sekarang many-to-many via guru_mapel)
   
2. **`mapels`** 
   - ❌ Removed: `kelas_id` (mapel sekarang bisa lintas kelas)
   
3. **`absens`** 
   - ✅ Added: `jam_mulai`, `jam_selesai`, `kelas_id`
   
4. **`kelas`** 
   - ✅ Added: `nama_kelas`, `tingkat`, `jurusan`

---

### 2. **Models - Eloquent Relationships**

#### 📝 Model Baru:
- **`JadwalPelajaran`** - dengan relasi ke Kelas, Mapel, Guru
- **`PelanggaranSiswa`** - dengan relasi ke Siswa, Point, BK

#### 🔄 Model Diupdate:
- **`Guru`** - Relasi many-to-many ke Mapel via `guru_mapel`
- **`Mapel`** - Relasi many-to-many ke Guru
- **`Absen`** - Tambah relasi ke Kelas
- **`Siswa`** - Tambah relasi ke PelanggaranSiswa
- **`BK`** - Tambah relasi ke PelanggaranSiswa
- **`Kelas`** - Tambah fillable dan relasi

---

### 3. **Controllers - API Endpoints**

#### 🆕 Controller Baru:
1. **`JadwalPelajaranController`**
   - CRUD jadwal pelajaran
   - Filter by kelas, hari, guru
   - `getJadwalByKelas()` - untuk siswa
   - `getJadwalGuru()` - untuk guru

2. **`PelanggaranSiswaController`**
   - CRUD pelanggaran siswa
   - `getTotalPointSiswa()` - total point per siswa
   - `getSiswaBermasalah()` - top 20 siswa dengan point tertinggi

#### ✏️ Controller Diupdate:
- **`GuruController`**
  - Support many-to-many mapel
  - Method `assignMapel()` untuk assign mapel ke guru
  - Load relasi jadwalPelajarans

---

### 4. **Middleware & Authorization**

#### 🔒 Middleware Baru:
- **`CheckRole`** - Middleware untuk role-based access control
  - Registered di `bootstrap/app.php` dengan alias `role`

---

### 5. **Routes - Role-Based API**

#### 🛣️ API Routes Structure:

**Public Routes:**
- `POST /api/login`
- `POST /api/register`

**Admin Routes** (`/api/admin/*` - role: Admin):
- Dashboard
- CRUD Guru (dengan assign mapel)
- CRUD Siswa
- CRUD Mapel
- CRUD Kelas
- CRUD BK
- CRUD Jadwal Pelajaran
- CRUD Point Pelanggaran

**Guru Routes** (`/api/guru/*` - role: Guru):
- Jadwal mengajar saya
- CRUD Absen (buat sesi absen)
- CRUD Absensi (input kehadiran siswa)

**BK Routes** (`/api/bk/*` - role: BK):
- Siswa bermasalah (top offenders)
- CRUD Pelanggaran siswa
- Total point siswa
- CRUD Penjadwalan konseling
- CRUD Bimbingan

**Siswa Routes** (`/api/siswa/*` - role: Siswa):
- Jadwal pelajaran kelas
- Riwayat absensi saya
- Point & pelanggaran saya
- Penjadwalan konseling saya

**Shared Routes**:
- Lihat jadwal pelajaran (Admin, Guru, Siswa)

**Total:** 81 API endpoints

---

### 6. **Seeder - Data Dummy**

#### 📊 Data yang Di-seed:

**Roles:**
- Admin, BK, Guru, Siswa

**Users & Accounts:**
- 1 Admin
- 1 BK
- 3 Guru (masing-masing mengajar 2 mapel)
- 3 Siswa

**Master Data:**
- 4 Kelas (X IPA 1, X IPA 2, XI IPA 1, XII IPA 1)
- 9 Mata Pelajaran (Matematika, Fisika, Kimia, Biologi, B. Indonesia, B. Inggris, Sejarah, Ekonomi, PJOK)
- 5 Jadwal Pelajaran untuk kelas X IPA 1
- 5 Jenis Point Pelanggaran (Terlambat, Bolos, Seragam, Merokok, Berkelahi)
- 2 Sample Pelanggaran Siswa

#### 🔑 Login Credentials:
```
Admin:   admin / admin123
BK:      bk / bk123
Guru:    guru1, guru2, guru3 / guru123
Siswa:   siswa1, siswa2, siswa3 / siswa123
```

---

### 7. **Documentation**

#### 📖 Files Created:
- **`API_DOCUMENTATION.md`** - Dokumentasi lengkap API endpoints
  - Authentication
  - Semua routes untuk Admin, Guru, BK, Siswa
  - Request/Response examples
  - Login credentials
  - Database structure

---

## 🎨 Alur Sistem

### 1️⃣ **Alur Admin**
1. Login sebagai admin
2. Kelola master data:
   - Tambah Guru → Assign mapel yang diajarkan
   - Tambah Siswa → Assign ke kelas
   - Buat Mata Pelajaran
   - Buat Kelas
3. Buat Jadwal Pelajaran per kelas:
   - Pilih hari, jam, kelas, mapel, guru
   - Jadwal otomatis terlihat oleh Guru & Siswa

### 2️⃣ **Alur Guru**
1. Login sebagai guru
2. Lihat jadwal mengajar hari ini/minggu ini
3. Buat sesi absen untuk mapel tertentu di kelas tertentu
4. Input kehadiran siswa:
   - Hadir / Sakit / Izin / Alpa
5. Lihat riwayat absensi per siswa/kelas

### 3️⃣ **Alur BK**
1. Login sebagai BK
2. Lihat siswa bermasalah (yang punya banyak pelanggaran)
3. Catat pelanggaran siswa:
   - Pilih jenis pelanggaran
   - Point otomatis terakumulasi
4. Buat jadwal konseling dengan siswa
5. Input catatan bimbingan setelah konseling

### 4️⃣ **Alur Siswa**
1. Login sebagai siswa
2. Lihat jadwal pelajaran kelas (per hari/minggu)
3. Lihat riwayat absensi:
   - Per mapel
   - Statistik kehadiran
4. Lihat point pelanggaran & riwayat
5. Lihat jadwal konseling dengan BK

---

## 🚀 Cara Menjalankan

### Setup Database:
```bash
# Fresh migration + seed data
php artisan migrate:fresh --seed
```

### Test Routes:
```bash
# Lihat semua API routes
php artisan route:list --path=api
```

### Start Server:
```bash
php artisan serve
```

---

## 📊 Database ERD (Simplified)

```
┌──────────┐       ┌──────────┐       ┌──────────┐
│  Users   │───────│  Roles   │       │  Admin   │
└──────────┘       └──────────┘       └──────────┘
     │                                       │
     ├───────────────────┬───────────────────┤
     │                   │                   │
┌──────────┐       ┌──────────┐       ┌──────────┐
│   Guru   │───────│guru_mapel│───────│  Mapel   │
└──────────┘       └──────────┘       └──────────┘
     │                                       │
     │                                       │
┌────────────────┐                    ┌──────────┐
│jadwal_pelajaran│────────────────────│  Kelas   │
└────────────────┘                    └──────────┘
     │                                       │
     │                                       │
┌──────────┐                          ┌──────────┐
│  Absen   │──────────────────────────│  Siswa   │
└──────────┘                          └──────────┘
     │                                       │
┌──────────┐                    ┌───────────────────┐
│ Absensi  │                    │pelanggaran_siswas │
└──────────┘                    └───────────────────┘
                                        │      │
                                   ┌────┴──┐   │
                                   │ Point │   │
                                   └───────┘   │
                                          ┌────┴──┐
                                          │   BK  │
                                          └───────┘
```

---

## 🎯 Fitur Utama

### ✅ Sudah Selesai:
1. ✅ Role-based authentication & authorization
2. ✅ CRUD master data (Guru, Siswa, Mapel, Kelas, BK)
3. ✅ Jadwal pelajaran dengan filter
4. ✅ Absensi siswa per mapel & jam
5. ✅ Point & pelanggaran siswa
6. ✅ Konseling BK (penjadwalan & bimbingan)
7. ✅ Many-to-many Guru-Mapel
8. ✅ Relational data dengan Eloquent
9. ✅ API documentation lengkap
10. ✅ Seeder dengan data dummy realistis

### 🔮 Bisa Dikembangkan (Future):
- [ ] Input nilai akademik (UH, UTS, UAS)
- [ ] Dashboard dengan grafik & statistik
- [ ] Export laporan PDF (absensi, nilai, pelanggaran)
- [ ] Notifikasi (Email/WhatsApp untuk orang tua)
- [ ] Wali kelas features
- [ ] Parent/Orang tua access
- [ ] QR Code untuk absensi
- [ ] Mobile app integration
- [ ] Raport digital
- [ ] E-learning/Materi pelajaran

---

## 📝 Notes

### Perbedaan dengan Struktur Lama:
1. **Guru-Mapel**: Sekarang many-to-many, lebih fleksibel
2. **Mapel**: Tidak terikat ke 1 kelas, bisa lintas kelas
3. **Jadwal Pelajaran**: Tabel terpisah dengan jam yang jelas
4. **Absensi**: Lebih detail dengan jam dan kelas
5. **Pelanggaran**: Sistem point terintegrasi dengan BK

### Best Practices Applied:
- ✅ RESTful API design
- ✅ Proper validation
- ✅ Role-based access control (RBAC)
- ✅ Eloquent relationships
- ✅ Middleware untuk authorization
- ✅ Consistent response format
- ✅ Error handling

---

## 🎓 Kesimpulan

Sistem SIAKAD SMA ini sekarang memiliki:
- **Database yang lebih fleksibel** dengan relasi yang benar
- **API lengkap** untuk semua role (Admin, Guru, BK, Siswa)
- **Authorization yang proper** dengan middleware
- **Dokumentasi lengkap** untuk development

Sistem sudah siap untuk development frontend dan bisa langsung digunakan untuk testing API dengan tools seperti Postman atau Thunder Client.

---

**Dibuat pada:** 4 Februari 2026  
**Status:** ✅ Ready for Testing & Frontend Integration
