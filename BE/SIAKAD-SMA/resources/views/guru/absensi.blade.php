@extends('layouts.app')

@section('title', 'Absensi Siswa - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Absensi Siswa')
@section('breadcrumb', 'Guru / Absensi')

@php
    $role = 'guru';
    $userName = 'Budi Santoso, S.Pd';
    $userRole = 'Guru Matematika';
@endphp

@push('styles')
<style>
        /* Tambahan styling khusus untuk halaman absensi */
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .attendance-table th {
            background: #f8f9fa;
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: #555;
            border-bottom: 2px solid #eee;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .attendance-table td {
            padding: 16px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .attendance-table tbody tr:hover {
            background: #f8f9fa;
        }

        .status-select {
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 14px;
            cursor: pointer;
            min-width: 120px;
            transition: all 0.3s ease;
        }

        .status-select.present {
            background: #e8f5e9;
            border-color: #4CAF50;
            color: #2e7d32;
        }

        .status-select.permit {
            background: #fff3e0;
            border-color: #FF9800;
            color: #ef6c00;
        }

        .status-select.sick {
            background: #e8eaf6;
            border-color: #3F51B5;
            color: #283593;
        }

        .status-select.absent {
            background: #ffebee;
            border-color: #F44336;
            color: #c62828;
        }

        .status-select.late {
            background: #fff8e1;
            border-color: #FFC107;
            color: #ff8f00;
        }

        .note-input {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            width: 100%;
            min-width: 200px;
        }

        .student-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .student-thumb {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }

        .attendance-summary {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            background: white;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .summary-label {
            font-weight: 500;
            color: #555;
        }

        .summary-value {
            font-weight: 600;
            color: #2196F3;
        }

        .summary-value.warning {
            color: #F44336;
        }

        .quick-attendance-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }

        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 20px;
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            border-color: #2196F3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(33, 150, 243, 0.1);
        }

        .action-btn i {
            font-size: 24px;
            color: #2196F3;
        }

        .action-btn span {
            font-weight: 500;
            color: #333;
            text-align: center;
        }

        .student-detail {
            display: flex;
            gap: 20px;
            align-items: center;
            margin-bottom: 25px;
        }

        .student-photo img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #e9ecef;
        }

        .attendance-history {
            margin: 25px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .history-chart {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .history-day {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .day-status {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid #ddd;
        }

        .day-status.present {
            background: #4CAF50;
            border-color: #4CAF50;
        }

        .day-status.sick {
            background: #3F51B5;
            border-color: #3F51B5;
        }

        .day-status.late {
            background: #FFC107;
            border-color: #FFC107;
        }

        .attendance-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .stat-item {
            background: white;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-label {
            display: block;
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }

        .stat-value {
            display: block;
            font-size: 18px;
            font-weight: 700;
            color: #2196F3;
        }

        .warning-box {
            background: #fff3e0;
            border: 1px solid #FF9800;
            border-radius: 6px;
            padding: 15px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
            margin-top: 20px;
        }

        .warning-box i {
            color: #FF9800;
            font-size: 20px;
            margin-top: 2px;
        }

        .warning-box p {
            margin: 0;
            color: #e65100;
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .student-detail {
                flex-direction: column;
                text-align: center;
            }

            .attendance-stats,
            .summary-grid {
                grid-template-columns: 1fr;
            }

            .quick-attendance-actions {
                grid-template-columns: 1fr;
            }

            .history-chart {
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px;
            }

            .attendance-table {
                font-size: 14px;
            }

            .attendance-table th,
            .attendance-table td {
                padding: 12px 8px;
            }

            .status-select {
                min-width: 100px;
                padding: 6px 8px;
            }

            .note-input {
                min-width: 150px;
            }
        }
    </style>
@endpush

@section('content')
        <div class="filter-card">
            <div class="form-row">
                <div class="form-group">
                    <label for="selectClass">Pilih Kelas</label>
                    <select id="selectClass">
                        <option value="">-- Pilih Kelas --</option>
                        <option value="x-mipa-1" selected>X MIPA 1 - Matematika</option>
                        <option value="xi-ipa-2">XI IPA 2 - Matematika</option>
                        <option value="xii-ips-1">XII IPS 1 - Matematika</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="selectDate">Tanggal</label>
                    <input type="date" id="selectDate" value="2024-01-16">
                </div>
                <div class="form-group">
                    <label for="selectSession">Sesi Pelajaran</label>
                    <select id="selectSession" >
                        <option value="1" selected>Sesi 1 (08:00-09:30)</option>
                    </select>
                </div>
            </div>
        </div>
        <!-- Attendance Stats -->
        <div class="stats-grid compact">
            <div class="stat-card">
                <div class="stat-icon" style="background: #4CAF50;">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stat-info">
                    <h3 id="presentCount">25</h3>
                    <p>Hadir</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #FF9800;">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div class="stat-info">
                    <h3 id="permitCount">2</h3>
                    <p>Izin</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #F44336;">
                    <i class="fas fa-user-times"></i>
                </div>
                <div class="stat-info">
                    <h3 id="absentCount">1</h3>
                    <p>Alpha</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #2196F3;">
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="stat-info">
                    <h3 id="sickCount">1</h3>
                    <p>Sakit</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #9C27B0;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3 id="totalCount">29</h3>
                    <p>Total Siswa</p>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-list"></i> Daftar Kehadiran Siswa - Kelas X MIPA 1</h3>
                <div class="card-actions">
                    <button class="btn-icon" >
                        <i class="fas fa-download"></i>
                    </button>
                    <button class="btn-icon">
                        <i class="fas fa-print"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="attendance-table" id="attendanceTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>NIS</th>
                                <th>Status</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <div class="student-cell">
                                        <img src="https://via.placeholder.com/35" alt="Student" class="student-thumb">
                                        <div>
                                            <strong>Ahmad Fauzi</strong>
                                            <small>Laki-laki</small>
                                        </div>
                                    </div>
                                </td>
                                <td>20241001</td>
                                <td>
                                    <select class="status-select present">
                                        <option value="present" selected>Hadir</option>
                                        <option value="permit">Izin</option>
                                        <option value="sick">Sakit</option>
                                        <option value="absent">Alpha</option>
                                        <option value="late">Terlambat</option>
                                    </select>
                                </td>

                                <td>08:05</td>
                                <td>
                                    <button class="btn-icon" onclick="showStudentDetail(1)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Attendance Actions -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-cogs"></i> Pengaturan Cepat</h3>
            </div>
            <div class="card-body">
                <div class="quick-attendance-actions">
                    <button class="action-btn" >
                        <i class="fas fa-user-check"></i>
                        <span>Tandai Semua Hadir</span>
                    </button>
                    <button class="action-btn">
                        <i class="fas fa-redo"></i>
                        <span>Reset Kehadiran</span>
                    </button>
                    <button class="action-btn">
                        <i class="fas fa-chart-bar"></i>
                        <span>Laporan Kehadiran</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Attendance Notes -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-sticky-note"></i> Catatan Kehadiran</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="attendanceNotes">Catatan untuk sesi ini:</label>
                    <textarea id="attendanceNotes" rows="3" placeholder="Masukkan catatan khusus mengenai kehadiran hari ini...">Kelas hadir dengan baik, hanya 1 siswa yang alpha tanpa keterangan.</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Student Detail -->
    <div id="studentDetailModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Detail Siswa</h3>
                <span class="close" onclick="closeStudentModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div class="student-detail">
                    <div class="student-photo">
                        <img src="https://via.placeholder.com/100" alt="Student Photo">
                    </div>
                    <div class="student-info">
                        <h4 id="studentName">Ahmad Fauzi</h4>
                        <p><strong>NIS:</strong> <span id="studentNIS">20241001</span></p>
                        <p><strong>Kelas:</strong> <span id="studentClass">X MIPA 1</span></p>
                        <p><strong>Jenis Kelamin:</strong> <span id="studentGender">Laki-laki</span></p>

                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeStudentModal()">Tutup</button>

            </div>
        </div>
    </div>

    <!-- Modal Bulk Attendance -->
    <div id="bulkModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Absen Massal</h3>
                <span class="close" onclick="closeBulkModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Pilih Status untuk Semua Siswa:</label>
                    <select id="bulkStatus">
                        <option value="present">Hadir</option>
                        <option value="permit">Izin</option>
                        <option value="sick">Sakit</option>
                        <option value="absent">Alpha</option>
                        <option value="late">Terlambat</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Keterangan Umum (opsional):</label>
                    <textarea id="bulkNote" rows="3" placeholder="Masukkan keterangan umum..."></textarea>
                </div>
                <div class="warning-box">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>Perhatian: Tindakan ini akan mengubah status kehadiran semua siswa dalam kelas terpilih.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeBulkModal()">Batal</button>
                <button class="btn btn-primary" onclick="applyBulkAttendance()">
                    <i class="fas fa-check"></i> Terapkan
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>


        function showStudentDetail(studentId) {
            currentStudentId = studentId;
            const modal = document.getElementById('studentDetailModal');
            modal.style.display = 'block';
        }

        function closeStudentModal() {
            document.getElementById('studentDetailModal').style.display = 'none';
        }

        function showBulkAttendance() {
            document.getElementById('bulkModal').style.display = 'block';
        }

        function closeBulkModal() {
            document.getElementById('bulkModal').style.display = 'none';
        }

        function applyBulkAttendance() {
            const bulkStatus = document.getElementById('bulkStatus').value;
            const bulkNote = document.getElementById('bulkNote').value;

            const statusSelects = document.querySelectorAll('.status-select');
            const noteInputs = document.querySelectorAll('.note-input');

            statusSelects.forEach(select => {
                select.value = bulkStatus;
                select.className = 'status-select ' + bulkStatus;
            });

            if (bulkNote) {
                noteInputs.forEach(input => {
                    input.value = bulkNote;
                });
            }

            updateStats();
            closeBulkModal();
            alert('Absen massal berhasil diterapkan!');
        }

        function markAllPresent() {
            if (confirm('Tandai semua siswa sebagai HADIR?')) {
                const statusSelects = document.querySelectorAll('.status-select');
                statusSelects.forEach(select => {
                    select.value = 'present';
                    select.className = 'status-select present';
                });
                updateStats();
            }
        }

        function resetAttendance() {
            if (confirm('Reset semua kehadiran ke status kosong?')) {
                const statusSelects = document.querySelectorAll('.status-select');
                const noteInputs = document.querySelectorAll('.note-input');

                statusSelects.forEach(select => {
                    select.value = '';
                    select.className = 'status-select';
                });

                noteInputs.forEach(input => {
                    input.value = '';
                });

                updateStats();
            }
        }

        function saveAttendance() {
            // Collect attendance data
            const attendanceRecords = [];
            const rows = document.querySelectorAll('#attendanceTable tbody tr');

            rows.forEach((row, index) => {
                const studentId = index + 1;
                const statusSelect = row.querySelector('.status-select');
                const noteInput = row.querySelector('.note-input');

                attendanceRecords.push({
                    studentId: studentId,
                    status: statusSelect.value,
                    note: noteInput.value,
                    timestamp: new Date().toISOString()
                });
            });

            // Simulate saving
            console.log('Saving attendance:', attendanceRecords);
            alert('Kehadiran berhasil disimpan!');
        }

        function exportAttendance() {
            alert('Fitur export ke Excel akan segera tersedia!');
        }

        function printAttendance() {
            window.print();
        }

        function showAttendanceHistory() {
            alert('Membuka riwayat kehadiran...');
            // Open attendance history page
        }

        function generateReport() {
            alert('Membuat laporan kehadiran...');
            // Generate and download report
        }

        function sendNotificationToParent() {
            alert('Notifikasi berhasil dikirim ke orang tua!');
            closeStudentModal();
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        };
    </script>
    <script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        if (mobileMenuToggle && sidebar) {
            mobileMenuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                mobileMenuToggle.innerHTML = sidebar.classList.contains('active')
                    ? '<i class="fas fa-times"></i>'
                    : '<i class="fas fa-bars"></i>';
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 1024) {
                    if (!sidebar.contains(event.target) &&
                        !mobileMenuToggle.contains(event.target) &&
                        sidebar.classList.contains('active')) {
                        sidebar.classList.remove('active');
                        mobileMenuToggle.innerHTML = '<i class="fas fa-bars"></i>';
                    }
                }
            });
        }

        // Update active link in sidebar
        const currentPage = window.location.pathname.split('/').pop();
        const navLinks = document.querySelectorAll('.sidebar-nav a');
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href === currentPage ||
                (href === 'dashboard.html' && currentPage === '') ||
                (href.includes(currentPage) && currentPage !== '')) {
                link.classList.add('active');
            }
        });
    });
</script>
@endpush
