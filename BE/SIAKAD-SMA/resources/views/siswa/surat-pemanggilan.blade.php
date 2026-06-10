@extends('layouts.app')
@php $role = 'siswa'; @endphp

@section('title', 'Surat Pemanggilan - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Surat Pemanggilan')
@section('breadcrumb', 'Siswa / Surat Pemanggilan')

@section('content')
<!-- Welcome Banner -->
<div class="welcome-card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
    <div class="welcome-content">
        <h2>Surat Pemanggilan</h2>
        <p>Daftar surat pemanggilan dari guru BK dan sekolah</p>
    </div>
    <div class="welcome-icon">
        <i class="fas fa-envelope fa-3x"></i>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="stat-info">
            <h3 id="totalSurat">0</h3>
            <p>Total Surat</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <i class="fas fa-envelope-open"></i>
        </div>
        <div class="stat-info">
            <h3 id="unreadSurat">0</h3>
            <p>Belum Dibaca</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3 id="readSurat">0</h3>
            <p>Sudah Dibaca</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h3 id="followUpSurat">0</h3>
            <p>Perlu Tindak Lanjut</p>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-filter"></i> Filter Surat</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <label>Status</label>
                <select class="form-control" id="filterStatus">
                    <option value="all">Semua Status</option>
                    <option value="unread">Belum Dibaca</option>
                    <option value="read">Sudah Dibaca</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Pengirim</label>
                <select class="form-control" id="filterSender">
                    <option value="all">Semua Pengirim</option>
                    <option value="bk">Guru BK</option>
                    <option value="admin">Tata Usaha</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Bulan</label>
                <select class="form-control" id="filterMonth">
                    <option value="all">Semua Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>&nbsp;</label>
                <button class="btn btn-primary btn-block" onclick="applyFilter()">
                    <i class="fas fa-search"></i> Terapkan Filter
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Letters List -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-list"></i> Daftar Surat Pemanggilan</h3>
    </div>
    <div class="card-body">
        <div class="letter-list" id="letterList">
            <div class="empty-state">Memuat surat pemanggilan...</div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .letter-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .letter-item {
        display: flex;
        align-items: start;
        gap: 16px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #ddd;
        cursor: pointer;
        transition: all 0.3s;
    }

    .letter-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }

    .letter-item.unread {
        background: #fff3cd;
        border-left-color: #ffc107;
    }

    .letter-item.unread:hover {
        background: #ffe69c;
    }

    .letter-icon {
        font-size: 32px;
        color: #666;
        min-width: 50px;
        text-align: center;
    }

    .letter-item.unread .letter-icon {
        color: #ffc107;
    }

    .letter-content {
        flex: 1;
    }

    .letter-content h4 {
        margin: 0 0 8px 0;
        font-size: 18px;
        color: #333;
    }

    .letter-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 12px;
        font-size: 14px;
        color: #666;
    }

    .letter-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .letter-preview {
        margin: 0;
        font-size: 14px;
        color: #555;
        line-height: 1.5;
    }

    .letter-actions {
        display: flex;
        align-items: center;
    }

    .empty-state {
        color: #6c757d;
        padding: 24px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .letter-item {
            flex-direction: column;
        }

        .letter-actions {
            width: 100%;
        }

        .letter-actions .btn {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let suratData = [];

    function getToken() {
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Token autentikasi tidak ditemukan. Silakan login ulang.');
            return null;
        }
        return token;
    }

    async function fetchCurrentUser() {
        const token = getToken();
        if (!token) return null;

        const response = await fetch('/api/me', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            console.error('Gagal mengambil data user', response.statusText);
            return null;
        }

        const result = await response.json();
        return result.data.profile;
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        if (Number.isNaN(date.getTime())) {
            return dateString;
        }
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }

    function mapSuratToView(surat) {
        // Do not treat 'sent' as 'read' by default. Mark as unread until explicitly opened/read.
        const isRead = surat.read_at || false;
        const statusValue = isRead ? 'read' : 'unread';
        const statusLabel = isRead ? 'Sudah Dibaca' : (surat.status === 'sent' ? 'Terkirim' : 'Belum Dibaca');
        const badgeClass = isRead ? 'badge-success' : (surat.status === 'sent' ? 'badge-info' : 'badge-danger');

        return {
            id: surat.id,
            title: surat.nomor_surat ? `Surat Pemanggilan - ${surat.nomor_surat}` : 'Surat Pemanggilan',
            sender: surat.bk?.nama ? `${surat.bk.nama} (Guru BK)` : 'BK',
            senderType: 'bk',
            date: formatDate(surat.tanggal_surat),
            status: statusValue,
            statusLabel,
            badgeClass,
            preview: surat.perihal,
            detail: `Perihal: ${surat.perihal}\nTanggal Panggilan: ${formatDate(surat.tanggal_panggilan)}\nWaktu: ${surat.waktu_panggilan}\n\n${surat.keterangan ?? ''}`,
            month: new Date(surat.tanggal_surat).getMonth() + 1
        };
    }

    function renderStats() {
        const total = suratData.length;
        const unread = suratData.filter(letter => letter.status === 'unread').length;
        const read = suratData.filter(letter => letter.status === 'read').length;
        const followUp = suratData.filter(letter => letter.status === 'unread').length;

        document.getElementById('totalSurat').textContent = total;
        document.getElementById('unreadSurat').textContent = unread;
        document.getElementById('readSurat').textContent = read;
        document.getElementById('followUpSurat').textContent = followUp;
    }

    function renderLetters(letters) {
        const list = document.getElementById('letterList');
        list.innerHTML = '';

        if (!letters.length) {
            list.innerHTML = '<div class="empty-state">Tidak ada surat pemanggilan yang sesuai filter.</div>';
            return;
        }

        letters.forEach(letter => {
            const item = document.createElement('div');
            item.className = `letter-item ${letter.status}`;
            item.onclick = () => openLetter(letter.id);
            item.innerHTML = `
                <div class="letter-icon">
                    <i class="fas ${letter.status === 'unread' ? 'fa-envelope' : 'fa-envelope-open'}"></i>
                </div>
                <div class="letter-content">
                    <h4>${letter.title}</h4>
                    <p class="letter-meta">
                        <span><i class="fas fa-user"></i> ${letter.sender}</span>
                        <span><i class="fas fa-calendar"></i> ${letter.date}</span>
                        <span class="badge ${letter.badgeClass}">${letter.statusLabel}</span>
                    </p>
                    <p class="letter-preview">${letter.preview}</p>
                </div>
                <div class="letter-actions">
                    <button class="btn btn-sm btn-info" onclick="event.stopPropagation(); openLetter(${letter.id})">
                        <i class="fas fa-eye"></i> Lihat
                    </button>
                </div>
            `;
            list.appendChild(item);
        });
    }

    async function fetchSuratData() {
        const siswa = await fetchCurrentUser();
        if (!siswa || !siswa.id) {
            document.getElementById('letterList').innerHTML = '<div class="empty-state">Anda harus login untuk melihat surat.</div>';
            return;
        }

        const token = getToken();
        if (!token) return;

        const response = await fetch(`/api/siswa/surat-pemanggilan-saya/${siswa.id}`, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            console.error('Gagal mengambil surat pemanggilan siswa', response.statusText);
            document.getElementById('letterList').innerHTML = '<div class="empty-state">Gagal memuat data surat pemanggilan.</div>';
            return;
        }

        const result = await response.json();
        suratData = (result.data || []).map(mapSuratToView);
        renderStats();
        renderLetters(suratData);
    }

    function applyFilter() {
        const status = document.getElementById('filterStatus').value;
        const sender = document.getElementById('filterSender').value;
        const month = document.getElementById('filterMonth').value;

        const filtered = suratData.filter(letter => {
            const statusMatch = status === 'all' || letter.status === status;
            const senderMatch = sender === 'all' || letter.senderType === sender;
            const monthMatch = month === 'all' || Number(month) === letter.month;
            return statusMatch && senderMatch && monthMatch;
        });

        renderLetters(filtered);
    }

    function openLetter(id) {
        const letterIndex = suratData.findIndex(item => item.id === id);
        if (letterIndex === -1) {
            alert('Surat tidak ditemukan');
            return;
        }

        const letter = suratData[letterIndex];

        // Optimistic update: immediately mark as read in UI
        suratData[letterIndex].status = 'read';
        suratData[letterIndex].statusLabel = 'Sudah Dibaca';
        suratData[letterIndex].badgeClass = 'badge-success';
        renderStats();
        renderLetters(suratData);

        // Mark as read on server (best-effort)
        (async () => {
            const token = getToken();
            if (token) {
                try {
                    const resp = await fetch(`/api/siswa/surat-pemanggilan/${id}/read`, {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${token}`,
                            'Accept': 'application/json'
                        }
                    });

                    if (!resp.ok) {
                        console.warn('Server gagal menandai surat sebagai dibaca');
                    }
                } catch (e) {
                    console.error('Gagal menandai surat sebagai dibaca', e);
                }
            }

            // Show details using updated local state
            const updated = suratData[letterIndex] || letter;
            alert(`Judul: ${updated.title}\nTanggal: ${updated.date}\nPengirim: ${updated.sender}\nStatus: ${updated.statusLabel}\n\n${updated.detail}`);
        })();
    }

    document.addEventListener('DOMContentLoaded', fetchSuratData);
</script>
@endpush