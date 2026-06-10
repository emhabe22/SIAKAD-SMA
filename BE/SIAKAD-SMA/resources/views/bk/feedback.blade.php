@extends('layouts.app')

@section('title', 'Feedback Konseling - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Feedback Konseling')
@section('breadcrumb', 'BK / Feedback Konseling')

@php
    $role = 'bk';
    $userName = 'Siti Nurhaliza, S.Pd';
    $userRole = 'Guru BK';
@endphp

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-comments"></i> Feedback Konseling</h3>
    </div>
    <div class="card-body">
        <div class="filter-section">
            <div class="filter-group">
                <label>Cari Siswa</label>
                <input type="text" id="searchSiswa" class="form-control" placeholder="Ketik nama siswa...">
            </div>
            <div class="filter-group">
                <label>Status Feedback</label>
                <select id="filterStatus" class="form-control">
                    <option value="">Semua</option>
                    <option value="has-feedback">Sudah Diberi Feedback</option>
                    <option value="no-feedback">Belum Ada Feedback</option>
                </select>
            </div>
            <div class="filter-group">
                <button class="btn btn-primary" onclick="applyFilters()">
                    <i class="fas fa-search"></i> Filter
                </button>
            </div>
        </div>

        <div id="konseling-list" class="konseling-list">
            <div style="text-align: center; padding: 40px;">
                <p>Memuat data konseling yang selesai...</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Feedback Form -->
<div id="feedbackModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3>Berikan Feedback Konseling</h3>
            <span class="close" onclick="closeFeedbackModal()">&times;</span>
        </div>
        <div class="modal-body">
            <div id="siswa-info" style="background: #f8f9fa; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                <strong>Siswa:</strong> <span id="info-siswa-nama">-</span><br>
                <strong>Tanggal Konseling:</strong> <span id="info-tanggal">-</span><br>
                <strong>Status:</strong> <span id="info-status">-</span>
            </div>
            <form id="feedbackForm">
                <div class="form-group">
                    <label>Judul Feedback</label>
                    <input type="text" id="feedbackJudul" class="form-control" placeholder="Masukkan judul feedback" required>
                </div>
                <div class="form-group">
                    <label>Isi Feedback</label>
                    <textarea id="feedbackIsi" class="form-control" rows="5" placeholder="Tulis feedback konseling..." required></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeFeedbackModal()">Batal</button>
            <button class="btn btn-primary" onclick="submitFeedback()">
                <i class="fas fa-check"></i> Simpan Feedback
            </button>
        </div>
    </div>
</div>

<!-- Modal View Feedback -->
<div id="viewFeedbackModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <div class="modal-header">
            <h3>Detail Feedback</h3>
            <span class="close" onclick="closeViewFeedbackModal()">&times;</span>
        </div>
        <div class="modal-body">
            <div id="view-siswa-info" style="background: #f8f9fa; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                <strong>Siswa:</strong> <span id="view-siswa-nama">-</span><br>
                <strong>Tanggal Konseling:</strong> <span id="view-tanggal">-</span>
            </div>
            <h5 id="view-feedback-judul"></h5>
            <p id="view-feedback-isi" style="line-height: 1.6;"></p>
            <small style="color: #999;" id="view-feedback-date"></small>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" onclick="editCurrentFeedback()">
                <i class="fas fa-edit"></i> Edit
            </button>
            <button class="btn btn-danger" onclick="deleteCurrentFeedback()">
                <i class="fas fa-trash"></i> Hapus
            </button>
            <button class="btn btn-secondary" onclick="closeViewFeedbackModal()">Tutup</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let allKonseling = [];
    let currentPenjadwalanId = null;
    let currentFeedbackId = null;
    let currentSiswaId = null;

    function getToken() {
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Token autentikasi tidak ditemukan. Silakan login ulang.');
            return null;
        }
        return token;
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        if (Number.isNaN(date.getTime())) return dateString;
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    async function fetchKonselingData() {
        const token = getToken();
        if (!token) return;

        try {
            const response = await fetch('/api/bk/penjadwalan', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Gagal mengambil data konseling');
            }

            const result = await response.json();
            let penjadwalans = result.data || [];

            // Filter hanya yang sudah selesai (status = 1)
            allKonseling = penjadwalans
                .filter(p => p.status === 1 || p.status === '1')
                .map(p => {
                    const siswa = p.siswa || {};
                    return {
                        id: p.id,
                        siswa_id: p.siswa_id,
                        siswa_nama: siswa.nama || 'Siswa',
                        siswa_tingkat: siswa.tingkat || '-',
                        tanggal: p.tanggal || '-',
                        waktu: p.waktu || '-',
                        keterangan: p.keterangan || '-',
                        feedback: p.feedback || null,
                        bk_nama: (p.bk || {}).nama || '-'
                    };
                })
                .sort((a, b) => new Date(b.tanggal) - new Date(a.tanggal));

            renderKonselingList(allKonseling);
        } catch (error) {
            console.error('Error fetching konseling data:', error);
            document.getElementById('konseling-list').innerHTML = 
                '<div style="text-align: center; padding: 40px; color: red;">Gagal memuat data konseling</div>';
        }
    }

    function renderKonselingList(konselingList) {
        const listDiv = document.getElementById('konseling-list');
        
        if (!konselingList || konselingList.length === 0) {
            listDiv.innerHTML = '<div style="text-align: center; padding: 40px;">Tidak ada konseling yang selesai</div>';
            return;
        }

        listDiv.innerHTML = konselingList.map(k => `
            <div class="konseling-card">
                <div class="konseling-header">
                    <div class="konseling-info">
                        <h4>${k.siswa_nama}</h4>
                        <small>${k.siswa_tingkat}</small>
                    </div>
                    ${k.feedback ? 
                        '<span class="badge badge-success">Sudah Diberi Feedback</span>' :
                        '<span class="badge badge-warning">Belum Ada Feedback</span>'
                    }
                </div>
                <div class="konseling-detail">
                    <div class="detail-row">
                        <strong>Tanggal:</strong> ${formatDate(k.tanggal)}
                    </div>
                    <div class="detail-row">
                        <strong>Catatan:</strong> ${k.keterangan}
                    </div>
                </div>
                <div class="konseling-actions">
                    ${k.feedback ?
                        `<button class="btn btn-sm btn-info" onclick="viewFeedback(${k.id}, ${k.siswa_id})">
                            <i class="fas fa-eye"></i> Lihat Feedback
                        </button>` :
                        `<button class="btn btn-sm btn-primary" onclick="openFeedbackForm(${k.id}, '${k.siswa_nama}', '${k.tanggal}', ${k.siswa_id})">
                            <i class="fas fa-comments"></i> Beri Feedback
                        </button>`
                    }
                </div>
            </div>
        `).join('');
    }

    function applyFilters() {
        const searchTerm = document.getElementById('searchSiswa').value.toLowerCase();
        const statusFilter = document.getElementById('filterStatus').value;

        const filtered = allKonseling.filter(k => {
            const nameMatch = k.siswa_nama.toLowerCase().includes(searchTerm);
            const statusMatch = statusFilter === '' ||
                (statusFilter === 'has-feedback' && k.feedback) ||
                (statusFilter === 'no-feedback' && !k.feedback);
            return nameMatch && statusMatch;
        });

        renderKonselingList(filtered);
    }

    function openFeedbackForm(penjadwalanId, siswa_nama, tanggal, siswa_id) {
        currentPenjadwalanId = penjadwalanId;
        currentSiswaId = siswa_id;
        document.getElementById('info-siswa-nama').textContent = siswa_nama;
        document.getElementById('info-tanggal').textContent = formatDate(tanggal);
        document.getElementById('info-status').textContent = 'Selesai';
        document.getElementById('feedbackJudul').value = '';
        document.getElementById('feedbackIsi').value = '';
        document.getElementById('feedbackModal').classList.add('show');
    }

    function closeFeedbackModal() {
        document.getElementById('feedbackModal').classList.remove('show');
    }

    async function submitFeedback() {
        const token = getToken();
        if (!token || !currentPenjadwalanId) return;

        const judul = document.getElementById('feedbackJudul').value;
        const isi = document.getElementById('feedbackIsi').value;

        if (!judul.trim() || !isi.trim()) {
            alert('Judul dan isi feedback tidak boleh kosong');
            return;
        }

        try {
            const response = await fetch(`/api/bk/penjadwalan/${currentPenjadwalanId}/feedback`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ judul, isi })
            });

            const result = await response.json();

            if (!response.ok) {
                alert(result.message || 'Gagal menyimpan feedback');
                return;
            }

            alert('Feedback berhasil diberikan!');
            closeFeedbackModal();
            fetchKonselingData();
        } catch (error) {
            console.error('Error submitting feedback:', error);
            alert('Terjadi kesalahan saat menyimpan feedback');
        }
    }

    async function viewFeedback(penjadwalanId, siswaId) {
        const token = getToken();
        if (!token) return;

        try {
            const response = await fetch(`/api/bk/penjadwalan/${penjadwalanId}/feedback`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();
            const feedback = result.data;

            if (!feedback) {
                alert('Feedback tidak ditemukan');
                return;
            }

            currentFeedbackId = feedback.id;
            currentPenjadwalanId = penjadwalanId;
            currentSiswaId = siswaId;

            // Find konseling data
            const konseling = allKonseling.find(k => k.id === penjadwalanId);
            
            document.getElementById('view-siswa-nama').textContent = konseling.siswa_nama;
            document.getElementById('view-tanggal').textContent = formatDate(konseling.tanggal);
            document.getElementById('view-feedback-judul').textContent = feedback.judul;
            document.getElementById('view-feedback-isi').textContent = feedback.isi;
            document.getElementById('view-feedback-date').textContent = 
                'Dibuat: ' + formatDate(feedback.created_at);

            document.getElementById('viewFeedbackModal').classList.add('show');
        } catch (error) {
            console.error('Error viewing feedback:', error);
            alert('Gagal memuat feedback');
        }
    }

    function closeViewFeedbackModal() {
        document.getElementById('viewFeedbackModal').classList.remove('show');
    }

    async function editCurrentFeedback() {
        closeViewFeedbackModal();
        const judul = document.getElementById('view-feedback-judul').textContent;
        const isi = document.getElementById('view-feedback-isi').textContent;
        const siswa_nama = document.getElementById('view-siswa-nama').textContent;
        const tanggal = document.getElementById('view-tanggal').textContent;

        document.getElementById('info-siswa-nama').textContent = siswa_nama;
        document.getElementById('info-tanggal').textContent = tanggal;
        document.getElementById('info-status').textContent = 'Selesai';
        document.getElementById('feedbackJudul').value = judul;
        document.getElementById('feedbackIsi').value = isi;

        // Change submit to update
        const submitBtn = document.querySelector('#feedbackModal .modal-footer .btn-primary');
        submitBtn.textContent = '📝 Update Feedback';
        submitBtn.onclick = updateFeedback;

        document.getElementById('feedbackModal').classList.add('show');
    }

    async function updateFeedback() {
        const token = getToken();
        if (!token || !currentFeedbackId) return;

        const judul = document.getElementById('feedbackJudul').value;
        const isi = document.getElementById('feedbackIsi').value;

        try {
            const response = await fetch(`/api/bk/feedback/${currentFeedbackId}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ judul, isi })
            });

            const result = await response.json();
            if (!response.ok) {
                alert(result.message || 'Gagal mengubah feedback');
                return;
            }

            alert('Feedback berhasil diubah!');
            closeFeedbackModal();
            fetchKonselingData();

            // Reset button
            const submitBtn = document.querySelector('#feedbackModal .modal-footer .btn-primary');
            submitBtn.textContent = '✓ Simpan Feedback';
            submitBtn.onclick = submitFeedback;
        } catch (error) {
            console.error('Error updating feedback:', error);
            alert('Terjadi kesalahan saat mengubah feedback');
        }
    }

    async function deleteCurrentFeedback() {
        if (!confirm('Yakin ingin menghapus feedback ini?')) return;

        const token = getToken();
        if (!token || !currentFeedbackId) return;

        try {
            const response = await fetch(`/api/bk/feedback/${currentFeedbackId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();
            if (!response.ok) {
                alert(result.message || 'Gagal menghapus feedback');
                return;
            }

            alert('Feedback berhasil dihapus!');
            closeViewFeedbackModal();
            fetchKonselingData();
        } catch (error) {
            console.error('Error deleting feedback:', error);
            alert('Terjadi kesalahan saat menghapus feedback');
        }
    }

    // Modal click outside to close
    window.onclick = function(event) {
        const feedbackModal = document.getElementById('feedbackModal');
        const viewModal = document.getElementById('viewFeedbackModal');
        
        if (event.target === feedbackModal) {
            closeFeedbackModal();
        }
        if (event.target === viewModal) {
            closeViewFeedbackModal();
        }
    }

    // Load data on page load
    document.addEventListener('DOMContentLoaded', function() {
        fetchKonselingData();
    });
</script>

<style>
    .filter-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #eee;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .filter-group label {
        font-weight: 500;
        color: #555;
        font-size: 13px;
    }

    .filter-group input,
    .filter-group select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 13px;
    }

    .konseling-list {
        display: grid;
        gap: 16px;
    }

    .konseling-card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 16px;
        background: #f8f9fa;
        transition: all 0.2s;
    }

    .konseling-card:hover {
        border-color: #667eea;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.1);
    }

    .konseling-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .konseling-info h4 {
        margin: 0 0 4px 0;
        font-size: 16px;
        color: #333;
    }

    .konseling-info small {
        color: #999;
    }

    .badge {
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-success {
        background: #d4edda;
        color: #155724;
    }

    .badge-warning {
        background: #fff3cd;
        color: #856404;
    }

    .konseling-detail {
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #ddd;
    }

    .detail-row {
        font-size: 13px;
        color: #555;
        margin-bottom: 6px;
    }

    .konseling-actions {
        display: flex;
        gap: 8px;
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        font-size: 13px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background: #5568d3;
    }

    .btn-info {
        background: #2196F3;
        color: white;
    }

    .btn-info:hover {
        background: #0b7dda;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 12px;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
    }

    .btn-danger {
        background: #dc3545;
        color: white;
    }

    .btn-danger:hover {
        background: #c82333;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
    }

    .modal.show {
        display: flex;
    }

    .modal-content {
        background: white;
        border-radius: 8px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-footer {
        padding: 20px;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .close {
        font-size: 24px;
        cursor: pointer;
        color: #999;
    }

    .close:hover {
        color: #333;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 500;
        color: #555;
        font-size: 13px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 13px;
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }
</style>
@endpush

