@extends('layouts.app')

@section('title', 'Kelola Guru - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Kelola Data Guru')
@section('breadcrumb', 'Admin / Data Guru')

@php
    $role = 'admin';
    $userName = 'Administrator';
    $userRole = 'Admin Sistem';
@endphp

@section('content')

<style>
    /* Badge styles for Jabatan */
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

    .badge-guru-mapel {
        background-color: #9C27B0;
        color: white;
    }

    .badge-kepala-sekolah {
        background-color: #F44336;
        color: white;
    }

    .badge-wali-kelas {
        background-color: #2196F3;
        color: white;
    }

    .badge-guru-bk {
        background-color: #4CAF50;
        color: white;
    }

    .badge-default {
        background-color: #9E9E9E;
        color: white;
    }
</style>

        <!-- Main Content Container -->
        <div class="content-container">


            <!-- Stats Cards -->
            <div class="stats-grid compact">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #4CAF50;">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="statTotalGuru">0</h3>
                        <p>Total Guru</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #FF9800;">
                        <i class="fas fa-female"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="statGuruPerempuan">0</h3>
                        <p>Guru Perempuan</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #9C27B0;">
                        <i class="fas fa-male"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="statGuruLaki">0</h3>
                        <p>Guru Laki-laki</p>
                    </div>
                </div>
            </div>

            <!-- Teachers Table -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-list"></i> Daftar Guru</h3>
                    <div class="card-actions">
                        <button class="btn btn-primary" onclick="openAddModal()" style="margin-right: 10px">
                            <i class="fas fa-plus"></i> Tambah Guru
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
                    <div class="table-responsive">
                        <table class="data-table" id="teachersTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama Guru</th>
                                    <th>Jabatan</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="guruTableBody">
                                <tr>
                                    <td colspan="7" style="text-align: center;">Memuat data...</td>
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
                        <button class="page-btn">5</button>
                        <button class="page-btn">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>


        </div>

    <!-- Modal Add/Edit Teacher -->
    <div id="teacherModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Tambah Guru Baru</h3>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="teacherForm">
                    <input type="hidden" id="guruId">
                    <div class="form-group">
                        <label for="nip">NIP *</label>
                        <input type="text" id="nip" required placeholder="Masukkan NIP">
                    </div>

                    <div class="form-group">
                        <label for="fullName">Nama Lengkap *</label>
                        <input type="text" id="fullName" required placeholder="Masukkan nama lengkap">
                    </div>

                    <div class="form-group">
                        <label for="gender">Jenis Kelamin *</label>
                        <select id="gender" required>
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Jabatan *</label>
                        <div id="jabatanGroup" class="checkbox-group" style="flex-direction: column; align-items: flex-start; gap: 10px;">
                            <label class="checkbox-label">
                                <input type="checkbox" name="jabatan[]" value="Guru Mata Pelajaran">
                                <span>Guru Mata Pelajaran</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="jabatan[]" value="Kepala Sekolah">
                                <span>Kepala Sekolah</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="jabatan[]" value="Wali Kelas">
                                <span>Wali Kelas</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="jabatan[]" value="Guru BK">
                                <span>Guru BK</span>
                            </label>
                        </div>
                        <small class="form-text">Klik untuk memilih lebih dari satu. <strong>Guru BK tidak dapat dikombinasikan dengan jabatan lain.</strong></small>
                    </div>

                    <div class="form-group">
                        <label>Mata Pelajaran *</label>
                        <div id="mapelGroup" class="checkbox-group" style="flex-direction: column; align-items: flex-start; gap: 10px; max-height: 200px; overflow-y: auto; border: 1px solid #e2e8f0; padding: 12px; border-radius: 8px; background: #f8fafc; width: 100%;">
                            <!-- Populated dynamically -->
                        </div>
                        <small class="form-text">Pilih salah satu mata pelajaran (hanya dapat memilih 1).</small>
                    </div>

                    <div class="form-group">
                        <label for="address">Alamat *</label>
                        <textarea id="address" rows="3" required placeholder="Masukkan alamat"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="phone">Telepon *</label>
                        <input type="tel" id="phone" required placeholder="Masukkan nomor telepon">
                    </div>

                    <div class="form-group">
                        <label for="username">Username *</label>
                        <input type="text" id="username" required placeholder="Masukkan username">
                    </div>

                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" id="password" placeholder="Masukkan password">
                        <small style="color: #666;" id="passwordNote">Minimal 6 karakter</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal()">Batal</button>
                <button class="btn btn-primary" onclick="saveGuru()">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
        let currentGuruId = null;
        let isEditMode = false;
        let allMapels = [];

        document.addEventListener('DOMContentLoaded', function() {
            fetchGurus();
            fetchMapels();
            
            // Handle BK exclusivity (checkbox-based)
            const jabatanCheckboxes = document.querySelectorAll('input[name="jabatan[]"]');
            jabatanCheckboxes.forEach(cb => cb.addEventListener('change', syncJabatanExclusivity));
            syncJabatanExclusivity();
        });

        function getSelectedJabatan() {
            return Array.from(document.querySelectorAll('input[name="jabatan[]"]:checked')).map(cb => cb.value);
        }

        function syncJabatanExclusivity() {
            const checkboxes = Array.from(document.querySelectorAll('input[name="jabatan[]"]'));
            const bkCheckbox = checkboxes.find(cb => cb.value === 'Guru BK');
            const otherCheckboxes = checkboxes.filter(cb => cb.value !== 'Guru BK');

            const bkChecked = Boolean(bkCheckbox && bkCheckbox.checked);
            const otherChecked = otherCheckboxes.some(cb => cb.checked);

            if (bkChecked) {
                otherCheckboxes.forEach(cb => {
                    cb.checked = false;
                    cb.disabled = true;
                });
            } else {
                otherCheckboxes.forEach(cb => {
                    cb.disabled = false;
                });
            }

            if (bkCheckbox) {
                if (otherChecked) {
                    bkCheckbox.checked = false;
                    bkCheckbox.disabled = true;
                } else {
                    bkCheckbox.disabled = false;
                }
            }
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

        // Fetch all mapels for dropdown
        async function fetchMapels() {
            const token = getToken();
            if (!token) return;

            try {
                const response = await fetch('/api/admin/mapel', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success && result.data) {
                    allMapels = result.data;
                    populateMapelDropdown();
                }
            } catch (error) {
                console.error('Error fetching mapels:', error);
            }
        }

        function populateMapelDropdown() {
            const container = document.getElementById('mapelGroup');
            container.innerHTML = allMapels.map(mapel => `
                <label class="checkbox-label" style="display: flex; align-items: center; gap: 8px; width: 100%; cursor: pointer;">
                    <input type="checkbox" name="mapel_ids[]" value="${mapel.id}" onchange="handleMapelSelection(this)">
                    <span>${mapel.kode_mapel} - ${mapel.nama_mapel}</span>
                </label>
            `).join('');
        }

        function handleMapelSelection(checkbox) {
            if (checkbox.checked) {
                const checkboxes = document.querySelectorAll('input[name="mapel_ids[]"]');
                checkboxes.forEach(cb => {
                    if (cb !== checkbox) {
                        cb.checked = false;
                    }
                });
            }
        }

        // Fetch all gurus
        async function fetchGurus() {
            const token = getToken();
            if (!token) return;

            try {
                const response = await fetch('/api/admin/guru', {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                if (response.status === 401) {
                    alert('Sesi Anda telah berakhir. Silakan login kembali.');
                    localStorage.removeItem('token');
                    window.location.href = '/login';
                    return;
                }

                const result = await response.json();

                if (result.success && result.data) {
                    renderTable(result.data);
                    updateStats(result.data);
                } else {
                    document.getElementById('guruTableBody').innerHTML = `
                        <tr><td colspan="7" style="text-align: center;">Gagal memuat data</td></tr>
                    `;
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('guruTableBody').innerHTML = `
                    <tr><td colspan="7" style="text-align: center;">Terjadi kesalahan saat memuat data</td></tr>
                `;
            }
        }

        // Render table
        function renderTable(data) {
            const tbody = document.getElementById('guruTableBody');
            
            if (data.length === 0) {
                tbody.innerHTML = `
                    <tr><td colspan="7" style="text-align: center;">Tidak ada data guru</td></tr>
                `;
                return;
            }

            tbody.innerHTML = data.map((guru, index) => {
                const jenisKelamin = guru.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan';
                const mapelNames = guru.mapels && guru.mapels.length > 0 
                    ? guru.mapels.map(m => m.nama_mapel).join(', ') 
                    : '-';
                
                // Render multiple jabatan badges
                let jabatanBadges = '';
                if (guru.jabatan && Array.isArray(guru.jabatan) && guru.jabatan.length > 0) {
                    jabatanBadges = guru.jabatan.map(jab => {
                        let badgeClass = '';
                        switch(jab) {
                            case 'Guru Mata Pelajaran':
                                badgeClass = 'badge-guru-mapel';
                                break;
                            case 'Kepala Sekolah':
                                badgeClass = 'badge-kepala-sekolah';
                                break;
                            case 'Wali Kelas':
                                badgeClass = 'badge-wali-kelas';
                                break;
                            case 'Guru BK':
                                badgeClass = 'badge-guru-bk';
                                break;
                            default:
                                badgeClass = 'badge-default';
                        }
                        return `<span class="badge ${badgeClass}">${jab}</span>`;
                    }).join(' ');
                } else {
                    jabatanBadges = '<span class="badge badge-default">-</span>';
                }
                
                return `
                    <tr>
                        <td>${index + 1}</td>
                        <td><strong>${guru.nip}</strong></td>
                        <td>${guru.nama}</td>
                        <td>${jabatanBadges}</td>
                        <td>${mapelNames}</td>
                        <td>${jenisKelamin}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon" onclick="editGuru(${guru.id})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-icon btn-danger" onclick="deleteGuru(${guru.id})" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Update stats
        function updateStats(data) {
            const total = data.length;
            const perempuan = data.filter(g => g.jenis_kelamin === 'P').length;
            const lakiLaki = data.filter(g => g.jenis_kelamin === 'L').length;

            document.getElementById('statTotalGuru').textContent = total;
            document.getElementById('statGuruPerempuan').textContent = perempuan;
            document.getElementById('statGuruLaki').textContent = lakiLaki;
        }

        // Open add modal
        function openAddModal() {
            isEditMode = false;
            currentGuruId = null;
            document.getElementById('modalTitle').textContent = 'Tambah Guru Baru';
            document.getElementById('teacherForm').reset();
            syncJabatanExclusivity();
            document.getElementById('guruId').value = '';
            document.getElementById('password').required = true;
            document.getElementById('passwordNote').textContent = 'Minimal 6 karakter (Required)';
            document.getElementById('teacherModal').style.display = 'block';
        }

        // Edit guru
        async function editGuru(id) {
            const token = getToken();
            if (!token) return;

            try {
                const response = await fetch(`/api/admin/guru/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success && result.data) {
                    const guru = result.data;
                    isEditMode = true;
                    currentGuruId = id;
                    
                    document.getElementById('modalTitle').textContent = 'Edit Data Guru';
                    document.getElementById('guruId').value = guru.id;
                    document.getElementById('nip').value = guru.nip;
                    document.getElementById('fullName').value = guru.nama;
                    document.getElementById('gender').value = guru.jenis_kelamin;
                    
                    // Set selected jabatan (multiple)
                    const jabatanCheckboxes = document.querySelectorAll('input[name="jabatan[]"]');
                    jabatanCheckboxes.forEach(cb => {
                        cb.checked = Boolean(guru.jabatan && Array.isArray(guru.jabatan) && guru.jabatan.includes(cb.value));
                    });
                    syncJabatanExclusivity();
                    
                    document.getElementById('address').value = guru.alamat;
                    document.getElementById('phone').value = guru.no_telp;
                    document.getElementById('username').value = guru.user.username;
                    document.getElementById('password').value = '';
                    document.getElementById('password').required = false;
                    document.getElementById('passwordNote').textContent = 'Kosongkan jika tidak ingin mengubah password';
                    
                    // Set selected mapel checkboxes
                    const mapelCheckboxes = document.querySelectorAll('input[name="mapel_ids[]"]');
                    mapelCheckboxes.forEach(cb => {
                        cb.checked = guru.mapels.some(m => m.id == cb.value);
                    });
                    
                    document.getElementById('teacherModal').style.display = 'block';
                } else {
                    alert('Gagal memuat data guru');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat data');
            }
        }

        // Save guru
        async function saveGuru() {
            const token = getToken();
            if (!token) return;

            const nip = document.getElementById('nip').value.trim();
            const nama = document.getElementById('fullName').value.trim();
            const jenisKelamin = document.getElementById('gender').value;
            
            const selectedJabatan = getSelectedJabatan();
            
            // Validasi: Guru BK tidak bisa memiliki jabatan lain
            if (selectedJabatan.includes('Guru BK') && selectedJabatan.length > 1) {
                alert('Guru BK tidak dapat memiliki jabatan lain!');
                return;
            }
            
            const alamat = document.getElementById('address').value.trim();
            const noTelp = document.getElementById('phone').value.trim();
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;

            // Validation: saat add mode, semua field required. Saat edit mode, field opsional
            if (!isEditMode) {
                if (!nip || !nama || !jenisKelamin || selectedJabatan.length === 0 || !alamat || !noTelp || !username) {
                    alert('Harap lengkapi semua field yang wajib diisi!');
                    return;
                }
            }

            if (!isEditMode && !password) {
                alert('Password wajib diisi untuk guru baru!');
                return;
            }

            if (password && password.length < 6) {
                alert('Password minimal 6 karakter!');
                return;
            }

            // Get selected mapels (hanya 1)
            const checkedMapel = document.querySelector('input[name="mapel_ids[]"]:checked');
            const selectedMapels = checkedMapel ? [checkedMapel.value] : [];

            // Build data object - only include fields with values
            const data = {};
            
            if (nip) data.nip = nip;
            if (nama) data.nama = nama;
            if (jenisKelamin) data.jenis_kelamin = jenisKelamin;
            if (selectedJabatan.length > 0) data.jabatan = selectedJabatan;
            if (alamat) data.alamat = alamat;
            if (noTelp) data.no_telp = noTelp;
            if (selectedMapels.length > 0) data.mapel_ids = selectedMapels;
            if (username) data.username = username;
            if (password) data.password = password;

            try {
                const guruId = document.getElementById('guruId').value;
                const url = guruId ? `/api/admin/guru/${guruId}` : '/api/admin/guru';
                const method = guruId ? 'PUT' : 'POST';

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    alert(result.message || 'Data guru berhasil disimpan!');
                    closeModal();
                    fetchGurus(); // Reload data
                } else {
                    const errorMsg = result.errors 
                        ? Object.values(result.errors).flat().join('\n')
                        : result.message || 'Gagal menyimpan data guru';
                    alert(errorMsg);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan data');
            }
        }

        // Delete guru
        async function deleteGuru(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus guru ini?')) {
                return;
            }

            const token = getToken();
            if (!token) return;

            try {
                const response = await fetch(`/api/admin/guru/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    alert(result.message || 'Guru berhasil dihapus!');
                    fetchGurus(); // Reload data
                } else {
                    alert(result.message || 'Gagal menghapus guru');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus data');
            }
        }

        function closeModal() {
            document.getElementById('teacherModal').style.display = 'none';
        }

        function refreshTable() {
            fetchGurus();
        }

        function exportToExcel() {
            alert('Fitur export ke Excel akan segera tersedia!');
        }

        function printTable() {
            window.print();
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

