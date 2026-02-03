@extends('layouts.app')

@section('title', 'Bimbingan Konseling - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Bimbingan Konseling')
@section('breadcrumb', 'Siswa / Bimbingan Konseling')

@php
    $role = 'siswa';
    $userName = 'Ahmad Fauzi';
    $userRole = 'Siswa X MIPA 1';
@endphp

@section('content')
<!-- Welcome Banner -->
<div class="welcome-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="welcome-content">
        <h2>Bimbingan Konseling</h2>
        <p>Kelola sesi konseling dan ajukan bimbingan dengan guru BK</p>
    </div>
    <div class="welcome-icon">
        <i class="fas fa-hands-helping fa-3x"></i>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="stat-info">
            <h3>3</h3>
            <p>Sesi Aktif</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h3>2</h3>
            <p>Menunggu Konfirmasi</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>8</h3>
            <p>Sesi Selesai</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="stat-info">
            <h3>1</h3>
            <p>Surat Pemanggilan</p>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-plus-circle"></i> Aksi Cepat</h3>
    </div>
    <div class="card-body">
        <div class="quick-actions">
            <button class="btn btn-primary" onclick="showRequestBKModal()">
                <i class="fas fa-plus"></i> Ajukan Sesi BK
            </button>
            <button class="btn btn-info" onclick="viewBKSchedule()">
                <i class="fas fa-calendar-alt"></i> Lihat Jadwal
            </button>
            <button class="btn btn-success" onclick="viewBKHistory()">
                <i class="fas fa-history"></i> Riwayat BK
            </button>
        </div>
    </div>
</div>

<!-- Active Sessions -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-list"></i> Sesi BK Aktif</h3>
        <button class="btn btn-sm btn-outline-primary" onclick="refreshSessions()">
            <i class="fas fa-sync-alt"></i> Refresh
        </button>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Guru BK</th>
                    <th>Topik</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>05 Feb 2026</td>
                    <td>10:00 - 11:00</td>
                    <td>Bu Siti Aminah, S.Pd</td>
                    <td>Konsultasi Akademik</td>
                    <td><span class="badge badge-success">Disetujui</span></td>
                    <td>
                        <button class="btn btn-sm btn-info" onclick="viewDetail(1)">Detail</button>
                    </td>
                </tr>
                <tr>
                    <td>08 Feb 2026</td>
                    <td>13:00 - 14:00</td>
                    <td>Pak Ahmad Rizki, M.Pd</td>
                    <td>Konseling Pribadi</td>
                    <td><span class="badge badge-warning">Menunggu</span></td>
                    <td>
                        <button class="btn btn-sm btn-info" onclick="viewDetail(2)">Detail</button>
                    </td>
                </tr>
                <tr>
                    <td>10 Feb 2026</td>
                    <td>09:00 - 10:00</td>
                    <td>Bu Siti Aminah, S.Pd</td>
                    <td>Bimbingan Karir</td>
                    <td><span class="badge badge-warning">Menunggu</span></td>
                    <td>
                        <button class="btn btn-sm btn-info" onclick="viewDetail(3)">Detail</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- History -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-history"></i> Riwayat Sesi BK</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Guru BK</th>
                    <th>Topik</th>
                    <th>Catatan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>01 Feb 2026</td>
                    <td>Bu Siti Aminah, S.Pd</td>
                    <td>Konseling Akademik</td>
                    <td>Sesi berjalan dengan baik</td>
                    <td><span class="badge badge-success">Selesai</span></td>
                </tr>
                <tr>
                    <td>25 Jan 2026</td>
                    <td>Pak Ahmad Rizki, M.Pd</td>
                    <td>Konseling Sosial</td>
                    <td>Perlu tindak lanjut</td>
                    <td><span class="badge badge-success">Selesai</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showRequestBKModal() {
        alert('Fitur ajukan BK akan segera tersedia');
    }
    
    function viewBKSchedule() {
        alert('Menampilkan jadwal BK');
    }
    
    function viewBKHistory() {
        alert('Menampilkan riwayat BK lengkap');
    }
    
    function refreshSessions() {
        alert('Memperbarui data sesi...');
        location.reload();
    }
    
    function viewDetail(id) {
        alert('Menampilkan detail sesi BK #' + id);
    }
</script>
@endpush