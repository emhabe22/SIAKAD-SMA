@extends('layouts.app')

@section('title', 'Surat Pemanggilan - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Surat Pemanggilan')
@section('breadcrumb', 'BK / Surat Pemanggilan')

@php
    $role = 'bk';
    $userName = 'Siti Nurhaliza, S.Pd';
    $userRole = 'Guru BK';
@endphp

@section('content')
<!-- Quick Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #2196F3;">
            <i class="fas fa-paper-plane"></i>
        </div>
        <div class="stat-info">
            <h3 id="sentCount">0</h3>
            <p>Terkirim</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #4CAF50;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3 id="confirmedCount">0</h3>
            <p>Dikonfirmasi</p>
        </div>
    </div>
</div>
  <div class="modal" id="letterModal">
            <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
                <button type="button" class="btn-icon modal-close" onclick="closeLetterModal()"><i class="fas fa-times"></i></button>
                <h4 id="modalTitle">Buat Surat Pemanggilan</h4>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Siswa</label>
                        <select id="letterSiswa" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label>Nomor Surat</label>
                        <input type="text" id="letterNomor" class="form-control" placeholder="Nomor surat" />
                    </div>
                    <div class="form-group">
                        <label>Perihal</label>
                        <input type="text" id="letterPerihal" class="form-control" placeholder="Perihal surat" />
                    </div>
                    <div class="form-group">
                        <label>Tanggal Surat</label>
                        <input type="date" id="letterTanggalSurat" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Tanggal Panggilan</label>
                        <input type="date" id="letterTanggalPanggilan" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Waktu Panggilan</label>
                        <input type="time" id="letterWaktuPanggilan" class="form-control" />
                    </div>
                    <div class="form-group form-group-full">
                        <label>Keterangan</label>
                        <textarea id="letterKeterangan" class="form-control" rows="4" placeholder="Isi keterangan surat"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" onclick="closeLetterModal()" type="button">Batal</button>
                    <button class="btn btn-primary" onclick="saveLetterDraft()" type="button">Simpan Draft</button>
                </div>
            </div>
        </div>
<div class="card">
    <div class="card-header">
        <h3 id="tabTitle">Surat Pemanggilan</h3>
        <div class="card-actions">
            <button type="button" class="btn-icon" onclick="exportLetters()">
                <i class="fas fa-download"></i>
            </button>
            <button type="button" class="btn-icon" onclick="printLetters()">
                <i class="fas fa-print"></i>
            </button>
            <button type="button" class="btn btn-primary" onclick="openCreateLetterModal()" style="margin-left: 12px;">
                <i class="fas fa-plus"></i> Buat Surat Pemanggilan
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-buttons">
            <button class="tab-btn active" onclick="switchTab('draft')">Draft</button>
            <button class="tab-btn" onclick="switchTab('sent')">Terkirim</button>
        </div>

        <div class="letters-container" id="draftTab"></div>
        <div class="letters-container" id="sentTab" style="display: none;"></div>

      

        <div class="pagination" id="paginationControls" style="display:none;">
            <button class="page-btn" disabled>
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="page-btn active">1</button>
            <button class="page-btn">2</button>
            <button class="page-btn">3</button>
            <button class="page-btn">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-history"></i> Aktivitas Terkait Surat</h3>
    </div>
    <div class="card-body">
        <div class="activity-timeline" id="activityTimeline">
            <div class="empty-state">Memuat aktivitas surat...</div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .tab-buttons {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
    }
    .tab-btn {
        border: 1px solid #dee2e6;
        background: #fff;
        color: #495057;
        padding: 10px 18px;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.25s ease;
    }
    .tab-btn.active, .tab-btn:hover {
        background: #f2f6fb;
    }
    .letters-container {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .letter-card {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 20px;
        background: #fff;
        box-shadow: 0 4px 12px rgb(0 0 0 / 5%);
    }
    .letter-header {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        align-items: flex-start;
        margin-bottom: 16px;
    }
    .letter-info h4 {
        margin: 0 0 8px;
    }
    .letter-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        font-size: 14px;
        color: #6c757d;
    }
    .letter-meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .letter-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: flex-end;
    }
    .btn-icon {
        border: 1px solid #dee2e6;
        background: #fff;
        color: #495057;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: background 0.25s ease;
    }
    .btn-icon:hover {
        background: #f2f6fb;
    }
    .btn-icon.btn-success {
        background: #4CAF50;
        color: #fff;
    }
    .btn-icon.btn-danger {
        background: #f44336;
        color: #fff;
    }
    .letter-content {
        margin-top: 8px;
        color: #495057;
        line-height: 1.7;
    }
    .activity-timeline {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .activity-item {
        display: flex;
        gap: 16px;
        padding: 18px;
        border-radius: 10px;
        background: #f8f9fa;
    }
   .modal {
    display: none;
    position: fixed;
    inset: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.42);
    align-items: center;
    justify-content: center;
    z-index: 99999;
    padding: 24px;
}

.modal.show {
    display: flex;
}

.modal-content {
    width: 100%;
    max-width: 760px;
    background: #fff;
    border-radius: 16px;
    padding: 28px;
    position: relative;
    box-shadow: 0 20px 70px rgba(0, 0, 0, 0.15);
    max-height: calc(100vh - 80px);
    overflow-y: auto;
}
    .modal-close {
        position: absolute;
        top: 18px;
        right: 18px;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        margin-top: 18px;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .form-group-full {
        grid-column: 1 / -1;
    }
    .modal-content label {
        font-weight: 600;
        color: #343a40;
    }
    .modal-content .form-control {
        width: 100%;
        border: 1px solid #dfe3e8;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 14px;
        color: #495057;
        background: #fff;
    }
    .modal-content textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 22px;
    }
    @media (max-width: 900px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
    .activity-icon {
        font-size: 24px;
        color: #2196F3;
        min-width: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .activity-content h5 {
        margin: 0 0 8px;
    }
    .activity-time {
        display: block;
        margin-top: 10px;
        color: #6c757d;
        font-size: 13px;
    }
    .empty-state {
        color: #6c757d;
        padding: 24px;
        text-align: center;
    }
    @media (max-width: 768px) {
        .letter-header {
            flex-direction: column;
            align-items: stretch;
        }
        .letter-actions {
            justify-content: flex-start;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    let suratData = [];
    let siswaOptions = [];
    let currentLetterId = null;

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

    function mapSuratToLetter(surat) {
        const statusValue = surat.status === 'sent' ? 'sent' : 'draft';
        const statusLabel = surat.status === 'sent' ? 'Terkirim' : 'Draft';
        const sender = surat.siswa?.nama ? `${surat.siswa.nama} (${surat.siswa.tingkat})` : 'Siswa';

        return {
            id: surat.id,
            siswa_id: surat.siswa_id,
            nomor_surat: surat.nomor_surat,
            perihal: surat.perihal,
            tanggal_surat: surat.tanggal_surat,
            tanggal_panggilan: surat.tanggal_panggilan,
            waktu_panggilan: surat.waktu_panggilan,
            keterangan: surat.keterangan,
            title: surat.nomor_surat ? `Surat Pemanggilan - ${surat.nomor_surat}` : `Surat Pemanggilan - ${sender}`,
            studentName: surat.siswa?.nama ?? 'Siswa',
            meta: sender,
            date: formatDate(surat.tanggal_surat),
            status: statusValue,
            statusLabel,
            description: `Perihal: ${surat.perihal}. Jadwal panggilan: ${formatDate(surat.tanggal_panggilan)} ${surat.waktu_panggilan}.`,
            detail: surat.keterangan || `Perihal: ${surat.perihal}. Jadwal panggilan: ${formatDate(surat.tanggal_panggilan)} ${surat.waktu_panggilan}.`,
            updated_at: surat.updated_at,
        };
    }

    function renderStats() {
        const sentCount = suratData.filter(letter => letter.status === 'sent').length;
        const confirmedCount = sentCount;

        document.getElementById('sentCount').textContent = sentCount;
        document.getElementById('confirmedCount').textContent = confirmedCount;
    }

    function renderLetters() {
        const draftList = document.getElementById('draftTab');
        const sentList = document.getElementById('sentTab');

        draftList.innerHTML = '';
        sentList.innerHTML = '';

        const draftLetters = suratData.filter(letter => letter.status === 'draft');
        const sentLetters = suratData.filter(letter => letter.status === 'sent');

        if (!draftLetters.length) {
            draftList.innerHTML = '<div class="empty-state">Tidak ada draft surat.</div>';
        }
        if (!sentLetters.length) {
            sentList.innerHTML = '<div class="empty-state">Tidak ada surat terkirim.</div>';
        }

        draftLetters.forEach(letter => {
            const card = document.createElement('div');
            card.className = 'letter-card';
            card.innerHTML = `
                <div class="letter-header">
                    <div class="letter-info">
                        <h4>${letter.title}</h4>
                        <div class="letter-meta">
                            <span><i class="fas fa-user"></i> ${letter.meta}</span>
                            <span><i class="fas fa-calendar"></i> Dibuat: ${letter.date}</span>
                            <span><i class="fas fa-clock"></i> Status: <strong>${letter.statusLabel}</strong></span>
                        </div>
                    </div>
                    <div class="letter-actions">
                        <button class="btn-icon" onclick="event.stopPropagation(); editLetter(${letter.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon btn-success" onclick="event.stopPropagation(); sendLetter(${letter.id})">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                        <button class="btn-icon btn-danger" onclick="event.stopPropagation(); deleteLetter(${letter.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="letter-content">
                    ${letter.description}
                </div>
            `;
            draftList.appendChild(card);
        });

        sentLetters.forEach(letter => {
            const card = document.createElement('div');
            card.className = 'letter-card';
            card.innerHTML = `
                <div class="letter-header">
                    <div class="letter-info">
                        <h4>${letter.title}</h4>
                        <div class="letter-meta">
                            <span><i class="fas fa-user"></i> ${letter.meta}</span>
                            <span><i class="fas fa-calendar"></i> Dikirim: ${letter.date}</span>
                            <span><i class="fas fa-clock"></i> Status: <strong>${letter.statusLabel}</strong></span>
                        </div>
                    </div>
                    <div class="letter-actions">
                        <button class="btn-icon" onclick="event.stopPropagation(); viewLetter(${letter.id})">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-icon" onclick="event.stopPropagation(); resendLetter(${letter.id})">
                            <i class="fas fa-redo"></i>
                        </button>
                        <button class="btn-icon" onclick="event.stopPropagation(); printSingleLetter(${letter.id})">
                            <i class="fas fa-print"></i>
                        </button>
                    </div>
                </div>
                <div class="letter-content">
                    ${letter.description}
                </div>
            `;
            sentList.appendChild(card);
        });
    }

    function renderActivity() {
        const container = document.getElementById('activityTimeline');
        if (!suratData.length) {
            container.innerHTML = '<div class="empty-state">Belum ada aktivitas surat.</div>';
            return;
        }

        const activities = suratData
            .map(letter => ({
                id: letter.id,
                title: letter.status === 'draft' ? `Draft dibuat untuk ${letter.studentName}` : `Surat terkirim untuk ${letter.studentName}`,
                description: letter.detail,
                date: letter.date,
                icon: letter.status === 'draft' ? 'fa-envelope' : 'fa-paper-plane'
            }))
            .sort((a,b) => new Date(b.date) - new Date(a.date));

        container.innerHTML = '';
        activities.forEach(activity => {
            const item = document.createElement('div');
            item.className = 'activity-item';
            item.innerHTML = `
                <div class="activity-icon">
                    <i class="fas ${activity.icon}"></i>
                </div>
                <div class="activity-content">
                    <h5>${activity.title}</h5>
                    <p>${activity.description}</p>
                    <span class="activity-time">${activity.date}</span>
                </div>
            `;
            container.appendChild(item);
        });
    }

    async function fetchSiswaOptions() {
        const token = getToken();
        if (!token) return;

        const response = await fetch('/api/bk/siswa', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            console.error('Gagal mengambil daftar siswa', response.statusText);
            return;
        }

        const result = await response.json();
        siswaOptions = result.data || [];
        const select = document.getElementById('letterSiswa');
        select.innerHTML = '<option value="">Pilih siswa</option>';
        siswaOptions.forEach(siswa => {
            const opt = document.createElement('option');
            opt.value = siswa.id;
            opt.textContent = siswa.nama || `Siswa #${siswa.id}`;
            select.appendChild(opt);
        });
    }

    function closeLetterModal() {
        document.getElementById('letterModal').classList.remove('show');
    }

    function openCreateLetterModal() {
        currentLetterId = null;
        document.getElementById('modalTitle').textContent = 'Buat Surat Pemanggilan Baru';
        document.getElementById('letterSiswa').value = '';
        document.getElementById('letterNomor').value = '';
        document.getElementById('letterPerihal').value = '';
        document.getElementById('letterTanggalSurat').value = '';
        document.getElementById('letterTanggalPanggilan').value = '';
        document.getElementById('letterWaktuPanggilan').value = '';
        document.getElementById('letterKeterangan').value = '';
        document.getElementById('letterModal').classList.add('show');
    }

    document.getElementById('letterModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeLetterModal();
        }
    });

    async function fetchSuratData() {
        const profile = await fetchCurrentUser();
        if (!profile || !profile.id) {
            document.getElementById('activityTimeline').innerHTML = '<div class="empty-state">Anda harus login untuk melihat data surat.</div>';
            return;
        }

        const token = getToken();
        if (!token) return;

        const response = await fetch('/api/bk/surat-pemanggilan', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            console.error('Gagal mengambil data surat pemanggilan', response.statusText);
            document.getElementById('activityTimeline').innerHTML = '<div class="empty-state">Gagal memuat data surat pemanggilan.</div>';
            return;
        }

        const result = await response.json();
        suratData = (result.data || []).map(mapSuratToLetter);
        renderStats();
        renderLetters();
        renderActivity();
    }

    async function initializePage() {
        await fetchCurrentUser();
        await fetchSiswaOptions();
        await fetchSuratData();
    }

    async function sendLetter(id) {
        if (!confirm('Kirim surat ini?')) return;
        const token = getToken();
        if (!token) return;

        const response = await fetch(`/api/bk/surat-pemanggilan/${id}/send`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            alert('Gagal mengirim surat.');
            return;
        }

        await fetchSuratData();
    }

    async function resendLetter(id) {
        if (!confirm('Kirim ulang surat ini?')) return;
        await sendLetter(id);
    }

    async function deleteLetter(id) {
        if (!confirm('Hapus surat ini?')) return;
        const token = getToken();
        if (!token) return;

        const response = await fetch(`/api/bk/surat-pemanggilan/${id}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            alert('Gagal menghapus surat.');
            return;
        }

        await fetchSuratData();
    }

    function editLetter(id) {
        const letter = suratData.find(item => item.id === id);
        if (!letter) {
            alert('Surat tidak ditemukan');
            return;
        }
        currentLetterId = id;
        document.getElementById('modalTitle').textContent = 'Edit Surat Pemanggilan';
        document.getElementById('letterSiswa').value = letter.siswa_id || '';
        document.getElementById('letterNomor').value = letter.nomor_surat || '';
        document.getElementById('letterPerihal').value = letter.perihal || '';
        document.getElementById('letterTanggalSurat').value = letter.tanggal_surat || '';
        document.getElementById('letterTanggalPanggilan').value = letter.tanggal_panggilan || '';
        document.getElementById('letterWaktuPanggilan').value = letter.waktu_panggilan || '';
        document.getElementById('letterKeterangan').value = letter.keterangan || '';
        document.getElementById('letterModal').classList.add('show');
    }

    async function saveLetterDraft() {
        const token = getToken();
        if (!token) return;

        const payload = {
            siswa_id: document.getElementById('letterSiswa').value,
            nomor_surat: document.getElementById('letterNomor').value,
            perihal: document.getElementById('letterPerihal').value,
            tanggal_surat: document.getElementById('letterTanggalSurat').value,
            tanggal_panggilan: document.getElementById('letterTanggalPanggilan').value,
            waktu_panggilan: document.getElementById('letterWaktuPanggilan').value,
            keterangan: document.getElementById('letterKeterangan').value,
            status: 'draft'
        };

        // Basic client-side validation
        if (!payload.siswa_id) { alert('Pilih siswa terlebih dahulu.'); return; }
        if (!payload.perihal || !payload.perihal.trim()) { alert('Isikan perihal surat.'); return; }
        if (!payload.tanggal_surat) { alert('Pilih tanggal surat.'); return; }
        if (!payload.tanggal_panggilan) { alert('Pilih tanggal panggilan.'); return; }
        if (!payload.waktu_panggilan) { alert('Isikan waktu panggilan.'); return; }

        const method = currentLetterId ? 'PUT' : 'POST';
        const url = currentLetterId ? `/api/bk/surat-pemanggilan/${currentLetterId}` : '/api/bk/surat-pemanggilan';

        try {
            const response = await fetch(url, {
                method,
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            if (response.ok) {
                closeLetterModal();
                await fetchSuratData();
                return;
            }

            // Try to parse server response for validation errors
            let result = null;
            try { result = await response.json(); } catch (e) { /* ignore parse error */ }

            if (response.status === 422 && result && result.errors) {
                const messages = Object.values(result.errors).flat().join('\n');
                alert('Validasi gagal:\n' + messages);
                return;
            }

            if (result && result.message) {
                alert('Gagal menyimpan surat: ' + result.message);
                return;
            }

            alert('Gagal menyimpan surat. Periksa kembali data input.');
        } catch (err) {
            console.error('Error saat menyimpan surat:', err);
            alert('Terjadi kesalahan jaringan saat menyimpan surat.');
        }
    }

    function viewLetter(id) {
        const letter = suratData.find(item => item.id === id);
        if (!letter) {
            alert('Surat tidak ditemukan');
            return;
        }
        alert(`Judul: ${letter.title}\nTanggal: ${letter.date}\nStatus: ${letter.statusLabel}\n\n${letter.detail}`);
    }

    function exportLetters() {
        alert('Fitur ekspor surat akan segera tersedia!');
    }

    function printLetters() {
        window.print();
    }

    function printSingleLetter(id) {
        const letter = suratData.find(item => item.id === id);
        if (!letter) {
            alert('Surat tidak ditemukan');
            return;
        }
        alert(`Mencetak surat: ${letter.title}`);
    }

    function switchTab(tabName) {
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.toggle('active', btn.textContent.toLowerCase().includes(tabName));
        });
        document.getElementById('draftTab').style.display = tabName === 'draft' ? 'flex' : 'none';
        document.getElementById('sentTab').style.display = tabName === 'sent' ? 'flex' : 'none';
        document.getElementById('tabTitle').textContent = tabName === 'draft' ? 'Surat Draft' : 'Surat Terkirim';
    }

    document.addEventListener('DOMContentLoaded', initializePage);
</script>
@endpush
