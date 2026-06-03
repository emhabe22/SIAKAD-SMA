@extends('layouts.app')

@section('title', 'Dashboard Guru - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Dashboard Guru')
@section('breadcrumb', 'Home / Dashboard')

@php
    $role = 'guru';
    $userName = 'Memuat...';
    $userRole = 'Memuat...';
@endphp

@section('content')

        <!-- Welcome Message -->
        <div class="welcome-card">
            <div class="welcome-content">
                <h2>Selamat <span id="greetingTime">Pagi</span>, <span id="greetingHonorific">Bapak/Ibu</span> <span id="greetingName">Guru</span>!</h2>
                <p id="greetingDate" style="font-size:14px; color:#888;"></p>
            </div>
            <div class="welcome-actions">
                <button class="btn btn-primary" onclick="location.href='/guru/jadwal-mengajar'">
                    <i class="fas fa-calendar"></i> Lihat Jadwal
                </button>
                <button class="btn btn-success" onclick="location.href='/guru/absensi'">
                    <i class="fas fa-clipboard-check"></i> Input Absen
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: #4CAF50;">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-info">
                    <h3 id="statJamMengajar">-</h3>
                    <p>Jam Mengajar/Minggu</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #2196F3;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3 id="statTotalSiswa">-</h3>
                    <p>Siswa Diajar</p>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="content-grid">
            <!-- Left Column -->
            <div class="left-column">
                <!-- Jadwal Hari Ini -->
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-calendar-day"></i> Jadwal Mengajar Hari Ini</h3>
                        <a href="/guru/jadwal-mengajar" class="btn-link">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        <div class="today-schedule" id="todayScheduleList">
                            <div class="empty-state" style="text-align:center; padding:24px; color:#aaa;">
                                <i class="fas fa-spinner fa-spin"></i> Memuat jadwal...
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-bolt"></i> Tindakan Cepat</h3>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions-grid">
                            <button class="quick-action-btn" onclick="location.href='/guru/absensi'">
                                <div class="action-icon">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <span>Input Absensi</span>
                            </button>
                            <button class="quick-action-btn" onclick="location.href='/guru/logbook'">
                                <div class="action-icon">
                                    <i class="fas fa-book"></i>
                                </div>
                                <span>Isi Logbook</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection

@push('scripts')
<script>
    const HARI_ID = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const BULAN_ID = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    document.addEventListener('DOMContentLoaded', () => {
        setGreeting();
        initDashboard();
    });

    function setGreeting() {
        const now = new Date();
        const hour = now.getHours();
        let time = 'Pagi';
        if (hour >= 11 && hour < 15) time = 'Siang';
        else if (hour >= 15 && hour < 19) time = 'Sore';
        else if (hour >= 19) time = 'Malam';
        document.getElementById('greetingTime').textContent = time;

        const hari = HARI_ID[now.getDay()];
        const tgl = now.getDate();
        const bln = BULAN_ID[now.getMonth()];
        const thn = now.getFullYear();
        document.getElementById('greetingDate').textContent = `${hari}, ${tgl} ${bln} ${thn}`;
    }

    function getToken() {
        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/login';
            return null;
        }
        return token;
    }

    async function initDashboard() {
        const token = getToken();
        if (!token) return;

        try {
            // Load guru info & mapel
            const meRes = await fetch('/api/me', { headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' } });
            const me = await meRes.json();
            const guru = me.data?.profile;
            if (guru) {
                const honorific = guru.jenis_kelamin === 'Perempuan' ? 'Ibu' : 'Bapak';
                document.getElementById('greetingHonorific').textContent = honorific;
                document.getElementById('greetingName').textContent = guru.nama;
            }

            // Update sidebar name
            const sidebarName = document.getElementById('sidebarUserName');
            const sidebarRole = document.getElementById('sidebarUserRole');
            if (sidebarName && guru) sidebarName.textContent = guru.nama;
            if (sidebarRole && guru) {
                const mapelName = (guru.mapels && guru.mapels.length > 0) ? guru.mapels[0].nama_mapel : '';
                sidebarRole.textContent = mapelName ? `Guru ${mapelName}` : 'Guru';
            }

            // Load jadwal today
            const today = HARI_ID[new Date().getDay()];
            const jadwalRes = await fetch(`/api/guru/jadwal-pelajaran?hari=${today}`, {
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
            });
            const jadwalResult = await jadwalRes.json();
            const allJadwal = jadwalResult.success ? (jadwalResult.data || []) : [];

            // Filter by guru_id
            const guruId = guru?.id;
            const jadwalGuru = guruId ? allJadwal.filter(j => j.guru_id == guruId && j.tipe === 'mapel') : [];

            renderTodaySchedule(jadwalGuru);

            // Load stats
            const statsRes = await fetch('/api/guru/jadwal-pelajaran', {
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
            });
            const statsResult = await statsRes.json();
            const allWeekJadwal = statsResult.success ? (statsResult.data || []) : [];
            const myWeekJadwal = guruId ? allWeekJadwal.filter(j => j.guru_id == guruId && j.tipe === 'mapel') : [];
            document.getElementById('statJamMengajar').textContent = myWeekJadwal.length;

            // Count unique students (based on tingkat)
            const tingkats = [...new Set(myWeekJadwal.map(j => j.tingkat))];
            let totalSiswa = 0;
            for (const t of tingkats) {
                const sRes = await fetch(`/api/guru/siswa-tingkat/${t}`, {
                    headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
                });
                const sResult = await sRes.json();
                if (sResult.success) totalSiswa += (sResult.data || []).length;
            }
            document.getElementById('statTotalSiswa').textContent = totalSiswa;

        } catch (err) {
            console.error(err);
        }
    }

    function renderTodaySchedule(jadwalList) {
        const container = document.getElementById('todayScheduleList');
        if (!jadwalList.length) {
            container.innerHTML = `<div style="text-align:center; padding:24px; color:#aaa;"><i class="fas fa-calendar-times" style="font-size:32px; margin-bottom:8px; display:block;"></i>Tidak ada jadwal mengajar hari ini.</div>`;
            return;
        }

        const now = new Date();
        const currentTime = now.getHours() * 60 + now.getMinutes();

        const html = jadwalList.sort((a, b) => (a.jam_mulai || '').localeCompare(b.jam_mulai || '')).map(j => {
            const mulai = j.jam_mulai ? j.jam_mulai.substring(0, 5) : '';
            const selesai = j.jam_selesai ? j.jam_selesai.substring(0, 5) : '';
            const [hM, mM] = mulai.split(':').map(Number);
            const [hS, mS] = selesai.split(':').map(Number);
            const startMin = hM * 60 + mM;
            const endMin = hS * 60 + mS;

            let badge = '';
            if (currentTime >= startMin && currentTime <= endMin) {
                badge = `<span class="status-badge ongoing">Sedang Berlangsung</span>`;
            } else if (currentTime < startMin) {
                badge = `<span class="status-badge upcoming">Akan Datang</span>`;
            } else {
                badge = `<span class="status-badge completed">Selesai</span>`;
            }

            const mapelNama = j.mapel?.nama_mapel || 'Mapel';
            const tingkat = j.tingkat ? `Kelas ${j.tingkat}` : '';
            const isOngoing = currentTime >= startMin && currentTime <= endMin;

            return `
                <div class="schedule-item ${isOngoing ? 'current' : ''}">
                    <div class="schedule-time">
                        <span class="time">${mulai} - ${selesai}</span>
                        ${badge}
                    </div>
                    <div class="schedule-details">
                        <h4>${mapelNama} - ${tingkat}</h4>
                    </div>
                    <button class="btn btn-sm btn-primary" onclick="location.href='/guru/absensi'">
                        <i class="fas fa-clipboard-check"></i> Absen
                    </button>
                </div>`;
        }).join('');
        container.innerHTML = html;
    }
</script>
@endpush
