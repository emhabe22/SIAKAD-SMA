@extends('layouts.app')

@section('title', 'Kelola Mata Pelajaran - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Kelola Mata Pelajaran')
@section('breadcrumb', 'Admin / Mata Pelajaran')

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
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="statTotalMapel">0</h3>
                        <p>Total Mapel</p>
                    </div>
                </div>
            </div>

            <!-- Subjects Table -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-list"></i> Daftar Mata Pelajaran</h3>
                    <div class="card-actions">
                        <button class="btn btn-primary" onclick="openAddModal()" style="margin-right: 10px">
                            <i class="fas fa-plus"></i> Tambah Mata Pelajaran
                        </button>
                        <button class="btn btn-secondary" onclick="location.href='/admin/jadwal-pelajaran'" style="margin-right: 10px">
                            <i class="fas fa-calendar-alt"></i> Atur Jadwal
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
                        <table class="data-table" id="subjectsTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode Mapel</th>
                                    <th>Nama Mata Pelajaran</th>
                                    <th>Tingkat</th>
                                    <th>Guru Pengampu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="mapelTableBody">
                                <tr>
                                    <td colspan="6" style="text-align: center;">Memuat data...</td>
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
                        <button class="page-btn">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    <!-- Modal Add/Edit Subject -->
    <div id="mapelModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Tambah Mata Pelajaran Baru</h3>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="mapelForm">
                    <input type="hidden" id="mapelId">
                    
                    <div class="form-group">
                        <label for="namaMapel">Nama Mata Pelajaran *</label>
                        <input type="text" id="namaMapel" required placeholder="Contoh: Matematika">
                    </div>

                    <div class="form-group">
                        <label for="tingkat">Tingkat Kelas *</label>
                        <select id="tingkat" required>
                            <option value="">-- Pilih Tingkat --</option>
                            <option value="X">Kelas X</option>
                            <option value="XI">Kelas XI</option>
                            <option value="XII">Kelas XII</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="kodeMapel">Kode Mata Pelajaran *</label>
                        <input type="text" id="kodeMapel" required placeholder="Contoh: X-MAT">
                        <small style="color: #666;">Format: TINGKAT-SINGKATAN (Contoh: X-MAT, XI-FIS, XII-BIO)</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal()">Batal</button>
                <button class="btn btn-primary" onclick="saveMapel()">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
        let currentMapelId = null;
        let isEditMode = false;

        document.addEventListener('DOMContentLoaded', function() {
            fetchMapels();
        });

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

        // Fetch all mapels
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
                    document.getElementById('mapelTableBody').innerHTML = `
                        <tr><td colspan="6" style="text-align: center;">Gagal memuat data</td></tr>
                    `;
                }
            } catch (error) {
                console.error('Error:', error);
                document.getElementById('mapelTableBody').innerHTML = `
                    <tr><td colspan="6" style="text-align: center;">Terjadi kesalahan saat memuat data</td></tr>
                `;
            }
        }

        // Render table
        function renderTable(data) {
            const tbody = document.getElementById('mapelTableBody');
            
            if (data.length === 0) {
                tbody.innerHTML = `
                    <tr><td colspan="6" style="text-align: center;">Tidak ada data mata pelajaran</td></tr>
                `;
                return;
            }

            tbody.innerHTML = data.map((mapel, index) => {
                const guruNames = mapel.gurus && mapel.gurus.length > 0 
                    ? mapel.gurus.map(g => g.nama).join(', ') 
                    : '-';
                
                // Badge for tingkat
                let tingkatBadge = '';
                switch(mapel.tingkat) {
                    case 'X':
                        tingkatBadge = '<span class="badge" style="background: #2196F3; color: white; padding: 6px 12px; border-radius: 12px; font-size: 12px;">Kelas X</span>';
                        break;
                    case 'XI':
                        tingkatBadge = '<span class="badge" style="background: #4CAF50; color: white; padding: 6px 12px; border-radius: 12px; font-size: 12px;">Kelas XI</span>';
                        break;
                    case 'XII':
                        tingkatBadge = '<span class="badge" style="background: #FF9800; color: white; padding: 6px 12px; border-radius: 12px; font-size: 12px;">Kelas XII</span>';
                        break;
                }
                
                return `
                    <tr>
                        <td>${index + 1}</td>
                        <td><strong>${mapel.kode_mapel}</strong></td>
                        <td>${mapel.nama_mapel}</td>
                        <td>${tingkatBadge}</td>
                        <td>${guruNames}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon" onclick="editMapel(${mapel.id})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-icon btn-danger" onclick="deleteMapel(${mapel.id})" title="Hapus">
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
            document.getElementById('statTotalMapel').textContent = data.length;
        }

        // Open add modal
        function openAddModal() {
            isEditMode = false;
            currentMapelId = null;
            document.getElementById('modalTitle').textContent = 'Tambah Mata Pelajaran Baru';
            document.getElementById('mapelForm').reset();
            document.getElementById('mapelId').value = '';
            document.getElementById('mapelModal').style.display = 'block';
        }

        // Edit mapel
        async function editMapel(id) {
            const token = getToken();
            if (!token) return;

            try {
                const response = await fetch(`/api/admin/mapel/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success && result.data) {
                    const mapel = result.data;
                    isEditMode = true;
                    currentMapelId = id;
                    
                    document.getElementById('modalTitle').textContent = 'Edit Data Mata Pelajaran';
                    document.getElementById('mapelId').value = mapel.id;
                    document.getElementById('namaMapel').value = mapel.nama_mapel;
                    document.getElementById('tingkat').value = mapel.tingkat;
                    document.getElementById('kodeMapel').value = mapel.kode_mapel;
                    
                    document.getElementById('mapelModal').style.display = 'block';
                } else {
                    alert('Gagal memuat data mata pelajaran');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memuat data');
            }
        }

        // Save mapel
        async function saveMapel() {
            const token = getToken();
            if (!token) return;

            const namaMapel = document.getElementById('namaMapel').value.trim();
            const tingkat = document.getElementById('tingkat').value;
            const kodeMapel = document.getElementById('kodeMapel').value.trim();

            // Validasi: saat add mode, semua field required. Saat edit mode, field opsional
            if (!isEditMode) {
                if (!namaMapel || !tingkat || !kodeMapel) {
                    alert('Harap lengkapi semua field yang wajib diisi!');
                    return;
                }
            }

            // Build data object - only include fields with values
            const data = {};
            if (namaMapel) data.nama_mapel = namaMapel;
            if (tingkat) data.tingkat = tingkat;
            if (kodeMapel) data.kode_mapel = kodeMapel;

            try {
                const mapelId = document.getElementById('mapelId').value;
                const url = mapelId ? `/api/admin/mapel/${mapelId}` : '/api/admin/mapel';
                const method = mapelId ? 'PUT' : 'POST';

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
                    alert(result.message || 'Data mata pelajaran berhasil disimpan!');
                    closeModal();
                    fetchMapels(); // Reload data
                } else {
                    if (result.errors) {
                        const errors = Object.values(result.errors).flat().join('\n');
                        alert('Validasi gagal:\n' + errors);
                    } else {
                        alert(result.message || 'Gagal menyimpan data mata pelajaran');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan data');
            }
        }

        // Delete mapel
        async function deleteMapel(id) {
            if (!confirm('Apakah Anda yakin ingin menghapus mata pelajaran ini?')) {
                return;
            }

            const token = getToken();
            if (!token) return;

            try {
                const response = await fetch(`/api/admin/mapel/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    alert(result.message || 'Mata pelajaran berhasil dihapus!');
                    fetchMapels(); // Reload data
                } else {
                    alert(result.message || 'Gagal menghapus mata pelajaran');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menghapus data');
            }
        }

        function closeModal() {
            document.getElementById('mapelModal').style.display = 'none';
        }

        function refreshTable() {
            fetchMapels();
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
