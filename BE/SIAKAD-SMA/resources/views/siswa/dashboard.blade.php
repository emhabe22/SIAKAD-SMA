@extends('layouts.app')

@section('title', 'Dashboard Siswa - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Dashboard Siswa')
@section('breadcrumb', 'Home / Dashboard')

@php
    $role = 'siswa';
    $userName = 'Memuat...';
    $userRole = 'Memuat...';
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

        /* Konten Utama - sudah dihandle oleh layout */

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
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
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

        /* Responsif */
        @media (max-width: 1100px) {
            .stats-section {
                grid-template-columns: 1fr;
            }
            
            .schedule-summary {
                flex-direction: column;
                gap: 20px;
            }
        }

        @media (max-width: 768px) {
            .stats-section {
                grid-template-columns: 1fr;
            }
            
            .schedule-summary {
                flex-direction: column;
                gap: 20px;
            }
        }

        /* Responsif untuk modal logout */
        @media (max-width: 480px) {
            .stats-section {
                grid-template-columns: 1fr;
            }
        }
</style>
@endpush

@section('content')
            <div id="page-content">
                <!-- Dashboard Content (Default) -->
                <div id="dashboard-content" class="page-content active">
                    <!-- Pengingat Penting -->
                    <div class="reminder-card" id="reminderCard" style="display:none;">
                        <div class="reminder-content">
                            <h3>Pengingat Penting</h3>
                            <p id="reminderText">Anda memiliki notifikasi yang perlu ditinjau.</p>
                            <div class="reminder-buttons">
                                <button id="lihat-surat" onclick="location.href='/siswa/surat-pemanggilan'"><i class="fas fa-envelope-open-text"></i> Lihat Surat</button>
                                <button id="status-bk" onclick="location.href='/siswa/bk'"><i class="fas fa-tasks"></i> Status BK</button>
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
                            <h4>Kehadiran Bulan Ini</h4>
                            <div class="stat-value" id="stat-hadir">-</div>
                            <p><small>Total hari hadir</small></p>
                        </div>
                        <div class="stat-card" data-page="bk">
                            <h4>Jadwal Konseling</h4>
                            <div class="stat-value" id="stat-konseling">-</div>
                            <p><small>Jadwal aktif</small></p>
                        </div>
                    </div>

                    <!-- Menunggu Konfirmasi -->
                    <div class="confirmation-section">
                        <h3>Menunggu Konfirmasi</h3>
                        <div class="confirmation-grid">
                            <div class="confirmation-item" data-page="bk">
                                <h4>Jadwal Konseling</h4>
                                <div class="count" id="pending-konseling">-</div>
                                <p><small>Menunggu konfirmasi</small></p>
                            </div>
                            <div class="confirmation-item">
                                <h4>Surat Pemanggilan</h4>
                                <div class="count" id="pending-surat">-</div>
                                <p><small>Belum dibaca</small></p>
                            </div>
                        </div>
                    </div>

                    <!-- Jadwal Mata Pelajaran Hari Ini -->
                    <div class="schedule-card">
                        <h3>Mata Pelajaran Hari Ini</h3>
                        <div class="schedule-summary" id="jadwalSummary">
                            <div class="schedule-item">
                                <h4>Sudah Selesai</h4>
                                <div class="count completed" id="jadwal-selesai">-</div>
                                <p><small>Mapel telah diselesaikan</small></p>
                            </div>
                            <div class="schedule-item">
                                <h4>Berikutnya</h4>
                                <div class="count upcoming" id="jadwal-berikutnya">-</div>
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
                            <p>Total kehadiran bulan ini: <strong id="total-hadir">0</strong> hari</p>
                            <div class="reminder-buttons">
                                <button id="attendance-print"><i class="fas fa-print"></i> Cetak</button>
                                <button id="attendance-history"><i class="fas fa-history"></i> Riwayat</button>
                            </div>
                        </div>
                        <div class="reminder-icon">
                            <i class="fas fa-chart-line fa-3x"></i>
                        </div>
                    </div>

                    <div class="stats-section">
                        <div class="stat-card">
                            <h4>Hadir</h4>
                            <div class="stat-value" id="absen-hadir">0</div>
                            <p><small>Hari hadir bulan ini</small></p>
                        </div>
                        <div class="stat-card">
                            <h4>Izin</h4>
                            <div class="stat-value" id="absen-izin">0</div>
                            <p><small>Hari izin bulan ini</small></p>
                        </div>
                        <div class="stat-card">
                            <h4>Sakit</h4>
                            <div class="stat-value" id="absen-sakit">0</div>
                            <p><small>Hari sakit bulan ini</small></p>
                        </div>
                        <div class="stat-card">
                            <h4>Alpha</h4>
                            <div class="stat-value" id="absen-alpha">0</div>
                            <p><small>Hari alpha bulan ini</small></p>
                        </div>
                    </div>

                    <div class="confirmation-section">
                        <h3>Absensi Terbaru</h3>
                        <div id="attendance-list">
                            <p style="text-align: center; color: #666;">Memuat data absensi...</p>
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
@endsection

@push('scripts')
    <script>
        // Get token helper
        function getToken() {
            const token = localStorage.getItem('token');
            if (!token) {
                alert('Anda belum login. Silakan login terlebih dahulu.');
                window.location.href = '/login';
                return null;
            }
            return token;
        }

        // Get siswa ID
        async function getSiswaId() {
            const token = getToken();
            if (!token) return null;

            try {
                const response = await fetch('/api/me', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();
                
                if (result.success && result.data.profile) {
                    return result.data.profile.id;
                }
            } catch (error) {
                console.error('Error fetching user profile:', error);
            }
            
            return null;
        }

        // Inisialisasi
        document.addEventListener('DOMContentLoaded', async function() {
            await fetchDashboardData();
            setupEventListeners();
        });

        // Fetch dashboard data
        async function fetchDashboardData() {
            const token = getToken();
            if (!token) return;

            try {
                // ── 1. Ambil data profil user (siswa) ──
                const meRes = await fetch('/api/me', {
                    headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
                });
                const me = await meRes.json();
                const siswa = me.data?.profile;
                const siswaId = siswa?.id;
                const tingkat = siswa?.tingkat;

                if (!siswaId) return;

                // Update sidebar
                const sidebarName = document.getElementById('sidebarUserName');
                const sidebarRole = document.getElementById('sidebarUserRole');
                if (sidebarName && siswa) sidebarName.textContent = siswa.nama;
                if (sidebarRole && tingkat) sidebarRole.textContent = `Siswa Tingkat ${tingkat}`;

                // ── 2. Absensi saya ──
                const absenRes = await fetch(`/api/siswa/absensi-saya/${siswaId}`, {
                    headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
                });
                const absenResult = await absenRes.json();
                if (absenResult.success) {
                    const stats = absenResult.stats || {};
                    const bulanIni = stats.hadir || 0;
                    document.getElementById('stat-hadir').textContent = bulanIni;

                    // Show reminder jika ada alpa
                    const alpa = stats.alpa || 0;
                    if (alpa > 0) {
                        document.getElementById('reminderText').innerHTML =
                            `Anda memiliki <strong>${alpa} ketidakhadiran (Alpa)</strong> bulan ini. Harap segera konfirmasi ke wali kelas.`;
                        document.getElementById('reminderCard').style.display = 'flex';
                    }
                }

                // ── 3. Point pelanggaran ──
                try {
                    const pointRes = await fetch(`/api/siswa/pelanggaran-saya/${siswaId}`, {
                        headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
                    });
                    const pointResult = await pointRes.json();
                    if (pointResult.success) {
                        document.getElementById('stat-point').textContent = pointResult.data?.total_point ?? 0;
                    }
                } catch(e) { document.getElementById('stat-point').textContent = 0; }

                // ── 4. Jadwal konseling ──
                try {
                    const konselingRes = await fetch(`/api/siswa/penjadwalan-saya/${siswaId}`, {
                        headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
                    });
                    const konselingResult = await konselingRes.json();
                    if (konselingResult.success) {
                        const schedules = konselingResult.data || [];
                        const pending = schedules.filter(s => s.status == '0' || s.status === 'menunggu').length;
                        document.getElementById('stat-konseling').textContent = schedules.length;
                        document.getElementById('pending-konseling').textContent = pending;

                        if (pending > 0) {
                            const card = document.getElementById('reminderCard');
                            const txt = document.getElementById('reminderText');
                            if (card) card.style.display = 'flex';
                            if (txt) txt.innerHTML = `Anda memiliki <strong>${pending} jadwal konseling</strong> menunggu konfirmasi.`;
                        }
                    }
                } catch(e) {
                    document.getElementById('stat-konseling').textContent = 0;
                    document.getElementById('pending-konseling').textContent = 0;
                }

                // ── 5. Jadwal pelajaran hari ini ──
                if (tingkat) {
                    const HARI_ID_JS = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    const todayHari = HARI_ID_JS[new Date().getDay()];
                    const jadwalRes = await fetch(`/api/siswa/jadwal-tingkat/${tingkat}`, {
                        headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
                    });
                    const jadwalResult = await jadwalRes.json();
                    if (jadwalResult.success) {
                        const jadwalHariIni = (jadwalResult.data || []).filter(j => j.hari === todayHari && j.tipe === 'mapel');
                        const now = new Date();
                        const currentMin = now.getHours() * 60 + now.getMinutes();
                        let selesai = 0, berikutnya = 0;
                        jadwalHariIni.forEach(j => {
                            const [hS, mS] = (j.jam_selesai || '00:00').substring(0,5).split(':').map(Number);
                            if ((hS * 60 + mS) < currentMin) selesai++;
                            else berikutnya++;
                        });
                        document.getElementById('jadwal-selesai').textContent = selesai;
                        document.getElementById('jadwal-berikutnya').textContent = berikutnya;
                    }
                }

                // Surat pemanggilan (BK belum terkoneksi - set 0)
                document.getElementById('pending-surat').textContent = 0;

            } catch (error) {
                console.error('Error fetching dashboard data:', error);
            }
        }

        // ========== FUNGSI UTAMA ==========

        // Setup semua event listeners
        function setupEventListeners() {
            // Action cards navigation
            document.querySelectorAll('.action-card[data-page]').forEach(card => {
                card.addEventListener('click', function() {
                    const page = this.dataset.page;
                    navigateToPage(page);
                });
            });

            // Stat cards navigation
            document.querySelectorAll('.stat-card[data-page]').forEach(card => {
                card.addEventListener('click', function() {
                    const page = this.dataset.page;
                    navigateToPage(page);
                });
            });

            // Confirmation items navigation
            document.querySelectorAll('.confirmation-item[data-page]').forEach(item => {
                item.addEventListener('click', function() {
                    const page = this.dataset.page;
                    navigateToPage(page);
                });
            });

            // Dashboard buttons
            const lihatSuratBtn = document.getElementById('lihat-surat');
            if (lihatSuratBtn) {
                lihatSuratBtn.addEventListener('click', function() {
                    alert('Membuka halaman surat pemanggilan BK');
                });
            }
            
            const statusBkBtn = document.getElementById('status-bk');
            if (statusBkBtn) {
                statusBkBtn.addEventListener('click', function() {
                    navigateToPage('bk');
                });
            }

            // Attendance buttons
            const printBtn = document.getElementById('attendance-print');
            if (printBtn) {
                printBtn.addEventListener('click', function() {
                    alert('Mencetak rekap kehadiran...');
                });
            }

            // BK buttons
            const bkRequestBtn = document.getElementById('bk-request');
            if (bkRequestBtn) {
                bkRequestBtn.addEventListener('click', function() {
                    window.location.href = '/siswa/bk';
                });
            }
        }

        // Navigasi antar halaman
        function navigateToPage(page) {
            // Redirect to actual pages
            const pageUrls = {
                'attendance': '/siswa/absensi',
                'bk': '/siswa/bk',
                'schedule': '/siswa/jadwal'
            };
            
            if (pageUrls[page]) {
                window.location.href = pageUrls[page];
            }
        }

        // Fungsi untuk halaman absensi
        function showAttendanceMonth(month) {
            alert(`Menampilkan kehadiran bulan ${month}`);
        }

        // Fungsi untuk halaman BK
        function openBKRequest() {
            window.location.href = '/siswa/bk';
        }

        function openBKSchedule() {
            window.location.href = '/siswa/bk';
        }

        function openBKHistory() {
            window.location.href = '/siswa/bk';
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
    </script>
@endpush