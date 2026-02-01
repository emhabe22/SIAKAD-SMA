# 🚀 Quick Reference - SIAKAD SMA API

## ⚡ Quick Start

```bash
# 1. Start Server
php artisan serve

# 2. Login
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"username":"admin","password":"admin123"}'

# 3. Copy token dari response
```

---

## 🔑 Default Credentials

```
Username: admin
Password: admin123
```

---

## 📋 All Endpoints

### Auth (Public)
```
POST   /api/register
POST   /api/login
```

### Auth (Protected)
```
POST   /api/logout
GET    /api/me
```

### Roles
```
GET    /api/roles
POST   /api/roles
GET    /api/roles/{id}
PUT    /api/roles/{id}
DELETE /api/roles/{id}
```

### Admins
```
GET    /api/admins
POST   /api/admins
GET    /api/admins/{id}
PUT    /api/admins/{id}
DELETE /api/admins/{id}
```

### BK
```
GET    /api/bk
POST   /api/bk
GET    /api/bk/{id}
PUT    /api/bk/{id}
DELETE /api/bk/{id}
```

### Kelas
```
GET    /api/kelas
POST   /api/kelas
GET    /api/kelas/{id}
PUT    /api/kelas/{id}
DELETE /api/kelas/{id}
```

### Mapels
```
GET    /api/mapels
POST   /api/mapels
GET    /api/mapels/{id}
PUT    /api/mapels/{id}
DELETE /api/mapels/{id}
```

### Siswas
```
GET    /api/siswas
POST   /api/siswas
GET    /api/siswas/{id}
PUT    /api/siswas/{id}
DELETE /api/siswas/{id}
```

### Gurus
```
GET    /api/gurus
POST   /api/gurus
GET    /api/gurus/{id}
PUT    /api/gurus/{id}
DELETE /api/gurus/{id}
```

### Absens
```
GET    /api/absens
POST   /api/absens
GET    /api/absens/{id}
PUT    /api/absens/{id}
DELETE /api/absens/{id}
```

### Absensis
```
GET    /api/absensis
POST   /api/absensis
GET    /api/absensis/{id}
PUT    /api/absensis/{id}
DELETE /api/absensis/{id}
```

### Penjadwalans
```
GET    /api/penjadwalans
POST   /api/penjadwalans
GET    /api/penjadwalans/{id}
PUT    /api/penjadwalans/{id}
DELETE /api/penjadwalans/{id}
```

### Points
```
GET    /api/points
POST   /api/points
GET    /api/points/{id}
PUT    /api/points/{id}
DELETE /api/points/{id}
```

### Bimbingans
```
GET    /api/bimbingans
POST   /api/bimbingans
GET    /api/bimbingans/{id}
PUT    /api/bimbingans/{id}
DELETE /api/bimbingans/{id}
```

---

## 🎯 Common Tasks

### Create Siswa
```json
POST /api/siswas
{
  "nama": "Budi Santoso",
  "nisn": "1234567890",
  "alamat": "Jl. Merdeka No. 10",
  "no_telp": 8123456789,
  "kelas_id": 1,
  "nama_wali": "Pak Budi",
  "username": "budi123",
  "password": "password123"
}
```

### Create Guru
```json
POST /api/gurus
{
  "nama": "Ibu Siti",
  "nip": "198001012001",
  "alamat": "Jl. Guru No. 1",
  "no_telp": 8123456789,
  "mapel_id": 1,
  "username": "siti_guru",
  "password": "password123"
}
```

### Create Absen
```json
POST /api/absens
{
  "tanggal": "2026-01-28",
  "pertemuan": "Pertemuan 1",
  "mapel_id": 1,
  "guru_id": 1
}
```

### Create Absensi
```json
POST /api/absensis
{
  "siswa_id": 1,
  "absen_id": 1,
  "status": "1"
}
```

---

## 📱 Header Template

```
Authorization: Bearer {your_token}
Content-Type: application/json
```

---

## 🔄 Response Format

```json
{
  "success": true,
  "message": "Success message",
  "data": {}
}
```

---

## 📁 Files Location

- Controllers: `app/Http/Controllers/`
- Models: `app/Models/`
- Routes: `routes/api.php`
- Migrations: `database/migrations/`
- Seeders: `database/seeders/`

---

## 🛠️ Useful Commands

```bash
# Start server
php artisan serve

# Run migrations
php artisan migrate

# Run seeders
php artisan db:seed

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Check routes
php artisan route:list

# Create new migration
php artisan make:migration create_table_name

# Create new controller
php artisan make:controller ControllerName

# Create new model
php artisan make:model ModelName
```

---

## 📊 Role IDs

```
1 = BK
2 = Guru
3 = Admin
4 = Siswa
```

---

**Base URL:** `http://localhost:8000/api`
