# 🧪 Quick Test API

## Test Manual dengan Browser

1. **Start Server**
```bash
php artisan serve
```

2. **Buka browser dan test endpoint:**

### Test Welcome Page
```
http://localhost:8000
```

### Test API Login (gunakan Postman/Insomnia)
```
POST http://localhost:8000/api/login
Body (JSON):
{
  "username": "admin",
  "password": "admin123"
}
```

## Test dengan Postman

### 1. Install Postman
Download dari: https://www.postman.com/downloads/

### 2. Import Collection
- Buka Postman
- Klik Import
- Pilih file `SIAKAD_SMA.postman_collection.json`

### 3. Set Environment Variables
- `base_url` = `http://localhost:8000`
- `token` = (akan diisi setelah login)

### 4. Test Login
- Pilih request "Auth > Login"
- Klik Send
- Copy token dari response
- Set ke variable `token`

### 5. Test Endpoint Lain
Semua endpoint sudah tersedia di collection, tinggal klik Send!

## Test dengan cURL (Windows PowerShell)

### Login
```powershell
$body = @{
    username = "admin"
    password = "admin123"
} | ConvertTo-Json

Invoke-RestMethod -Uri "http://localhost:8000/api/login" -Method POST -Body $body -ContentType "application/json"
```

### Get All Roles (setelah login)
```powershell
$token = "paste_token_here"
Invoke-RestMethod -Uri "http://localhost:8000/api/roles" -Method GET -Headers @{Authorization="Bearer $token"}
```

## Struktur Response

### Success Login
```json
{
  "success": true,
  "message": "Login berhasil",
  "data": {
    "user": {
      "id": 1,
      "username": "admin",
      "role_id": 3
    },
    "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
  }
}
```

### Error
```json
{
  "success": false,
  "message": "Username atau password salah"
}
```

## Troubleshooting

### Server tidak bisa diakses
```bash
# Pastikan server running
php artisan serve

# Atau gunakan port lain
php artisan serve --port=8001
```

### Database error
```bash
# Check connection
php artisan migrate:status

# Reset database jika perlu
php artisan migrate:fresh --seed
```

### Token expired
- Login ulang untuk mendapatkan token baru
- Token Sanctum tidak expired secara default

## Next Steps

1. ✅ Test semua endpoint di Postman
2. ✅ Buat data dummy (Kelas, Mapel, Siswa, dll)
3. ✅ Test flow lengkap (Create Siswa > Absen > Bimbingan)
4. ✅ Integrasikan dengan Frontend

Happy Testing! 🚀
