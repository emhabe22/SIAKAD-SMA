@extends('layouts.app')

@section('title', 'Absensi Saya - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Riwayat Absensi Saya')
@section('breadcrumb', 'Siswa / Absensi')

@php
    $role = 'siswa';
    $userName = 'Memuat...';
    $userRole = 'Memuat...';
@endphp

@push('styles')
<style>
    .status-badge { padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600; }
    .badge-hadir  { background:#e8f5e9; color:#2e7d32; }
    .badge-izin   { background:#fff3e0; color:#ef6c00; }
    .badge-sakit  { background:#e8eaf6; color:#283593; }
    .badge-alpa   { background:#ffebee; color:#c62828; }

    .mapel-card {
        background:#fff; border:1px solid #e2e8f0; border-radius:12px;
        overflow:hidden; margin-bottom:16px; transition:box-shadow 0.2s;
    }
    .mapel-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
    .mapel-header {
        display:flex; align-items:center; justify-content:space-between;
        padding:16px 20px; background:#f8fafc; border-bottom:1px solid #e2e8f0;
        cursor:pointer;
    }
    .mapel-title { font-weight:600; color:#1e293b; font-size:15px; }
    .mapel-stats { display:flex; gap:8px; align-items:center; }
    .persen-badge {
        padding:4px 12px; border-radius:20px; font-size:13px; font-weight:700;
    }
    .persen-ok   { background:#e8f5e9; color:#2e7d32; }
    .persen-warn { background:#fff3e0; color:#ef6c00; }
    .persen-bad  { background:#ffebee; color:#c62828; }

    .mapel-body { padding:16px 20px; display:none; }
    .mapel-body.open { display:block; }

    .progress-wrap { margin:12px 0; }
    .progress-label { display:flex; justify-content:space-between; font-size:13px; color:#475569; margin-bottom:4px; }
    .progress-bar { height:8px; background:#e2e8f0; border-radius:4px; overflow:hidden; }
    .progress-fill { height:100%; border-radius:4px; transition:width 0.4s; }

    .detail-table { width:100%; border-collapse:collapse; margin-top:12px; }
    .detail-table th { background:#f8fafc; padding:10px 14px; text-align:left; font-size:12px; font-weight:600; color:#64748b; }
    .detail-table td { padding:10px 14px; border-bottom:1px solid #f8fafc; font-size:13px; }
    .detail-table tbody tr:hover { background:#f8fafc; }

    .global-stats { display:flex; gap:12px; flex-wrap:wrap; margin-bottom:20px; }
    .gstat { background:#fff; border:1px solid #e2e8f0; border-radius:10px; padding:14px 20px; flex:1; min-width:120px; text-align:center; }
    .gstat .num { font-size:24px; font-weight:700; }
    .gstat .lbl { font-size:12px; color:#64748b; margin-top:2px; }

    .toggle-icon { transition:transform 0.3s; }
    .toggle-icon.open { transform:rotate(180deg); }
</style>
@endpush

@section('content')
<div class="content-container">

    <!-- Banner -->
    <div class="welcome-card" style="background: linear-gradient(135deg, #1565C0, #42A5F5);">
        <div class="welcome-content">
            <h2>Riwayat Absensi <span id="namaDisplay" style="color:#ffe082;">Saya</span></h2>
            <p id="infoDisplay">Memuat data...</p>
        </div>
        <div class="welcome-icon"><i class="fas fa-clipboard-list"></i></div>
    </div>

    <!-- Global Stats -->
    <div class="global-stats" id="globalStats">
        <div class="gstat"><div class="num" style="color:#4CAF50;" id="gHadir">-</div><div class="lbl">Total Hadir</div></div>
        <div class="gstat"><div class="num" style="color:#FF9800;" id="gIzin">-</div><div class="lbl">Total Izin</div></div>
        <div class="gstat"><div class="num" style="color:#3F51B5;" id="gSakit">-</div><div class="lbl">Total Sakit</div></div>
        <div class="gstat"><div class="num" style="color:#F44336;" id="gAlpa">-</div><div class="lbl">Total Alpa</div></div>
        <div class="gstat"><div class="num" style="color:#475569;" id="gTotal">-</div><div class="lbl">Total Pertemuan</div></div>
    </div>

    <!-- Riwayat per Mapel -->
    <div id="absensiContainer">
        <div style="text-align:center; padding:40px; color:#94a3b8;">
            <i class="fas fa-spinner fa-spin" style="font-size:32px; display:block; margin-bottom:12px;"></i>
            Memuat riwayat absensi...
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let siswaId = null;

document.addEventListener('DOMContentLoaded', function () {
    loadProfile();
});

function getToken() {
    const t = localStorage.getItem('token');
    if (!t) { window.location.href = '/login'; return null; }
    return t;
}

async function loadProfile() {
    const token = getToken(); if (!token) return;
    try {
        const res  = await fetch('/api/me', {
            headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success && data.data.profile) {
            const siswa = data.data.profile;
            siswaId = siswa.id;
            document.getElementById('namaDisplay').textContent = siswa.nama;
            document.getElementById('infoDisplay').textContent = `NISN: ${siswa.nisn} | Tingkat: ${siswa.tingkat}`;
            loadAbsensiSaya(siswa.id);
        }
    } catch (e) { console.error('loadProfile:', e); }
}

async function loadAbsensiSaya(id) {
    const token = getToken(); if (!token) return;
    try {
        const res  = await fetch(`/api/siswa/absensi-saya/${id}`, {
            headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success) renderAbsensi(data.data);
    } catch (e) {
        document.getElementById('absensiContainer').innerHTML =
            '<div style="text-align:center; color:#ef4444; padding:32px;">Gagal memuat data absensi</div>';
    }
}

function renderAbsensi(list) {
    const container = document.getElementById('absensiContainer');

    if (!list || !list.length) {
        container.innerHTML = `
            <div style="text-align:center; padding:48px; color:#94a3b8;">
                <i class="fas fa-clipboard" style="font-size:40px; display:block; margin-bottom:12px;"></i>
                Belum ada riwayat absensi
            </div>`;
        return;
    }

    // Hitung global stats
    let totalH = 0, totalI = 0, totalS = 0, totalA = 0, totalAll = 0;
    list.forEach(m => {
        totalH += m.hadir; totalI += m.izin;
        totalS += m.sakit; totalA += m.alpa; totalAll += m.total;
    });
    document.getElementById('gHadir').textContent  = totalH;
    document.getElementById('gIzin').textContent   = totalI;
    document.getElementById('gSakit').textContent  = totalS;
    document.getElementById('gAlpa').textContent   = totalA;
    document.getElementById('gTotal').textContent  = totalAll;

    container.innerHTML = list.map((m, idx) => {
        const persen    = m.persentase;
        const pClass    = persen >= 80 ? 'persen-ok' : (persen >= 60 ? 'persen-warn' : 'persen-bad');
        const fillColor = persen >= 80 ? '#4CAF50' : (persen >= 60 ? '#FF9800' : '#F44336');
        const mapelName = m.mapel ? m.mapel.nama_mapel : 'Mata Pelajaran';

        const detailRows = m.detail.map((d, di) => `
            <tr>
                <td>${di + 1}</td>
                <td>${formatDate(d.tanggal)}</td>
                <td>${d.pertemuan}</td>
                <td style="font-size:12px; color:#64748b;">${d.jam_mulai} – ${d.jam_selesai}</td>
                <td><span class="status-badge badge-${d.status}">${d.status.charAt(0).toUpperCase()+d.status.slice(1)}</span></td>
                <td style="font-size:12px; color:#64748b;">${d.guru ? d.guru.nama : '-'}</td>
                <td style="font-size:12px; color:#64748b;">${d.keterangan || '-'}</td>
            </tr>`).join('');

        return `
        <div class="mapel-card">
            <div class="mapel-header" onclick="toggleMapel(${idx})">
                <div class="mapel-title">
                    <i class="fas fa-book-open" style="color:#3B82F6; margin-right:8px;"></i>
                    ${mapelName}
                </div>
                <div class="mapel-stats">
                    <span style="font-size:13px; color:#64748b;">${m.total} Pertemuan</span>
                    <span class="persen-badge ${pClass}">${persen}% Hadir</span>
                    <i class="fas fa-chevron-down toggle-icon" id="toggle_${idx}"></i>
                </div>
            </div>
            <div class="mapel-body" id="body_${idx}">
                <!-- Mini stats -->
                <div style="display:flex; gap:16px; flex-wrap:wrap; margin-bottom:16px;">
                    <div style="display:flex; align-items:center; gap:6px; font-size:13px;">
                        <span style="width:10px; height:10px; border-radius:50%; background:#4CAF50; display:inline-block;"></span>
                        Hadir: <strong>${m.hadir}</strong>
                    </div>
                    <div style="display:flex; align-items:center; gap:6px; font-size:13px;">
                        <span style="width:10px; height:10px; border-radius:50%; background:#FF9800; display:inline-block;"></span>
                        Izin: <strong>${m.izin}</strong>
                    </div>
                    <div style="display:flex; align-items:center; gap:6px; font-size:13px;">
                        <span style="width:10px; height:10px; border-radius:50%; background:#3F51B5; display:inline-block;"></span>
                        Sakit: <strong>${m.sakit}</strong>
                    </div>
                    <div style="display:flex; align-items:center; gap:6px; font-size:13px;">
                        <span style="width:10px; height:10px; border-radius:50%; background:#F44336; display:inline-block;"></span>
                        Alpa: <strong>${m.alpa}</strong>
                    </div>
                </div>

                <!-- Progress bar kehadiran -->
                <div class="progress-wrap">
                    <div class="progress-label">
                        <span>Persentase Kehadiran</span>
                        <strong style="color:${fillColor};">${persen}%</strong>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width:${persen}%; background:${fillColor};"></div>
                    </div>
                    ${persen < 75 ? `<small style="color:#ef4444; margin-top:4px; display:block;"><i class="fas fa-exclamation-triangle"></i> Kehadiran di bawah batas minimum 75%</small>` : ''}
                </div>

                <!-- Detail pertemuan -->
                <div class="table-responsive">
                    <table class="detail-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Pertemuan</th>
                                <th>Jam</th>
                                <th>Status</th>
                                <th>Guru</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>${detailRows}</tbody>
                    </table>
                </div>
            </div>
        </div>`;
    }).join('');
}

function toggleMapel(idx) {
    const body   = document.getElementById(`body_${idx}`);
    const icon   = document.getElementById(`toggle_${idx}`);
    const isOpen = body.classList.contains('open');
    body.classList.toggle('open', !isOpen);
    icon.classList.toggle('open', !isOpen);
}

function formatDate(d) {
    if (!d) return '-';
    return new Date(d).toLocaleDateString('id-ID', { day:'2-digit', month:'long', year:'numeric' });
}
</script>
@endpush