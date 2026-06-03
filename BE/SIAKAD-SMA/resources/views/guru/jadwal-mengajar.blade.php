@extends('layouts.app')

@section('title', 'Jadwal Mengajar - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Jadwal Mengajar')
@section('breadcrumb', 'Guru / Jadwal Mengajar')

@php
    $role = 'guru';
    $userName = 'Memuat...';
    $userRole = 'Memuat...';
@endphp

@push('styles')
<style>
    .schedule-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }
    .stat-card-schedule {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        text-align: center;
    }
    .stat-card-schedule h3 {
        margin: 0 0 8px 0;
        color: #555;
        font-size: 14px;
        font-weight: 600;
    }
    .stat-value-schedule {
        font-size: 36px;
        font-weight: 700;
        color: #2196F3;
        display: block;
        margin-bottom: 4px;
    }
    .stat-label-schedule {
        font-size: 13px;
        color: #888;
    }

    .filter-bar {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }
    .filter-bar .day-pill {
        padding: 8px 18px;
        border-radius: 20px;
        border: 2px solid #e0e0e0;
        background: #fff;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
        color: #555;
        transition: all 0.2s;
    }
    .filter-bar .day-pill.active {
        border-color: #2196F3;
        background: #2196F3;
        color: #fff;
    }
    .filter-bar .day-pill:hover:not(.active) {
        border-color: #2196F3;
        color: #2196F3;
    }

    .schedule-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .jadwal-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        background: #fff;
        transition: all 0.2s;
    }
    .jadwal-item:hover {
        border-color: #2196F3;
        box-shadow: 0 2px 10px rgba(33,150,243,0.1);
    }
    .jadwal-time {
        min-width: 110px;
        text-align: center;
        background: #e3f2fd;
        border-radius: 8px;
        padding: 10px;
    }
    .jadwal-time .time-text {
        font-weight: 700;
        color: #1565c0;
        font-size: 13px;
        display: block;
    }
    .jadwal-info {
        flex: 1;
    }
    .jadwal-info h4 {
        margin: 0 0 4px 0;
        color: #333;
        font-size: 15px;
    }
    .jadwal-info p {
        margin: 0;
        color: #777;
        font-size: 13px;
    }
    .badge-tingkat {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 700;
        background: #4CAF50;
        color: white;
    }
    .empty-jadwal {
        text-align: center;
        padding: 48px;
        color: #aaa;
    }
    .empty-jadwal i { font-size: 48px; margin-bottom: 12px; display: block; }
</style>
@endpush

@section('content')
<div class="content-container">



    <!-- Schedule Card -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-calendar-week"></i> Jadwal Mengajar Mingguan</h3>
        </div>
        <div class="card-body">
            <!-- Day Filter Pills -->
            <div class="filter-bar" id="dayFilterBar">
                <button class="day-pill active" data-hari="Semua">Semua Hari</button>
                <button class="day-pill" data-hari="Senin">Senin</button>
                <button class="day-pill" data-hari="Selasa">Selasa</button>
                <button class="day-pill" data-hari="Rabu">Rabu</button>
                <button class="day-pill" data-hari="Kamis">Kamis</button>
                <button class="day-pill" data-hari="Jumat">Jumat</button>
                <button class="day-pill" data-hari="Sabtu">Sabtu</button>
            </div>

            <!-- Schedule List -->
            <div class="schedule-list" id="jadwalList">
                <div class="empty-jadwal">
                    <i class="fas fa-spinner fa-spin"></i>
                    <p>Memuat jadwal...</p>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    const HARI_ORDER = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const HARI_ID_JS = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    let allJadwal = [];
    let activeHari = 'Semua';

    document.addEventListener('DOMContentLoaded', () => {
        initPage();
        setupFilters();
    });

    function getToken() {
        const token = localStorage.getItem('token');
        if (!token) { window.location.href = '/login'; return null; }
        return token;
    }

    async function initPage() {
        const token = getToken();
        if (!token) return;

        try {
            // Get current user
            const meRes = await fetch('/api/me', { headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' } });
            const me = await meRes.json();
            const guru = me.data?.profile;

            if (!guru) {
                document.getElementById('jadwalList').innerHTML = `<div class="empty-jadwal"><i class="fas fa-exclamation-circle"></i><p>Data guru tidak ditemukan.</p></div>`;
                return;
            }

            // Update sidebar
            const sidebarName = document.getElementById('sidebarUserName');
            const sidebarRole = document.getElementById('sidebarUserRole');
            if (sidebarName) sidebarName.textContent = guru.nama;
            if (sidebarRole && guru) {
                const mapelName = (guru.mapels && guru.mapels.length > 0) ? guru.mapels[0].nama_mapel : '';
                sidebarRole.textContent = mapelName ? `Guru ${mapelName}` : 'Guru';
            }

            // Load all jadwal
            const jadwalRes = await fetch('/api/guru/jadwal-pelajaran', {
                headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
            });
            const jadwalResult = await jadwalRes.json();
            const all = jadwalResult.success ? (jadwalResult.data || []) : [];

            // Filter by this guru and only mapel
            allJadwal = all.filter(j => j.guru_id == guru.id && j.tipe === 'mapel');



            // Highlight today's pill
            document.querySelectorAll('#dayFilterBar .day-pill').forEach(p => {
                if (p.dataset.hari === todayHari) p.style.boxShadow = '0 0 0 2px #ff980050';
            });

            renderJadwal();
        } catch (err) {
            console.error(err);
            document.getElementById('jadwalList').innerHTML = `<div class="empty-jadwal"><i class="fas fa-exclamation-circle"></i><p>Gagal memuat jadwal.</p></div>`;
        }
    }

    function setupFilters() {
        document.querySelectorAll('#dayFilterBar .day-pill').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('#dayFilterBar .day-pill').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                activeHari = btn.dataset.hari;
                renderJadwal();
            });
        });
    }

    function renderJadwal() {
        const list = document.getElementById('jadwalList');
        let filtered = activeHari === 'Semua' ? allJadwal : allJadwal.filter(j => j.hari === activeHari);

        // Sort by day order then by time
        filtered.sort((a, b) => {
            const dayDiff = HARI_ORDER.indexOf(a.hari) - HARI_ORDER.indexOf(b.hari);
            if (dayDiff !== 0) return dayDiff;
            return (a.jam_mulai || '').localeCompare(b.jam_mulai || '');
        });

        if (!filtered.length) {
            list.innerHTML = `<div class="empty-jadwal"><i class="fas fa-calendar-times"></i><p>Tidak ada jadwal mengajar${activeHari !== 'Semua' ? ' hari ' + activeHari : ''}.</p></div>`;
            return;
        }

        const now = new Date();
        const todayHari = HARI_ID_JS[now.getDay()];
        const currentMin = now.getHours() * 60 + now.getMinutes();

        let html = '';
        let lastHari = null;

        filtered.forEach(j => {
            if (activeHari === 'Semua' && j.hari !== lastHari) {
                lastHari = j.hari;
                html += `<div style="font-weight:700; color:#2196F3; padding:8px 0; border-bottom:2px solid #e3f2fd; margin-bottom:4px;">${j.hari}</div>`;
            }

            const mulai = j.jam_mulai ? j.jam_mulai.substring(0, 5) : '';
            const selesai = j.jam_selesai ? j.jam_selesai.substring(0, 5) : '';
            const mapelNama = j.mapel?.nama_mapel || '-';
            const tingkat = j.tingkat || '-';

            let statusBadge = '';
            if (j.hari === todayHari) {
                const [hM, mM] = mulai.split(':').map(Number);
                const [hS, mS] = selesai.split(':').map(Number);
                const startMin = hM * 60 + mM;
                const endMin = hS * 60 + mS;
                if (currentMin >= startMin && currentMin <= endMin) {
                    statusBadge = `<span class="status-badge ongoing" style="font-size:11px;">Berlangsung</span>`;
                }
            }

            html += `
                <div class="jadwal-item">
                    <div class="jadwal-time">
                        <span class="time-text">${mulai} - ${selesai}</span>
                    </div>
                    <div class="jadwal-info">
                        <h4>${mapelNama} ${statusBadge}</h4>
                        <p><i class="fas fa-graduation-cap"></i> Kelas ${tingkat}</p>
                    </div>
                    <span class="badge-tingkat">${tingkat}</span>
                </div>`;
        });

        list.innerHTML = html;
    }
</script>
@endpush
