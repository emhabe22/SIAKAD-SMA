@extends('layouts.app')

@section('title', 'Kelola Kelas - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Kelola Data Kelas')
@section('breadcrumb', 'Admin / Data Kelas')

@php
    $role = 'admin';
    $userName = 'Administrator';
    $userRole = 'Admin Sistem';
@endphp

@section('content')

        <!-- Main Content Container -->
        <div class="content-container">


            <!-- Stats Cards -->
            <div class="stats-grid compact">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #4CAF50;">
                        <i class="fas fa-school"></i>
                    </div>
                    <div class="stat-info">
                        <h3>18</h3>
                        <p>Total Kelas</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #2196F3;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-info">
                        <h3>6</h3>
                        <p>Kelas X</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #FF9800;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-info">
                        <h3>6</h3>
                        <p>Kelas XI</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #9C27B0;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-info">
                        <h3>6</h3>
                        <p>Kelas XII</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #F44336;">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>452</h3>
                        <p>Total Siswa</p>
                    </div>
                </div>
            </div>

            <!-- Classes Table -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-list"></i> Daftar Kelas</h3>
                    <div class="card-actions">
                        <button class="btn-icon" onclick="exportToExcel()" title="Export ke Excel">
                            <i class="fas fa-file-excel"></i>
                        </button>
                        <button class="btn-icon" onclick="printTable()" title="Cetak">
                            <i class="fas fa-print"></i>
                        </button>
                        <button class="btn-icon" onclick="refreshTable()" title="Refresh">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="data-table" id="classesTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kelas</th>
                                    <th>Tingkat</th>
                                    <th>Jurusan</th>

                                    <th>Jumlah Siswa</th>
                                    <th>Ruangan</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <div class="class-cell">
                                            <div class="class-icon">
                                                <i class="fas fa-school"></i>
                                            </div>
                                            <div>
                                                <strong>X MIPA 1</strong>
                                                <small>Kelas Unggulan</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>X</td>
                                    <td><span class="badge badge-mipa">MIPA</span></td>
                                    <td>
                                        <div class="teacher-cell-small">
                                            <img src="https://via.placeholder.com/30" alt="Teacher">
                                            <span>Budi Santoso, S.Pd</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="student-count">
                                            <span class="count">28</span>
                                            <span class="capacity">/32</span>
                                            <div class="progress-bar small">
                                                <div class="progress-fill" style="width: 87.5%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Ruang 201</td>
                                    <td>2024/2025</td>
                                    <td><span class="status-badge active">Aktif</span></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon" onclick="viewClass(1)" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-icon" onclick="editClass(1)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon" onclick="manageStudents(1)" title="Kelola Siswa">
                                                <i class="fas fa-users"></i>
                                            </button>
                                            <button class="btn-icon btn-danger" onclick="deleteClass(1)" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination">
                        <button class="page-btn" disabled>
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">4</button>
                        <button class="page-btn">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>




        </div>

    <!-- Modal Add/Edit Class -->
    <div id="classModal" class="modal">
        <div class="modal-content wide-modal">
            <div class="modal-header">
                <h3 id="modalTitle">Tambah Kelas Baru</h3>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="classForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="className">Nama Kelas *</label>
                            <input type="text" id="className" required placeholder="Contoh: X MIPA 1">
                        </div>
                        <div class="form-group">
                            <label for="classCode">Kode Kelas</label>
                            <input type="text" id="classCode" placeholder="Auto-generate" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="level">Tingkat Kelas *</label>
                            <select id="level" required>
                                <option value="">-- Pilih Tingkat --</option>
                                <option value="X">Kelas X</option>
                                <option value="XI">Kelas XI</option>
                                <option value="XII">Kelas XII</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="major">Jurusan *</label>
                            <select id="major" required>
                                <option value="">-- Pilih Jurusan --</option>
                                <option value="MIPA">MIPA</option>
                                <option value="IPS">IPS</option>
                                <option value="BAHASA">Bahasa</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="homeroomTeacher">Wali Kelas</label>
                            <select id="homeroomTeacher">
                                <option value="">-- Pilih Wali Kelas --</option>
                                <option value="1">Budi Santoso, S.Pd</option>
                                <option value="2">Siti Nurhaliza, M.Pd</option>
                                <option value="3">Dewi Sartika, S.Pd</option>
                                <option value="4">Mulyadi, S.Pd</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="room">Ruangan</label>
                            <input type="text" id="room" placeholder="Contoh: Ruang 201">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="studentCapacity">Kapasitas Siswa *</label>
                            <input type="number" id="studentCapacity" required min="1" max="40" value="32">
                        </div>
                        <div class="form-group">
                            <label for="academicYear">Tahun Ajaran *</label>
                            <select id="academicYear" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                <option value="2023/2024">2023/2024</option>
                                <option value="2024/2025" selected>2024/2025</option>
                                <option value="2025/2026">2025/2026</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Deskripsi Kelas</label>
                        <textarea id="description" rows="3" placeholder="Deskripsi tambahan tentang kelas..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Kelas Unggulan?</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="isExcellent">
                                <span>Ya, kelas ini adalah kelas unggulan</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Status Kelas *</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="status" value="active" checked>
                                <span>Aktif</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="status" value="inactive">
                                <span>Tidak Aktif</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="status" value="graduated">
                                <span>Lulus</span>
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal()">Batal</button>
                <button class="btn btn-primary" onclick="saveClass()">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </div>
    </div>

    <!-- Modal View Class -->
    <div id="viewModal" class="modal">
        <div class="modal-content wide-modal">
            <div class="modal-header">
                <h3>Detail Kelas</h3>
                <span class="close" onclick="closeViewModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div class="class-detail-view">
                    <div class="class-header">
                        <div class="class-icon-large">
                            <i class="fas fa-school"></i>
                        </div>
                        <div class="class-info-large">
                            <h2 id="viewClassName">X MIPA 1</h2>
                            <p class="class-code" id="viewClassCode">Kode: CLS-2024-XMIPA1</p>
                            <div class="class-tags">
                                <span class="badge badge-mipa" id="viewMajor">MIPA</span>
                                <span class="status-badge active" id="viewStatus">Aktif</span>
                                <span class="excellent-badge" id="viewExcellent">Unggulan</span>
                            </div>
                        </div>
                    </div>

                    <div class="detail-tabs">
                        <div class="tab-buttons">
                            <button class="tab-btn active" onclick="showTab('info')">Informasi</button>
                            <button class="tab-btn" onclick="showTab('students')">Daftar Siswa</button>

                        </div>

                        <div class="tab-content active" id="infoTab">
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <label>Tingkat:</label>
                                    <span id="viewLevel">Kelas X</span>
                                </div>
                                <div class="detail-item">
                                    <label>Jurusan:</label>
                                    <span id="viewMajorInfo">MIPA</span>
                                </div>


                                <div class="detail-item">
                                    <label>Kapasitas:</label>
                                    <span id="viewCapacity">32 siswa</span>
                                </div>
                                <div class="detail-item">
                                    <label>Tahun Ajaran:</label>
                                    <span id="viewAcademicYear">2024/2025</span>
                                </div>
                                <div class="detail-item full-width">
                                    <label>Deskripsi:</label>
                                    <p id="viewDescription">Kelas unggulan dengan fokus pada pengembangan kemampuan sains dan matematika.</p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content" id="studentsTab">
                            <div class="students-list">
                                <div class="list-header">
                                    <h4>Daftar Siswa (28/32)</h4>
                                    <button class="btn btn-sm btn-primary" onclick="manageStudentsFromView()">
                                        <i class="fas fa-users-cog"></i> Kelola Siswa
                                    </button>
                                </div>
                                <div class="students-table">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Siswa</th>
                                                <th>NIS</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Ahmad Fauzi</td>
                                                <td>20241001</td>
                                                <td>Laki-laki</td>
                                                <td><span class="status-badge active">Aktif</span></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Dewi Anggraini</td>
                                                <td>20241002</td>
                                                <td>Perempuan</td>
                                                <td><span class="status-badge active">Aktif</span></td>
                                            </tr>
                                            <!-- Add more students as needed -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content" id="scheduleTab">
                            <div class="schedule-view">
                                <h4>Jadwal Pelajaran</h4>
                                <div class="schedule-grid">
                                    <div class="schedule-day">
                                        <h5>Senin</h5>
                                        <div class="schedule-items">
                                            <div class="schedule-item">
                                                <span class="time">07:30 - 09:00</span>
                                                <span class="subject">Matematika</span>
                                                <span class="teacher">Budi Santoso</span>
                                            </div>
                                            <div class="schedule-item">
                                                <span class="time">09:30 - 11:00</span>
                                                <span class="subject">Fisika</span>
                                                <span class="teacher">Ahmad Hidayat</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Add more days as needed -->
                                </div>
                            </div>
                        </div>

                        <div class="tab-content" id="subjectsTab">
                            <div class="subjects-list">
                                <h4>Mata Pelajaran</h4>
                                <div class="subject-items">
                                    <div class="subject-item">
                                        <div class="subject-icon">
                                            <i class="fas fa-calculator"></i>
                                        </div>
                                        <div class="subject-info">
                                            <h5>Matematika</h5>
                                            <p>Budi Santoso, S.Pd</p>
                                        </div>
                                        <span class="subject-hours">4 jam/minggu</span>
                                    </div>
                                    <div class="subject-item">
                                        <div class="subject-icon">
                                            <i class="fas fa-atom"></i>
                                        </div>
                                        <div class="subject-info">
                                            <h5>Fisika</h5>
                                            <p>Ahmad Hidayat, M.Si</p>
                                        </div>
                                        <span class="subject-hours">3 jam/minggu</span>
                                    </div>
                                    <!-- Add more subjects as needed -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeViewModal()">Tutup</button>
                <button class="btn btn-primary" onclick="editFromView()">
                    <i class="fas fa-edit"></i> Edit Data
                </button>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="../assets/js/main.js"></script>
<script src="../assets/js/admin-classes.js"></script>
<script>
        let currentClassId = null;
        let isEditMode = false;

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize DataTable
            $('#classesTable').DataTable({
                pageLength: 10,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });

            // Mobile menu
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const sidebar = document.getElementById('sidebar');

            if (mobileMenuToggle && sidebar) {
                mobileMenuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    mobileMenuToggle.innerHTML = sidebar.classList.contains('active')
                        ? '<i class="fas fa-times"></i>'
                        : '<i class="fas fa-bars"></i>';
                });
            }

            // Auto-generate class code
            document.getElementById('className').addEventListener('input', function() {
                const className = this.value;
                if (className) {
                    const code = 'CLS-' + new Date().getFullYear() + '-' + className.toUpperCase().replace(/\s+/g, '');
                    document.getElementById('classCode').value = code;
                }
            });
        });

        function showAddModal() {
            isEditMode = false;
            currentClassId = null;
            document.getElementById('modalTitle').textContent = 'Tambah Kelas Baru';
            document.getElementById('classForm').reset();
            document.getElementById('classModal').style.display = 'block';
        }

        function editClass(id) {
            isEditMode = true;
            currentClassId = id;
            document.getElementById('modalTitle').textContent = 'Edit Data Kelas';
            // Load class data into form
            loadClassData(id);
            document.getElementById('classModal').style.display = 'block';
        }

        function viewClass(id) {
            currentClassId = id;
            // Load class data for view
            loadViewData(id);
            document.getElementById('viewModal').style.display = 'block';
        }

        function loadClassData(id) {
            // Simulate loading data
            const classData = {
                className: 'X MIPA 1',
                classCode: 'CLS-2024-XMIPA1',
                level: 'X',
                major: 'MIPA',
                homeroomTeacher: '1',
                room: 'Ruang 201',
                studentCapacity: '32',
                academicYear: '2024/2025',
                description: 'Kelas unggulan dengan fokus pada pengembangan kemampuan sains dan matematika.',
                isExcellent: true,
                status: 'active'
            };

            // Populate form
            Object.keys(classData).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    if (element.type === 'checkbox') {
                        element.checked = classData[key];
                    } else if (element.type === 'radio') {
                        document.querySelector(`input[name="status"][value="${classData[key]}"]`).checked = true;
                    } else {
                        element.value = classData[key];
                    }
                }
            });
        }

        function loadViewData(id) {
            // Simulate loading view data
            const viewData = {
                className: 'X MIPA 1',
                classCode: 'CLS-2024-XMIPA1',
                major: 'MIPA',
                status: 'active',
                level: 'Kelas X',
                majorInfo: 'MIPA',
                room: 'Ruang 201',
                capacity: '32 siswa',
                academicYear: '2024/2025',
                description: 'Kelas unggulan dengan fokus pada pengembangan kemampuan sains dan matematika.',
                excellent: 'Unggulan'
            };

            // Populate view
            Object.keys(viewData).forEach(key => {
                const element = document.getElementById('view' + key.charAt(0).toUpperCase() + key.slice(1));
                if (element) {
                    element.textContent = viewData[key];
                    if (element.classList && element.classList.contains('status-badge')) {
                        element.className = 'status-badge ' + viewData[key];
                    }
                }
            });
        }

        function saveClass() {
            const form = document.getElementById('classForm');
            if (form.checkValidity()) {
                if (isEditMode) {
                    alert(`Data kelas #${currentClassId} berhasil diperbarui!`);
                } else {
                    alert('Kelas baru berhasil ditambahkan!');
                }
                closeModal();
            } else {
                alert('Harap lengkapi semua field yang wajib diisi!');
            }
        }

        function deleteClass(id) {
            if (confirm('Apakah Anda yakin ingin menghapus kelas ini?')) {
                alert(`Kelas #${id} berhasil dihapus!`);
                // Implement delete functionality
            }
        }

        function manageStudents(id) {
            alert(`Membuka pengelolaan siswa untuk kelas #${id}`);
            // Implement student management
        }

        function filterTable() {
            const levelFilter = document.getElementById('filterLevel').value;
            const majorFilter = document.getElementById('filterMajor').value;
            const yearFilter = document.getElementById('filterYear').value;
            const searchTerm = document.getElementById('searchClass').value.toLowerCase();

            // Implement filtering logic
            console.log(`Filtering: Level=${levelFilter}, Major=${majorFilter}, Year=${yearFilter}, Search=${searchTerm}`);
        }

        function resetFilters() {
            document.getElementById('filterLevel').value = 'all';
            document.getElementById('filterMajor').value = 'all';
            document.getElementById('filterYear').value = 'all';
            document.getElementById('searchClass').value = '';
            filterTable();
        }

        function exportToExcel() {
            alert('Data kelas berhasil diexport ke Excel!');
        }

        function printTable() {
            window.print();
        }

        function refreshTable() {
            alert('Tabel kelas diperbarui!');
        }

        function assignHomeroomTeacher() {
            alert('Membuka form penugasan wali kelas...');
        }

        function generateClassSchedule() {
            alert('Generate jadwal kelas...');
        }

        function moveStudents() {
            alert('Membuka form pemindahan siswa...');
        }

        function exportClassData() {
            alert('Export data kelas...');
        }

        function closeModal() {
            document.getElementById('classModal').style.display = 'none';
        }

        function closeViewModal() {
            document.getElementById('viewModal').style.display = 'none';
        }

        function editFromView() {
            closeViewModal();
            editClass(currentClassId);
        }

        function printClassReport() {
            alert('Mencetak rapor kelas...');
        }

        function manageStudentsFromView() {
            closeViewModal();
            manageStudents(currentClassId);
        }

        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabName + 'Tab').classList.add('active');

            // Add active class to clicked button
            event.currentTarget.classList.add('active');
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
@endpush
