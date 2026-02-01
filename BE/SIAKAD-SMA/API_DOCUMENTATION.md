# 📚 SIAKAD SMA - API Documentation

## Base URL
```
http://localhost:8000/api
```

## 🔐 Authentication
API menggunakan **Laravel Sanctum** (Bearer Token)

### Headers untuk endpoint yang perlu auth:
```
Authorization: Bearer {your_token}
Content-Type: application/json
```

---

## 📋 Endpoints

### **1. AUTHENTICATION**

#### Register
```http
POST /api/register
```
**Body:**
```json
{
  "username": "user123",
  "password": "password123",
  "role_id": 1,
  "nisn": "1234567890",  // optional, untuk siswa
  "nip": "198001012000"  // optional, untuk guru/bk
}
```
**Response:**
```json
{
  "success": true,
  "message": "Register berhasil",
  "data": {
    "user": { ... },
    "token": "your_auth_token_here"
  }
}
```

#### Login
```http
POST /api/login
```
**Body:**
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
  "data": {
    "user": { ... },
    "token": "your_auth_token_here"
  }
}
```

#### Logout
```http
POST /api/logout
```
**Headers:** `Authorization: Bearer {token}`

**Response:**
```json
{
  "success": true,
  "message": "Logout berhasil"
}
```

#### Get Current User
```http
GET /api/me
```
**Headers:** `Authorization: Bearer {token}`

**Response:**
```json
{
  "success": true,
  "data": { ... }
}
```

---

### **2. ROLES**

#### Get All Roles
```http
GET /api/roles
```

#### Get Single Role
```http
GET /api/roles/{id}
```

#### Create Role
```http
POST /api/roles
```
**Body:**
```json
{
  "name": "Role Name"
}
```

#### Update Role
```http
PUT /api/roles/{id}
```

#### Delete Role
```http
DELETE /api/roles/{id}
```

---

### **3. ADMINS**

#### Get All Admins
```http
GET /api/admins
```

#### Get Single Admin
```http
GET /api/admins/{id}
```

#### Create Admin
```http
POST /api/admins
```
**Body:**
```json
{
  "nama": "Nama Admin",
  "no_telp": "08123456789",
  "username": "admin2",
  "password": "password123"
}
```

#### Update Admin
```http
PUT /api/admins/{id}
```
**Body:**
```json
{
  "nama": "Nama Admin Updated",
  "no_telp": "08123456789",
  "password": "newpassword"  // optional
}
```

#### Delete Admin
```http
DELETE /api/admins/{id}
```

---

### **4. BK (Bimbingan Konseling)**

#### Get All BK
```http
GET /api/bk
```

#### Get Single BK
```http
GET /api/bk/{id}
```

#### Create BK
```http
POST /api/bk
```
**Body:**
```json
{
  "nama": "Nama BK",
  "nip": "198001012000",
  "alamat": "Jl. Contoh No. 1",
  "no_telp": 8123456789,
  "username": "bk1",
  "password": "password123"
}
```

#### Update BK
```http
PUT /api/bk/{id}
```

#### Delete BK
```http
DELETE /api/bk/{id}
```

---

### **5. KELAS**

#### Get All Kelas
```http
GET /api/kelas
```

#### Create Kelas
```http
POST /api/kelas
```
**Body:**
```json
{}
```

#### Update Kelas
```http
PUT /api/kelas/{id}
```

#### Delete Kelas
```http
DELETE /api/kelas/{id}
```

---

### **6. MAPEL (Mata Pelajaran)**

#### Get All Mapel
```http
GET /api/mapels
```

#### Create Mapel
```http
POST /api/mapels
```
**Body:**
```json
{
  "nama_mapel": "Matematika",
  "kelas_id": 1
}
```

#### Update Mapel
```http
PUT /api/mapels/{id}
```

#### Delete Mapel
```http
DELETE /api/mapels/{id}
```

---

### **7. SISWA**

#### Get All Siswa
```http
GET /api/siswas
```

#### Get Single Siswa
```http
GET /api/siswas/{id}
```

#### Create Siswa
```http
POST /api/siswas
```
**Body:**
```json
{
  "nama": "Nama Siswa",
  "nisn": "1234567890",
  "alamat": "Jl. Siswa No. 1",
  "no_telp": 8123456789,
  "kelas_id": 1,
  "nama_wali": "Nama Wali",
  "username": "siswa1",
  "password": "password123"
}
```

#### Update Siswa
```http
PUT /api/siswas/{id}
```

#### Delete Siswa
```http
DELETE /api/siswas/{id}
```

---

### **8. GURU**

#### Get All Guru
```http
GET /api/gurus
```

#### Create Guru
```http
POST /api/gurus
```
**Body:**
```json
{
  "nama": "Nama Guru",
  "nip": "198001012001",
  "alamat": "Jl. Guru No. 1",
  "no_telp": 8123456789,
  "mapel_id": 1,
  "username": "guru1",
  "password": "password123"
}
```

#### Update Guru
```http
PUT /api/gurus/{id}
```

#### Delete Guru
```http
DELETE /api/gurus/{id}
```

---

### **9. ABSEN**

#### Get All Absen
```http
GET /api/absens
```

#### Create Absen
```http
POST /api/absens
```
**Body:**
```json
{
  "tanggal": "2026-01-28",
  "pertemuan": "Pertemuan 1",
  "mapel_id": 1,
  "guru_id": 1
}
```

#### Update Absen
```http
PUT /api/absens/{id}
```

#### Delete Absen
```http
DELETE /api/absens/{id}
```

---

### **10. ABSENSI**

#### Get All Absensi
```http
GET /api/absensis
```

#### Create Absensi
```http
POST /api/absensis
```
**Body:**
```json
{
  "siswa_id": 1,
  "absen_id": 1,
  "status": "1"  // 1 = hadir, 0 = tidak hadir
}
```

#### Update Absensi
```http
PUT /api/absensis/{id}
```

#### Delete Absensi
```http
DELETE /api/absensis/{id}
```

---

### **11. PENJADWALAN**

#### Get All Penjadwalan
```http
GET /api/penjadwalans
```

#### Create Penjadwalan
```http
POST /api/penjadwalans
```
**Body:**
```json
{
  "tanggal": "2026-01-28",
  "waktu": "10:00:00",
  "siswa_id": 1,
  "bk_id": 1,
  "status": "1"  // optional, 1 = selesai, 0 = belum
}
```

#### Update Penjadwalan
```http
PUT /api/penjadwalans/{id}
```

#### Delete Penjadwalan
```http
DELETE /api/penjadwalans/{id}
```

---

### **12. POINTS**

#### Get All Points
```http
GET /api/points
```

#### Create Point
```http
POST /api/points
```
**Body:**
```json
{
  "nama": "Terlambat",
  "nilai": 10
}
```

#### Update Point
```http
PUT /api/points/{id}
```

#### Delete Point
```http
DELETE /api/points/{id}
```

---

### **13. BIMBINGAN**

#### Get All Bimbingan
```http
GET /api/bimbingans
```

#### Create Bimbingan
```http
POST /api/bimbingans
```
**Body:**
```json
{
  "catatan": "Catatan bimbingan...",
  "ringkasan": "Ringkasan bimbingan...",
  "penjadwalan_id": 1,
  "point_id": 1
}
```

#### Update Bimbingan
```http
PUT /api/bimbingans/{id}
```

#### Delete Bimbingan
```http
DELETE /api/bimbingans/{id}
```

---

## 🚀 Testing dengan Postman/Insomnia

### 1. Login terlebih dahulu
```http
POST /api/login
Body: { "username": "admin", "password": "admin123" }
```

### 2. Copy token dari response

### 3. Gunakan token di header untuk endpoint lain
```
Authorization: Bearer {paste_token_disini}
```

---

## ✅ Response Format

### Success Response
```json
{
  "success": true,
  "message": "Pesan sukses",
  "data": { ... }
}
```

### Error Response
```json
{
  "success": false,
  "message": "Pesan error"
}
```

### Validation Error
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "field_name": ["Error message"]
  }
}
```

---

## 🔑 Default Login

**Username:** `admin`  
**Password:** `admin123`

---

## 📝 Role IDs
- `1` = BK
- `2` = Guru
- `3` = Admin
- `4` = Siswa
