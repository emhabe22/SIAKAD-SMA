@extends('layouts.app')

@section('title', 'Dashboard Guru - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Dashboard Guru')
@section('breadcrumb', 'Home / Dashboard')
@section('notification-count', '5')

@php
    $role = 'guru';
    $userName = 'Budi Santoso, S.Pd';
    $userRole = 'Guru Matematika';
@endphp

@section('content')

        <!-- Welcome Message -->
        <div class="welcome-card">
            <div class="welcome-content">
                <h2>Selamat Pagi, Bapak Budi Santoso!</h2>
                <p>Anda memiliki <strong>3 kelas</strong> untuk hari ini. Sesi pertama dimulai pukul <strong>08:00 WIB</strong></p>
            </div>
            <div class="welcome-actions">
                <button class="btn btn-primary" onclick="location.href='jadwal-mengajar.html'">
                    <i class="fas fa-calendar"></i> Lihat Jadwal
                </button>
                <button class="btn btn-success" onclick="location.href='absensi.html'">
                    <i class="fas fa-clipboard-check"></i> Input Absen
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: #4CAF50;">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-info">
                    <h3>18</h3>
                    <p>Jam Mengajar/Minggu</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #2196F3;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>105</h3>
                    <p>Siswa Diajar</p>
                </div>
            </div>

        </div>

        <!-- Main Content Grid -->
        <div class="content-grid">
            <!-- Left Column -->
            <div class="left-column">
                <!-- Jadwal Hari Ini -->
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-calendar-day"></i> Jadwal Mengajar Hari Ini</h3>
                        <a href="/guru/jadwal-mengajar" class="btn-link">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        <div class="today-schedule">
                            <div class="schedule-item current">
                                <div class="schedule-time">
                                    <span class="time">08:00 - 09:30</span>
                                    <span class="status-badge ongoing">Sedang Berlangsung</span>
                                </div>
                                <div class="schedule-details">
                                    <h4>Matematika - Kelas X MIPA 1</h4>

                                </div>
                                <button class="btn btn-sm btn-primary" >
                                    <i class="fas fa-clipboard-check"></i> Absen
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-bolt"></i> Tindakan Cepat</h3>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions-grid">
                            <button class="quick-action-btn" onclick="location.href='/guru/absensi'">
                                <div class="action-icon">
                                    <i class="fas fa-clipboard-check"></i>
                                </div>
                                <span>Input Absensi</span>
                            </button>
                            <button class="quick-action-btn" onclick="location.href='/guru/logbook'">
                                <div class="action-icon">
                                    <i class="fas fa-book"></i>
                                </div>
                                <span>Isi Logbook</span>
                            </button>
                            <button class="quick-action-btn">
                                <div class="action-icon">
                                    <i class="fas fa-bullhorn"></i>
                                </div>
                                <span>Buat Pengumuman</span>
                            </button>
                            <button class="quick-action-btn" >
                                <div class="action-icon">
                                    <i class="fas fa-tasks"></i>
                                </div>
                                <span>Buat Tugas</span>
                            </button>
                            <button class="quick-action-btn" >
                                <div class="action-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <span>Progress Siswa</span>
                            </button>
                            <button class="quick-action-btn" >
                                <div class="action-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <span>Jadwal Pertemuan</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
        </div>

        <!-- Recent Activities & Tasks -->
        <div class="content-grid">
            <!-- Aktivitas Terbaru -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-history"></i> Aktivitas Terbaru</h3>
                </div>
                <div class="card-body">
                    <div class="activity-timeline">
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <div class="activity-content">
                                <h5>Input Absensi Kelas X MIPA 1</h5>
                                <p>Absensi untuk pelajaran Matematika tanggal 15 Januari 2024</p>
                                <span class="activity-time">Kemarin, 15:30</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.css">
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.js"></script>
<script>
    // Initialize mini calendar
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize mini calendar
        initMiniCalendar();

        // Calendar navigation
        document.getElementById('prevMonth')?.addEventListener('click', function() {
            alert('Previous month');
        });

        document.getElementById('nextMonth')?.addEventListener('click', function() {
            alert('Next month');
        });
    });

    function initMiniCalendar() {
        const calendarEl = document.getElementById('miniCalendar');
        if (!calendarEl) return;

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: false,
            height: 250,
            events: [
                {
                    title: 'UTS',
                    start: '2024-01-18',
                    color: '#FF9800'
                },
                {
                    title: 'Rapat Guru',
                    start: '2024-01-22',
                    color: '#2196F3'
                },
                {
                    title: 'Deadline Logbook',
                    start: '2024-01-25',
                    color: '#9C27B0'
                }
            ]
        });
        calendar.render();
    }

    function takeAttendance(classId) {
        alert(`Membuka form absensi untuk kelas ID: ${classId}`);
        window.location.href = `absensi.html?class=${classId}`;
    }

    function createAnnouncement() {
        alert('Membuat pengumuman baru...');
    }

    function createAssignment() {
        alert('Membuat tugas baru...');
    }

    function viewStudentProgress() {
        alert('Melihat progress siswa...');
    }

    function scheduleMeeting() {
        alert('Menjadwalkan pertemuan...');
    }
</script>
@endpush
