<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi - SIAKAD SMA Mishbahul Ulum</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/layout.css">
    <link rel="stylesheet" href="/assets/css/components.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Styles khusus untuk halaman absensi */
        .attendance-container {
            display: flex;
            gap: 24px;
            margin-top: 24px;
        }

        .attendance-summary {
            flex: 1;
            max-width: 320px;
        }

        .attendance-content {
            flex: 2;
        }

        .summary-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .summary-card h3 {
            color: #333;
            margin-bottom: 20px;
            font-size: 18px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .stat-item {
            text-align: center;
            padding: 16px;
            border-radius: 8px;
            background: #f8f9fa;
        }

        .stat-value {
            font-size: 28px;
            font-weight: bold;
            display: block;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 14px;
            color: #666;
        }

        .attendance-types {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .type-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px;
            border-radius: 6px;
            background: #f8f9fa;
        }

        .type-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .type-name {
            font-size: 14px;
        }

        .type-count {
            margin-left: auto;
            font-weight: bold;
        }

        /* Progress bars */
        .progress-container {
            margin-top: 16px;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 14px;
        }

        .progress-bar-container {
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            transition: width 0.3s ease;
        }

        /* Filter section */
        .attendance-filter {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-group label {
            font-size: 14px;
            color: #555;
            font-weight: 500;
        }

        .filter-select, .filter-input {
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            background: white;
        }

        .filter-buttons {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        /* Attendance table */
        .attendance-table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .table-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
        }

        .table-header h3 {
            margin: 0;
            color: #333;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .attendance-table {
            width: 100%;
            border-collapse: collapse;
        }

        .attendance-table th {
            background: #f8f9fa;
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: #555;
            border-bottom: 1px solid #eee;
        }

        .attendance-table td {
            padding: 16px;
            border-bottom: 1px solid #eee;
        }

        .attendance-table tbody tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-present {
            background: #d4edda;
            color: #155724;
        }

        .status-sick {
            background: #fff3cd;
            color: #856404;
        }

        .status-permit {
            background: #cce5ff;
            color: #004085;
        }

        .status-absent {
            background: #f8d7da;
            color: #721c24;
        }

        .status-late {
            background: #fff3cd;
            color: #856404;
        }

        .day-header {
            background: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            margin: 20px 0 12px 0;
            font-weight: 600;
        }

        .month-summary {
            margin-top: 24px;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .month-summary h4 {
            margin: 0 0 16px 0;
            color: #333;
        }

        .summary-chart {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .chart-container {
            padding: 16px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .chart-container h5 {
            margin: 0 0 12px 0;
            font-size: 14px;
            color: #555;
        }

        /* Export buttons */
        .export-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            justify-content: flex-end;
        }

        .btn-export {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.3s;
        }

        .btn-export:hover {
            background: #218838;
        }

        .btn-export.print {
            background: #007bff;
        }

        .btn-export.print:hover {
            background: #0056b3;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .attendance-container {
                flex-direction: column;
            }

            .attendance-summary {
                max-width: 100%;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .export-actions {
                justify-content: stretch;
            }

            .btn-export {
                flex: 1;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <i class="fas fa-graduation-cap"></i>
                    <h2>SIAKAD<br><span>SMA Mishbahul Ulum</span></h2>
                </div>
            </div>
            
            <div class="sidebar-menu">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div class="user-details">
                        <h4 class="user-name">Nama Siswa</h4>
                        <span class="user-role badge badge-primary">SISWA</span>
                    </div>
                </div>
                
                <nav>
                    <ul>
                        <li>
                            <a href="dashboard.html">
                                <i class="fas fa-home"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="active">
                            <a href="absensi.html">
                                <i class="fas fa-calendar-check"></i>
                                <span>Absensi</span>
                            </a>
                        </li>
                        <li>
                            <a href="bk.html">
                                <i class="fas fa-hands-helping"></i>
                                <span>Bimbingan Konseling</span>
                            </a>
                        </li>
                        <li>
                            <a href="surat-pemanggilan.html">
                                <i class="fas fa-envelope"></i>
                                <span>Surat Pemanggilan</span>
                            </a>
                        </li>
                        <li>
                            <a href="/index.html">
                                <i class="fas fa-info-circle"></i>
                                <span>Informasi Sekolah</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            
            <div class="sidebar-footer">
                <a href="#" id="logoutBtn" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="content">
            <!-- Top Navigation -->
            <header class="top-nav">
                <div class="nav-left">
                    <button class="menu-toggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1>Absensi</h1>
                </div>
                <div class="nav-right">
                    <div class="notifications">
                        <button class="notification-btn">
                            <i class="fas fa-bell"></i>
                            <span class="notification-count">2</span>
                        </button>
                    </div>
                    <div class="date-display">
                        <i class="fas fa-calendar-alt"></i>
                        <span id="currentDate">Senin, 1 Januari 2024</span>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Welcome Banner -->
                <div class="welcome-banner" style="background: linear-gradient(135deg, #0066CC, #009B48);">
                    <div class="welcome-text">
                        <h2>Rekap Kehadiran <span class="student-name">Nama Siswa</span></h2>
                        <p>Kelas: XII IPA 1 | Semester: Genap 2023/2024</p>
                    </div>
                    <div class="welcome-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>

                <div class="attendance-container">
                    <!-- Summary Sidebar -->
                    <div class="attendance-summary">
                        <div class="summary-card">
                            <h3>Statistik Kehadiran</h3>
                            <div class="stats-grid">
                                <div class="stat-item" style="background: #d4edda;">
                                    <span class="stat-value">92%</span>
                                    <span class="stat-label">Kehadiran</span>
                                </div>
                                <div class="stat-item" style="background: #f8f9fa;">
                                    <span class="stat-value">88</span>
                                    <span class="stat-label">Hadir</span>
                                </div>
                                <div class="stat-item" style="background: #f8f9fa;">
                                    <span class="stat-value">4</span>
                                    <span class="stat-label">Izin</span>
                                </div>
                                <div class="stat-item" style="background: #f8f9fa;">
                                    <span class="stat-value">2</span>
                                    <span class="stat-label">Sakit</span>
                                </div>
                            </div>

                            <div class="progress-container">
                                <div class="progress-label">
                                    <span>Target: 95%</span>
                                    <span>92%</span>
                                </div>
                                <div class="progress-bar-container">
                                    <div class="progress-bar-fill" style="width: 92%; background: #28a745;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="summary-card">
                            <h3>Keterangan Absensi</h3>
                            <div class="attendance-types">
                                <div class="type-item">
                                    <div class="type-color" style="background: #28a745;"></div>
                                    <span class="type-name">Hadir</span>
                                    <span class="type-count">88</span>
                                </div>
                                <div class="type-item">
                                    <div class="type-color" style="background: #ffc107;"></div>
                                    <span class="type-name">Sakit</span>
                                    <span class="type-count">2</span>
                                </div>
                                <div class="type-item">
                                    <div class="type-color" style="background: #17a2b8;"></div>
                                    <span class="type-name">Izin</span>
                                    <span class="type-count">4</span>
                                </div>
                                <div class="type-item">
                                    <div class="type-color" style="background: #dc3545;"></div>
                                    <span class="type-name">Alpa</span>
                                    <span class="type-count">0</span>
                                </div>
                                <div class="type-item">
                                    <div class="type-color" style="background: #fd7e14;"></div>
                                    <span class="type-name">Terlambat</span>
                                    <span class="type-count">1</span>
                                </div>
                                <div class="type-item">
                                    <div class="type-color" style="background: #6f42c1;"></div>
                                    <span class="type-name">Izin Pulang</span>
                                    <span class="type-count">3</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="attendance-content">
                        <!-- Filter Section -->
                        <div class="attendance-filter">
                            <div class="filter-grid">
                                <div class="filter-group">
                                    <label>Periode</label>
                                    <select class="filter-select" id="periodSelect">
                                        <option value="month">Bulan Ini</option>
                                        <option value="week">Minggu Ini</option>
                                        <option value="all">Semua Data</option>
                                        <option value="custom">Custom</option>
                                    </select>
                                </div>
                                <div class="filter-group" id="monthGroup">
                                    <label>Bulan</label>
                                    <select class="filter-select" id="monthSelect">
                                        <option value="1">Januari</option>
                                        <option value="2">Februari</option>
                                        <option value="3" selected>Maret</option>
                                        <option value="4">April</option>
                                        <option value="5">Mei</option>
                                        <option value="6">Juni</option>
                                    </select>
                                </div>
                                <div class="filter-group" id="yearGroup">
                                    <label>Tahun</label>
                                    <select class="filter-select" id="yearSelect">
                                        <option value="2023">2023</option>
                                        <option value="2024" selected>2024</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label>Status</label>
                                    <select class="filter-select" id="statusSelect">
                                        <option value="all">Semua Status</option>
                                        <option value="present">Hadir</option>
                                        <option value="sick">Sakit</option>
                                        <option value="permit">Izin</option>
                                        <option value="absent">Alpa</option>
                                        <option value="late">Terlambat</option>
                                    </select>
                                </div>
                            </div>
                            <div class="filter-buttons">
                                <button class="btn btn-secondary" id="resetFilter">
                                    <i class="fas fa-redo"></i> Reset
                                </button>
                                <button class="btn btn-primary" id="applyFilter">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                        </div>

                        <!-- Attendance Table -->
                        <div class="attendance-table-container">
                            <div class="table-header">
                                <h3><i class="fas fa-calendar-alt"></i> Rekap Absensi Harian</h3>
                            </div>
                            <div class="table-responsive">
                                <table class="attendance-table" id="attendanceTable">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Hari</th>
                                            <th>Mata Pelajaran</th>
                                            <th>Jam</th>
                                            <th>Status</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="attendanceData">
                                        <!-- Data akan diisi oleh JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Monthly Summary -->
                        <div class="month-summary">
                            <h4><i class="fas fa-chart-pie"></i> Ringkasan Bulan Maret 2024</h4>
                            <div class="summary-chart">
                                <div class="chart-container">
                                    <h5>Distribusi Kehadiran</h5>
                                    <canvas id="attendanceChart" width="200" height="150"></canvas>
                                </div>
                                <div class="chart-container">
                                    <h5>Perbandingan Per Mata Pelajaran</h5>
                                    <canvas id="subjectChart" width="200" height="150"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Export Options -->
                        <div class="export-actions">
                            <button class="btn-export print" onclick="printAttendance()">
                                <i class="fas fa-print"></i> Cetak Rekap
                            </button>
                            <button class="btn-export" onclick="exportToPDF()">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </button>
                            <button class="btn-export" onclick="exportToExcel()">
                                <i class="fas fa-file-excel"></i> Export Excel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="main-footer">
                <p>&copy; 2024 SIAKAD SMA Mishbahul Ulum. Sistem Informasi Akademik.</p>
                <p>Versi 1.0.0 | <span id="lastSync">Terakhir sinkron: -</span></p>
            </footer>
        </main>
    </div>

    <!-- Modals -->
    <div id="notificationModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Notifikasi</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="notifications-list" id="notificationsList">
                    <!-- Notifikasi akan diisi oleh JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/assets/js/auth.js"></script>
    <script src="/assets/js/api.js"></script>
    <script>
        class AttendancePage {
            constructor() {
                this.currentData = [];
                this.init();
            }

            init() {
                this.updateDateDisplay();
                this.loadAttendanceData();
                this.setupEventListeners();
                this.setupCharts();
            }

            updateDateDisplay() {
                const dateElement = document.getElementById('currentDate');
                const now = new Date();
                const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const months = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                
                const dayName = days[now.getDay()];
                const date = now.getDate();
                const monthName = months[now.getMonth()];
                const year = now.getFullYear();
                
                dateElement.textContent = `${dayName}, ${date} ${monthName} ${year}`;
            }

            async loadAttendanceData() {
                try {
                    // Simulasi data dari API
                    const data = await this.getMockAttendanceData();
                    this.currentData = data;
                    this.renderAttendanceTable(data);
                } catch (error) {
                    console.error('Error loading attendance data:', error);
                    this.showError('Gagal memuat data absensi');
                }
            }

            renderAttendanceTable(data) {
                const tbody = document.getElementById('attendanceData');
                tbody.innerHTML = '';

                if (data.length === 0) {
                    tbody.innerHTML = `
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="empty-state">
                                    <i class="fas fa-calendar-times fa-2x"></i>
                                    <p>Tidak ada data absensi untuk periode ini</p>
                                </div>
                            </td>
                        </tr>
                    `;
                    return;
                }

                // Kelompokkan data berdasarkan tanggal
                const groupedData = this.groupByDate(data);
                
                for (const [date, entries] of Object.entries(groupedData)) {
                    // Tambahkan header hari
                    const dateObj = new Date(date);
                    const dayName = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'][dateObj.getDay()];
                    
                    // Header row
                    const headerRow = document.createElement('tr');
                    headerRow.className = 'day-header-row';
                    headerRow.innerHTML = `
                        <td colspan="6" style="padding: 0;">
                            <div class="day-header">
                                ${dayName}, ${this.formatDate(dateObj)}
                            </div>
                        </td>
                    `;
                    tbody.appendChild(headerRow);
                    
                    // Data rows
                    entries.forEach(entry => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${this.formatDate(new Date(entry.date))}</td>
                            <td>${dayName}</td>
                            <td>${entry.subject}</td>
                            <td>${entry.time}</td>
                            <td>
                                <span class="status-badge ${this.getStatusClass(entry.status)}">
                                    <i class="fas fa-${this.getStatusIcon(entry.status)}"></i>
                                    ${entry.status}
                                </span>
                            </td>
                            <td>${entry.notes || '-'}</td>
                        `;
                        tbody.appendChild(row);
                    });
                }
            }

            groupByDate(data) {
                return data.reduce((groups, item) => {
                    const date = item.date.split('T')[0];
                    if (!groups[date]) {
                        groups[date] = [];
                    }
                    groups[date].push(item);
                    return groups;
                }, {});
            }

            formatDate(date) {
                return date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
            }

            getStatusClass(status) {
                const classes = {
                    'Hadir': 'status-present',
                    'Sakit': 'status-sick',
                    'Izin': 'status-permit',
                    'Alpa': 'status-absent',
                    'Terlambat': 'status-late'
                };
                return classes[status] || 'status-absent';
            }

            getStatusIcon(status) {
                const icons = {
                    'Hadir': 'check-circle',
                    'Sakit': 'thermometer',
                    'Izin': 'file-alt',
                    'Alpa': 'times-circle',
                    'Terlambat': 'clock'
                };
                return icons[status] || 'question-circle';
            }

            setupCharts() {
                // Chart distribusi kehadiran
                const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
                this.attendanceChart = new Chart(attendanceCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Hadir', 'Izin', 'Sakit', 'Alpa'],
                        datasets: [{
                            data: [88, 4, 2, 0],
                            backgroundColor: [
                                '#28a745',
                                '#17a2b8',
                                '#ffc107',
                                '#dc3545'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });

                // Chart perbandingan mata pelajaran
                const subjectCtx = document.getElementById('subjectChart').getContext('2d');
                this.subjectChart = new Chart(subjectCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Matematika', 'Fisika', 'Kimia', 'Biologi', 'Bahasa'],
                        datasets: [{
                            label: 'Kehadiran (%)',
                            data: [95, 92, 90, 88, 96],
                            backgroundColor: '#007bff'
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100
                            }
                        }
                    }
                });
            }

            setupEventListeners() {
                // Menu toggle
                document.querySelector('.menu-toggle').addEventListener('click', () => {
                    document.querySelector('.sidebar').classList.toggle('active');
                });

                // Notification button
                document.querySelector('.notification-btn').addEventListener('click', () => {
                    document.getElementById('notificationModal').classList.add('active');
                });

                // Close modal buttons
                document.querySelectorAll('.close-modal').forEach(button => {
                    button.addEventListener('click', () => {
                        document.getElementById('notificationModal').classList.remove('active');
                    });
                });

                // Filter period change
                document.getElementById('periodSelect').addEventListener('change', (e) => {
                    const isCustom = e.target.value === 'custom';
                    document.getElementById('monthGroup').style.display = 
                        (e.target.value === 'month' || isCustom) ? 'block' : 'none';
                    document.getElementById('yearGroup').style.display = 
                        isCustom ? 'block' : 'none';
                });

                // Apply filter
                document.getElementById('applyFilter').addEventListener('click', () => {
                    this.applyFilters();
                });

                // Reset filter
                document.getElementById('resetFilter').addEventListener('click', () => {
                    this.resetFilters();
                });

                // Logout button
                document.getElementById('logoutBtn').addEventListener('click', (e) => {
                    e.preventDefault();
                    auth.logout();
                });
            }

            applyFilters() {
                const period = document.getElementById('periodSelect').value;
                const month = document.getElementById('monthSelect').value;
                const year = document.getElementById('yearSelect').value;
                const status = document.getElementById('statusSelect').value;

                console.log('Applying filters:', { period, month, year, status });
                // Implementasi filter sebenarnya
                this.loadAttendanceData(); // Reload dengan filter
            }

            resetFilters() {
                document.getElementById('periodSelect').value = 'month';
                document.getElementById('monthSelect').value = '3';
                document.getElementById('yearSelect').value = '2024';
                document.getElementById('statusSelect').value = 'all';
                document.getElementById('monthGroup').style.display = 'block';
                document.getElementById('yearGroup').style.display = 'none';
                
                this.loadAttendanceData();
            }

            showError(message) {
                const tbody = document.getElementById('attendanceData');
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center text-danger">
                            <i class="fas fa-exclamation-triangle"></i> ${message}
                        </td>
                    </tr>
                `;
            }

            getMockAttendanceData() {
                return new Promise((resolve) => {
                    setTimeout(() => {
                        resolve([
                            { date: '2024-03-15T07:30:00', subject: 'Matematika', status: 'Hadir', time: '07:30 - 09:00', notes: '' },
                            { date: '2024-03-15T09:00:00', subject: 'Fisika', status: 'Hadir', time: '09:00 - 10:30', notes: '' },
                            { date: '2024-03-15T10:30:00', subject: 'Kimia', status: 'Hadir', time: '10:30 - 12:00', notes: '' },
                            { date: '2024-03-14T07:30:00', subject: 'Biologi', status: 'Terlambat', time: '07:30 - 09:00', notes: 'Terlambat 15 menit' },
                            { date: '2024-03-14T09:00:00', subject: 'Bahasa Indonesia', status: 'Sakit', time: '09:00 - 10:30', notes: 'Surat dokter terlampir' },
                            { date: '2024-03-13T07:30:00', subject: 'Matematika', status: 'Hadir', time: '07:30 - 09:00', notes: '' },
                            { date: '2024-03-13T09:00:00', subject: 'Fisika', status: 'Izin', time: '09:00 - 10:30', notes: 'Izin keluarga' },
                            { date: '2024-03-12T07:30:00', subject: 'Kimia', status: 'Hadir', time: '07:30 - 09:00', notes: '' },
                            { date: '2024-03-12T09:00:00', subject: 'Biologi', status: 'Hadir', time: '09:00 - 10:30', notes: '' },
                            { date: '2024-03-11T07:30:00', subject: 'Bahasa Inggris', status: 'Hadir', time: '07:30 - 09:00', notes: '' }
                        ]);
                    }, 1000);
                });
            }
        }

        // Export functions
        function printAttendance() {
            window.print();
        }

        function exportToPDF() {
            alert('Fitur export PDF akan segera tersedia!');
            // Implementasi export PDF menggunakan jsPDF
        }

        function exportToExcel() {
            alert('Fitur export Excel akan segera tersedia!');
            // Implementasi export Excel menggunakan SheetJS
        }

        // Initialize page when loaded
        document.addEventListener('DOMContentLoaded', () => {
            new AttendancePage();
        });
    </script>
</body>
</html>