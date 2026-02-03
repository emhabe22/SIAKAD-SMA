<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard BK - SIAKAD SMA Mishbahul Ulum</title>
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/layout.css">
    <link rel="stylesheet" href="../../assets/css/components.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Tambahan CSS untuk dashboard BK */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }

        .stat-info h3 {
            margin: 0;
            font-size: 28px;
            color: #333;
        }

        .stat-info p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 14px;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 30px;
        }

        @media (max-width: 1024px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        .left-column, .right-column {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h3 {
            margin: 0;
            color: #333;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-link {
            color: #2196F3;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .btn-link:hover {
            text-decoration: underline;
        }

        .card-body {
            padding: 20px;
        }

        /* Schedule list styles */
        .schedule-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .schedule-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .schedule-item:hover {
            border-color: #2196F3;
            background: #f8f9fa;
        }

        .schedule-time {
            min-width: 120px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .time {
            font-weight: 600;
            color: #333;
        }

        .status {
            font-size: 12px;
            padding: 3px 8px;
            border-radius: 12px;
            font-weight: 500;
        }

        .status.active {
            background: #4CAF50;
            color: white;
        }

        .status.upcoming {
            background: #2196F3;
            color: white;
        }

        .schedule-details {
            flex: 1;
        }

        .schedule-details h4 {
            margin: 0 0 5px 0;
            color: #333;
        }

        .schedule-details p {
            margin: 0 0 8px 0;
            color: #666;
            font-size: 14px;
        }

        .tag {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .tag.urgent {
            background: #F44336;
            color: white;
        }

        .tag.regular {
            background: #4CAF50;
            color: white;
        }

        .tag.warning {
            background: #FF9800;
            color: white;
        }

        /* Quick actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        @media (max-width: 768px) {
            .quick-actions {
                grid-template-columns: 1fr;
            }
        }

        .action-btn {
            padding: 15px;
            background: white;
            border: 2px solid #2196F3;
            border-radius: 10px;
            color: #2196F3;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background: #2196F3;
            color: white;
        }

        .action-btn i {
            font-size: 20px;
        }

        /* Attention list */
        .attention-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .attention-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .attention-item:hover {
            border-color: #FF9800;
            background: #fff8e1;
        }

        .student-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            background: #f0f0f0;
        }

        .student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .student-info {
            flex: 1;
        }

        .student-info h4 {
            margin: 0 0 5px 0;
            color: #333;
        }

        .student-info p {
            margin: 0 0 5px 0;
            color: #666;
            font-size: 14px;
        }

        .student-info small {
            color: #F44336;
            font-size: 12px;
        }

        .btn-sm {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-warning {
            background: #FF9800;
            color: white;
        }

        .btn-warning:hover {
            background: #F57C00;
        }

        /* Stats chart */
        .stats-chart {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .chart-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .chart-label {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 100px;
            font-size: 14px;
            color: #666;
        }

        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .dot.academic { background: #4CAF50; }
        .dot.social { background: #2196F3; }
        .dot.career { background: #FF9800; }
        .dot.personal { background: #9C27B0; }

        .chart-bar {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .bar-fill {
            height: 10px;
            border-radius: 5px;
        }

        /* Data table */
        .full-width {
            width: 100%;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: #f8f9fa;
            padding: 12px 16px;
            text-align: left;
            font-weight: 600;
            color: #555;
            border-bottom: 2px solid #eee;
        }

        .data-table td {
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
        }

        .data-table tbody tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .completed { background: #4CAF50; color: white; }
        .pending { background: #FF9800; color: white; }
        .in-progress { background: #2196F3; color: white; }

        .btn-icon {
            padding: 6px;
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .btn-icon:hover {
            background: #f0f0f0;
            color: #2196F3;
        }

        /* Top header */
        .top-header {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .header-left h1 {
            margin: 0 0 5px 0;
            color: #333;
        }

        .breadcrumb {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notifications {
            position: relative;
            cursor: pointer;
        }

        .notifications i {
            font-size: 20px;
            color: #666;
        }

        .notification-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #F44336;
            color: white;
            font-size: 12px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .date-display {
            font-size: 14px;
            color: #666;
            padding: 8px 16px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        /* Sidebar styles */
        .sidebar {
            width: 260px;
            background: #1e3a8a;
            color: white;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-profile img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
        }

        .user-info h4 {
            margin: 0 0 5px 0;
            font-size: 18px;
        }

        .role-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
        }

        .sidebar-nav ul {
            list-style: none;
            padding: 20px 0;
        }

        .sidebar-nav li {
            margin-bottom: 5px;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar-nav a:hover,
        .sidebar-nav li.active a {
            background: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #60a5fa;
        }

        .sidebar-nav a i {
            width: 20px;
            text-align: center;
        }

        .badge {
            background: #F44336;
            color: white;
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: auto;
        }

        .divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 20px 0;
        }

        /* Main content adjustment */
        .main-content {
            margin-left: 260px;
            padding: 20px;
            min-height: 100vh;
            background: #f5f7fa;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .top-header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .content-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="user-profile">
                <img src="../../assets/images/user-avatar.png" alt="Avatar BK">
                <div class="user-info">
                    <h4>Nama Konselor BK</h4>
                    <span class="role-badge">Bimbingan Konseling</span>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <ul>
                <li class="active">
                    <a href="dashboard.html">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="validasi.html">
                        <i class="fas fa-check-circle"></i>
                        <span>Validasi Siswa</span>
                        <span class="badge">3</span>
                    </a>
                </li>
                <li>
                    <a href="feedback.html">
                        <i class="fas fa-comments"></i>
                        <span>Feedback</span>
                        <span class="badge">5</span>
                    </a>
                </li>
                <li>
                    <a href="surat-pemanggilan.html">
                        <i class="fas fa-envelope"></i>
                        <span>Surat Pemanggilan</span>
                    </a>
                </li>
                <li>
                    <a href="laporan.html">
                        <i class="fas fa-chart-bar"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="../../login.html">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-left">
                <h1>Dashboard Bimbingan Konseling</h1>
                <p class="breadcrumb">Home / Dashboard BK</p>
            </div>
            <div class="header-right">
                <div class="notifications">
                    <i class="fas fa-bell"></i>
                    <span class="notification-count">4</span>
                </div>
                <div class="date-display">
                    <span id="current-date">Senin, 15 Januari 2024</span>
                </div>
            </div>
        </header>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: #4CAF50;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>125</h3>
                    <p>Siswa Aktif</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #2196F3;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>8</h3>
                    <p>Konseling Hari Ini</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #FF9800;">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-info">
                    <h3>15</h3>
                    <p>Perlu Validasi</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #9C27B0;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>87%</h3>
                    <p>Resolved Cases</p>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="content-grid">
            <!-- Left Column -->
            <div class="left-column">
                <!-- Jadwal Konseling Hari Ini -->
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-calendar-alt"></i> Jadwal Konseling Hari Ini</h3>
                        <a href="#" class="btn-link">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        <div class="schedule-list">
                            <div class="schedule-item">
                                <div class="schedule-time">
                                    <span class="time">08:00 - 09:00</span>
                                    <span class="status active">Sedang Berjalan</span>
                                </div>
                                <div class="schedule-details">
                                    <h4>Andi Pratama</h4>
                                    <p>Kelas XII IPA 1 - Masalah Belajar</p>
                                    <span class="tag urgent">Urgent</span>
                                </div>
                            </div>
                            <div class="schedule-item">
                                <div class="schedule-time">
                                    <span class="time">10:00 - 11:00</span>
                                    <span class="status upcoming">Akan Datang</span>
                                </div>
                                <div class="schedule-details">
                                    <h4>Siti Nurhaliza</h4>
                                    <p>Kelas XI IPS 2 - Konseling Karir</p>
                                    <span class="tag regular">Regular</span>
                                </div>
                            </div>
                            <div class="schedule-item">
                                <div class="schedule-time">
                                    <span class="time">13:00 - 14:00</span>
                                    <span class="status upcoming">Akan Datang</span>
                                </div>
                                <div class="schedule-details">
                                    <h4>Rizki Ramadhan</h4>
                                    <p>Kelas X MIPA - Masalah Sosial</p>
                                    <span class="tag warning">Perhatian</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="right-column">
                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-bolt"></i> Tindakan Cepat</h3>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions">
                            <button class="action-btn" onclick="location.href='surat-pemanggilan.html'">
                                <i class="fas fa-envelope"></i>
                                <span>Buat Surat Pemanggilan</span>
                            </button>
                            <button class="action-btn" onclick="location.href='validasi.html'">
                                <i class="fas fa-check-circle"></i>
                                <span>Validasi Siswa</span>
                            </button>
                            <button class="action-btn" onclick="location.href='feedback.html'">
                                <i class="fas fa-comment-medical"></i>
                                <span>Beri Feedback</span>
                            </button>
                            <button class="action-btn" onclick="location.href='laporan.html'">
                                <i class="fas fa-file-alt"></i>
                                <span>Buat Laporan</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="card full-width">
            <div class="card-header">
                <h3><i class="fas fa-history"></i> Aktivitas Terbaru</h3>
            </div>
            <div class="card-body">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Aktivitas</th>
                            <th>Siswa</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>15 Jan 2024, 08:30</td>
                            <td>Konseling Akademik</td>
                            <td>Andi Pratama (XII IPA 1)</td>
                            <td><span class="status-badge completed">Selesai</span></td>
                            <td>
                                <button class="btn-icon" title="Lihat Detail"><i class="fas fa-eye"></i></button>
                                <button class="btn-icon" title="Edit"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>14 Jan 2024, 14:15</td>
                            <td>Validasi Kehadiran</td>
                            <td>Siti Nurhaliza (XI IPS 2)</td>
                            <td><span class="status-badge pending">Pending</span></td>
                            <td>
                                <button class="btn-icon" title="Lihat Detail"><i class="fas fa-eye"></i></button>
                                <button class="btn-icon" title="Setujui"><i class="fas fa-check"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>13 Jan 2024, 10:45</td>
                            <td>Surat Pemanggilan</td>
                            <td>Rizki Ramadhan (X MIPA)</td>
                            <td><span class="status-badge in-progress">Diproses</span></td>
                            <td>
                                <button class="btn-icon" title="Lihat Detail"><i class="fas fa-eye"></i></button>
                                <button class="btn-icon" title="Cetak"><i class="fas fa-print"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Update current date
        function updateDate() {
            const now = new Date();
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            document.getElementById('current-date').textContent = 
                now.toLocaleDateString('id-ID', options);
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateDate();
            
            // Notification bell click
            document.querySelector('.notifications').addEventListener('click', function() {
                alert('Notifikasi: 4 pesan belum dibaca');
            });
            
            // Set active menu based on current page
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.sidebar-nav a');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPage || (href === 'dashboard.html' && currentPage === '')) {
                    link.parentElement.classList.add('active');
                } else {
                    link.parentElement.classList.remove('active');
                }
            });
            
            // Add event listeners to buttons
            document.querySelectorAll('.attention-item .btn-warning').forEach(btn => {
                btn.addEventListener('click', function() {
                    const studentName = this.closest('.attention-item').querySelector('h4').textContent;
                    alert(`Melakukan follow up untuk siswa: ${studentName}`);
                });
            });
            
            document.querySelectorAll('.data-table .btn-icon').forEach(btn => {
                btn.addEventListener('click', function() {
                    const activity = this.closest('tr').querySelector('td:nth-child(2)').textContent;
                    const student = this.closest('tr').querySelector('td:nth-child(3)').textContent;
                    alert(`Aksi untuk: ${activity}\nSiswa: ${student}`);
                });
            });
        });

        // Mobile menu toggle (if needed)
        function initMobileMenu() {
            const mobileMenuToggle = document.createElement('button');
            mobileMenuToggle.innerHTML = '<i class="fas fa-bars"></i>';
            mobileMenuToggle.className = 'mobile-menu-toggle';
            mobileMenuToggle.style.cssText = `
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 1000;
                background: #1e3a8a;
                color: white;
                border: none;
                width: 40px;
                height: 40px;
                border-radius: 8px;
                display: none;
                align-items: center;
                justify-content: center;
                cursor: pointer;
            `;
            
            document.body.appendChild(mobileMenuToggle);
            
            const sidebar = document.querySelector('.sidebar');
            
            mobileMenuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                mobileMenuToggle.innerHTML = sidebar.classList.contains('active') 
                    ? '<i class="fas fa-times"></i>' 
                    : '<i class="fas fa-bars"></i>';
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768) {
                    if (!sidebar.contains(event.target) && 
                        !mobileMenuToggle.contains(event.target) && 
                        sidebar.classList.contains('active')) {
                        sidebar.classList.remove('active');
                        mobileMenuToggle.innerHTML = '<i class="fas fa-bars"></i>';
                    }
                }
            });
            
            // Show/hide mobile menu toggle based on screen size
            function checkScreenSize() {
                if (window.innerWidth <= 768) {
                    mobileMenuToggle.style.display = 'flex';
                    sidebar.classList.remove('active');
                } else {
                    mobileMenuToggle.style.display = 'none';
                    sidebar.classList.add('active');
                }
            }
            
            checkScreenSize();
            window.addEventListener('resize', checkScreenSize);
        }
        
        // Initialize mobile menu if needed
        initMobileMenu();
    </script>
</body>
</html>