@extends('layouts.app')

@section('title', 'Absensi Siswa - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Absensi Siswa')
@section('breadcrumb', 'Guru / Absensi')

@php
    $role = 'guru';
    $userName = 'Memuat...';
    $userRole = 'Memuat...';
@endphp

@push('styles')
<style>
    .status-badge { padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    .badge-hadir  { background: #e8f5e9; color: #2e7d32; }
    .badge-izin   { background: #fff3e0; color: #ef6c00; }
    .badge-sakit  { background: #e8eaf6; color: #283593; }
    .badge-alpa   { background: #ffebee; color: #c62828; }

    .status-radio-group { display: flex; gap: 6px; }
    .status-radio-group label {
        padding: 5px 12px; border-radius: 6px; cursor: pointer; font-size: 13px;
        font-weight: 500; border: 1.5px solid #ddd; transition: all 0.2s;
        user-select: none;
    }
    .status-radio-group input[type="radio"] { display: none; }
    .status-radio-group input:checked + label.lbl-hadir  { background:#4CAF50; color:#fff; border-color:#4CAF50; }
    .status-radio-group input:checked + label.lbl-izin   { background:#FF9800; color:#fff; border-color:#FF9800; }
    .status-radio-group input:checked + label.lbl-sakit  { background:#3F51B5; color:#fff; border-color:#3F51B5; }
    .status-radio-group input:checked + label.lbl-alpa   { background:#F44336; color:#fff; border-color:#F44336; }

    .history-table { width:100%; border-collapse:collapse; }
    .history-table th { background:#f1f5f9; padding:12px 16px; text-align:left; font-weight:600; color:#475569; font-size:13px; }
    .history-table td { padding:12px 16px; border-bottom:1px solid #f1f5f9; vertical-align:middle; }
    .history-table tbody tr:hover { background:#f8fafc; }

    /* Modal wider */
    #absenModal .modal-content, #detailModal .modal-content { max-width: 860px; max-height: 90vh; overflow-y: auto; }

    .checklist-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }
    .select-all-wrap  { display:flex; gap:10px; }

    .siswa-row { display:grid; grid-template-columns:40px 1fr auto; align-items:center; gap:12px;
                 padding:10px 12px; border:1px solid #e2e8f0; border-radius:8px; margin-bottom:8px;
                 background:#fff; transition:background 0.2s; }
    .siswa-row:hover { background:#f8fafc; }
    .siswa-no  { width:28px; height:28px; background:#e2e8f0; border-radius:50%;
                 display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#475569; }
    .siswa-name { font-weight:500; color:#1e293b; font-size:14px; }
    .siswa-nisn { font-size:12px; color:#64748b; }

    .log-item { display:flex; gap:12px; padding:10px 0; border-bottom:1px solid #f1f5f9; }
    .log-icon { width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .log-icon.dibuat { background:#e8f5e9; color:#4CAF50; }
    .log-icon.diubah { background:#fff3e0; color:#FF9800; }
    .log-time  { font-size:12px; color:#94a3b8; margin-top:2px; }

    .stats-mini { display:flex; gap:16px; flex-wrap:wrap; margin:16px 0; }
    .stat-mini  { display:flex; align-items:center; gap:8px; background:#f8fafc;
                  border-radius:8px; padding:10px 16px; }
    .stat-mini .num { font-size:20px; font-weight:700; }
    .stat-mini .lbl { font-size:12px; color:#64748b; }

    .empty-state { text-align:center; padding:48px 20px; color:#94a3b8; }
    .empty-state i { font-size:48px; margin-bottom:16px; display:block; }
</style>
@endpush

@section('content')
<div class="content-container">

    <!-- Stats realtime -->
    <div class="stats-grid compact">
        <div class="stat-card">
            <div class="stat-icon" style="background:#4CAF50;"><i class="fas fa-clipboard-check"></i></div>
            <div class="stat-info"><h3 id="statTotalSesi">0</h3><p>Total Sesi Absen</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#2196F3;"><i class="fas fa-calendar-day"></i></div>
            <div class="stat-info"><h3 id="statSesiHariIni">0</h3><p>Sesi Hari Ini</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#FF9800;"><i class="fas fa-book-open"></i></div>
            <div class="stat-info"><h3 id="statTotalPertemuan">0</h3><p>Total Pertemuan</p></div>
        </div>
    </div>

    <!-- Riwayat Sesi Absen -->
    <div class="card">
        <div class="card-header">
            <h3><i class="fas fa-list-alt"></i> Riwayat Sesi Absen</h3>
            <div class="card-actions">
                <button class="btn btn-primary" onclick="openAbsenModal()">
                    <i class="fas fa-plus"></i> Buat Absen
                </button>
                <button class="btn-icon" onclick="loadAbsenSaya()" title="Refresh">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="history-table" id="absenTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Mata Pelajaran</th>
                            <th>Tingkat</th>
                            <th>Pertemuan</th>
                            <th>Jam</th>
                            <th>Hadir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="absenTableBody">
                        <tr><td colspan="8" style="text-align:center;padding:32px;">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ========== MODAL BUAT ABSEN ========== -->
<div id="absenModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-plus-circle"></i> Buat Sesi Absen Baru</h3>
            <span class="close" onclick="closeAbsenModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="absenForm">
                <!-- Baris 1: Tanggal & Pertemuan -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label>Tanggal *</label>
                        <input type="date" id="absenTanggal" required>
                    </div>
                    <div class="form-group">
                        <label>Pertemuan ke- *</label>
                        <input type="text" id="absenPertemuan" required placeholder="Contoh: P-1">
                    </div>
                </div>

                <!-- Baris 2: Jam -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label>Jam Mulai *</label>
                        <input type="time" id="absenJamMulai" required>
                    </div>
                    <div class="form-group">
                        <label>Jam Selesai *</label>
                        <input type="time" id="absenJamSelesai" required>
                    </div>
                </div>

                <!-- Baris 3: Tingkat & Mapel -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label>Tingkat *</label>
                        <select id="absenTingkat" required onchange="onTingkatChange()">
                            <option value="">-- Pilih Tingkat --</option>
                            <option value="X">Tingkat X</option>
                            <option value="XI">Tingkat XI</option>
                            <option value="XII">Tingkat XII</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Mata Pelajaran *</label>
                        <select id="absenMapel" required>
                            <option value="">-- Otomatis dari mapel Anda --</option>
                        </select>
                    </div>
                </div>

                <!-- Log Book -->
                <div class="form-group">
                    <label><i class="fas fa-book"></i> Materi yang Diajarkan</label>
                    <textarea id="absenMateri" rows="2" placeholder="Contoh: Integral Parsial, Bab 3 halaman 45-50..."></textarea>
                </div>
                <div class="form-group">
                    <label><i class="fas fa-sticky-note"></i> Catatan Guru (opsional)</label>
                    <textarea id="absenCatatan" rows="2" placeholder="Catatan khusus mengenai jalannya kelas..."></textarea>
                </div>

                <hr style="margin:16px 0; border:none; border-top:1px solid #e2e8f0;">

                <!-- Checklist Siswa -->
                <div class="checklist-header">
                    <label style="font-weight:600; color:#1e293b;">
                        <i class="fas fa-users"></i> Daftar Kehadiran Siswa
                        <span id="siswaCount" style="font-weight:400; color:#64748b; font-size:13px;"> — pilih tingkat terlebih dahulu</span>
                    </label>
                    <div class="select-all-wrap">
                        <button type="button" class="btn btn-secondary" style="padding:6px 12px; font-size:13px;" onclick="setAllStatus('hadir')">✓ Semua Hadir</button>
                        <button type="button" class="btn btn-secondary" style="padding:6px 12px; font-size:13px;" onclick="setAllStatus('alpa')">✗ Semua Alpa</button>
                    </div>
                </div>
                <div id="siswaChecklist" style="max-height:300px; overflow-y:auto; border:1px solid #e2e8f0; border-radius:8px; padding:12px; background:#f8fafc;">
                    <div class="empty-state"><i class="fas fa-users"></i><p>Pilih tingkat untuk memuat daftar siswa</p></div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeAbsenModal()">Batal</button>
            <button class="btn btn-primary" onclick="simpanAbsen()" id="btnSimpan">
                <i class="fas fa-save"></i> Simpan Absensi
            </button>
        </div>
    </div>
</div>

<!-- ========== MODAL DETAIL SESI ========== -->
<div id="detailModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-eye"></i> Detail Sesi Absen</h3>
            <span class="close" onclick="closeDetailModal()">&times;</span>
        </div>
        <div class="modal-body" id="detailModalBody">
            <p style="text-align:center;">Memuat...</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeDetailModal()">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let guruId       = null;
let guruMapels   = [];
let siswasLoaded = [];
let currentDetailAbsenId = null;

// ─── INIT ────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
    // Set default tanggal ke hari ini
    document.getElementById('absenTanggal').value = new Date().toISOString().split('T')[0];
    loadGuruProfile();
});

function getToken() {
    const token = localStorage.getItem('token');
    if (!token) { window.location.href = '/login'; return null; }
    return token;
}

// ─── LOAD PROFIL GURU (ambil guru_id dan mapels) ─────────────
async function loadGuruProfile() {
    const token = getToken(); if (!token) return;
    try {
        const res  = await fetch('/api/guru/mapel-saya', {
            headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success) {
            guruId      = data.data.guru.id;
            guruMapels  = data.data.mapels;

            // Update sidebar name
            const guru = data.data.guru;
            const mapels = data.data.mapels;
            const sidebarName = document.getElementById('sidebarUserName');
            const sidebarRole = document.getElementById('sidebarUserRole');
            if (sidebarName && guru) sidebarName.textContent = guru.nama;
            if (sidebarRole) {
                const mapelName = (mapels && mapels.length > 0) ? mapels[0].nama_mapel : '';
                sidebarRole.textContent = mapelName ? `Guru ${mapelName}` : 'Guru';
            }

            populateMapelOptions();
            loadAbsenSaya();
        }
    } catch (e) { console.error('loadGuruProfile:', e); }
}

function populateMapelOptions() {
    const sel = document.getElementById('absenMapel');
    sel.innerHTML = '<option value="">-- Pilih Mapel --</option>';
    guruMapels.forEach(m => {
        sel.innerHTML += `<option value="${m.id}">${m.kode_mapel} - ${m.nama_mapel}</option>`;
    });
}

// ─── LOAD RIWAYAT ABSEN SAYA ─────────────────────────────────
async function loadAbsenSaya() {
    const token = getToken(); if (!token) return;
    try {
        const res  = await fetch('/api/guru/absen-saya', {
            headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success) {
            renderAbsenTable(data.data);
            updateStats(data.data);
        }
    } catch (e) {
        document.getElementById('absenTableBody').innerHTML =
            '<tr><td colspan="8" style="text-align:center;">Gagal memuat data</td></tr>';
    }
}

function renderAbsenTable(list) {
    const tbody = document.getElementById('absenTableBody');
    if (!list.length) {
        tbody.innerHTML = `<tr><td colspan="8" style="text-align:center; padding:32px; color:#94a3b8;">
            <i class="fas fa-clipboard" style="font-size:32px; display:block; margin-bottom:8px;"></i>
            Belum ada sesi absen. Klik <strong>+ Buat Absen</strong> untuk memulai.
        </td></tr>`;
        return;
    }
    const today = new Date().toISOString().split('T')[0];
    tbody.innerHTML = list.map((a, i) => {
        const hadir  = a.total_hadir  ?? 0;
        const total  = a.total_siswa  ?? 0;
        const isToday = a.tanggal === today;
        return `
        <tr>
            <td>${i + 1}</td>
            <td>
                <strong>${formatDate(a.tanggal)}</strong>
                ${isToday ? '<span class="status-badge badge-hadir" style="margin-left:6px; font-size:10px;">Hari ini</span>' : ''}
            </td>
            <td>${a.mapel ? a.mapel.nama_mapel : '-'}</td>
            <td><span class="status-badge" style="background:#e0f2fe; color:#0369a1;">${a.tingkat}</span></td>
            <td>${a.pertemuan}</td>
            <td style="font-size:13px; color:#475569;">${a.jam_mulai} – ${a.jam_selesai}</td>
            <td>
                <span style="font-weight:600; color:#4CAF50;">${hadir}</span>
                <span style="color:#94a3b8; font-size:12px;">/ ${total}</span>
            </td>
            <td>
                <button class="btn-icon" onclick="openDetailModal(${a.id})" title="Detail & Log Book">
                    <i class="fas fa-eye"></i>
                </button>
            </td>
        </tr>`;
    }).join('');
}

function updateStats(list) {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('statTotalSesi').textContent    = list.length;
    document.getElementById('statSesiHariIni').textContent  = list.filter(a => a.tanggal === today).length;
    document.getElementById('statTotalPertemuan').textContent = list.length;
}

// ─── MODAL BUAT ABSEN ─────────────────────────────────────────
function openAbsenModal() {
    document.getElementById('absenForm').reset();
    document.getElementById('absenTanggal').value = new Date().toISOString().split('T')[0];
    populateMapelOptions();
    document.getElementById('siswaChecklist').innerHTML =
        '<div class="empty-state"><i class="fas fa-users"></i><p>Pilih tingkat untuk memuat daftar siswa</p></div>';
    document.getElementById('siswaCount').textContent = ' — pilih tingkat terlebih dahulu';
    document.getElementById('absenModal').style.display = 'block';
}

function closeAbsenModal() {
    document.getElementById('absenModal').style.display = 'none';
}

// Saat tingkat dipilih → load daftar siswa
async function onTingkatChange() {
    const tingkat = document.getElementById('absenTingkat').value;
    if (!tingkat) {
        document.getElementById('siswaChecklist').innerHTML =
            '<div class="empty-state"><i class="fas fa-users"></i><p>Pilih tingkat untuk memuat daftar siswa</p></div>';
        return;
    }

    const token = getToken(); if (!token) return;
    document.getElementById('siswaChecklist').innerHTML =
        '<p style="text-align:center; padding:20px; color:#94a3b8;"><i class="fas fa-spinner fa-spin"></i> Memuat siswa...</p>';

    try {
        const res  = await fetch(`/api/guru/siswa-tingkat/${tingkat}`, {
            headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success) {
            siswasLoaded = data.data;
            renderSiswaChecklist(siswasLoaded);
        }
    } catch (e) {
        document.getElementById('siswaChecklist').innerHTML = '<p style="color:red; text-align:center;">Gagal memuat siswa</p>';
    }
}

function renderSiswaChecklist(siswas) {
    document.getElementById('siswaCount').textContent = ` — ${siswas.length} siswa ditemukan`;
    if (!siswas.length) {
        document.getElementById('siswaChecklist').innerHTML =
            '<p style="text-align:center; color:#94a3b8;">Tidak ada siswa di tingkat ini</p>';
        return;
    }
    document.getElementById('siswaChecklist').innerHTML = siswas.map((s, i) => `
        <div class="siswa-row">
            <div class="siswa-no">${i + 1}</div>
            <div>
                <div class="siswa-name">${s.nama}</div>
                <div class="siswa-nisn">NISN: ${s.nisn}</div>
            </div>
            <div class="status-radio-group">
                <input type="radio" name="status_${s.id}" id="h_${s.id}" value="hadir" checked>
                <label for="h_${s.id}" class="lbl-hadir">Hadir</label>

                <input type="radio" name="status_${s.id}" id="i_${s.id}" value="izin">
                <label for="i_${s.id}" class="lbl-izin">Izin</label>

                <input type="radio" name="status_${s.id}" id="s_${s.id}" value="sakit">
                <label for="s_${s.id}" class="lbl-sakit">Sakit</label>

                <input type="radio" name="status_${s.id}" id="a_${s.id}" value="alpa">
                <label for="a_${s.id}" class="lbl-alpa">Alpa</label>
            </div>
        </div>
    `).join('');
}

function setAllStatus(status) {
    siswasLoaded.forEach(s => {
        const radio = document.querySelector(`input[name="status_${s.id}"][value="${status}"]`);
        if (radio) radio.checked = true;
    });
}

// ─── SIMPAN ABSEN (Bulk) ──────────────────────────────────────
async function simpanAbsen() {
    const token = getToken(); if (!token) return;

    const tanggal    = document.getElementById('absenTanggal').value;
    const pertemuan  = document.getElementById('absenPertemuan').value.trim();
    const jamMulai   = document.getElementById('absenJamMulai').value;
    const jamSelesai = document.getElementById('absenJamSelesai').value;
    const tingkat    = document.getElementById('absenTingkat').value;
    const mapelId    = document.getElementById('absenMapel').value;
    const materi     = document.getElementById('absenMateri').value.trim();
    const catatan    = document.getElementById('absenCatatan').value.trim();

    if (!tanggal || !pertemuan || !jamMulai || !jamSelesai || !tingkat || !mapelId) {
        alert('Harap lengkapi semua field yang wajib diisi!'); return;
    }
    if (!siswasLoaded.length) {
        alert('Tidak ada siswa yang dimuat. Pilih tingkat terlebih dahulu!'); return;
    }

    // Kumpulkan data absensi per siswa
    const absensiArr = siswasLoaded.map(s => {
        const checked = document.querySelector(`input[name="status_${s.id}"]:checked`);
        return { siswa_id: s.id, status: checked ? checked.value : 'alpa', keterangan: '' };
    });

    const payload = {
        tanggal, pertemuan, jam_mulai: jamMulai, jam_selesai: jamSelesai,
        tingkat, mapel_id: mapelId, guru_id: guruId,
        materi: materi || null, catatan_guru: catatan || null,
        absensi: absensiArr,
    };

    document.getElementById('btnSimpan').disabled = true;
    document.getElementById('btnSimpan').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

    try {
        const res  = await fetch('/api/guru/absensi/bulk', {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });
        const data = await res.json();

        if (res.ok && data.success) {
            closeAbsenModal();
            loadAbsenSaya();
            alert(`✅ Absensi berhasil disimpan!\n${data.data.total_hadir} dari ${data.data.total_siswa} siswa hadir.`);
        } else {
            const err = data.errors ? Object.values(data.errors).flat().join('\n') : data.message;
            alert('Gagal menyimpan: ' + err);
        }
    } catch (e) {
        console.error(e);
        alert('Terjadi kesalahan jaringan');
    } finally {
        document.getElementById('btnSimpan').disabled = false;
        document.getElementById('btnSimpan').innerHTML = '<i class="fas fa-save"></i> Simpan Absensi';
    }
}

// ─── MODAL DETAIL SESI ───────────────────────────────────────
async function openDetailModal(absenId) {
    currentDetailAbsenId = absenId;
    document.getElementById('detailModal').style.display = 'block';
    document.getElementById('detailModalBody').innerHTML =
        '<p style="text-align:center; padding:32px;"><i class="fas fa-spinner fa-spin"></i> Memuat detail...</p>';

    const token = getToken(); if (!token) return;
    try {
        const res  = await fetch(`/api/guru/absen/${absenId}/detail`, {
            headers: { 'Authorization': `Bearer ${token}`, 'Accept': 'application/json' }
        });
        const data = await res.json();
        if (data.success) renderDetailModal(data.data);
    } catch (e) {
        document.getElementById('detailModalBody').innerHTML = '<p style="color:red; text-align:center;">Gagal memuat detail</p>';
    }
}

function closeDetailModal() {
    document.getElementById('detailModal').style.display = 'none';
    currentDetailAbsenId = null;
}

function renderDetailModal(data) {
    const { absen, statistik, log_books } = data;
    const statusColor = { hadir:'#4CAF50', izin:'#FF9800', sakit:'#3F51B5', alpa:'#F44336' };
    const statusBadge = s => `<span class="status-badge badge-${s}">${s.charAt(0).toUpperCase()+s.slice(1)}</span>`;

    const siswaTabel = absen.absensis && absen.absensis.length
        ? absen.absensis.map((ab, i) => `
            <tr>
                <td>${i + 1}</td>
                <td>${ab.siswa ? ab.siswa.nama : '-'}</td>
                <td>${ab.siswa ? ab.siswa.nisn : '-'}</td>
                <td>${statusBadge(ab.status)}</td>
                <td style="font-size:13px; color:#64748b;">${ab.keterangan || '-'}</td>
                <td>
                    <button class="btn-icon" style="padding:4px 8px;" onclick="editAbsensi(${ab.id}, '${ab.status}')" title="Edit status">
                        <i class="fas fa-edit"></i>
                    </button>
                </td>
            </tr>`).join('')
        : '<tr><td colspan="6" style="text-align:center; color:#94a3b8;">Tidak ada data</td></tr>';

    const logItems = log_books && log_books.length
        ? log_books.map(log => `
            <div class="log-item">
                <div class="log-icon ${log.aksi.includes('ubah') ? 'diubah' : 'dibuat'}">
                    <i class="fas ${log.aksi.includes('ubah') ? 'fa-edit' : 'fa-plus-circle'}"></i>
                </div>
                <div>
                    <div style="font-size:14px; color:#1e293b;">${log.deskripsi || log.aksi}</div>
                    <div class="log-time">
                        ${log.user ? log.user.username : '—'} &bull; ${formatDateTime(log.created_at)}
                    </div>
                </div>
            </div>`).join('')
        : '<p style="color:#94a3b8; font-size:13px;">Belum ada log</p>';

    document.getElementById('detailModalBody').innerHTML = `
        <!-- Info Sesi -->
        <div style="background:#f8fafc; border-radius:8px; padding:16px; margin-bottom:16px;">
            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:12px; font-size:14px;">
                <div><span style="color:#64748b;">Tanggal</span><br><strong>${formatDate(absen.tanggal)}</strong></div>
                <div><span style="color:#64748b;">Jam</span><br><strong>${absen.jam_mulai} – ${absen.jam_selesai}</strong></div>
                <div><span style="color:#64748b;">Pertemuan</span><br><strong>${absen.pertemuan}</strong></div>
                <div><span style="color:#64748b;">Mapel</span><br><strong>${absen.mapel ? absen.mapel.nama_mapel : '-'}</strong></div>
                <div><span style="color:#64748b;">Tingkat</span><br><strong>${absen.tingkat}</strong></div>
                <div><span style="color:#64748b;">Guru</span><br><strong>${absen.guru ? absen.guru.nama : '-'}</strong></div>
            </div>
        </div>

        <!-- Log Book -->
        ${absen.materi || absen.catatan_guru ? `
        <div style="background:#fffbeb; border:1px solid #fde68a; border-radius:8px; padding:16px; margin-bottom:16px;">
            <h4 style="margin:0 0 10px 0; color:#92400e;"><i class="fas fa-book"></i> Log Book</h4>
            ${absen.materi ? `<p style="margin:0 0 8px 0;"><strong>Materi:</strong> ${absen.materi}</p>` : ''}
            ${absen.catatan_guru ? `<p style="margin:0;"><strong>Catatan:</strong> ${absen.catatan_guru}</p>` : ''}
        </div>` : ''}

        <!-- Statistik -->
        <div class="stats-mini">
            <div class="stat-mini"><span class="num" style="color:#4CAF50;">${statistik.hadir}</span><span class="lbl">Hadir</span></div>
            <div class="stat-mini"><span class="num" style="color:#FF9800;">${statistik.izin}</span><span class="lbl">Izin</span></div>
            <div class="stat-mini"><span class="num" style="color:#3F51B5;">${statistik.sakit}</span><span class="lbl">Sakit</span></div>
            <div class="stat-mini"><span class="num" style="color:#F44336;">${statistik.alpa}</span><span class="lbl">Alpa</span></div>
            <div class="stat-mini"><span class="num" style="color:#475569;">${statistik.total_siswa}</span><span class="lbl">Total</span></div>
        </div>

        <!-- Tabel Siswa -->
        <h4 style="margin:16px 0 10px; color:#1e293b;"><i class="fas fa-users"></i> Daftar Kehadiran Siswa</h4>
        <div class="table-responsive">
            <table class="history-table">
                <thead><tr><th>No</th><th>Nama</th><th>NISN</th><th>Status</th><th>Keterangan</th><th>Aksi</th></tr></thead>
                <tbody>${siswaTabel}</tbody>
            </table>
        </div>

        <!-- Log Book Audit Trail -->
        <h4 style="margin:20px 0 10px; color:#1e293b;"><i class="fas fa-history"></i> Riwayat Perubahan (Log Book)</h4>
        <div style="max-height:200px; overflow-y:auto; border:1px solid #e2e8f0; border-radius:8px; padding:12px;">
            ${logItems}
        </div>
    `;
}

// ─── EDIT STATUS ABSENSI ──────────────────────────────────────
async function editAbsensi(absensiId, currentStatus) {
    const token   = getToken(); if (!token) return;
    const statuses = ['hadir', 'izin', 'sakit', 'alpa'];
    const selected = prompt(
        `Ubah status kehadiran:\n1. hadir\n2. izin\n3. sakit\n4. alpa\n\nStatus saat ini: ${currentStatus}\nMasukkan status baru:`
    );
    if (!selected || !statuses.includes(selected.toLowerCase())) {
        if (selected !== null) alert('Status tidak valid. Gunakan: hadir, izin, sakit, atau alpa');
        return;
    }

    try {
        const res  = await fetch(`/api/guru/absensi/${absensiId}`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: selected.toLowerCase() })
        });
        const data = await res.json();
        if (res.ok && data.success) {
            alert('✅ Status berhasil diubah!');
            openDetailModal(currentDetailAbsenId);
        } else {
            alert('Gagal mengubah status: ' + (data.message || ''));
        }
    } catch (e) {
        console.error(e);
        alert('Terjadi kesalahan');
    }
}

// ─── HELPER ──────────────────────────────────────────────────
function formatDate(dateStr) {
    if (!dateStr) return '-';
    return new Date(dateStr).toLocaleDateString('id-ID', { day:'2-digit', month:'long', year:'numeric' });
}
function formatDateTime(dtStr) {
    if (!dtStr) return '-';
    return new Date(dtStr).toLocaleString('id-ID', { day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit' });
}

window.onclick = function (event) {
    ['absenModal', 'detailModal'].forEach(id => {
        const m = document.getElementById(id);
        if (event.target === m) m.style.display = 'none';
    });
};
</script>
@endpush
