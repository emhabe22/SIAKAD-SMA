@extends('layouts.app')

@section('title', 'Feedback - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Feedback')
@section('breadcrumb', 'BK / Feedback')

@php
    $role = 'bk';
    $userName = 'Siti Nurhaliza, S.Pd';
    $userRole = 'Guru BK';
@endphp

@section('content')
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-comments"></i> Daftar Feedback</h3>
        <button class="btn btn-primary" onclick="showFeedbackForm()">
            <i class="fas fa-plus"></i> Beri Feedback Baru
        </button>
    </div>
    <div class="card-body">
        <div class="feedback-list">
            <div class="feedback-item">
                <div class="feedback-header">
                    <div class="student-info">
                        <img src="https://via.placeholder.com/50" alt="Avatar" class="avatar">
                        <div>
                            <h4>Andi Pratama</h4>
                            <small>XII IPA 1</small>
                        </div>
                    </div>
                    <span class="badge badge-success">Sudah Dibaca</span>
                </div>
                <div class="feedback-content">
                    <h5>Terima kasih atas bimbingannya</h5>
                    <p>Terima kasih atas bimbingan bapak/ibu. Saya sudah bisa mengatasi masalah belajar saya dan nilai semakin membaik.</p>
                </div>
                <div class="feedback-meta">
                    <span><i class="fas fa-clock"></i> 15 Jan 2024, 09:30</span>
                    <div class="feedback-actions">
                        <button class="btn btn-sm btn-primary" onclick="replyFeedback(1)">
                            <i class="fas fa-reply"></i> Balas
                        </button>
                        <button class="btn btn-sm btn-secondary" onclick="viewFeedback(1)">
                            <i class="fas fa-eye"></i> Lihat
                        </button>
                    </div>
                </div>
            </div>

            <div class="feedback-item">
                <div class="feedback-header">
                    <div class="student-info">
                        <img src="https://via.placeholder.com/50" alt="Avatar" class="avatar">
                        <div>
                            <h4>Siti Nurhaliza</h4>
                            <small>XI IPS 2 - Orang Tua</small>
                        </div>
                    </div>
                    <span class="badge badge-warning">Belum Dibaca</span>
                </div>
                <div class="feedback-content">
                    <h5>Feedback konseling karir</h5>
                    <p>Anak saya sangat terbantu dengan sesi konseling karir kemarin. Sekarang dia lebih fokus pada tujuan masa depannya.</p>
                </div>
                <div class="feedback-meta">
                    <span><i class="fas fa-clock"></i> 14 Jan 2024, 14:15</span>
                    <div class="feedback-actions">
                        <button class="btn btn-sm btn-primary" onclick="replyFeedback(2)">
                            <i class="fas fa-reply"></i> Balas
                        </button>
                        <button class="btn btn-sm btn-secondary" onclick="viewFeedback(2)">
                            <i class="fas fa-eye"></i> Lihat
                        </button>
                    </div>
                </div>
            </div>

            <div class="feedback-item">
                <div class="feedback-header">
                    <div class="student-info">
                        <img src="https://via.placeholder.com/50" alt="Avatar" class="avatar">
                        <div>
                            <h4>Rizki Ramadhan</h4>
                            <small>X MIPA</small>
                        </div>
                    </div>
                    <span class="badge badge-danger">Urgent</span>
                </div>
                <div class="feedback-content">
                    <h5>Permintaan follow up</h5>
                    <p>Saya ingin melanjutkan konseling untuk masalah sosial yang belum tuntas. Kapan kita bisa bertemu lagi?</p>
                </div>
                <div class="feedback-meta">
                    <span><i class="fas fa-clock"></i> 13 Jan 2024, 10:45</span>
                    <div class="feedback-actions">
                        <button class="btn btn-sm btn-primary" onclick="replyFeedback(3)">
                            <i class="fas fa-reply"></i> Balas
                        </button>
                        <button class="btn btn-sm btn-secondary" onclick="viewFeedback(3)">
                            <i class="fas fa-eye"></i> Lihat
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="stats-grid" style="margin-top: 24px;">
    <div class="stat-card">
        <div class="stat-icon" style="background: #FF9800;">
            <i class="fas fa-inbox"></i>
        </div>
        <div class="stat-info">
            <h3>12</h3>
            <p>Feedback Masuk</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #4CAF50;">
            <i class="fas fa-check"></i>
        </div>
        <div class="stat-info">
            <h3>8</h3>
            <p>Sudah Dibalas</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #2196F3;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h3>4</h3>
            <p>Menunggu</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #F44336;">
            <i class="fas fa-exclamation"></i>
        </div>
        <div class="stat-info">
            <h3>2</h3>
            <p>Urgent</p>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div id="feedbackModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Beri Feedback Baru</h3>
            <span class="close" onclick="closeFeedbackForm()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="feedbackForm">
                <div class="form-group">
                    <label>Kepada</label>
                    <select class="form-control" required>
                        <option value="">Pilih penerima</option>
                        <option>Siswa - Andi Pratama (XII IPA 1)</option>
                        <option>Guru - Bu Ani (Matematika)</option>
                        <option>Orang Tua - Bapak Budi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Subjek</label>
                    <input type="text" class="form-control" placeholder="Masukkan subjek" required>
                </div>
                <div class="form-group">
                    <label>Pesan</label>
                    <textarea class="form-control" rows="4" placeholder="Tulis pesan feedback..." required></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeFeedbackForm()">Batal</button>
            <button class="btn btn-primary" onclick="submitFeedback()">
                <i class="fas fa-paper-plane"></i> Kirim
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function showFeedbackForm() {
        document.getElementById('feedbackModal').style.display = 'block';
    }

    function closeFeedbackForm() {
        document.getElementById('feedbackModal').style.display = 'none';
    }

    function replyFeedback(id) {
        alert('Membalas feedback #' + id);
    }

    function viewFeedback(id) {
        alert('Melihat detail feedback #' + id);
    }

    function submitFeedback() {
        alert('Feedback berhasil dikirim!');
        closeFeedbackForm();
    }

    window.onclick = function(event) {
        const modal = document.getElementById('feedbackModal');
        if (event.target === modal) {
            closeFeedbackForm();
        }
    }
</script>

<style>
    .feedback-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .feedback-item {
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 20px;
        background: #f8f9fa;
    }

    .feedback-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .student-info .avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }

    .student-info h4 {
        margin: 0;
        font-size: 16px;
    }

    .student-info small {
        color: #666;
    }

    .feedback-content {
        margin-bottom: 15px;
    }

    .feedback-content h5 {
        margin: 0 0 8px 0;
        color: #333;
    }

    .feedback-content p {
        margin: 0;
        color: #666;
    }

    .feedback-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #ddd;
        font-size: 14px;
        color: #777;
    }

    .feedback-actions {
        display: flex;
        gap: 8px;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-success { background: #4CAF50; color: white; }
    .badge-warning { background: #FF9800; color: white; }
    .badge-danger { background: #F44336; color: white; }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background: white;
        margin: 5% auto;
        padding: 0;
        border-radius: 12px;
        width: 90%;
        max-width: 600px;
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
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        color: #999;
    }

    .close:hover {
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #555;
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
    }

    .form-control:focus {
        outline: none;
        border-color: #2196F3;
        box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
    }
</style>
@endpush
