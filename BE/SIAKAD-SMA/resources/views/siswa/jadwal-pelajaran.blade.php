@extends('layouts.app')

@section('title', 'Jadwal Pelajaran - SIAKAD SMA')
@section('page-title', 'Jadwal Pelajaran')
@section('breadcrumb', 'Siswa / Jadwal Pelajaran')

@php
    $role = 'siswa';
    $userName = 'Memuat...';
    $userRole = 'Siswa';
@endphp

@push('styles')
<style>
    /* Modern Schedule Grid */
    .schedule-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        align-items: start;
    }
    .day-column {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .day-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        padding: 16px 20px;
        font-size: 18px;
        font-weight: 700;
        text-align: center;
        letter-spacing: 0.5px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }
    .day-body {
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
        background: #f8fafc;
        flex-grow: 1;
        min-height: 100px;
    }
    .subject-card {
        background: white;
        border-radius: 12px;
        padding: 16px;
        border-left: 4px solid #3b82f6;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }
    .subject-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59,130,246,0.15);
    }
    .subject-time {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .subject-name {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px 0;
        line-height: 1.3;
    }
    .subject-teacher {
        font-size: 13px;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .empty-day {
        text-align: center;
        padding: 24px 16px;
        color: #94a3b8;
        font-size: 14px;
        font-style: italic;
    }
    .empty-day i {
        display: block;
        font-size: 24px;
        margin-bottom: 8px;
        color: #cbd5e1;
    }
    
    .loader-container {
        text-align: center;
        padding: 60px;
        color: #64748b;
    }
    .loader-container i {
        font-size: 40px;
        margin-bottom: 16px;
        color: #3b82f6;
    }
    
    /* Subject Card Colors based on index */
    .color-0 { border-left-color: #ef4444; }
    .color-1 { border-left-color: #f97316; }
    .color-2 { border-left-color: #eab308; }
    .color-3 { border-left-color: #22c55e; }
    .color-4 { border-left-color: #06b6d4; }
    .color-5 { border-left-color: #3b82f6; }
    .color-6 { border-left-color: #8b5cf6; }
    .color-7 { border-left-color: #d946ef; }
    .color-8 { border-left-color: #f43f5e; }
</style>
@endpush

@section('content')
<div class="content-container">
    
    <div style="margin-bottom: 24px; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h2 style="margin: 0; color: #1e293b; font-size: 24px;"><i class="fas fa-calendar-week" style="color: #3b82f6; margin-right: 8px;"></i> Jadwal Pelajaran Anda</h2>
            <p style="margin: 4px 0 0 0; color: #64748b;" id="tingkatInfo">Tingkat: Memuat...</p>
        </div>
    </div>

    <div id="loadingIndicator" class="loader-container">
        <i class="fas fa-circle-notch fa-spin"></i>
        <h3>Menyiapkan Jadwal Anda...</h3>
    </div>

    <div id="scheduleGrid" class="schedule-container" style="display: none;">
        <!-- Columns will be injected here via JS -->
    </div>
</div>
@endsection

@push('scripts')
<script>
    const DAYS = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    
    document.addEventListener('DOMContentLoaded', initSchedule);

    function getToken() {
        const t = localStorage.getItem('token');
        if (!t) { window.location.href = '/login'; return null; }
        return t;
    }

    async function initSchedule() {
        const token = getToken();
        if (!token) return;

        try {
            // 1. Fetch Profile (to get Tingkat)
            const meRes = await fetch('/api/me', { headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' } });
            const me = await meRes.json();
            const siswa = me.data?.profile;
            
            if (siswa) {
                const sn = document.getElementById('sidebarUserName');
                const sr = document.getElementById('sidebarUserRole');
                if (sn) sn.textContent = siswa.nama;
                if (sr) sr.textContent = `Siswa Tingkat ${siswa.tingkat}`;
                
                document.getElementById('tingkatInfo').textContent = `Tingkat: Kelas ${siswa.tingkat}`;
                
                // 2. Fetch Schedule based on Tingkat
                await loadSchedule(siswa.tingkat, token);
            } else {
                showError("Gagal memuat profil siswa.");
            }
        } catch (err) {
            console.error(err);
            showError("Terjadi kesalahan jaringan.");
        }
    }
    
    async function loadSchedule(tingkat, token) {
        try {
            const res = await fetch(`/api/siswa/jadwal-tingkat/${tingkat}`, {
                headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' }
            });
            const result = await res.json();
            
            if (result.success) {
                renderSchedule(result.data || []);
            } else {
                showError(result.message || "Gagal memuat jadwal.");
            }
        } catch (err) {
            console.error(err);
            showError("Terjadi kesalahan saat memuat jadwal.");
        }
    }
    
    function renderSchedule(jadwalGrouped) {
        document.getElementById('loadingIndicator').style.display = 'none';
        const grid = document.getElementById('scheduleGrid');
        grid.style.display = 'grid';
        grid.innerHTML = '';
        
        DAYS.forEach(day => {
            // Get array for this day, default to empty array
            const listForDay = jadwalGrouped[day] || [];
            
            // Sort schedule for this day
            const dayJadwal = listForDay
                .sort((a, b) => (a.jam_mulai || '').localeCompare(b.jam_mulai || ''));
                
            let icon = 'fa-calendar-day';
            if (day === 'Jumat') icon = 'fa-mosque';
            
            let cardsHtml = '';
            
            if (dayJadwal.length === 0) {
                cardsHtml = `
                    <div class="empty-day">
                        <i class="fas fa-mug-hot"></i>
                        Tidak ada pelajaran
                    </div>
                `;
            } else {
                cardsHtml = dayJadwal.map((j, index) => {
                    const mulai = j.jam_mulai ? j.jam_mulai.substring(0, 5) : '';
                    const selesai = j.jam_selesai ? j.jam_selesai.substring(0, 5) : '';
                    
                    if (j.tipe === 'kegiatan') {
                        const namaKegiatan = j.keterangan || 'Kegiatan';
                        return `
                            <div style="background: #f1f5f9; border-radius: 8px; padding: 12px; text-align: center; margin-bottom: 8px; border: 1px dashed #cbd5e1;">
                                <div style="font-size: 11px; font-weight: 700; color: #64748b; margin-bottom: 4px;">
                                    <i class="fas fa-clock"></i> ${mulai} - ${selesai}
                                </div>
                                <h4 style="margin: 0; font-size: 14px; color: #475569; font-weight: 600;">${namaKegiatan}</h4>
                            </div>
                        `;
                    }
                    
                    const mapelNama = j.mapel ? j.mapel.nama_mapel : 'Mapel';
                    const guruNama = j.guru ? j.guru.nama : '-';
                    const colorIndex = (j.mapel_id || index) % 9;
                    
                    return `
                        <div class="subject-card color-${colorIndex}" style="margin-bottom: 8px;">
                            <div class="subject-time">
                                <i class="fas fa-clock"></i> ${mulai} - ${selesai}
                            </div>
                            <h4 class="subject-name">${mapelNama}</h4>
                            <div class="subject-teacher">
                                <i class="fas fa-chalkboard-teacher"></i> ${guruNama}
                            </div>
                        </div>
                    `;
                }).join('');
            }
            
            const colHtml = `
                <div class="day-column">
                    <div class="day-header">
                        <i class="fas ${icon}"></i> ${day}
                    </div>
                    <div class="day-body">
                        ${cardsHtml}
                    </div>
                </div>
            `;
            
            grid.innerHTML += colHtml;
        });
    }
    
    function showError(message) {
        document.getElementById('loadingIndicator').style.display = 'none';
        const grid = document.getElementById('scheduleGrid');
        grid.style.display = 'block';
        grid.innerHTML = `
            <div style="text-align:center; padding: 40px; background: #fee2e2; border-radius: 16px; color: #b91c1c;">
                <i class="fas fa-exclamation-triangle" style="font-size: 40px; margin-bottom: 16px;"></i>
                <h3 style="margin:0 0 8px 0;">Opps!</h3>
                <p style="margin:0;">${message}</p>
            </div>
        `;
    }
</script>
@endpush
