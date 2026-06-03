@extends('layouts.app')

@section('title', 'Logbook Guru - SIAKAD SMA Admin')
@section('page-title', 'Laporan Logbook Guru')
@section('breadcrumb', 'Admin / Logbook Guru')

@php $role = 'admin'; @endphp

@push('styles')
<style>
    .guru-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }
    .guru-logbook-card {
        background: white; border-radius: 14px; padding: 22px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        transition: all 0.2s; cursor: pointer;
    }
    .guru-logbook-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.12); }

    .guru-card-header { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; }
    .guru-avatar {
        width: 48px; height: 48px; border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 18px; font-weight: 700; flex-shrink: 0;
    }
    .guru-card-name h4 { margin: 0; font-size: 15px; font-weight: 700; color: #1e293b; }
    .guru-card-name p  { margin: 2px 0 0; font-size: 12px; color: #64748b; }

    .guru-logbook-stats { display: flex; gap: 8px; flex-wrap: wrap; }
    .mini-stat {
        flex: 1; min-width: 80px; text-align: center; padding: 10px 6px;
        border-radius: 8px; background: #f8fafc;
    }
    .mini-stat .num { font-size: 22px; font-weight: 800; display: block; }
    .mini-stat .lbl { font-size: 10px; color: #64748b; }
    .mini-stat.total .num { color: #3b82f6; }
    .mini-stat.serah  .num { color: #22c55e; }
    .mini-stat.draft  .num { color: #f59e0b; }

    .guru-card-footer { margin-top: 14px; }

    /* Detail Modal */
    .logbook-detail-list { display: flex; flex-direction: column; gap: 12px; }
    .lb-item {
        border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px;
        background: white; border-left: 4px solid #e2e8f0;
    }
    .lb-item.diserahkan { border-left-color: #22c55e; }
    .lb-item.draft { border-left-color: #f59e0b; }

    .lb-item-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
    .lb-item-title { font-weight: 700; color: #1e293b; font-size: 14px; }
    .lb-item-meta  { font-size: 12px; color: #64748b; margin-top: 2px; }
    .lb-badge { padding: 3px 10px; border-radius: 12px; font-size: 11px; font-weight: 700; }
    .lb-badge.diserahkan { background: #dcfce7; color: #15803d; }
    .lb-badge.draft      { background: #fef9c3; color: #a16207; }

    .lb-content-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 10px; }
    .lb-field h6 { margin: 0 0 4px; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; }
    .lb-field p  { margin: 0; font-size: 13px; color: #374151; line-height: 1.5; }
    .lb-field p.empty { color: #cbd5e1; font-style: italic; }

    .filter-bar-lb { display: flex; gap: 8px; margin-bottom: 16px; flex-wrap: wrap; }
    .filter-pill {
        padding: 6px 16px; border-radius: 20px; border: 2px solid #e2e8f0;
        background: white; cursor: pointer; font-size: 13px; font-weight: 600; color: #555;
        transition: all 0.2s;
    }
    .filter-pill.active { border-color: #3b82f6; background: #3b82f6; color: white; }

    .empty-state-lb { text-align: center; padding: 48px; color: #94a3b8; }
    .empty-state-lb i { font-size: 48px; display: block; margin-bottom: 12px; }
</style>
@endpush

@section('content')
<div class="content-container">
    <div id="listView">
        <div class="card-header" style="margin-bottom:20px; background:none; padding:0;">
            <h3 style="font-size:16px; color:#1e293b;"><i class="fas fa-chalkboard-teacher" style="color:#3b82f6;"></i> Daftar Guru</h3>
        </div>
        <div class="guru-grid" id="guruGrid">
            <div style="text-align:center; padding:48px; color:#94a3b8; grid-column:1/-1;">
                <i class="fas fa-spinner fa-spin" style="font-size:32px;"></i>
                <p>Memuat data...</p>
            </div>
        </div>
    </div>

    <!-- Detail View (per Guru) -->
    <div id="detailView" style="display:none;">
        <div style="display:flex; align-items:center; gap:12px; margin-bottom:20px;">
            <button onclick="backToList()" class="btn btn-secondary" style="padding:8px 16px;">
                <i class="fas fa-arrow-left"></i> Kembali
            </button>
            <div>
                <h3 id="detailGuruName" style="margin:0; font-size:18px; color:#1e293b;"></h3>
                <p id="detailGuruMapel" style="margin:0; font-size:13px; color:#64748b;"></p>
            </div>
        </div>

        <!-- Filter -->
        <div class="filter-bar-lb" id="detailFilterBar">
            <button class="filter-pill active" data-filter="semua">Semua</button>
            <button class="filter-pill" data-filter="diserahkan">Diserahkan</button>
            <button class="filter-pill" data-filter="draft">Draft</button>
        </div>

        <div class="logbook-detail-list" id="logbookDetailList">
            <div class="empty-state-lb"><i class="fas fa-spinner fa-spin"></i><p>Memuat...</p></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const BULAN_ID = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    let allDetailLogbooks = [];
    let activeFilter = 'semua';

    document.addEventListener('DOMContentLoaded', initAdminLogbook);

    function getToken() {
        const t = localStorage.getItem('token');
        if (!t) { window.location.href = '/login'; return null; }
        return t;
    }

    async function initAdminLogbook() {
        const token = getToken(); if (!token) return;
        const res = await fetch('/api/admin/logbook-guru', {
            headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' }
        });
        const result = await res.json();
        if (!result.success) { document.getElementById('guruGrid').innerHTML = '<p style="color:red;">Gagal memuat data</p>'; return; }
        renderGuruGrid(result.data || []);
    }

    function renderGuruGrid(gurus) {
        const grid = document.getElementById('guruGrid');
        if (!gurus.length) {
            grid.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:48px; color:#94a3b8;"><i class="fas fa-users" style="font-size:48px; display:block; margin-bottom:12px;"></i>Belum ada data guru.</div>';
            return;
        }
        grid.innerHTML = gurus.map(g => {
            const inisial = g.nama ? g.nama.charAt(0).toUpperCase() : 'G';
            const mapels = g.mapels?.map(m => m.nama_mapel).join(', ') || '-';
            const pctSerahkan = g.total_logbook > 0 ? Math.round((g.total_diserahkan / g.total_logbook) * 100) : 0;
            return `
                <div class="guru-logbook-card" onclick="openGuruDetail(${g.id}, '${g.nama?.replace(/'/g,"\\'")}', '${mapels.replace(/'/g,"\\'")}')">
                    <div class="guru-card-header">
                        <div class="guru-avatar">${inisial}</div>
                        <div class="guru-card-name">
                            <h4>${g.nama}</h4>
                            <p>${mapels.substring(0, 40)}${mapels.length > 40 ? '...' : ''}</p>
                        </div>
                    </div>
                    <div class="guru-logbook-stats">
                        <div class="mini-stat total"><span class="num">${g.total_logbook}</span><span class="lbl">Total</span></div>
                        <div class="mini-stat serah"><span class="num">${g.total_diserahkan}</span><span class="lbl">Diserahkan</span></div>
                        <div class="mini-stat draft"><span class="num">${g.total_draft}</span><span class="lbl">Draft</span></div>
                    </div>
                    <div class="guru-card-footer">
                        <div style="display:flex; justify-content:space-between; font-size:12px; color:#64748b; margin-bottom:4px;">
                            <span>Progress Penyerahan</span><span style="font-weight:700; color:#1e293b;">${pctSerahkan}%</span>
                        </div>
                        <div style="background:#f1f5f9; border-radius:4px; height:6px; overflow:hidden;">
                            <div style="width:${pctSerahkan}%; height:100%; background:#22c55e; border-radius:4px; transition:width 0.4s;"></div>
                        </div>
                    </div>
                </div>`;
        }).join('');
    }

    async function openGuruDetail(guruId, guruNama, guruMapel) {
        document.getElementById('listView').style.display = 'none';
        document.getElementById('detailView').style.display = 'block';
        document.getElementById('detailGuruName').textContent = guruNama;
        document.getElementById('detailGuruMapel').textContent = guruMapel;
        document.getElementById('logbookDetailList').innerHTML = '<div class="empty-state-lb"><i class="fas fa-spinner fa-spin"></i><p>Memuat logbook...</p></div>';

        const token = getToken(); if (!token) return;
        const res = await fetch(`/api/admin/logbook-guru/${guruId}`, {
            headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' }
        });
        const result = await res.json();
        if (!result.success) { document.getElementById('logbookDetailList').innerHTML = '<p style="color:red; text-align:center;">Gagal memuat logbook</p>'; return; }

        allDetailLogbooks = result.data || [];
        setupDetailFilter();
        renderDetailList(allDetailLogbooks);
    }

    function setupDetailFilter() {
        document.querySelectorAll('#detailFilterBar .filter-pill').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('#detailFilterBar .filter-pill').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                activeFilter = btn.dataset.filter;
                const filtered = activeFilter === 'semua' ? allDetailLogbooks : allDetailLogbooks.filter(lb => lb.status === activeFilter);
                renderDetailList(filtered);
            });
        });
    }

    function renderDetailList(list) {
        const container = document.getElementById('logbookDetailList');
        if (!list.length) {
            container.innerHTML = '<div class="empty-state-lb"><i class="fas fa-inbox"></i><p>Tidak ada logbook ditemukan.</p></div>';
            return;
        }

        container.innerHTML = list.map(lb => {
            const absen = lb.absen || {};
            const mapelNama = absen.mapel?.nama_mapel || '-';
            const tanggal = absen.tanggal ? new Date(absen.tanggal).toLocaleDateString('id-ID', { day:'2-digit', month:'long', year:'numeric' }) : '-';
            const isDiserahkan = lb.status === 'diserahkan';
            const badgeClass = isDiserahkan ? 'diserahkan' : 'draft';
            const badgeText  = isDiserahkan ? '✅ Diserahkan' : '📝 Draft';
            const diserahkanAt = lb.diserahkan_at ? new Date(lb.diserahkan_at).toLocaleString('id-ID') : null;

            return `<div class="lb-item ${lb.status}">
                <div class="lb-item-header">
                    <div>
                        <div class="lb-item-title">${mapelNama} — Kelas ${absen.tingkat || '-'}</div>
                        <div class="lb-item-meta">
                            <i class="fas fa-calendar"></i> ${tanggal} &bull;
                            <i class="fas fa-clock"></i> ${(absen.jam_mulai||'').substring(0,5)}–${(absen.jam_selesai||'').substring(0,5)} &bull;
                            <i class="fas fa-layer-group"></i> ${absen.pertemuan || '-'} &bull;
                            <i class="fas fa-users"></i> ${lb.total_hadir}/${lb.total_siswa} hadir
                        </div>
                        ${diserahkanAt ? `<div class="lb-item-meta" style="margin-top:2px; color:#22c55e;"><i class="fas fa-check-circle"></i> Diserahkan: ${diserahkanAt}</div>` : ''}
                    </div>
                    <span class="lb-badge ${badgeClass}">${badgeText}</span>
                </div>
                <div class="lb-content-grid">
                    <div class="lb-field">
                        <h6><i class="fas fa-book"></i> Materi Pembelajaran</h6>
                        <p class="${lb.materi_pembelajaran ? '' : 'empty'}">${lb.materi_pembelajaran || 'Belum diisi'}</p>
                    </div>
                    <div class="lb-field">
                        <h6><i class="fas fa-chalkboard"></i> Metode Pembelajaran</h6>
                        <p class="${lb.metode_pembelajaran ? '' : 'empty'}">${lb.metode_pembelajaran || 'Belum diisi'}</p>
                    </div>
                    <div class="lb-field" style="grid-column:1/-1;">
                        <h6><i class="fas fa-tasks"></i> Tugas & Evaluasi</h6>
                        <p class="${lb.tugas_evaluasi ? '' : 'empty'}">${lb.tugas_evaluasi || 'Belum diisi'}</p>
                    </div>
                </div>
            </div>`;
        }).join('');
    }

    function backToList() {
        document.getElementById('detailView').style.display = 'none';
        document.getElementById('listView').style.display = 'block';
        allDetailLogbooks = [];
    }
</script>
@endpush
