@extends('layouts.app')

@section('title', 'Dashboard Admin - SIAKAD SMA Mishbahul Ulum')

@section('page-title', 'Dashboard Administrator')
@section('breadcrumb', 'Dashboard / Admin')
@section('notification-count', '0')

@php
    $role = 'admin';
    $userName = 'Administrator';
    $userRole = 'Admin Sistem';
@endphp

@section('content')
<!-- Welcome Card -->
<div class="welcome-card admin-welcome">
    <div class="welcome-content">
        <h2><i class="fas fa-crown"></i> Selamat datang, <strong>Administrator</strong>!</h2>
        <p>Anda dapat mengelola seluruh sistem akademik SMA Mishbahul Ulum dari dashboard ini.</p>
    </div>
    <div class="welcome-icon">
        <i class="fas fa-shield-alt"></i>
    </div>
</div>

<!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="siswas-count">0</h3>
                        <p>Total Siswa</p>
                        <div class="stat-trend up">


                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="gurus-count">0</h3>
                        <p>Total Guru</p>
                        <div class="stat-trend up">


                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <i class="fas fa-school"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="kelas-count">0</h3>
                        <p>Total Kelas</p>
                        <div class="stat-trend stable">


                        </div>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="mapel-count">0</h3>
                        <p>Mata Pelajaran</p>
                        <div class="stat-trend up">


                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                <!-- Left Column -->
                <div class="left-column">
                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-bolt"></i> Tindakan Cepat</h3>
                        </div>
                        <div class="card-body">
                            <div class="quick-actions-grid">
                                <button class="quick-action-btn" onclick="location.href='/admin/siswa'">
                                    <div class="action-icon">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <span>Tambah Siswa</span>
                                </button>
                                <button class="quick-action-btn" onclick="location.href='/admin/guru'">
                                    <div class="action-icon">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <span>Tambah Guru</span>
                                </button>
                                <button class="quick-action-btn" onclick="location.href='/admin/kelas'">
                                    <div class="action-icon">
                                        <i class="fas fa-plus-circle"></i>
                                    </div>
                                    <span>Buat Kelas</span>
                                </button>
                                <button class="quick-action-btn" onclick="showReportModal()">
                                    <div class="action-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <span>Generate Report</span>
                                </button>


                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities -->
                    <div class="card">
                        <div class="card-header">
                            <h3><i class="fas fa-history"></i> Aktivitas Terbaru</h3>
                            <a href="#" class="btn-link">Lihat Semua</a>
                        </div>
                        <div class="card-body">
                            <div class="activity-list">
                                <div class="activity-item">
                                    <div class="activity-icon success">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h5>Siswa Baru Ditambahkan</h5>
                                        <p>Ahmad Fauzi (X MIPA 1) telah ditambahkan ke sistem</p>
                                        <span class="activity-time">10 menit yang lalu</span>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <div class="activity-icon warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h5>Peringatan Sistem</h5>
                                        <p>Backup otomatis akan dilakukan malam ini pukul 00:00</p>
                                        <span class="activity-time">1 jam yang lalu</span>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <div class="activity-icon info">
                                        <i class="fas fa-chalkboard-teacher"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h5>Update Data Guru</h5>
                                        <p>Data guru matematika telah diperbarui</p>
                                        <span class="activity-time">3 jam yang lalu</span>
                                    </div>
                                </div>
                                <div class="activity-item">
                                    <div class="activity-icon primary">
                                        <i class="fas fa-file-export"></i>
                                    </div>
                                    <div class="activity-content">
                                        <h5>Report Generated</h5>
                                        <p>Laporan bulanan Desember 2023 telah diexport</p>
                                        <span class="activity-time">5 jam yang lalu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    <!-- Right Column -->
    <div class="right-column">
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Fetch dashboard data
    document.addEventListener('DOMContentLoaded', () => {
        fetch('/api/admin/dashboardAdmin', {
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('token'),
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            const data = res.data;
            document.getElementById('gurus-count').innerText  = data.gurus.length;
            document.getElementById('siswas-count').innerText = data.siswas.length;
            document.getElementById('kelas-count').innerText  = data.kelas.length;
            document.getElementById('mapel-count').innerText  = data.mapel.length;
        });
    });

    function showReportModal() {
        alert('Membuka modal untuk generate report');
    }
</script>
@endpush
