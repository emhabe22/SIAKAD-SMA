# ✅ SIAKAD SMA - Development Checklist

## 📋 Status Saat Ini: FASE 1 SELESAI ✅

---

## ✅ FASE 1 - Backend Core (SELESAI)

### Database & Migrations
- [x] Tabel users & roles
- [x] Tabel guru, siswa, admin, BK
- [x] Tabel kelas & mapel
- [x] Tabel guru_mapel (pivot many-to-many)
- [x] Tabel jadwal_pelajarans
- [x] Tabel absens & absensis
- [x] Tabel points & pelanggaran_siswas
- [x] Tabel penjadwalans & bimbingans
- [x] Perbaikan relasi database

### Models & Relationships
- [x] Model User dengan role
- [x] Model Guru (many-to-many dengan Mapel)
- [x] Model Siswa
- [x] Model Kelas (dengan fillable lengkap)
- [x] Model Mapel (tanpa kelas_id)
- [x] Model JadwalPelajaran
- [x] Model PelanggaranSiswa
- [x] Model Absen (dengan kelas_id & jam)
- [x] Semua relasi Eloquent

### Controllers & API
- [x] AuthController (login, register, logout)
- [x] AdminController (dashboard)
- [x] GuruController (CRUD + assign mapel)
- [x] SiswaController (CRUD)
- [x] BKController (CRUD)
- [x] KelasController (CRUD)
- [x] MapelController (CRUD)
- [x] JadwalPelajaranController (CRUD + filters)
- [x] PelanggaranSiswaController (CRUD + analytics)
- [x] AbsenController (CRUD)
- [x] AbsensiController (CRUD)
- [x] PointController (CRUD)

### Middleware & Authorization
- [x] CheckRole middleware
- [x] Register middleware di bootstrap/app.php
- [x] Role-based routes (Admin, Guru, BK, Siswa)
- [x] Sanctum authentication

### Seeders & Data
- [x] Role seeder (Admin, Guru, BK, Siswa)
- [x] User seeder dengan credentials
- [x] Kelas seeder (X IPA 1, X IPA 2, XI IPA 1, XII IPA 1)
- [x] Mapel seeder (9 mata pelajaran SMA)
- [x] Guru seeder (3 guru dengan mapel)
- [x] Siswa seeder (3 siswa)
- [x] Jadwal pelajaran seeder (5 jadwal)
- [x] Point pelanggaran seeder (5 jenis)
- [x] Sample pelanggaran siswa

### Documentation
- [x] README.md lengkap
- [x] API_DOCUMENTATION.md
- [x] RANGKUMAN_PERUBAHAN.md
- [x] Postman Collection
- [x] .env.example updated

---

## 🚧 FASE 2 - Enhancement & Features (TODO)

### Dashboard & Analytics
- [ ] Admin Dashboard dengan statistik
  - [ ] Total guru, siswa, kelas
  - [ ] Grafik kehadiran per bulan
  - [ ] Grafik pelanggaran per kelas
  - [ ] Top 10 siswa teladan
  - [ ] Top 10 siswa bermasalah
  
- [ ] Guru Dashboard
  - [ ] Jadwal hari ini
  - [ ] Kelas yang diampu
  - [ ] Statistik kehadiran per kelas
  - [ ] Kalender akademik
  
- [ ] BK Dashboard
  - [ ] Total siswa dikonseling
  - [ ] Grafik pelanggaran trend
  - [ ] Upcoming konseling sessions
  
- [ ] Siswa Dashboard
  - [ ] Jadwal hari ini
  - [ ] Statistik kehadiran bulan ini
  - [ ] Point pelanggaran
  - [ ] Upcoming tasks

### Nilai Akademik
- [ ] Migration untuk tabel nilai
  - [ ] nilai_harians (UH)
  - [ ] nilai_uts
  - [ ] nilai_uas
  - [ ] nilai_akhir
  
- [ ] Model Nilai dengan relasi
- [ ] NilaiController
  - [ ] Input nilai oleh guru
  - [ ] Lihat nilai oleh siswa
  - [ ] Export nilai ke Excel/PDF
  
- [ ] API Routes untuk nilai
  - [ ] Admin: Monitoring nilai
  - [ ] Guru: Input & edit nilai
  - [ ] Siswa: Lihat nilai pribadi

### Fitur Absensi Lanjutan
- [ ] Rekap absensi per bulan
- [ ] Export absensi ke Excel
- [ ] Statistik kehadiran per siswa
- [ ] Notifikasi jika siswa sering absen
- [ ] QR Code attendance (opsional)

### Laporan & Export
- [ ] Export Laporan Absensi PDF
  - [ ] Per kelas
  - [ ] Per mapel
  - [ ] Per periode
  
- [ ] Export Laporan Nilai PDF
  - [ ] Raport semester
  - [ ] Leger kelas
  
- [ ] Export Laporan Pelanggaran PDF
  - [ ] Per siswa
  - [ ] Per kelas
  - [ ] Per periode

### Wali Kelas Features
- [ ] Migration tabel wali_kelas
- [ ] Assign wali kelas ke kelas
- [ ] Wali kelas bisa:
  - [ ] Lihat siswa di kelas
  - [ ] Monitoring kehadiran kelas
  - [ ] Monitoring nilai kelas
  - [ ] Input catatan per siswa

### Parent/Orang Tua Portal
- [ ] Migration tabel orang_tua
- [ ] Link orang tua ke siswa
- [ ] Parent login & authentication
- [ ] Parent dapat:
  - [ ] Lihat jadwal anak
  - [ ] Lihat absensi anak
  - [ ] Lihat nilai anak
  - [ ] Lihat pelanggaran anak
  - [ ] Terima notifikasi

### Notifikasi System
- [ ] Setup mail configuration
- [ ] Email notification untuk:
  - [ ] Jadwal konseling BK
  - [ ] Pelanggaran siswa (ke orang tua)
  - [ ] Absensi rendah (ke orang tua)
  - [ ] Pengumuman penting
  
- [ ] WhatsApp notification (via API)
  - [ ] Setup WhatsApp Business API
  - [ ] Template pesan
  
- [ ] SMS Gateway (opsional)

---

## 🎯 FASE 3 - Advanced Features (FUTURE)

### E-Learning
- [ ] Upload materi pelajaran
- [ ] Video pembelajaran
- [ ] Quiz online
- [ ] Tugas online
- [ ] Forum diskusi

### Mobile App
- [ ] Setup Flutter/React Native project
- [ ] Login mobile
- [ ] Dashboard mobile
- [ ] Absensi via QR Code
- [ ] Push notification

### Calendar & Events
- [ ] Kalender akademik
- [ ] Event sekolah
- [ ] Ujian schedule
- [ ] Libur nasional

### Performance & Optimization
- [ ] Implement Redis cache
- [ ] Database indexing
- [ ] Query optimization
- [ ] API rate limiting
- [ ] CDN untuk assets

### Security Enhancement
- [ ] Two-factor authentication (2FA)
- [ ] Password policy enforcement
- [ ] Activity logging
- [ ] IP whitelist (opsional)
- [ ] CORS configuration

---

## 🧪 Testing & Quality

### Unit Testing
- [ ] Test AuthController
- [ ] Test GuruController
- [ ] Test SiswaController
- [ ] Test JadwalPelajaranController
- [ ] Test PelanggaranSiswaController
- [ ] Test middleware
- [ ] Test models & relationships

### Integration Testing
- [ ] Test complete user flows
- [ ] Test role-based access
- [ ] Test API endpoints
- [ ] Test database transactions

### Performance Testing
- [ ] Load testing dengan JMeter
- [ ] Stress testing
- [ ] Database query analysis

---

## 📱 Frontend Development

### Admin Frontend
- [ ] Dashboard
- [ ] Kelola Guru (CRUD)
- [ ] Kelola Siswa (CRUD)
- [ ] Kelola Kelas (CRUD)
- [ ] Kelola Mapel (CRUD)
- [ ] Kelola Jadwal Pelajaran
- [ ] Monitoring & Reports

### Guru Frontend
- [ ] Dashboard
- [ ] Jadwal mengajar
- [ ] Input absensi
- [ ] Input nilai
- [ ] Lihat siswa per kelas

### BK Frontend
- [ ] Dashboard
- [ ] Daftar siswa bermasalah
- [ ] Input pelanggaran
- [ ] Jadwal konseling
- [ ] Catatan bimbingan

### Siswa Frontend
- [ ] Dashboard
- [ ] Jadwal pelajaran
- [ ] Riwayat absensi
- [ ] Lihat nilai
- [ ] Point pelanggaran

---

## 🚀 Deployment

### Preparation
- [ ] Environment configuration
- [ ] Database optimization
- [ ] Security hardening
- [ ] HTTPS setup
- [ ] Backup strategy

### Hosting Options
- [ ] Shared hosting (cPanel)
- [ ] VPS (DigitalOcean, Vultr, etc.)
- [ ] Cloud (AWS, GCP, Azure)
- [ ] Heroku/Vercel (for testing)

### CI/CD
- [ ] GitHub Actions setup
- [ ] Automated testing
- [ ] Automated deployment
- [ ] Database migration automation

---

## 📝 Notes

### Priorities
1. **HIGH:** Dashboard & Analytics (Fase 2)
2. **HIGH:** Nilai Akademik (Fase 2)
3. **MEDIUM:** Laporan & Export PDF
4. **MEDIUM:** Parent Portal
5. **LOW:** E-Learning features
6. **LOW:** Mobile App

### Timeline Estimate
- **Fase 2:** 2-3 minggu (jika full-time)
- **Fase 3:** 1-2 bulan (bergantung scope)
- **Frontend:** 3-4 minggu (per platform)

### Next Steps
1. Mulai dengan Dashboard & Analytics
2. Implementasi Nilai Akademik
3. Buat export laporan PDF
4. Test dengan data real
5. Deployment ke staging server

---

**Last Updated:** 4 Februari 2026  
**Current Phase:** ✅ Fase 1 Complete - Ready for Phase 2
