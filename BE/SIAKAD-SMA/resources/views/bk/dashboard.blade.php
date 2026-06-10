@extends('layouts.app')

@section('title', 'Dashboard BK - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Dashboard BK')
@section('breadcrumb', 'Home / Dashboard')

@php
    $role = 'bk';
    $userName = 'Siti Nurhaliza, S.Pd';
    $userRole = 'Guru BK';
@endphp

@section('content')
<style>
    /* Tambahan CSS untuk dashboard BK */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 15px;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
    }

    .stat-info h3 {
        margin: 0;
        font-size: 28px;
        color: #333;
    }

    .stat-info p {
        margin: 5px 0 0 0;
        color: #666;
        font-size: 14px;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 30px;
    }

    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }

    .left-column, .right-column {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h3 {
        margin: 0;
        color: #333;
        font-size: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-link {
        color: #2196F3;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
    }

    .btn-link:hover {
        text-decoration: underline;
    }

    .card-body {
        padding: 20px;
    }

    /* Schedule list styles */
    .schedule-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .schedule-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 15px;
        border: 1px solid #eee;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .schedule-item:hover {
        border-color: #2196F3;
        background: #f8f9fa;
    }

    .schedule-time {
        min-width: 120px;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .time {
        font-weight: 600;
        color: #333;
    }

    .status {
        font-size: 12px;
        padding: 3px 8px;
        border-radius: 12px;
        font-weight: 500;
    }

    .status.active {
        background: #4CAF50;
        color: white;
    }

    .status.upcoming {
        background: #2196F3;
        color: white;
    }

    .schedule-details {
        flex: 1;
    }

    .schedule-details h4 {
        margin: 0 0 5px 0;
        color: #333;
    }

    .schedule-details p {
        margin: 0 0 8px 0;
        color: #666;
        font-size: 14px;
    }

    .tag {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .tag.urgent {
        background: #F44336;
        color: white;
    }

    .tag.regular {
        background: #4CAF50;
        color: white;
    }

    .tag.warning {
        background: #FF9800;
        color: white;
    }

    /* Quick actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    @media (max-width: 768px) {
        .quick-actions {
            grid-template-columns: 1fr;
        }
    }

    .action-btn {
        padding: 15px;
        background: white;
        border: 2px solid #2196F3;
        border-radius: 10px;
        color: #2196F3;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s ease;
    }

    .action-btn:hover {
        background: #2196F3;
        color: white;
    }

    .action-btn i {
        font-size: 20px;
    }

    /* Data table */
    .full-width {
        width: 100%;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        background: #f8f9fa;
        padding: 12px 16px;
        text-align: left;
        font-weight: 600;
        color: #555;
        border-bottom: 2px solid #eee;
    }

    .data-table td {
        padding: 12px 16px;
        border-bottom: 1px solid #eee;
    }

    .data-table tbody tr:hover {
        background: #f8f9fa;
    }

    .status-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .completed { background: #4CAF50; color: white; }
    .pending { background: #FF9800; color: white; }
    .in-progress { background: #2196F3; color: white; }

    .btn-icon {
        padding: 6px;
        background: none;
        border: none;
        color: #666;
        cursor: pointer;
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .btn-icon:hover {
        background: #f0f0f0;
        color: #2196F3;
    }
</style>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #4CAF50;">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <h3 id="activeStudentsCount">0</h3>
            <p>Siswa Aktif</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #2196F3;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h3 id="todayCounselCount">0</h3>
            <p>Konseling Hari Ini</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #FF9800;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="stat-info">
            <h3 id="pendingValidationCount">0</h3>
            <p>Perlu Validasi</p>
        </div>
    </div>

</div>
<div class="dashboard-meta" style="margin-bottom: 24px; color: #555; font-size: 15px;">
    <span id="current-date"></span>
</div>

<!-- Main Content Grid -->
<div class="content-grid">
    <!-- Left Column -->
    <div class="left-column">
        <!-- Jadwal Konseling Hari Ini -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-calendar-alt"></i> Jadwal Konseling Hari Ini</h3>
                <a href="#" class="btn-link">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="schedule-list" id="todayScheduleList">
                    <div class="schedule-item">
                        <div class="schedule-time">
                            <span class="time">Loading...</span>
                        </div>
                        <div class="schedule-details">
                            <h4>Memuat data jadwal...</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="right-column">
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-bolt"></i> Tindakan Cepat</h3>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <button class="action-btn" onclick="location.href='/bk/surat-pemanggilan'">
                        <i class="fas fa-envelope"></i>
                        <span>Buat Surat Pemanggilan</span>
                    </button>
                    <button class="action-btn" onclick="location.href='/bk/validasi'">
                        <i class="fas fa-check-circle"></i>
                        <span>Validasi Siswa</span>
                    </button>
                    <button class="action-btn" onclick="location.href='/bk/feedback'">
                        <i class="fas fa-comment-medical"></i>
                        <span>Beri Feedback</span>
                    </button>
                    <button class="action-btn" onclick="location.href='/bk/laporan'">
                        <i class="fas fa-file-alt"></i>
                        <span>Buat Laporan</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="card full-width">
    <div class="card-header">
        <h3><i class="fas fa-history"></i> Aktivitas Terbaru</h3>
    </div>
    <div class="card-body">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Aktivitas</th>
                    <th>Siswa</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="recentActivitiesBody">
                <tr>
                    <td colspan="5" style="text-align: center;">Memuat aktivitas terbaru...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function formatDate(dateString) {
        const date = new Date(dateString);
        if (Number.isNaN(date.getTime())) return '-';

        const options = {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        };

        return date.toLocaleDateString('id-ID', options);
    }

    function formatTime(timeString) {
        return timeString || '-';
    }

    function statusBadge(status) {
        switch (status) {
            case '1':
            case 1:
                return '<span class="status-badge completed">Disetujui</span>';
            case '0':
            case 0:
                return '<span class="status-badge pending">Menunggu</span>';
            default:
                return '<span class="status-badge in-progress">Proses</span>';
        }
    }

    function updateDate() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        document.getElementById('current-date').textContent =
            now.toLocaleDateString('id-ID', options);
    }

    function renderTodaySchedule(schedules) {
        const container = document.getElementById('todayScheduleList');
        const today = new Date().toISOString().split('T')[0];
        const todaySchedules = schedules.filter(item => item.tanggal === today);

        if (!todaySchedules.length) {
            container.innerHTML = '<div class="schedule-item"><div class="schedule-details"><h4>Tidak ada jadwal konseling hari ini</h4><p>Semua jadwal sudah bersih atau belum ada permintaan.</p></div></div>';
            return;
        }

        container.innerHTML = todaySchedules.map(item => {
            const namaSiswa = item.siswa ? item.siswa.nama : 'Siswa tidak ditemukan';
            const tingkat = item.siswa && item.siswa.tingkat ? item.siswa.tingkat : 'N/A';
            const siswa = `${namaSiswa} (${tingkat})`;
            return `
                <div class="schedule-item">
                    <div class="schedule-time">
                        <span class="time">${formatTime(item.waktu)}</span>
                        <span class="status ${item.status === '1' || item.status === 1 ? 'active' : 'upcoming'}">${item.status === '1' || item.status === 1 ? 'Disetujui' : 'Menunggu'}</span>
                    </div>
                    <div class="schedule-details">
                        <h4>${siswa}</h4>
                        <p>${item.keterangan || 'Tidak ada keterangan tambahan.'}</p>
                    </div>
                </div>
            `;
        }).join('');
    }

    function renderRecentActivities(schedules) {
        const body = document.getElementById('recentActivitiesBody');
        const sorted = schedules.sort((a, b) => new Date(b.tanggal + ' ' + b.waktu) - new Date(a.tanggal + ' ' + a.waktu));
        const recent = sorted.slice(0, 5);

        if (!recent.length) {
            body.innerHTML = '<tr><td colspan="5" style="text-align: center;">Tidak ada aktivitas terbaru.</td></tr>';
            return;
        }

        body.innerHTML = recent.map(item => {
            const waktu = `${formatDate(item.tanggal)}, ${formatTime(item.waktu)}`;
            const namaSiswa = item.siswa ? item.siswa.nama : 'Siswa tidak ditemukan';
            const tingkat = item.siswa && item.siswa.tingkat ? item.siswa.tingkat : 'N/A';
            const siswa = `${namaSiswa} (${tingkat})`;
            const aktivitas = item.keterangan ? `Konseling: ${item.keterangan}` : 'Jadwal Konseling';
            return `
                <tr>
                    <td>${waktu}</td>
                    <td>${aktivitas}</td>
                    <td>${siswa}</td>
                    <td>${statusBadge(item.status)}</td>
                    <td>
                        <button class="btn-icon" title="Lihat Detail"><i class="fas fa-eye"></i></button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    function updateStats(schedules) {
        const activeStudents = new Set(schedules.filter(item => item.status === '1' || item.status === 1).map(item => item.siswa_id)).size;
        const today = new Date().toISOString().split('T')[0];
        const todayCount = schedules.filter(item => item.tanggal === today).length;
        const pendingCount = schedules.filter(item => item.status === '0' || item.status === 0).length;

        document.getElementById('activeStudentsCount').textContent = activeStudents;
        document.getElementById('todayCounselCount').textContent = todayCount;
        document.getElementById('pendingValidationCount').textContent = pendingCount;
    }

    function fetchDashboardData() {
        const token = localStorage.getItem('token');
        if (!token) {
            console.error('Token tidak ditemukan');
            return;
        }
        fetch('/api/bk/penjadwalan', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        })
            .then(response => response.json())
            .then(result => {
                if (!result.success) {
                    throw new Error(result.message || 'Gagal memuat data.');
                }
                const schedules = result.data || [];
                updateStats(schedules);
                renderTodaySchedule(schedules);
                renderRecentActivities(schedules);
            })
            .catch(error => {
                console.error('Dashboard error:', error);
                document.getElementById('todayScheduleList').innerHTML = '<div class="schedule-item"><div class="schedule-details"><h4>Gagal memuat jadwal.</h4><p>Periksa koneksi atau login kembali.</p></div></div>';
                document.getElementById('recentActivitiesBody').innerHTML = '<tr><td colspan="5" style="text-align: center;">Terjadi kesalahan saat memuat aktivitas.</td></tr>';
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateDate();
        fetchDashboardData();
    });
</script>
@endpush
