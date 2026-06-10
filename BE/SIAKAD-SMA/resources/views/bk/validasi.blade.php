@extends('layouts.app')

@section('title', 'Validasi & Penjadwalan - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Validasi & Penjadwalan Konseling')
@section('breadcrumb', 'BK / Validasi & Penjadwalan')

@php
    $role = 'bk';
    $userName = 'Siti Nurhaliza, S.Pd';
    $userRole = 'Guru BK';
@endphp

@section('content')

    <!-- Statistics Card -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: #FF9800;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3 id="pendingCount">0</h3>
                <p>Menunggu Validasi</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #4CAF50;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3 id="approvedCount">0</h3>
                <p>Disetujui</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #F44336;">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-info">
                <h3 id="rejectedCount">0</h3>
                <p>Ditolak</p>
            </div>
        </div>

    </div>

<!-- Jadwal Konseling Section -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-calendar-alt"></i> Jadwal Konseling</h3>
        <button class="btn btn-primary" onclick="showAddScheduleModal()">
            <i class="fas fa-plus"></i> Buat Jadwal Baru
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="data-table" id="scheduleTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Nama Siswa</th>
                        <th>Tingkat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="scheduleTableBody">
                    <tr>
                        <td colspan="7" style="text-align: center;">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Validation List -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-list-check"></i> Daftar Validasi</h3>
        <div class="card-actions">
            <button class="btn-icon" >
                <i class="fas fa-file-excel"></i>
            </button>
            <button class="btn-icon" >
                <i class="fas fa-print"></i>
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="data-table" id="validationTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Tingkat</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Keterangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="validationTableBody">
                    <tr>
                        <td colspan="8" style="text-align: center;">Loading...</td>
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



<!-- Modal View Details -->
<div id="detailModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Detail Validasi</h3>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body">
            <div class="detail-grid">
                <div class="detail-item">
                    <label>Nama Siswa:</label>
                    <span id="detailNama">Ahmad Hidayat</span>
                </div>
                <div class="detail-item">
                    <label>NIS:</label>
                    <span id="detailNIS">2024001</span>
                </div>
                <div class="detail-item">
                    <label>Tingkat:</label>
                    <span id="detailKelas">X</span>
                </div>
                <div class="detail-item">
                    <label>Jenis Validasi:</label>
                    <span id="detailJenis">Izin Sakit</span>
                </div>
                <div class="detail-item">
                    <label>Tanggal:</label>
                    <span id="detailTanggal">15 Januari 2024</span>
                </div>
                <div class="detail-item full-width">
                    <label>Keterangan:</label>
                    <p id="detailKeterangan">Siswa tidak masuk sekolah selama 3 hari dengan alasan sakit. Membutuhkan surat dokter untuk validasi lebih lanjut.</p>
                </div>

                <div class="detail-item">
                    <label>Status:</label>
                    <span class="status-badge pending" id="detailStatus">Menunggu</span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal()">Tutup</button>
            <button class="btn btn-success">
                <i class="fas fa-check"></i> Setujui
            </button>
            <button class="btn btn-danger" >
                <i class="fas fa-times"></i> Tolak
            </button>
        </div>
    </div>
</div>

<!-- Modal Add Validation -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Tambah Validasi Baru</h3>
            <span class="close" onclick="closeAddModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="addValidationForm">
                <div class="form-group">
                    <label for="studentSelect">Pilih Siswa *</label>
                    <select id="studentSelect" required>
                        <option value="">-- Pilih Siswa --</option>
                        <option value="1">Ahmad Hidayat (X)</option>
                        <option value="2">Siti Nurhaliza (XI)</option>
                        <option value="3">Andi Pratama (XII)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="validationType">Jenis Validasi *</label>
                    <select id="validationType" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="sakit">Izin Sakit</option>
                        <option value="keluarga">Izin Keluarga</option>
                        <option value="alpha">Alpha Berkali-kali</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="validationDate">Tanggal *</label>
                    <input type="date" id="validationDate" required>
                </div>
                <div class="form-group">
                    <label for="description">Keterangan *</label>
                    <textarea id="description" rows="3" placeholder="Masukkan keterangan validasi..." required></textarea>
                </div>
                <div class="form-group">
                    <label>Upload Dokumen Pendukung</label>
                    <div class="file-upload">
                        <input type="file" id="documentUpload" accept=".pdf,.jpg,.png">
                        <label for="documentUpload" class="upload-btn">
                            <i class="fas fa-cloud-upload-alt"></i>
                            Pilih File
                        </label>
                        <span class="file-name">Belum ada file dipilih</span>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeAddModal()">Batal</button>
            <button class="btn btn-primary" onclick="submitValidation()">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </div>
</div>

<!-- Modal Add Schedule -->
<div id="addScheduleModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Buat Jadwal Konseling Baru</h3>
            <span class="close" onclick="closeAddScheduleModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="addScheduleForm">
                <div class="form-group">
                    <label for="scheduleSiswa">Pilih Siswa *</label>
                    <select id="scheduleSiswa" required>
                        <option value="">-- Pilih Siswa --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="scheduleTanggal">Tanggal Konseling *</label>
                    <input type="date" id="scheduleTanggal" required>
                </div>
                <div class="form-group">
                    <label for="scheduleWaktu">Waktu Konseling *</label>
                    <input type="time" id="scheduleWaktu" required>
                </div>
                <div class="form-group">
                    <label for="scheduleStatus">Status *</label>
                    <select id="scheduleStatus" required>
                        <option value="0">Menunggu Konfirmasi</option>
                        <option value="1">Dikonfirmasi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="scheduleKeterangan">Keterangan</label>
                    <textarea id="scheduleKeterangan" rows="3" placeholder="Masukkan keterangan jadwal konseling..."></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeAddScheduleModal()">Batal</button>
            <button class="btn btn-primary" onclick="submitSchedule()">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </div>
</div>

<!-- Modal Detail Schedule -->
<div id="detailScheduleModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Detail Jadwal Konseling</h3>
            <span class="close" onclick="closeDetailScheduleModal()">&times;</span>
        </div>
        <div class="modal-body">
            <div class="detail-grid">
                <div class="detail-item">
                    <label>Nama Siswa:</label>
                    <span id="detailScheduleSiswa">-</span>
                </div>
                <div class="detail-item">
                    <label>Tingkat:</label>
                    <span id="detailScheduleKelas">-</span>
                </div>
                <div class="detail-item">
                    <label>Tanggal:</label>
                    <span id="detailScheduleTanggal">-</span>
                </div>
                <div class="detail-item">
                    <label>Waktu:</label>
                    <span id="detailScheduleWaktu">-</span>
                </div>
                <div class="detail-item">
                    <label>Status:</label>
                    <span id="detailScheduleStatus">-</span>
                </div>
                <div class="detail-item full-width">
                    <label>Keterangan:</label>
                    <p id="detailScheduleKeterangan">-</p>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeDetailScheduleModal()">Tutup</button>
            <div id="scheduleActions"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentDetailId = null;
    function viewDetails(id) {
        currentDetailId = id;
        const modal = document.getElementById('detailModal');
        modal.style.display = 'block';
    }

    function showAddModal() {
        document.getElementById('addModal').style.display = 'block';
    }

    function closeAddModal() {
        document.getElementById('addModal').style.display = 'none';
        document.getElementById('addValidationForm').reset();
    }

    function closeModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    function resetFilters() {
        document.getElementById('statusFilter').value = 'all';
        document.getElementById('classFilter').value = 'all';
        document.getElementById('dateFilter').value = '';
        document.getElementById('searchStudent').value = '';
        filterTable();
    }

    function submitValidation() {
        const form = document.getElementById('addValidationForm');
        if (form.checkValidity()) {
            alert('Validasi baru berhasil ditambahkan!');
            closeAddModal();
        } else {
            alert('Harap lengkapi semua field yang wajib diisi!');
        }
    }

    function exportToExcel() {
        alert('Fitur export ke Excel akan segera tersedia!');
    }

    function printTable() {
        window.print();
    }

    // File upload preview
    document.getElementById('documentUpload').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : 'Belum ada file dipilih';
        document.querySelector('.file-name').textContent = fileName;
    });

    // ========== JADWAL KONSELING FUNCTIONS ==========
    
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

    // Load on page ready
    document.addEventListener('DOMContentLoaded', function() {
        fetchSchedules();
        fetchSiswaList();
    });

    async function getCurrentBKId() {
        const token = getToken();
        if (!token) return null;

        try {
            const response = await fetch('/api/me', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            if (result.success && result.data && result.data.user && result.data.user.role && result.data.user.role.name === 'BK' && result.data.profile) {
                return result.data.profile.id;
            }
        } catch (error) {
            console.error('Error fetching current BK profile:', error);
        }

        return null;
    }

    // Fetch all siswa for dropdown
    async function fetchSiswaList() {
        const token = getToken();
        if (!token) return;

        try {
            const response = await fetch('/api/bk/siswa', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success && result.data) {
                const select = document.getElementById('scheduleSiswa');
                select.innerHTML = '<option value="">-- Pilih Siswa --</option>';
                result.data.forEach(siswa => {
                    select.innerHTML += `<option value="${siswa.id}">${siswa.nama} - Tingkat ${siswa.tingkat || '-'}</option>`;
                });
            }
        } catch (error) {
            console.error('Error fetching siswa:', error);
        }
    }

    // Fetch all schedules
    async function fetchSchedules() {
        const token = getToken();
        if (!token) return;

        try {
            const response = await fetch('/api/bk/penjadwalan', {
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
                renderScheduleTable(result.data);
                renderValidationList(result.data.filter(item => item.status == '0'));
            } else {
                document.getElementById('scheduleTableBody').innerHTML = `
                    <tr><td colspan="7" style="text-align: center;">Gagal memuat data</td></tr>
                `;
                document.getElementById('validationTableBody').innerHTML = `
                    <tr><td colspan="8" style="text-align: center;">Gagal memuat data</td></tr>
                `;
            }
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('scheduleTableBody').innerHTML = `
                <tr><td colspan="7" style="text-align: center;">Terjadi kesalahan saat memuat data</td></tr>
            `;
            document.getElementById('validationTableBody').innerHTML = `
                <tr><td colspan="8" style="text-align: center;">Terjadi kesalahan saat memuat data</td></tr>
            `;
        }
    }

    // Render schedule table
    function renderScheduleTable(data) {
        const tbody = document.getElementById('scheduleTableBody');
        
        const pendingCount = data.filter(item => item.status == '0').length;
        const approvedCount = data.filter(item => item.status == '1').length;
        const rejectedCount = 0; // Rejected schedules are deleted once rejected

        document.getElementById('pendingCount').textContent = pendingCount;
        document.getElementById('approvedCount').textContent = approvedCount;
        document.getElementById('rejectedCount').textContent = rejectedCount;

        if (data.length === 0) {
            tbody.innerHTML = `
                <tr><td colspan="7" style="text-align: center;">Tidak ada jadwal konseling</td></tr>
            `;
            return;
        }

        tbody.innerHTML = data.map((schedule, index) => {
            const statusBadge = schedule.status == '1' 
                ? '<span class="status-badge confirmed">Dikonfirmasi</span>' 
                : '<span class="status-badge pending">Menunggu</span>';
            
            const actionButtons = schedule.status == '0' 
                ? `
                    <button class="btn-icon btn-success" onclick="approveSchedule(${schedule.id})" title="Konfirmasi">
                        <i class="fas fa-check"></i>
                    </button>
                    <button class="btn-icon btn-danger" onclick="rejectSchedule(${schedule.id})" title="Tolak">
                        <i class="fas fa-times"></i>
                    </button>
                ` 
                : `
                    <button class="btn-icon btn-danger" onclick="deleteSchedule(${schedule.id})" title="Hapus">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
            
            return `
                <tr>
                    <td>${index + 1}</td>
                    <td>${schedule.tanggal}</td>
                    <td>${schedule.waktu}</td>
                    <td>${schedule.siswa ? schedule.siswa.nama : 'N/A'}</td>
                    <td>${schedule.siswa && schedule.siswa.tingkat ? 'Tingkat ' + schedule.siswa.tingkat : 'N/A'}</td>
                    <td>${statusBadge}</td>
                    <td>
                        <button class="btn-icon" onclick="viewScheduleDetail(${schedule.id})" title="Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                        ${actionButtons}
                    </td>
                </tr>
            `;
        }).join('');
    }

    function renderValidationList(data) {
        const tbody = document.getElementById('validationTableBody');
        if (!tbody) return;

        if (data.length === 0) {
            tbody.innerHTML = `
                <tr><td colspan="8" style="text-align: center;">Tidak ada permintaan validasi</td></tr>
            `;
            return;
        }

        tbody.innerHTML = data.map((schedule, index) => {
            const statusBadge = schedule.status == '1' 
                ? '<span class="status-badge confirmed">Dikonfirmasi</span>' 
                : '<span class="status-badge pending">Menunggu</span>';

            return `
                <tr>
                    <td>${index + 1}</td>
                    <td>${schedule.siswa ? schedule.siswa.nama : 'N/A'}</td>
                    <td>${schedule.siswa && schedule.siswa.tingkat ? schedule.siswa.tingkat : 'N/A'}</td>
                    <td>${schedule.tanggal}</td>
                    <td>${schedule.waktu}</td>
                    <td>${schedule.keterangan || '-'}</td>
                    <td>${statusBadge}</td>
                    <td>
                        <button class="btn-icon btn-success" onclick="approveSchedule(${schedule.id})" title="Konfirmasi">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="btn-icon btn-danger" onclick="rejectSchedule(${schedule.id})" title="Tolak">
                            <i class="fas fa-times"></i>
                        </button>
                        <button class="btn-icon" onclick="viewScheduleDetail(${schedule.id})" title="Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Show add schedule modal
    function showAddScheduleModal() {
        document.getElementById('addScheduleModal').style.display = 'block';
    }

    // Close add schedule modal
    function closeAddScheduleModal() {
        document.getElementById('addScheduleModal').style.display = 'none';
        document.getElementById('addScheduleForm').reset();
    }

    // Submit schedule
    async function submitSchedule() {
        const token = getToken();
        if (!token) return;

        const siswaId = document.getElementById('scheduleSiswa').value;
        const tanggal = document.getElementById('scheduleTanggal').value;
        const waktu = document.getElementById('scheduleWaktu').value;
        const status = document.getElementById('scheduleStatus').value;
        const keterangan = document.getElementById('scheduleKeterangan').value;

        if (!siswaId || !tanggal || !waktu) {
            alert('Harap lengkapi semua field yang wajib diisi!');
            return;
        }

        const bkId = await getCurrentBKId();
        if (!bkId) {
            alert('Gagal mendapatkan data BK. Silakan refresh halaman dan coba lagi.');
            return;
        }

        try {
            const response = await fetch('/api/bk/penjadwalan', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    siswa_id: siswaId,
                    bk_id: bkId,
                    tanggal: tanggal,
                    waktu: waktu,
                    status: status || '1',
                    keterangan: keterangan
                })
            });

            const result = await response.json();

            if (result.success) {
                alert('Jadwal konseling berhasil dibuat!');
                closeAddScheduleModal();
                fetchSchedules(); // Refresh table
            } else {
                alert('Gagal membuat jadwal: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat membuat jadwal');
        }
    }

    // Delete schedule
    async function deleteSchedule(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus jadwal ini?')) {
            return;
        }

        const token = getToken();
        if (!token) return;

        try {
            const response = await fetch(`/api/bk/penjadwalan/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success) {
                alert('Jadwal berhasil dihapus!');
                fetchSchedules(); // Refresh table
            } else {
                alert('Gagal menghapus jadwal: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus jadwal');
        }
    }

    // View schedule detail
    async function viewScheduleDetail(id) {
        const token = getToken();
        if (!token) return;

        try {
            const response = await fetch(`/api/bk/penjadwalan/${id}`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success && result.data) {
                const schedule = result.data;
                
                document.getElementById('detailScheduleSiswa').textContent = schedule.siswa ? schedule.siswa.nama : 'N/A';
                document.getElementById('detailScheduleKelas').textContent = schedule.siswa && schedule.siswa.tingkat ? `Tingkat ${schedule.siswa.tingkat}` : 'N/A';
                document.getElementById('detailScheduleTanggal').textContent = schedule.tanggal;
                document.getElementById('detailScheduleWaktu').textContent = schedule.waktu;
                
                const statusBadge = schedule.status == '1' 
                    ? '<span class="status-badge confirmed">Dikonfirmasi</span>' 
                    : '<span class="status-badge pending">Menunggu</span>';
                document.getElementById('detailScheduleStatus').innerHTML = statusBadge;
                
                document.getElementById('detailScheduleKeterangan').textContent = schedule.keterangan || '-';

                // Show appropriate action buttons
                const actionsDiv = document.getElementById('scheduleActions');
                if (schedule.status == '0') {
                    actionsDiv.innerHTML = `
                        <button class="btn btn-success" onclick="approveSchedule(${schedule.id})">
                            <i class="fas fa-check"></i> Konfirmasi
                        </button>
                        <button class="btn btn-danger" onclick="rejectSchedule(${schedule.id})">
                            <i class="fas fa-times"></i> Tolak
                        </button>
                    `;
                } else {
                    actionsDiv.innerHTML = '';
                }

                document.getElementById('detailScheduleModal').style.display = 'block';
            } else {
                alert('Gagal memuat detail jadwal');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat detail');
        }
    }

    // Close detail schedule modal
    function closeDetailScheduleModal() {
        document.getElementById('detailScheduleModal').style.display = 'none';
    }

    // Approve schedule
    async function approveSchedule(id) {
        if (!confirm('Apakah Anda yakin ingin mengkonfirmasi jadwal ini?')) {
            return;
        }

        const token = getToken();
        if (!token) return;

        try {
            const response = await fetch(`/api/bk/penjadwalan/${id}/approve`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success) {
                alert('Jadwal berhasil dikonfirmasi!');
                closeDetailScheduleModal();
                fetchSchedules(); // Refresh table
            } else {
                alert('Gagal mengkonfirmasi jadwal: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengkonfirmasi jadwal');
        }
    }

    // Reject schedule
    async function rejectSchedule(id) {
        if (!confirm('Apakah Anda yakin ingin menolak jadwal ini? Jadwal akan dihapus.')) {
            return;
        }

        const token = getToken();
        if (!token) return;

        try {
            const response = await fetch(`/api/bk/penjadwalan/${id}/reject`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success) {
                alert('Jadwal berhasil ditolak!');
                closeDetailScheduleModal();
                fetchSchedules(); // Refresh table
            } else {
                alert('Gagal menolak jadwal: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menolak jadwal');
        }
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    }

    function renderValidationList(data) {
        const tbody = document.getElementById('validationTableBody');
        if (!tbody) return;

        if (data.length === 0) {
            tbody.innerHTML = `
                <tr><td colspan="8" style="text-align: center;">Tidak ada permintaan validasi</td></tr>
            `;
            return;
        }

        tbody.innerHTML = data.map((schedule, index) => {
            const statusBadge = schedule.status == '1' 
                ? '<span class="status-badge confirmed">Dikonfirmasi</span>' 
                : '<span class="status-badge pending">Menunggu</span>';

            return `
                <tr>
                    <td>${index + 1}</td>
                    <td>${schedule.siswa ? schedule.siswa.nama : 'N/A'}</td>
                    <td>${schedule.siswa && schedule.siswa.tingkat ? schedule.siswa.tingkat : 'N/A'}</td>
                    <td>${schedule.tanggal}</td>
                    <td>${schedule.waktu}</td>
                    <td>${schedule.keterangan || '-'}</td>
                    <td>${statusBadge}</td>
                    <td>
                        <button class="btn-icon btn-success" onclick="approveSchedule(${schedule.id})" title="Konfirmasi">
                            <i class="fas fa-check"></i>
                        </button>
                        <button class="btn-icon btn-danger" onclick="rejectSchedule(${schedule.id})" title="Tolak">
                            <i class="fas fa-times"></i>
                        </button>
                        <button class="btn-icon" onclick="viewScheduleDetail(${schedule.id})" title="Detail">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
            `;
        }).join('');
    }
</script>
@endpush
