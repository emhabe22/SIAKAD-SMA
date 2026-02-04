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
            <h3>12</h3>
            <p>Terkirim</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #4CAF50;">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>8</h3>
            <p>Dikonfirmasi</p>
        </div>
    </div>

</div>
<div class="card">
    <div class="card-header">
        <h3 id="tabTitle">Surat Pemanggilan</h3>
        <div class="card-actions">
            <button class="btn-icon" >
                <i class="fas fa-download"></i>
            </button>
            <button class="btn-icon" >
                <i class="fas fa-print"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="letters-container" id="draftTab">
            <!-- Draft Letters -->
            <div class="letter-card">
                <div class="letter-header">
                    <div class="letter-info">
                        <h4>Pemanggilan Orang Tua - Andi Pratama</h4>
                        <div class="letter-meta">
                            <span><i class="fas fa-user"></i> Andi Pratama (XII IPA 1)</span>
                            <span><i class="fas fa-calendar"></i> Dibuat: 15 Jan 2024</span>
                            <span><i class="fas fa-clock"></i> Status: <span class="status-draft">Draft</span></span>
                        </div>
                    </div>
                    <div class="letter-actions">
                        <button class="btn-icon" >
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn-icon btn-success" >
                            <i class="fas fa-paper-plane"></i>
                        </button>
                        <button class="btn-icon btn-danger" >
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="letter-content">
                    <p><strong>Perihal:</strong> Pembahasan penurunan nilai akademik dan kehadiran</p>
                    <p><strong>Kepada:</strong> Bapak/Ibu Orang Tua/Wali dari Andi Pratama</p>
                    <p><strong>Agenda:</strong> Konseling mengenai penurunan performa belajar dan rencana perbaikan</p>
                </div>
            </div>
        </div>

        <!-- Sent Letters (hidden by default) -->
        <div class="letters-container" id="sentTab" style="display: none;">
            <div class="letter-card">
                <div class="letter-header">
                    <div class="letter-info">
                        <h4>Pemanggilan - Ahmad Hidayat</h4>
                        <div class="letter-meta">
                            <span><i class="fas fa-user"></i> Ahmad Hidayat (X MIPA 2)</span>
                            <span><i class="fas fa-calendar"></i> Dikirim: 13 Jan 2024</span>
                            <span><i class="fas fa-clock"></i> Status: <span class="status-sent">Terkirim</span></span>
                        </div>
                    </div>
                    <div class="letter-actions">
                        <button class="btn-icon" onclick="viewLetter(3)">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn-icon" onclick="resendLetter(3)">
                            <i class="fas fa-redo"></i>
                        </button>
                        <button class="btn-icon" onclick="printSingleLetter(3)">
                            <i class="fas fa-print"></i>
                        </button>
                    </div>
                </div>
                <div class="letter-content">
                    <p><strong>Perihal:</strong> Pembahasan masalah kedisiplinan</p>
                    <p><strong>Jadwal:</strong> Senin, 22 Januari 2024, 10:00 WIB</p>
                    <p><strong>Lokasi:</strong> Ruang BK SMA Mishbahul Ulum</p>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination">
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
        <div class="activity-timeline">
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div class="activity-content">
                    <h5>Surat dikirim ke Ahmad Hidayat</h5>
                    <p>Surat pemanggilan untuk pembahasan masalah kedisiplinan telah dikirim</p>
                    <span class="activity-time">13 Jan 2024, 14:30</span>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="activity-content">
                    <h5>Konfirmasi dari orang tua Siti</h5>
                    <p>Orang tua Siti Nurhaliza telah mengkonfirmasi kehadiran untuk konseling karir</p>
                    <span class="activity-time">12 Jan 2024, 10:15</span>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="activity-content">
                    <h5>Surat baru dibuat</h5>
                    <p>Draft surat pemanggilan untuk Andi Pratama telah dibuat</p>
                    <span class="activity-time">11 Jan 2024, 16:45</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentTab = 'draft';
    let currentLetterId = null;

    function switchTab(tabName) {
        currentTab = tabName;

        // Update active tab button
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.currentTarget.classList.add('active');

        // Show/hide tab content
        document.getElementById('draftTab').style.display = 'none';
        document.getElementById('sentTab').style.display = 'none';

        document.getElementById(tabName + 'Tab').style.display = 'block';

        // Update title
        const titles = {
            'draft': 'Surat Draft',
            'sent': 'Surat Terkirim',
            'confirmed': 'Surat Dikonfirmasi',
            'archived': 'Surat Arsip'
        };
        document.getElementById('tabTitle').textContent = titles[tabName];
    }

    function createNewLetter() {
        alert('Membuat surat baru...');
    }

    function editLetter(id) {
        alert(`Mengedit surat #${id}`);
    }

    function viewLetter(id) {
        alert(`Melihat surat #${id}`);
    }

    function sendLetter(id) {
        if (confirm('Kirim surat ini?')) {
            alert(`Surat #${id} telah dikirim!`);
        }
    }

    function resendLetter(id) {
        if (confirm('Kirim ulang surat ini?')) {
            alert(`Surat #${id} telah dikirim ulang!`);
        }
    }

    function deleteLetter(id) {
        if (confirm('Hapus surat ini?')) {
            alert(`Surat #${id} telah dihapus!`);
        }
    }

    function exportLetters() {
        alert('Fitur export surat akan segera tersedia!');
    }

    function printLetters() {
        window.print();
    }

    function printSingleLetter(id) {
        alert(`Mencetak surat #${id}`);
    }
</script>
@endpush
