@extends('layouts.app')

@section('title', 'Kelola Siswa - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Kelola Data Siswa')
@section('breadcrumb', 'Admin / Data Siswa')

@php
    $role = 'admin';
    $userName = 'Administrator';
    $userRole = 'Admin Sistem';
@endphp

@push('styles')
<style>
    /* Badge styles */
    .badge {
        padding: 6px 12px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        text-align: center;
        white-space: nowrap;
        margin: 2px;
    }

    .badge-tingkat-x {
        background-color: #2196F3;
        color: white;
    }

    .badge-tingkat-xi {
        background-color: #4CAF50;
        color: white;
    }

    .badge-tingkat-xii {
        background-color: #FF9800;
        color: white;
    }

    /* Filter Pill Styles */
    .filter-container {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
        background: #f8fafc;
        padding: 12px 20px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .filter-label {
        font-weight: 600;
        color: #475569;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-pills {
        display: flex;
        gap: 8px;
        background: #e2e8f0;
        padding: 4px;
        border-radius: 30px;
    }

    .filter-pill {
        border: none;
        background: transparent;
        padding: 6px 18px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .filter-pill:hover {
        color: #1e293b;
    }

    .filter-pill.active {
        background: #ffffff;
        color: #2196F3;
        box-shadow: 0 2px 4px rgba(0,0,0,0.06);
    }

    /* Search Box Styles in Header */
    .search-box-container {
        position: relative;
    }

    .search-input {
        padding: 8px 12px 8px 36px;
        border-radius: 30px;
        border: 1px solid #e2e8f0;
        outline: none;
        font-size: 14px;
        width: 240px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: #f8fafc;
    }

    .search-input:focus {
        border-color: #2196F3;
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.15);
        width: 300px;
    }

    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        pointer-events: none;
        transition: color 0.3s ease;
    }

    .search-input:focus + .search-icon {
        color: #2196F3;
    }
</style>
@endpush

@section('content')

        <!-- Main Content Container -->
        <div class="content-container">


            <!-- Stats Cards -->
            <div class="stats-grid compact">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #2196F3;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="statTingkatX">0</h3>
                        <p>Tingkat X</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #FF9800;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="statTingkatXI">0</h3>
                        <p>Tingkat XI</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #9C27B0;">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="statTingkatXII">0</h3>
                        <p>Tingkat XII</p>
                    </div>
                </div>
    
            </div>

            <div class="card">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                    <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                        <h3 style="margin: 0;"><i class="fas fa-list"></i> Daftar Siswa</h3>
                        <div class="search-box-container">
                            <input type="text" id="siswaSearchInput" class="search-input" placeholder="Cari nama atau NISN..." oninput="handleSiswaSearch()">
                            <i class="fas fa-search search-icon"></i>
                        </div>
                    </div>
                    <div class="card-actions">
                        <button class="btn btn-primary" onclick="showAddModal()" style="margin-right: 10px;">
                            <i class="fas fa-plus"></i> Tambah Siswa
                        </button>
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
                    <!-- Filter Tingkat -->
                    <div class="filter-container">
                        <span class="filter-label"><i class="fas fa-filter"></i> Filter Tingkat:</span>
                        <div class="filter-pills">
                            <button class="filter-pill active" onclick="filterByTingkat('all')" data-tingkat="all">Semua</button>
                            <button class="filter-pill" onclick="filterByTingkat('X')" data-tingkat="X">Tingkat X</button>
                            <button class="filter-pill" onclick="filterByTingkat('XI')" data-tingkat="XI">Tingkat XI</button>
                            <button class="filter-pill" onclick="filterByTingkat('XII')" data-tingkat="XII">Tingkat XII</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="data-table" id="studentsTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th>Tingkat</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Telepon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="siswaTableBody">
                                <!-- Data will be loaded via JavaScript -->
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
                        <button class="page-btn">5</button>
                        <button class="page-btn">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>


        </div>

    <!-- Modal Add/Edit Student -->
    <div id="studentModal" class="modal">
        <div class="modal-content wide-modal">
            <div class="modal-header">
                <h3 id="modalTitle">Tambah Siswa Baru</h3>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="studentForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nisn">NISN *</label>
                            <input type="text" id="nisn" required placeholder="Masukkan NISN">
                        </div>
                        <div class="form-group">
                            <label for="fullName">Nama Lengkap *</label>
                            <input type="text" id="fullName" required placeholder="Masukkan nama lengkap">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="foto">Foto Siswa</label>
                        <input type="file" id="foto" accept="image/*" onchange="previewImage(this)">
                        <div id="imagePreview" style="margin-top: 10px; display: none;">
                            <img id="preview" src="" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; border: 2px solid #ddd;">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" id="tempat_lahir" placeholder="Masukkan tempat lahir">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select id="jenis_kelamin">
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="agama">Agama</label>
                            <select id="agama">
                                <option value="">-- Pilih --</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="tingkat">Tingkat *</label>
                            <select id="tingkat" required>
                                <option value="">-- Pilih Tingkat --</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tahun_masuk">Tahun Masuk</label>
                            <input type="number" id="tahun_masuk" placeholder="Contoh: 2024" min="2000" max="2100">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat Lengkap *</label>
                        <textarea id="alamat" rows="3" required placeholder="Masukkan alamat lengkap"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="no_telp">Nomor Telepon *</label>
                            <input type="tel" id="no_telp" required placeholder="Masukkan nomor telepon">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" placeholder="Masukkan email">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="nama_wali">Nama Ayah *</label>
                            <input type="text" id="nama_wali" required placeholder="Masukkan nama ayah">
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan_ayah">Pekerjaan Ayah</label>
                            <input type="text" id="pekerjaan_ayah" placeholder="Pekerjaan ayah">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="nama_ibu">Nama Ibu</label>
                            <input type="text" id="nama_ibu" placeholder="Masukkan nama ibu">
                        </div>
                        <div class="form-group">
                            <label for="pekerjaan_ibu">Pekerjaan Ibu</label>
                            <input type="text" id="pekerjaan_ibu" placeholder="Pekerjaan ibu">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="telp_ortu">Telepon Orang Tua</label>
                        <input type="tel" id="telp_ortu" placeholder="Nomor telepon orang tua">
                    </div>
                        <div class="form-group">
                            <label for="password">Password *</label>
                            <input type="password" id="password" placeholder="Minimal 6 karakter">
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button class="btn btn-secondary" onclick="closeModal()">Batal</button>
                    <button class="btn btn-primary" onclick="saveStudent()">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="../assets/js/main.js"></script>
<script src="../assets/js/admin-students.js"></script>
<script>
        let currentStudentId = null;
        let isEditMode = false;
        let siswasData = [];
        let currentTingkatFilter = 'all';
        let searchQuery = '';
        let currentPage = 1;
        const itemsPerPage = 10;

        function handleSiswaSearch() {
            searchQuery = document.getElementById('siswaSearchInput').value.toLowerCase().trim();
            currentPage = 1; // Reset to page 1 on search
            applyFilterAndSearch();
        }

        function filterByTingkat(tingkat) {
            currentTingkatFilter = tingkat;
            currentPage = 1; // Reset to page 1 on filter
            
            // Update active pill UI
            document.querySelectorAll('.filter-pill').forEach(pill => {
                pill.classList.remove('active');
                if (pill.getAttribute('data-tingkat') === tingkat) {
                    pill.classList.add('active');
                }
            });

            applyFilterAndSearch();
        }

        function changePage(page) {
            currentPage = page;
            applyFilterAndSearch();
        }

        function applyFilterAndSearch() {
            // 1. Filter by Tingkat
            let filtered = siswasData;
            if (currentTingkatFilter !== 'all') {
                filtered = filtered.filter(s => s.tingkat === currentTingkatFilter);
            }
            
            // 2. Filter by Search Query
            if (searchQuery) {
                filtered = filtered.filter(s => 
                    (s.nama && s.nama.toLowerCase().includes(searchQuery)) ||
                    (s.nisn && s.nisn.toLowerCase().includes(searchQuery))
                );
            }
            
            // 3. Paginate
            const totalItems = filtered.length;
            const startIndex = (currentPage - 1) * itemsPerPage;
            const paginatedData = filtered.slice(startIndex, startIndex + itemsPerPage);
            
            // 4. Render Table
            renderTable(paginatedData, startIndex);
            
            // 5. Render Pagination
            renderPagination(totalItems);
        }

        function renderPagination(totalItems) {
            const totalPages = Math.ceil(totalItems / itemsPerPage) || 1;
            const paginationContainer = document.querySelector('.pagination');
            if (!paginationContainer) return;
            
            if (currentPage > totalPages) currentPage = totalPages;
            
            let html = `
                <button class="page-btn" ${currentPage === 1 ? 'disabled' : ''} onclick="changePage(${currentPage - 1})">
                    <i class="fas fa-chevron-left"></i>
                </button>
            `;
            
            for (let i = 1; i <= totalPages; i++) {
                html += `
                    <button class="page-btn ${currentPage === i ? 'active' : ''}" onclick="changePage(${i})">${i}</button>
                `;
            }
            
            html += `
                <button class="page-btn" ${currentPage === totalPages ? 'disabled' : ''} onclick="changePage(${currentPage + 1})">
                    <i class="fas fa-chevron-right"></i>
                </button>
            `;
            
            paginationContainer.innerHTML = html;
        }

        // Fetch data siswa dari API
        async function fetchSiswas() {
            try {
                const token = localStorage.getItem('token');
                
                if (!token) {
                    alert('Anda belum login. Silakan login terlebih dahulu.');
                    window.location.href = '/login';
                    return;
                }

                const response = await fetch('/api/admin/siswa', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (response.status === 401) {
                    alert('Sesi login Anda telah berakhir. Silakan login kembali.');
                    localStorage.removeItem('token');
                    window.location.href = '/login';
                    return;
                }

                if (!response.ok) {
                    throw new Error('Failed to fetch data');
                }

                const result = await response.json();
                if (result.success) {
                    siswasData = result.data;
                    currentTingkatFilter = 'all';
                    searchQuery = '';
                    document.getElementById('siswaSearchInput').value = '';
                    document.querySelectorAll('.filter-pill').forEach(pill => {
                        pill.classList.remove('active');
                        if (pill.getAttribute('data-tingkat') === 'all') {
                            pill.classList.add('active');
                        }
                    });
                    applyFilterAndSearch();
                    updateStats(siswasData);
                } else {
                    console.error('API returned error:', result);
                }
            } catch (error) {
                console.error('Error fetching siswas:', error);
                alert('Gagal memuat data siswa. Silakan refresh halaman.');
            }
        }

        // Render data ke tabel
        function renderTable(data, startIndex = 0) {
            const tbody = document.getElementById('siswaTableBody');
            tbody.innerHTML = '';

            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align: center;">Tidak ada data siswa</td></tr>';
                return;
            }

            data.forEach((siswa, index) => {
                const jenisKelamin = siswa.jenis_kelamin === 'L' ? 'Laki-laki' : siswa.jenis_kelamin === 'P' ? 'Perempuan' : '-';
                
                let tingkatBadge = '';
                switch(siswa.tingkat) {
                    case 'X':
                        tingkatBadge = '<span class="badge badge-tingkat-x">Kelas X</span>';
                        break;
                    case 'XI':
                        tingkatBadge = '<span class="badge badge-tingkat-xi">Kelas XI</span>';
                        break;
                    case 'XII':
                        tingkatBadge = '<span class="badge badge-tingkat-xii">Kelas XII</span>';
                        break;
                    default:
                        tingkatBadge = `<span class="badge badge-default">${siswa.tingkat || '-'}</span>`;
                }

                const row = `
                    <tr>
                        <td>${startIndex + index + 1}</td>
                        <td><strong>${siswa.nisn || '-'}</strong></td>
                        <td><strong>${siswa.nama || '-'}</strong></td>
                        <td>${tingkatBadge}</td>
                        <td>${jenisKelamin}</td>
                        <td>${siswa.no_telp || '-'}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon" onclick="viewStudent(${siswa.id})" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-icon" onclick="editStudent(${siswa.id})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-icon btn-danger" onclick="deleteStudent(${siswa.id})" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        // Update statistik
        function updateStats(data) {
            const total = data.length;
            const tingkatX = data.filter(s => s.tingkat === 'X').length;
            const tingkatXI = data.filter(s => s.tingkat === 'XI').length;
            const tingkatXII = data.filter(s => s.tingkat === 'XII').length;

            document.getElementById('statTingkatX').textContent = tingkatX;
            document.getElementById('statTingkatXI').textContent = tingkatXI;
            document.getElementById('statTingkatXII').textContent = tingkatXII;
        }

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

        // Preview image before upload
        function previewImage(input) {
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('imagePreview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.style.display = 'block';
                };
                
                reader.readAsDataURL(input.files[0]);
            } else {
                previewContainer.style.display = 'none';
            }
        }

        // Show Add Modal
        function showAddModal() {
            isEditMode = false;
            currentStudentId = null;
            document.getElementById('modalTitle').textContent = 'Tambah Siswa Baru';
            document.getElementById('studentForm').reset();
            document.getElementById('password').required = true;
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('studentModal').style.display = 'block';
        }

        // Edit Student
        async function editStudent(id) {
            const token = getToken();
            if (!token) return;

            try {
                const response = await fetch(`/api/admin/siswa/${id}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (response.ok) {
                    const result = await response.json();
                    if (result.success) {
                        isEditMode = true;
                        currentStudentId = id;
                        loadStudentData(result.data);
                        document.getElementById('modalTitle').textContent = 'Edit Data Siswa';
                        document.getElementById('password').required = false;
                        document.getElementById('studentModal').style.display = 'block';
                    }
                } else {
                    alert('Gagal memuat data siswa');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat data');
            }
        }

        // Load student data to form
        function loadStudentData(data) {
            document.getElementById('nisn').value = data.nisn || '';
            document.getElementById('fullName').value = data.nama || '';
            document.getElementById('tingkat').value = data.tingkat || '';
            document.getElementById('nama_wali').value = data.nama_wali || '';
            document.getElementById('alamat').value = data.alamat || '';
            document.getElementById('no_telp').value = data.no_telp || '';
            document.getElementById('password').value = ''; // Don't show password
            document.getElementById('tempat_lahir').value = data.tempat_lahir || '';
            document.getElementById('tanggal_lahir').value = data.tanggal_lahir || '';
            document.getElementById('jenis_kelamin').value = data.jenis_kelamin || '';
            document.getElementById('agama').value = data.agama || '';
            document.getElementById('email').value = data.email || '';
            document.getElementById('tahun_masuk').value = data.tahun_masuk || '';
            document.getElementById('nama_ibu').value = data.nama_ibu || '';
            document.getElementById('pekerjaan_ayah').value = data.pekerjaan_ayah || '';
            document.getElementById('pekerjaan_ibu').value = data.pekerjaan_ibu || '';
            document.getElementById('telp_ortu').value = data.telp_ortu || '';
            
            // Show existing photo if available
            if (data.foto) {
                const preview = document.getElementById('preview');
                const previewContainer = document.getElementById('imagePreview');
                preview.src = `/storage/${data.foto}`;
                previewContainer.style.display = 'block';
            } else {
                document.getElementById('imagePreview').style.display = 'none';
            }
        }

        // Save Student (Create or Update)
        async function saveStudent() {
            const form = document.getElementById('studentForm');
            
            // Validasi hanya untuk mode tambah, skip untuk mode edit
            if (!isEditMode && !form.checkValidity()) {
                alert('Harap lengkapi semua field yang wajib diisi!');
                form.reportValidity();
                return;
            }

            const token = getToken();
            if (!token) return;

            // Use FormData to handle file uploads
            const formData = new FormData();
            
            // Only add fields that have values
            const fullName = document.getElementById('fullName').value;
            const nisn = document.getElementById('nisn').value;
            const alamat = document.getElementById('alamat').value;
            const noTelp = document.getElementById('no_telp').value;
            const tingkat = document.getElementById('tingkat').value;
            const namaWali = document.getElementById('nama_wali').value;
            
            if (fullName) formData.append('nama', fullName);
            if (nisn) formData.append('nisn', nisn);
            if (alamat) formData.append('alamat', alamat);
            if (noTelp) formData.append('no_telp', noTelp);
            if (tingkat) formData.append('tingkat', tingkat);
            if (namaWali) formData.append('nama_wali', namaWali);
            
            // Optional fields
            if (document.getElementById('tempat_lahir').value) formData.append('tempat_lahir', document.getElementById('tempat_lahir').value);
            if (document.getElementById('tanggal_lahir').value) formData.append('tanggal_lahir', document.getElementById('tanggal_lahir').value);
            if (document.getElementById('jenis_kelamin').value) formData.append('jenis_kelamin', document.getElementById('jenis_kelamin').value);
            if (document.getElementById('agama').value) formData.append('agama', document.getElementById('agama').value);
            if (document.getElementById('email').value) formData.append('email', document.getElementById('email').value);
            if (document.getElementById('tahun_masuk').value) formData.append('tahun_masuk', document.getElementById('tahun_masuk').value);
            if (document.getElementById('nama_ibu').value) formData.append('nama_ibu', document.getElementById('nama_ibu').value);
            if (document.getElementById('pekerjaan_ayah').value) formData.append('pekerjaan_ayah', document.getElementById('pekerjaan_ayah').value);
            if (document.getElementById('pekerjaan_ibu').value) formData.append('pekerjaan_ibu', document.getElementById('pekerjaan_ibu').value);
            if (document.getElementById('telp_ortu').value) formData.append('telp_ortu', document.getElementById('telp_ortu').value);

            // Add password if provided
            const password = document.getElementById('password').value;
            if (password) {
                formData.append('password', password);
            }

            // Add file if selected
            const fotoInput = document.getElementById('foto');
            if (fotoInput.files.length > 0) {
                formData.append('foto', fotoInput.files[0]);
            }

            // For PUT requests, Laravel expects _method field
            if (isEditMode) {
                formData.append('_method', 'PUT');
            }

            try {
                const url = isEditMode ? `/api/admin/siswa/${currentStudentId}` : '/api/admin/siswa';
                const method = 'POST'; // Always POST when using FormData with files

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}` 
                        // Don't set Content-Type, browser will set it with boundary
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    alert(result.message || 'Data siswa berhasil disimpan!');
                    closeModal();
                    fetchSiswas(); // Reload data
                } else {
                    alert(result.message || 'Gagal menyimpan data siswa');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan data');
            }
        }

        // Delete Student
        async function deleteStudent(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus siswa ini?')) {
                return;
            }

            const token = getToken();
            if (!token) return;

            try {
                const response = await fetch(`/api/admin/siswa/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    alert(result.message || 'Siswa berhasil dihapus!');
                    fetchSiswas(); // Reload data
                } else {
                    alert(result.message || 'Gagal menghapus siswa');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus data');
            }
        }

        // View Student Detail
        async function viewStudent(id) {
            const token = getToken();
            if (!token) return;

            try {
                const response = await fetch(`/api/admin/siswa/${id}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (response.ok) {
                    const result = await response.json();
                    if (result.success) {
                        currentStudentId = id;
                        loadViewData(result.data);
                        document.getElementById('viewModal').style.display = 'block';
                    }
                } else {
                    alert('Gagal memuat detail siswa');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat data');
            }
        }

        // Load view data to modal
        function loadViewData(data) {
            // Header info
            document.getElementById('viewName').textContent = data.nama || '-';
            document.getElementById('viewNIS').textContent = `NISN: ${data.nisn || '-'}`;
            document.getElementById('viewClass').textContent = data.tingkat ? `Tingkat ${data.tingkat}` : '-';
            
            // Display photo
            const viewPhoto = document.getElementById('viewPhoto');
            if (data.foto) {
                viewPhoto.src = `/storage/${data.foto}`;
            } else {
                viewPhoto.src = 'https://via.placeholder.com/120';
            }
            
            // Tab Data Pribadi
            document.getElementById('viewNISN').textContent = data.nisn || '-';
            const birthPlace = data.tempat_lahir || '-';
            const birthDate = data.tanggal_lahir || '-';
            document.getElementById('viewBirth').textContent = birthDate !== '-' ? `${birthPlace}, ${birthDate}` : birthPlace;
            document.getElementById('viewGender').textContent = data.jenis_kelamin === 'L' ? 'Laki-laki' : (data.jenis_kelamin === 'P' ? 'Perempuan' : '-');
            document.getElementById('viewReligion').textContent = data.agama || '-';
            document.getElementById('viewAddress').textContent = data.alamat || '-';
            document.getElementById('viewPhone').textContent = data.no_telp || '-';
            document.getElementById('viewEmail').textContent = data.email || data.user?.username || '-';
            
            // Tab Data Akademik
            document.getElementById('viewAcademicClass').textContent = data.tingkat ? `Tingkat ${data.tingkat}` : '-';
            const viewMajor = document.getElementById('viewMajor');
            if (viewMajor) {
                viewMajor.textContent = data.tingkat ? `Tingkat ${data.tingkat}` : '-';
            }
            document.getElementById('viewEntryYear').textContent = data.tahun_masuk || '-';
            
            // Tab Data Keluarga
            document.getElementById('viewFather').textContent = data.nama_wali || '-';
            document.getElementById('viewFatherJob').textContent = data.pekerjaan_ayah || '-';
            document.getElementById('viewMother').textContent = data.nama_ibu || '-';
            document.getElementById('viewMotherJob').textContent = data.pekerjaan_ibu || '-';
            document.getElementById('viewParentPhone').textContent = data.telp_ortu || '-';
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Load data siswa
            fetchSiswas();

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

            // File upload preview (commented out - field removed from form)
            /* 
            document.getElementById('photoUpload')?.addEventListener('change', function(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('filePreview');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML = `
                            <div class="preview-image">
                                <img src="${e.target.result}" alt="Preview">
                                <button type="button" class="remove-image" onclick="removePreview()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        `;
                    };
                    reader.readAsDataURL(file);
                }
            });
            */
        });

        function filterTable() {
            const classFilter = document.getElementById('filterClass').value;
            const majorFilter = document.getElementById('filterMajor').value;
            const searchTerm = document.getElementById('searchStudent').value.toLowerCase();

            // Implement filtering logic
            console.log(`Filtering: Class=${classFilter}, Major=${majorFilter}, Search=${searchTerm}`);
        }

        function resetFilters() {
            document.getElementById('filterClass').value = 'all';
            document.getElementById('filterMajor').value = 'all';
            document.getElementById('searchStudent').value = '';
            filterTable();
        }

        function exportToExcel() {
            alert('Data siswa berhasil diexport ke Excel!');
        }

        function printTable() {
            window.print();
        }

        function refreshTable() {
            fetchSiswas();
        }

        function applyBulkAction() {
            const action = document.getElementById('bulkAction').value;
            if (!action) {
                alert('Pilih tindakan terlebih dahulu!');
                return;
            }

            if (confirm(`Terapkan tindakan "${action}" pada siswa terpilih?`)) {
                alert(`Tindakan "${action}" berhasil diterapkan!`);
            }
        }

        function selectAllStudents() {
            alert('Semua siswa dipilih!');
        }

        function deselectAllStudents() {
            alert('Pilihan dibatalkan!');
        }

        function closeModal() {
            document.getElementById('studentModal').style.display = 'none';
        }

        function closeViewModal() {
            document.getElementById('viewModal').style.display = 'none';
        }

        function editFromView() {
            closeViewModal();
            editStudent(currentStudentId);
        }

        function printStudentCard() {
            alert('Kartu siswa sedang dicetak...');
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

        /*
        function removePreview() {
            document.getElementById('filePreview').innerHTML = '';
            document.getElementById('photoUpload').value = '';
        }
        */

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
