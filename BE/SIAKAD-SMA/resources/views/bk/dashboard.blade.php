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
            <h3>125</h3>
            <p>Siswa Aktif</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #2196F3;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h3>8</h3>
            <p>Konseling Hari Ini</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #FF9800;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="stat-info">
            <h3>15</h3>
            <p>Perlu Validasi</p>
        </div>
    </div>

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
                <div class="schedule-list">
                    <div class="schedule-item">
                        <div class="schedule-time">
                            <span class="time">08:00 - 09:00</span>
                            <span class="status active">Sedang Berjalan</span>
                        </div>
                        <div class="schedule-details">
                            <h4>Andi Pratama</h4>
                            <p>Kelas XII IPA 1 - Masalah Belajar</p>
                            <span class="tag urgent">Urgent</span>
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
                    <button class="action-btn" onclick="location.href='surat-pemanggilan.html'">
                        <i class="fas fa-envelope"></i>
                        <span>Buat Surat Pemanggilan</span>
                    </button>
                    <button class="action-btn" onclick="location.href='validasi.html'">
                        <i class="fas fa-check-circle"></i>
                        <span>Validasi Siswa</span>
                    </button>
                    <button class="action-btn" onclick="location.href='feedback.html'">
                        <i class="fas fa-comment-medical"></i>
                        <span>Beri Feedback</span>
                    </button>
                    <button class="action-btn" onclick="location.href='laporan.html'">
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
            <tbody>
                <tr>
                    <td>15 Jan 2024, 08:30</td>
                    <td>Konseling Akademik</td>
                    <td>Andi Pratama (XII IPA 1)</td>
                    <td><span class="status-badge completed">Selesai</span></td>
                    <td>
                        <button class="btn-icon" title="Lihat Detail"><i class="fas fa-eye"></i></button>
                        <button class="btn-icon" title="Edit"><i class="fas fa-edit"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>14 Jan 2024, 14:15</td>
                    <td>Validasi Kehadiran</td>
                    <td>Siti Nurhaliza (XI IPS 2)</td>
                    <td><span class="status-badge pending">Pending</span></td>
                    <td>
                        <button class="btn-icon" title="Lihat Detail"><i class="fas fa-eye"></i></button>
                        <button class="btn-icon" title="Setujui"><i class="fas fa-check"></i></button>
                    </td>
                </tr>
                <tr>
                    <td>13 Jan 2024, 10:45</td>
                    <td>Surat Pemanggilan</td>
                    <td>Rizki Ramadhan (X MIPA)</td>
                    <td><span class="status-badge in-progress">Diproses</span></td>
                    <td>
                        <button class="btn-icon" title="Lihat Detail"><i class="fas fa-eye"></i></button>
                        <button class="btn-icon" title="Cetak"><i class="fas fa-print"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Update current date
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

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        updateDate();

        // Add event listeners to buttons
        document.querySelectorAll('.data-table .btn-icon').forEach(btn => {
            btn.addEventListener('click', function() {
                const activity = this.closest('tr').querySelector('td:nth-child(2)').textContent;
                const student = this.closest('tr').querySelector('td:nth-child(3)').textContent;
                alert(`Aksi untuk: ${activity}\nSiswa: ${student}`);
            });
        });
    });
</script>
@endpush
