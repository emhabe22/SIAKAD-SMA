@extends('layouts.app')

@section('title', 'Dashboard Siswa - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Dashboard Siswa')
@section('breadcrumb', 'Home / Dashboard')

@php
    $role = 'siswa';
    $userName = 'Ahmad Fauzi';
    $userRole = 'Siswa X MIPA 1';
@endphp

@push('styles')
<style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Navigasi */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #1a3a8f 0%, #2d5bd6 100%);
            color: white;
            padding: 25px 20px;
            box-shadow: 3px 0 15px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .logo-area {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo {
            width: 50px;
            height: 50px;
            background-color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .logo i {
            font-size: 24px;
            color: #2d5bd6;
        }

        .logo-text h1 {
            font-size: 20px;
            font-weight: 700;
        }

        .logo-text p {
            font-size: 12px;
            opacity: 0.8;
            margin-top: 3px;
        }

        .user-info {
            display: flex;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }

        .user-avatar i {
            font-size: 20px;
            color: #2d5bd6;
        }

        .user-details h3 {
            font-size: 16px;
            margin-bottom: 3px;
        }

        .user-details span {
            font-size: 12px;
            background-color: #4caf50;
            padding: 2px 8px;
            border-radius: 10px;
            display: inline-block;
        }

        .nav-section {
            margin-bottom: 25px;
        }

        .nav-section h3 {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            opacity: 0.7;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-menu li {
            margin-bottom: 8px;
        }

        .nav-menu li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .nav-menu li a:hover, .nav-menu li.active a {
            background-color: rgba(255, 255, 255, 0.15);
        }

        .nav-menu li a i {
            margin-right: 12px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .status-indicator {
            display: flex;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 12px;
            border-radius: 10px;
            margin-top: 30px;
            font-size: 14px;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            background-color: #4caf50;
            border-radius: 50%;
            margin-right: 10px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        /* Konten Utama */
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h2 {
            font-size: 28px;
            color: #1a3a8f;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .date-time {
            font-size: 14px;
            color: #666;
            background-color: white;
            padding: 10px 20px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: #1a3a8f;
            cursor: pointer;
            padding: 10px;
        }

        /* Pengingat Penting */
        .reminder-card {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8e53 100%);
            color: white;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 20px rgba(255, 107, 107, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .reminder-content h3 {
            font-size: 22px;
            margin-bottom: 10px;
        }

        .reminder-content p {
            opacity: 0.9;
            margin-bottom: 15px;
        }

        .reminder-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .reminder-buttons button {
            background-color: white;
            color: #ff6b6b;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .reminder-buttons button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Statistik Dashboard */
        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h4 {
            font-size: 16px;
            color: #666;
            margin-bottom: 15px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .progress-bar {
            height: 10px;
            background-color: #eee;
            border-radius: 5px;
            margin-top: 15px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            border-radius: 5px;
        }

        /* Kartu Menunggu Konfirmasi */
        .confirmation-section {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
        }

        .confirmation-section h3 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #1a3a8f;
        }

        .confirmation-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
        }

        .confirmation-item {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .confirmation-item:hover {
            transform: translateY(-3px);
            background-color: #e9ecef;
        }

        .confirmation-item h4 {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .confirmation-item .count {
            font-size: 36px;
            font-weight: 700;
            color: #1a3a8f;
        }

        /* Jadwal Mapel Hari Ini */
        .schedule-card {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .schedule-card h3 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #1a3a8f;
        }

        .schedule-summary {
            display: flex;
            justify-content: space-between;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }

        .schedule-item {
            text-align: center;
            flex: 1;
            padding: 10px;
        }

        .schedule-item h4 {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .schedule-item .count {
            font-size: 36px;
            font-weight: 700;
        }

        .completed {
            color: #4caf50;
        }

        .upcoming {
            color: #2196f3;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .action-card {
            background-color: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .action-card i {
            font-size: 40px;
            margin-bottom: 15px;
            color: #2d5bd6;
        }

        .action-card h4 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
        }

        .action-card p {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }

        .action-btn {
            background-color: #2d5bd6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .action-btn:hover {
            background-color: #1a3a8f;
        }

        /* ========== STYLE LOGOUT ========== */

        /* Style untuk tombol logout di sidebar */
        #logout-menu a {
            color: #ff6b6b;
            background-color: rgba(255, 107, 107, 0.1);
        }

        #logout-menu a:hover {
            background-color: rgba(255, 107, 107, 0.2);
        }

        #logout-menu a i {
            color: #ff6b6b;
        }

        /* Modal konfirmasi logout */
        .logout-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .logout-modal.active {
            display: flex;
        }

        .logout-modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logout-modal-icon {
            font-size: 60px;
            color: #ff6b6b;
            margin-bottom: 20px;
        }

        .logout-modal-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .logout-modal-message {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .logout-modal-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .logout-btn-confirm, .logout-btn-cancel {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 120px;
        }

        .logout-btn-confirm {
            background-color: #ff6b6b;
            color: white;
        }

        .logout-btn-confirm:hover {
            background-color: #ff5252;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 82, 82, 0.3);
        }

        .logout-btn-cancel {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #ddd;
        }

        .logout-btn-cancel:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Responsif */
        @media (max-width: 1100px) {
            .container {
                flex-direction: column;
            }
            
            .sidebar {
                width: 100%;
                height: auto;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1000;
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .menu-toggle {
                display: block;
            }
            
            .nav-menu {
                display: flex;
                flex-wrap: wrap;
            }
            
            .nav-menu li {
                flex: 1;
                min-width: 120px;
            }
        }

        @media (max-width: 768px) {
            .reminder-card {
                flex-direction: column;
                text-align: center;
            }
            
            .reminder-buttons {
                justify-content: center;
                margin-top: 15px;
            }
            
            .stats-section {
                grid-template-columns: 1fr;
            }
            
            .schedule-summary {
                flex-direction: column;
                gap: 20px;
            }
            
            .main-content {
                padding: 20px;
            }
            
            .header {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }
            
            .header-right {
                width: 100%;
                justify-content: space-between;
            }
        }

        /* Responsif untuk modal logout */
        @media (max-width: 480px) {
            .logout-modal-buttons {
                flex-direction: column;
            }
            
            .logout-btn-confirm, .logout-btn-cancel {
                width: 100%;
            }
        }
</style>
@endpush

@section('content')
            <div id="page-content">
                <!-- Dashboard Content (Default) -->
                <div id="dashboard-content" class="page-content active">
                    <!-- Pengingat Penting -->
                    <div class="reminder-card">
                        <div class="reminder-content">
                            <h3>Pengingat Penting</h3>
                            <p>Anda memiliki <strong>1 surat pemanggilan BK</strong> yang belum dibaca dan <strong>2 pengajuan BK</strong> menunggu konfirmasi. Harap segera tinjau untuk informasi lebih lanjut.</p>
                            <div class="reminder-buttons">
                                <button id="lihat-surat"><i class="fas fa-envelope-open-text"></i> Lihat Surat</button>
                                <button id="status-bk"><i class="fas fa-tasks"></i> Status BK</button>
                            </div>
                        </div>
                        <div class="reminder-icon">
                            <i class="fas fa-bell fa-3x"></i>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="quick-actions">
                        <div class="action-card" data-page="attendance">
                            <i class="fas fa-calendar-check"></i>
                            <h4>Kehadiran</h4>
                            <p>Cek dan kelola kehadiran Anda</p>
                            <button class="action-btn">Buka Kehadiran</button>
                        </div>
                        <div class="action-card" data-page="bk">
                            <i class="fas fa-comments"></i>
                            <h4>Bimbingan Konseling</h4>
                            <p>Ajukan sesi BK dan lihat jadwal</p>
                            <button class="action-btn">Buka BK</button>
                        </div>
                        <div class="action-card" data-page="schedule">
                            <i class="fas fa-calendar-alt"></i>
                            <h4>Jadwal Pelajaran</h4>
                            <p>Lihat jadwal pelajaran harian</p>
                            <button class="action-btn">Buka Jadwal</button>
                        </div>
                    </div>

                    <!-- Statistik -->
                    <div class="stats-section">
                        <div class="stat-card" data-page="attendance">
                            <h4>Kehadiran</h4>
                            <div class="stat-value">92%</div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 92%; background-color: #4caf50;"></div>
                            </div>
                            <p><small>Rate kehadiran bulan ini</small></p>
                        </div>
                        <div class="stat-card" data-page="bk">
                            <h4>Bimbingan Konseling</h4>
                            <div class="stat-value">3</div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 60%; background-color: #2196f3;"></div>
                            </div>
                            <p><small>Sesi aktif bulan ini</small></p>
                        </div>
                        <div class="stat-card">
                            <h4>Progress Akademik</h4>
                            <div class="stat-value">78%</div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 78%; background-color: #ff9800;"></div>
                            </div>
                            <p><small>Progress semester ini</small></p>
                        </div>
                    </div>

                    <!-- Menunggu Konfirmasi -->
                    <div class="confirmation-section">
                        <h3>Menunggu Konfirmasi</h3>
                        <div class="confirmation-grid">
                            <div class="confirmation-item" data-page="bk">
                                <h4>Sesi Konseling</h4>
                                <div class="count">1</div>
                                <p><small>Menunggu jadwal</small></p>
                            </div>
                            <div class="confirmation-item" data-page="bk">
                                <h4>Pengajuan BK</h4>
                                <div class="count">2</div>
                                <p><small>Perlu ditinjau</small></p>
                            </div>
                            <div class="confirmation-item" data-page="attendance">
                                <h4>Absensi Izin</h4>
                                <div class="count">3</div>
                                <p><small>Perlu konfirmasi</small></p>
                            </div>
                        </div>
                    </div>

                    <!-- Jadwal Mata Pelajaran Hari Ini -->
                    <div class="schedule-card">
                        <h3>Mata Pelajaran Hari Ini</h3>
                        <div class="schedule-summary">
                            <div class="schedule-item">
                                <h4>Sudah Selesai</h4>
                                <div class="count completed">3</div>
                                <p><small>Mapel telah diselesaikan</small></p>
                            </div>
                            <div class="schedule-item">
                                <h4>Berikutnya</h4>
                                <div class="count upcoming">2</div>
                                <p><small>Mapel akan datang</small></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attendance Content -->
                <div id="attendance-content" class="page-content" style="display: none;">
                    <div class="reminder-card" style="background: linear-gradient(135deg, #009B48 0%, #00C853 100%);">
                        <div class="reminder-content">
                            <h3>Rekap Kehadiran</h3>
                            <p>Kehadiran bulan ini: <strong>92%</strong> | Total hadir: <strong>22/24</strong> hari</p>
                            <div class="reminder-buttons">
                                <button id="attendance-print"><i class="fas fa-print"></i> Cetak</button>
                                <button id="attendance-history"><i class="fas fa-history"></i> Riwayat</button>
                            </div>
                        </div>
                        <div class="reminder-icon">
                            <i class="fas fa-chart-line fa-3x"></i>
                        </div>
                    </div>

                    <div class="quick-actions">
                        <div class="action-card" onclick="showAttendanceMonth('maret')">
                            <i class="fas fa-calendar"></i>
                            <h4>Maret 2024</h4>
                            <p>Kehadiran: 92%</p>
                            <button class="action-btn">Lihat Detail</button>
                        </div>
                        <div class="action-card" onclick="showAttendanceMonth('februari')">
                            <i class="fas fa-calendar"></i>
                            <h4>Februari 2024</h4>
                            <p>Kehadiran: 88%</p>
                            <button class="action-btn">Lihat Detail</button>
                        </div>
                        <div class="action-card" onclick="showAttendanceMonth('januari')">
                            <i class="fas fa-calendar"></i>
                            <h4>Januari 2024</h4>
                            <p>Kehadiran: 95%</p>
                            <button class="action-btn">Lihat Detail</button>
                        </div>
                    </div>

                    <div class="stats-section">
                        <div class="stat-card">
                            <h4>Hadir</h4>
                            <div class="stat-value">22</div>
                            <p><small>Hari hadir bulan ini</small></p>
                        </div>
                        <div class="stat-card">
                            <h4>Izin</h4>
                            <div class="stat-value">2</div>
                            <p><small>Hari izin bulan ini</small></p>
                        </div>
                        <div class="stat-card">
                            <h4>Sakit</h4>
                            <div class="stat-value">1</div>
                            <p><small>Hari sakit bulan ini</small></p>
                        </div>
                    </div>

                    <div class="confirmation-section">
                        <h3>Absensi Terbaru</h3>
                        <div id="attendance-list">
                            <div class="attendance-item">
                                <div class="attendance-date">Senin, 25 Maret</div>
                                <div class="attendance-status status-present">Hadir</div>
                                <div class="attendance-subject">Matematika, Fisika, Kimia</div>
                            </div>
                            <div class="attendance-item">
                                <div class="attendance-date">Jumat, 22 Maret</div>
                                <div class="attendance-status status-sick">Sakit</div>
                                <div class="attendance-subject">Semua Pelajaran</div>
                            </div>
                            <div class="attendance-item">
                                <div class="attendance-date">Kamis, 21 Maret</div>
                                <div class="attendance-status status-permit">Izin</div>
                                <div class="attendance-subject">Bahasa Indonesia</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BK Content -->
                <div id="bk-content" class="page-content" style="display: none;">
                    <div class="reminder-card" style="background: linear-gradient(135deg, #9C27B0 0%, #673AB7 100%);">
                        <div class="reminder-content">
                            <h3>Bimbingan Konseling</h3>
                            <p>Anda memiliki <strong>2 sesi aktif</strong> dan <strong>1 surat pemanggilan</strong> yang belum dibaca</p>
                            <div class="reminder-buttons">
                                <button id="bk-request"><i class="fas fa-plus"></i> Ajukan BK</button>
                                <button id="bk-schedule"><i class="fas fa-calendar-alt"></i> Jadwal</button>
                            </div>
                        </div>
                        <div class="reminder-icon">
                            <i class="fas fa-hands-helping fa-3x"></i>
                        </div>
                    </div>

                    <div class="quick-actions">
                        <div class="action-card" onclick="openBKRequest()">
                            <i class="fas fa-plus-circle"></i>
                            <h4>Ajukan BK</h4>
                            <p>Ajukan sesi bimbingan konseling baru</p>
                            <button class="action-btn">Ajukan Sekarang</button>
                        </div>
                        <div class="action-card" onclick="openBKSchedule()">
                            <i class="fas fa-calendar-check"></i>
                            <h4>Jadwal BK</h4>
                            <p>Lihat jadwal BK yang sudah direncanakan</p>
                            <button class="action-btn">Lihat Jadwal</button>
                        </div>
                        <div class="action-card" onclick="openBKHistory()">
                            <i class="fas fa-history"></i>
                            <h4>Riwayat BK</h4>
                            <p>Lihat riwayat sesi BK sebelumnya</p>
                            <button class="action-btn">Lihat Riwayat</button>
                        </div>
                    </div>

                    <div class="confirmation-section">
                        <h3>Sesi BK Aktif</h3>
                        <div id="bk-session-list">
                            <div class="bk-session-item">
                                <div class="bk-session-header">
                                    <h4>Konseling Akademik</h4>
                                    <span class="bk-status status-waiting">Menunggu</span>
                                </div>
                                <div class="bk-session-details">
                                    <p><i class="fas fa-calendar"></i> 28 Maret 2024 | 10:00-11:00</p>
                                    <p><i class="fas fa-user"></i> Bu Ani, S.Pd</p>
                                    <p><i class="fas fa-sticky-note"></i> Membahas nilai matematika</p>
                                </div>
                            </div>
                            <div class="bk-session-item">
                                <div class="bk-session-header">
                                    <h4>Konseling Pribadi</h4>
                                    <span class="bk-status status-approved">Disetujui</span>
                                </div>
                                <div class="bk-session-details">
                                    <p><i class="fas fa-calendar"></i> 25 Maret 2024 | 13:00-14:00</p>
                                    <p><i class="fas fa-user"></i> Pak Budi, M.Pd</p>
                                    <p><i class="fas fa-sticky-note"></i> Konsultasi karier</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Schedule Content -->
                <div id="schedule-content" class="page-content" style="display: none;">
                    <div class="reminder-card" style="background: linear-gradient(135deg, #FF9800 0%, #FF5722 100%);">
                        <div class="reminder-content">
                            <h3>Jadwal Pelajaran</h3>
                            <p>Hari ini: <strong>3 pelajaran selesai</strong>, <strong>2 pelajaran berikutnya</strong></p>
                            <div class="reminder-buttons">
                                <button id="schedule-today"><i class="fas fa-calendar-day"></i> Hari Ini</button>
                                <button id="schedule-week"><i class="fas fa-calendar-week"></i> Minggu Ini</button>
                                <button id="schedule-print"><i class="fas fa-print"></i> Cetak</button>
                            </div>
                        </div>
                        <div class="reminder-icon">
                            <i class="fas fa-calendar-alt fa-3x"></i>
                        </div>
                    </div>

                    <div class="quick-actions">
                        <div class="action-card" onclick="showScheduleDay('senin')">
                            <i class="fas fa-calendar-day"></i>
                            <h4>Senin</h4>
                            <p>Matematika, Fisika, Kimia, Biologi</p>
                            <button class="action-btn">Lihat Jadwal</button>
                        </div>
                        <div class="action-card" onclick="showScheduleDay('selasa')">
                            <i class="fas fa-calendar-day"></i>
                            <h4>Selasa</h4>
                            <p>Bahasa Indonesia, Inggris, IPS, PKN</p>
                            <button class="action-btn">Lihat Jadwal</button>
                        </div>
                        <div class="action-card" onclick="showScheduleDay('rabu')">
                            <i class="fas fa-calendar-day"></i>
                            <h4>Rabu</h4>
                            <p>Matematika, Fisika, Olahraga, Seni</p>
                            <button class="action-btn">Lihat Jadwal</button>
                        </div>
                    </div>

                    <div class="confirmation-section">
                        <h3>Jadwal Hari Ini</h3>
                        <div id="today-schedule">
                            <div class="schedule-item-today">
                                <div class="schedule-time">07:30 - 09:00</div>
                                <div class="schedule-subject">Matematika</div>
                                <div class="schedule-status status-completed">Selesai</div>
                            </div>
                            <div class="schedule-item-today">
                                <div class="schedule-time">09:00 - 10:30</div>
                                <div class="schedule-subject">Fisika</div>
                                <div class="schedule-status status-completed">Selesai</div>
                            </div>
                            <div class="schedule-item-today">
                                <div class="schedule-time">10:30 - 12:00</div>
                                <div class="schedule-subject">Kimia</div>
                                <div class="schedule-status status-completed">Selesai</div>
                            </div>
                            <div class="schedule-item-today">
                                <div class="schedule-time">13:00 - 14:30</div>
                                <div class="schedule-subject">Biologi</div>
                                <div class="schedule-status status-upcoming">Akan Datang</div>
                            </div>
                            <div class="schedule-item-today">
                                <div class="schedule-time">14:30 - 16:00</div>
                                <div class="schedule-subject">Bahasa Inggris</div>
                                <div class="schedule-status status-upcoming">Akan Datang</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Konfirmasi Logout -->
    <div id="logoutModal" class="logout-modal">
        <div class="logout-modal-content">
            <div class="logout-modal-icon">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <h3 class="logout-modal-title">Konfirmasi Logout</h3>
            <p class="logout-modal-message">
                Apakah Anda yakin ingin keluar dari sistem?<br>
                Semua data yang belum tersimpan akan hilang.
            </p>
            <div class="logout-modal-buttons">
                <button id="logoutConfirm" class="logout-btn-confirm">Ya, Logout</button>
                <button id="logoutCancel" class="logout-btn-cancel">Batal</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Data siswa
        const studentData = {
            name: "Ahmad Fauzi",
            class: "XII IPA 1",
            nis: "2024001",
            attendance: 92,
            bkSessions: 3,
            academicProgress: 78
        };

        // Inisialisasi
        document.addEventListener('DOMContentLoaded', function() {
            initializeDashboard();
            updateDateTime();
            setInterval(updateDateTime, 1000);
            setupEventListeners();
            updateLastSync();
        });

        // ========== FUNGSI LOGOUT ==========

        // Fungsi untuk setup logout
        function setupLogout() {
            // Event listener untuk tombol logout di menu
            document.getElementById('logout-menu').addEventListener('click', function(e) {
                e.preventDefault();
                showLogoutModal();
            });

            // Event listener untuk tombol logout di modal
            document.getElementById('logoutConfirm').addEventListener('click', function() {
                performLogout();
            });

            // Event listener untuk tombol cancel di modal
            document.getElementById('logoutCancel').addEventListener('click', function() {
                hideLogoutModal();
            });

            // Tutup modal saat klik di luar
            document.getElementById('logoutModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    hideLogoutModal();
                }
            });
        }

        // Tampilkan modal konfirmasi logout
        function showLogoutModal() {
            document.getElementById('logoutModal').classList.add('active');
            // Close sidebar jika di mobile
            if (window.innerWidth <= 1100) {
                document.querySelector('.sidebar').classList.remove('active');
            }
        }

        // Sembunyikan modal konfirmasi logout
        function hideLogoutModal() {
            document.getElementById('logoutModal').classList.remove('active');
        }

        // Proses logout
        // Proses logout
function performLogout() {
    // Tampilkan loading
    const modalContent = document.querySelector('.logout-modal-content');
    modalContent.innerHTML = `
        <div class="logout-modal-icon">
            <i class="fas fa-spinner fa-spin"></i>
        </div>
        <h3 class="logout-modal-title">Sedang logout...</h3>
        <p class="logout-modal-message">Menyimpan data dan mengakhiri sesi...</p>
    `;

    // Simulasi proses logout
    setTimeout(() => {
        // Clear data sesi
        clearSessionData();
        
        // Redirect ke halaman login umum
        window.location.href = '../login.html'; // atau 'index.html' tergantung struktur
    }, 1500);
}

        // Fungsi untuk clear session data
        function clearSessionData() {
            // Hapus data dari localStorage/sessionStorage
            localStorage.removeItem('student_token');
            localStorage.removeItem('student_data');
            sessionStorage.clear();
            
            // Log aktivitas logout
            console.log('Siswa berhasil logout');
        }

        // ========== FUNGSI UTAMA ==========

        // Fungsi untuk update waktu dan tanggal real-time
        function updateDateTime() {
            const now = new Date();
            
            // Format tanggal
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const formattedDate = now.toLocaleDateString('id-ID', options);
            
            // Format waktu
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const formattedTime = `${hours}:${minutes}:${seconds}`;
            
            // Update elemen
            document.getElementById('current-date').textContent = formattedDate;
            document.getElementById('current-time').textContent = formattedTime;
        }

        // Update waktu sinkronisasi
        function updateLastSync() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('last-sync').textContent = `Terakhir sinkron: ${hours}.${minutes}.${seconds}`;
        }

        // Setup semua event listeners
        function setupEventListeners() {
            // Menu toggle untuk mobile
            document.querySelector('.menu-toggle').addEventListener('click', function() {
                document.querySelector('.sidebar').classList.toggle('active');
            });

            // Setup logout functionality
            setupLogout();

            // Navigasi sidebar
            document.querySelectorAll('.nav-menu li:not(#logout-menu)').forEach(item => {
                item.addEventListener('click', function() {
                    const page = this.dataset.page;
                    navigateToPage(page);
                    
                    // Update active menu
                    document.querySelectorAll('.nav-menu li:not(#logout-menu)').forEach(li => {
                        li.classList.remove('active');
                    });
                    this.classList.add('active');
                    
                    // Close sidebar on mobile
                    if (window.innerWidth <= 1100) {
                        document.querySelector('.sidebar').classList.remove('active');
                    }
                });
            });

            // Action cards navigation
            document.querySelectorAll('.action-card[data-page]').forEach(card => {
                card.addEventListener('click', function() {
                    const page = this.dataset.page;
                    navigateToPage(page);
                    
                    // Update active menu
                    document.querySelectorAll('.nav-menu li:not(#logout-menu)').forEach(li => {
                        li.classList.remove('active');
                        if (li.dataset.page === page) {
                            li.classList.add('active');
                        }
                    });
                });
            });

            // Stat cards navigation
            document.querySelectorAll('.stat-card[data-page]').forEach(card => {
                card.addEventListener('click', function() {
                    const page = this.dataset.page;
                    navigateToPage(page);
                    
                    // Update active menu
                    document.querySelectorAll('.nav-menu li:not(#logout-menu)').forEach(li => {
                        li.classList.remove('active');
                        if (li.dataset.page === page) {
                            li.classList.add('active');
                        }
                    });
                });
            });

            // Confirmation items navigation
            document.querySelectorAll('.confirmation-item[data-page]').forEach(item => {
                item.addEventListener('click', function() {
                    const page = this.dataset.page;
                    navigateToPage(page);
                    
                    // Update active menu
                    document.querySelectorAll('.nav-menu li:not(#logout-menu)').forEach(li => {
                        li.classList.remove('active');
                        if (li.dataset.page === page) {
                            li.classList.add('active');
                        }
                    });
                });
            });

            // Dashboard buttons
            document.getElementById('lihat-surat').addEventListener('click', function() {
                alert('Membuka halaman surat pemanggilan BK');
            });
            
            document.getElementById('status-bk').addEventListener('click', function() {
                navigateToPage('bk');
            });

            // Attendance buttons
            document.getElementById('attendance-print').addEventListener('click', function() {
                alert('Mencetak rekap kehadiran...');
            });

            // BK buttons
            document.getElementById('bk-request').addEventListener('click', function() {
                alert('Membuka form pengajuan BK');
            });
        }

        // Navigasi antar halaman
        function navigateToPage(page) {
            // Hide all pages
            document.querySelectorAll('.page-content').forEach(content => {
                content.style.display = 'none';
            });
            
            // Show selected page
            document.getElementById(`${page}-content`).style.display = 'block';
            
            // Update page title
            const titles = {
                'dashboard': 'Dashboard Siswa',
                'attendance': 'Kehadiran',
                'bk': 'Bimbingan Konseling',
                'schedule': 'Jadwal Pelajaran'
            };
            document.getElementById('page-title').textContent = titles[page] || 'Dashboard Siswa';
        }

        // Initialize dashboard
        function initializeDashboard() {
            // Set student name
            document.getElementById('student-name').textContent = studentData.name;
            
            // Update stats with real data
            document.querySelectorAll('.stat-card:nth-child(1) .stat-value').forEach(el => {
                el.textContent = `${studentData.attendance}%`;
            });
            document.querySelectorAll('.stat-card:nth-child(2) .stat-value').forEach(el => {
                el.textContent = studentData.bkSessions;
            });
            document.querySelectorAll('.stat-card:nth-child(3) .stat-value').forEach(el => {
                el.textContent = `${studentData.academicProgress}%`;
            });
        }

        // Fungsi untuk halaman absensi
        function showAttendanceMonth(month) {
            alert(`Menampilkan kehadiran bulan ${month}`);
            // Di sini bisa diisi dengan logika untuk menampilkan data kehadiran bulan tertentu
        }

        // Fungsi untuk halaman BK
        function openBKRequest() {
            alert('Membuka form pengajuan BK');
        }

        function openBKSchedule() {
            alert('Membuka jadwal BK');
        }

        function openBKHistory() {
            alert('Membuka riwayat BK');
        }

        // Fungsi untuk halaman jadwal
        function showScheduleDay(day) {
            alert(`Menampilkan jadwal hari ${day}`);
        }

        // Efek hover untuk kartu statistik
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.1)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.05)';
            });
        });

        // Auto sync every 5 minutes
        setInterval(updateLastSync, 300000);
    </script>
@endpush