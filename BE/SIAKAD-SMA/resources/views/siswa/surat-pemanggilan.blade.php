@extends('layouts.app')

@section('title', 'Surat Pemanggilan - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Surat Pemanggilan')
@section('breadcrumb', 'Siswa / Surat Pemanggilan')

@php
    $role = 'siswa';
    $userName = 'Ahmad Fauzi';
    $userRole = 'Siswa X MIPA 1';
@endphp

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
            <h3>3</h3>
            <p>Total Surat</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <i class="fas fa-envelope-open"></i>
        </div>
        <div class="stat-info">
            <h3>1</h3>
            <p>Belum Dibaca</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>2</h3>
            <p>Sudah Dibaca</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h3>1</h3>
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
                    <option value="2" selected>Februari</option>
                    <option value="3">Maret</option>
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
        <div class="letter-list">
            <!-- Unread Letter -->
            <div class="letter-item unread" onclick="openLetter(1)">
                <div class="letter-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="letter-content">
                    <h4>Pemanggilan Orang Tua - Konsultasi Akademik</h4>
                    <p class="letter-meta">
                        <span><i class="fas fa-user"></i> Bu Siti Aminah, S.Pd (Guru BK)</span>
                        <span><i class="fas fa-calendar"></i> 03 Feb 2026</span>
                        <span class="badge badge-danger">Belum Dibaca</span>
                    </p>
                    <p class="letter-preview">Kepada Yth. Orang Tua/Wali dari Ahmad Fauzi, kami memohon kehadiran Bapak/Ibu untuk konsultasi terkait perkembangan akademik...</p>
                </div>
                <div class="letter-actions">
                    <button class="btn btn-sm btn-primary" onclick="event.stopPropagation(); openLetter(1)">
                        <i class="fas fa-eye"></i> Baca
                    </button>
                </div>
            </div>

            <!-- Read Letters -->
            <div class="letter-item read" onclick="openLetter(2)">
                <div class="letter-icon">
                    <i class="fas fa-envelope-open"></i>
                </div>
                <div class="letter-content">
                    <h4>Undangan Pertemuan Wali Murid</h4>
                    <p class="letter-meta">
                        <span><i class="fas fa-user"></i> Tata Usaha</span>
                        <span><i class="fas fa-calendar"></i> 01 Feb 2026</span>
                        <span class="badge badge-success">Sudah Dibaca</span>
                    </p>
                    <p class="letter-preview">Dengan hormat, kami mengundang Bapak/Ibu untuk hadir dalam pertemuan wali murid yang akan dilaksanakan pada...</p>
                </div>
                <div class="letter-actions">
                    <button class="btn btn-sm btn-info" onclick="event.stopPropagation(); openLetter(2)">
                        <i class="fas fa-eye"></i> Lihat
                    </button>
                </div>
            </div>

            <div class="letter-item read" onclick="openLetter(3)">
                <div class="letter-icon">
                    <i class="fas fa-envelope-open"></i>
                </div>
                <div class="letter-content">
                    <h4>Teguran Keterlambatan</h4>
                    <p class="letter-meta">
                        <span><i class="fas fa-user"></i> Pak Ahmad Rizki, M.Pd (Guru BK)</span>
                        <span><i class="fas fa-calendar"></i> 28 Jan 2026</span>
                        <span class="badge badge-success">Sudah Dibaca</span>
                    </p>
                    <p class="letter-preview">Kepada siswa Ahmad Fauzi, berdasarkan catatan kehadiran, terdapat beberapa keterlambatan yang perlu ditindaklanjuti...</p>
                </div>
                <div class="letter-actions">
                    <button class="btn btn-sm btn-info" onclick="event.stopPropagation(); openLetter(3)">
                        <i class="fas fa-eye"></i> Lihat
                    </button>
                </div>
            </div>
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
    function applyFilter() {
        const status = document.getElementById('filterStatus').value;
        const sender = document.getElementById('filterSender').value;
        const month = document.getElementById('filterMonth').value;
        
        console.log('Filter:', { status, sender, month });
        alert('Menerapkan filter...');
        // Implementasi filter di sini
    }

    function openLetter(id) {
        alert('Membuka surat #' + id);
        // Redirect ke halaman detail surat atau buka modal
        // window.location.href = '/siswa/surat-pemanggilan/' + id;
    }
</script>
@endpush