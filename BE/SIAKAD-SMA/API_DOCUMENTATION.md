# SIAKAD SMA - API Documentation

## 📋 Daftar Isi
- [Authentication](#authentication)
- [Admin Routes](#admin-routes)
- [Guru Routes](#guru-routes)
- [BK Routes](#bk-routes)
- [Siswa Routes](#siswa-routes)

---

## 🔐 Authentication

### Login
```http
POST /api/login
```
**Request Body:**
```json
{
  "username": "admin",
  "password": "admin123"
}
```

**Response:**
```json
{
  "success": true,
  "message": "Login berhasil",
  "token": "1|xxxxx",
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

### Logout
```http
POST /api/logout
Headers: Authorization: Bearer {token}
```

---

## 👨‍💼 Admin Routes
**Prefix:** `/api/admin`  
**Middleware:** `auth:sanctum`, `role:Admin`

### Dashboard
```http
GET /api/admin/dashboard
```

### Kelola Guru

#### Lihat Semua Guru
```http
GET /api/admin/guru
```

#### Tambah Guru
```http
POST /api/admin/guru
```
**Request Body:**
```json
{
  "nama": "Ahmad Rizki, S.Pd",
  "nip": "198501012010011001",
  "alamat": "Jl. Pendidikan No. 10",
  "no_telp": "081234567891",
  "username": "guru1",
  "password": "guru123",
  "mapel_ids": [1, 2]
}
```

#### Assign Mapel ke Guru
```http
POST /api/admin/guru/{id}/mapel
```
**Request Body:**
```json
{
  "mapel_ids": [1, 2, 3]
}
```

#### Update Guru
```http
PUT /api/admin/guru/{id}
```

#### Hapus Guru
```http
DELETE /api/admin/guru/{id}
```

### Kelola Siswa

#### Lihat Semua Siswa
```http
GET /api/admin/siswa
```

#### Tambah Siswa
```http
POST /api/admin/siswa
```
**Request Body:**
```json
{
  "nama": "Andi Pratama",
  "nisn": "0051234567",
  "alamat": "Jl. Gatot Subroto No. 15",
  "no_telp": "081234567894",
  "kelas_id": 1,
  "nama_wali": "Bapak Pratama",
  "username": "siswa1",
  "password": "siswa123"
}
```

#### Update/Hapus Siswa
```http
PUT /api/admin/siswa/{id}
DELETE /api/admin/siswa/{id}
```

### Kelola Mata Pelajaran

#### Lihat Semua Mapel
```http
GET /api/admin/mapel
```

#### Tambah Mapel
```http
POST /api/admin/mapel
```
**Request Body:**
```json
{
  "nama_mapel": "Matematika"
}
```

### Kelola Kelas

#### Lihat Semua Kelas
```http
GET /api/admin/kelas
```

#### Tambah Kelas
```http
POST /api/admin/kelas
```
**Request Body:**
```json
{
  "nama_kelas": "X IPA 1",
  "tingkat": "10",
  "jurusan": "IPA"
}
```

### Kelola Jadwal Pelajaran

#### Lihat Jadwal Pelajaran
```http
GET /api/admin/jadwal-pelajaran
GET /api/admin/jadwal-pelajaran?kelas_id=1
GET /api/admin/jadwal-pelajaran?hari=Senin
GET /api/admin/jadwal-pelajaran?guru_id=1
```

#### Tambah Jadwal Pelajaran
```http
POST /api/admin/jadwal-pelajaran
```
**Request Body:**
```json
{
  "hari": "Senin",
  "jam_mulai": "07:00",
  "jam_selesai": "08:30",
  "kelas_id": 1,
  "mapel_id": 1,
  "guru_id": 1,
  "ruangan": "R.301"
}
```

#### Update Jadwal
```http
PUT /api/admin/jadwal-pelajaran/{id}
```

#### Hapus Jadwal
```http
DELETE /api/admin/jadwal-pelajaran/{id}
```

### Kelola Point Pelanggaran

#### Lihat Point
```http
GET /api/admin/point
```

#### Tambah Point
```http
POST /api/admin/point
```
**Request Body:**
```json
{
  "nama": "Terlambat",
  "nilai": -10
}
```

---

## 👨‍🏫 Guru Routes
**Prefix:** `/api/guru`  
**Middleware:** `auth:sanctum`, `role:Guru`

### Jadwal Mengajar Saya
```http
GET /api/guru/jadwal-saya/{guru_id}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "Senin": [
      {
        "id": 1,
        "hari": "Senin",
        "jam_mulai": "07:00",
        "jam_selesai": "08:30",
        "kelas": {
          "nama_kelas": "X IPA 1"
        },
        "mapel": {
          "nama_mapel": "Matematika"
        },
        "ruangan": "R.301"
      }
    ],
    "Selasa": [...]
  }
}
```

### Kelola Absensi

#### Buat Sesi Absen
```http
POST /api/guru/absen
```
**Request Body:**
```json
{
  "tanggal": "2026-02-04",
  "jam_mulai": "07:00",
  "jam_selesai": "08:30",
  "kelas_id": 1,
  "pertemuan": "Pertemuan ke-5",
  "mapel_id": 1,
  "guru_id": 1
}
```

#### Input Absensi Siswa
```http
POST /api/guru/absensi
```
**Request Body:**
```json
{
  "siswa_id": 1,
  "absen_id": 1,
  "status": "1"  // 1 = Hadir, 0 = Tidak Hadir/Alpa
}
```

---

## 🧑‍⚖️ BK Routes
**Prefix:** `/api/bk`  
**Middleware:** `auth:sanctum`, `role:BK`

### Siswa Bermasalah
```http
GET /api/bk/siswa-bermasalah
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "nama": "Andi Pratama",
      "nisn": "0051234567",
      "nama_kelas": "X IPA 1",
      "total_point": -40,
      "jumlah_pelanggaran": 2
    }
  ]
}
```

### Kelola Pelanggaran Siswa

#### Lihat Pelanggaran
```http
GET /api/bk/pelanggaran-siswa
GET /api/bk/pelanggaran-siswa?siswa_id=1
```

#### Tambah Pelanggaran
```http
POST /api/bk/pelanggaran-siswa
```
**Request Body:**
```json
{
  "siswa_id": 1,
  "point_id": 2,
  "bk_id": 1,
  "tanggal": "2026-02-04",
  "keterangan": "Terlambat masuk kelas pukul 07:15"
}
```

#### Total Point Siswa
```http
GET /api/bk/total-point-siswa/{siswa_id}
```

### Kelola Penjadwalan Konseling
```http
GET /api/bk/penjadwalan
POST /api/bk/penjadwalan
PUT /api/bk/penjadwalan/{id}
DELETE /api/bk/penjadwalan/{id}
```

### Kelola Bimbingan
```http
GET /api/bk/bimbingan
POST /api/bk/bimbingan
PUT /api/bk/bimbingan/{id}
DELETE /api/bk/bimbingan/{id}
```

---

## 👨‍🎓 Siswa Routes
**Prefix:** `/api/siswa`  
**Middleware:** `auth:sanctum`, `role:Siswa`

### Jadwal Pelajaran Kelas Saya
```http
GET /api/siswa/jadwal-kelas/{kelas_id}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "Senin": [
      {
        "id": 1,
        "jam_mulai": "07:00",
        "jam_selesai": "08:30",
        "mapel": {
          "nama_mapel": "Matematika"
        },
        "guru": {
          "nama": "Ahmad Rizki, S.Pd"
        },
        "ruangan": "R.301"
      }
    ]
  }
}
```

### Absensi Saya
```http
GET /api/siswa/absensi-saya/{siswa_id}
```

### Pelanggaran & Point Saya
```http
GET /api/siswa/pelanggaran-saya/{siswa_id}
```

**Response:**
```json
{
  "success": true,
  "data": {
    "total_point": -40,
    "riwayat": [
      {
        "id": 1,
        "tanggal": "2026-02-01",
        "point": {
          "nama": "Terlambat",
          "nilai": -10
        },
        "bk": {
          "nama": "Budi Santoso, S.Pd"
        },
        "keterangan": "Terlambat masuk kelas"
      }
    ]
  }
}
```

### Penjadwalan Konseling Saya
```http
GET /api/siswa/penjadwalan-saya/{siswa_id}
```

---

## 🔄 Shared Routes
Accessible by multiple roles

### Jadwal Pelajaran (Read Only)
**Roles:** Admin, Guru, Siswa
```http
GET /api/jadwal-pelajaran
GET /api/jadwal-pelajaran/{id}
```

---

## 📝 Login Credentials (Seeder)

### Admin
- **Username:** `admin`
- **Password:** `admin123`

### BK
- **Username:** `bk`
- **Password:** `bk123`

### Guru
- **Username:** `guru1`, `guru2`, `guru3`
- **Password:** `guru123`

### Siswa
- **Username:** `siswa1`, `siswa2`, `siswa3`
- **Password:** `siswa123`

---

## 🏗️ Database Structure

### New Tables Created:
1. **guru_mapel** - Pivot table untuk relasi many-to-many Guru & Mapel
2. **jadwal_pelajarans** - Jadwal pelajaran per kelas
3. **pelanggaran_siswas** - Tracking pelanggaran siswa dengan point

### Updated Tables:
1. **gurus** - Removed `mapel_id` (now many-to-many)
2. **mapels** - Removed `kelas_id` (mapel bisa lintas kelas)
3. **absens** - Added `jam_mulai`, `jam_selesai`, `kelas_id`
4. **kelas** - Added `nama_kelas`, `tingkat`, `jurusan`

---

## 🎯 Key Features

### ✅ Admin
- Kelola semua master data (Guru, Siswa, Mapel, Kelas, BK)
- Buat jadwal pelajaran
- Kelola point pelanggaran

### ✅ Guru
- Lihat jadwal mengajar
- Absensi siswa per mapel & jam
- Riwayat absensi

### ✅ BK
- Lihat siswa bermasalah
- Catat pelanggaran siswa
- Jadwal konseling
- Catatan bimbingan

### ✅ Siswa
- Lihat jadwal pelajaran
- Lihat riwayat absensi
- Lihat point & pelanggaran
- Lihat jadwal konseling

---

## 🚀 Next Steps

### Phase 2 (Future Development):
- [ ] Input nilai akademik (UH, UTS, UAS)
- [ ] Dashboard dengan grafik dan statistik
- [ ] Export laporan PDF
- [ ] Notifikasi (Email/WhatsApp)
- [ ] Wali kelas features
- [ ] Parent/Orang tua features
- [ ] Attendance QR Code
- [ ] Mobile app integration

---

## 📞 Support
Untuk pertanyaan atau bantuan, silakan hubungi tim development.
