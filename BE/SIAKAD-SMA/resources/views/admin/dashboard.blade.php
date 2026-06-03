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
                                <button class="quick-action-btn" onclick="showReportModal()">
                                    <div class="action-icon">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                    <span>Generate Report</span>
                                </button>


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
    // Get token helper
    function getToken() {
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Anda belum login. Silakan login terlebih dahulu.');
            window.location.href = '/login';
            return null;
        }
        return token;
    }

    // Fetch dashboard data
    document.addEventListener('DOMContentLoaded', () => {
        const token = getToken();
        if (!token) return;

        fetch('/api/admin/dashboard', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        })
        .then(res => {
            if (res.status === 401) {
                alert('Sesi Anda telah berakhir. Silakan login kembali.');
                localStorage.removeItem('token');
                window.location.href = '/login';
                return;
            }
            return res.json();
        })
        .then(res => {
            if (res && res.success) {
                const data = res.data;
                document.getElementById('gurus-count').innerText  = data.gurus.length;
                document.getElementById('siswas-count').innerText = data.siswas.length;
                document.getElementById('mapel-count').innerText  = data.mapel.length;
            } else {
                console.error('Gagal memuat data dashboard');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    function showReportModal() {
        alert('Membuka modal untuk generate report');
    }
</script>
@endpush
