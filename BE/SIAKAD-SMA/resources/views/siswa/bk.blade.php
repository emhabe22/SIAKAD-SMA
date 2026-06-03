@extends('layouts.app')

@section('title', 'Bimbingan Konseling - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Bimbingan Konseling')
@section('breadcrumb', 'Siswa / Bimbingan Konseling')

@php
    $role = 'siswa';
    $userName = 'Ahmad Fauzi';
    $userRole = 'Siswa X MIPA 1';
@endphp

@section('content')
<!-- Welcome Banner -->
<div class="welcome-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="welcome-content">
        <h2>Bimbingan Konseling</h2>
        <p>Kelola sesi konseling dan ajukan bimbingan dengan guru BK</p>
    </div>
    <div class="welcome-icon">
        <i class="fas fa-hands-helping fa-3x"></i>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="stat-info">
            <h3>3</h3>
            <p>Sesi Aktif</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-info">
            <h3>2</h3>
            <p>Menunggu Konfirmasi</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
            <h3>8</h3>
            <p>Sesi Selesai</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="stat-info">
            <h3>1</h3>
            <p>Surat Pemanggilan</p>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-plus-circle"></i> Aksi Cepat</h3>
    </div>
    <div class="card-body">
        <div class="quick-actions">
            <button class="btn btn-primary" onclick="showRequestBKModal()">
                <i class="fas fa-plus"></i> Ajukan Jadwal Konseling
            </button>
            <button class="btn btn-success" onclick="refreshSessions()">
                <i class="fas fa-sync-alt"></i> Refresh Jadwal
            </button>
        </div>
    </div>
</div>

<!-- Active Sessions -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-list"></i> Jadwal Konseling Saya</h3>
        <button class="btn btn-sm btn-outline-primary" onclick="refreshSessions()">
            <i class="fas fa-sync-alt"></i> Refresh
        </button>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Guru BK</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="scheduleTableBody">
                <tr>
                    <td colspan="6" style="text-align: center;">Loading...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Request BK -->
<div id="requestBKModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Ajukan Jadwal Konseling</h3>
            <span class="close" onclick="closeRequestBKModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="requestBKForm">
                <div class="form-group">
                    <label for="bkSelect">Pilih Guru BK *</label>
                    <select id="bkSelect" required>
                        <option value="">-- Pilih Guru BK --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="requestTanggal">Tanggal Konseling *</label>
                    <input type="date" id="requestTanggal" required>
                </div>
                <div class="form-group">
                    <label for="requestWaktu">Waktu Konseling *</label>
                    <input type="time" id="requestWaktu" required>
                </div>
                <div class="form-group">
                    <label for="requestKeterangan">Keterangan *</label>
                    <textarea id="requestKeterangan" rows="3" placeholder="Jelaskan keperluan konseling Anda..." required></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeRequestBKModal()">Batal</button>
            <button class="btn btn-primary" onclick="submitRequestBK()">
                <i class="fas fa-paper-plane"></i> Ajukan
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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

    // Get siswa ID from localStorage or session
    async function getSiswaId() {
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
            
            if (result.success && result.data.profile) {
                return result.data.profile.id;
            }
        } catch (error) {
            console.error('Error fetching user profile:', error);
        }
        
        return null;
    }

    // Load on page ready
    document.addEventListener('DOMContentLoaded', function() {
        fetchSchedules();
        fetchBKList();
    });

    // Fetch BK list for dropdown
    async function fetchBKList() {
        const token = getToken();
        if (!token) return;

        try {
            const response = await fetch('/api/siswa/bk', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success && result.data) {
                const select = document.getElementById('bkSelect');
                select.innerHTML = '<option value="">-- Pilih Guru BK --</option>';
                result.data.forEach(bk => {
                    select.innerHTML += `<option value="${bk.id}">${bk.nama}</option>`;
                });
            }
        } catch (error) {
            console.error('Error fetching BK list:', error);
        }
    }

    // Fetch schedules
    async function fetchSchedules() {
        const token = getToken();
        if (!token) return;

        const siswaId = await getSiswaId();
        if (!siswaId) {
            document.getElementById('scheduleTableBody').innerHTML = `
                <tr><td colspan="5" style="text-align: center;">Gagal mendapatkan data siswa</td></tr>
            `;
            return;
        }

        try {
            const response = await fetch(`/api/siswa/penjadwalan-saya/${siswaId}`, {
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
            } else {
                document.getElementById('scheduleTableBody').innerHTML = `
                    <tr><td colspan="6" style="text-align: center;">Gagal memuat data</td></tr>
                `;
            }
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('scheduleTableBody').innerHTML = `
                <tr><td colspan="6" style="text-align: center;">Terjadi kesalahan saat memuat data</td></tr>
            `;
        }
    }

    // Render schedule table
    function renderScheduleTable(data) {
        const tbody = document.getElementById('scheduleTableBody');
        
        if (data.length === 0) {
            tbody.innerHTML = `
                <tr><td colspan="6" style="text-align: center;">Belum ada jadwal konseling</td></tr>
            `;
            return;
        }

        // Update stats
        const menunggu = data.filter(s => s.status == '0').length;
        const dikonfirmasi = data.filter(s => s.status == '1').length;
        
        // Update stat cards
        document.querySelectorAll('.stat-card')[0].querySelector('h3').textContent = dikonfirmasi;
        document.querySelectorAll('.stat-card')[1].querySelector('h3').textContent = menunggu;

        tbody.innerHTML = data.map(schedule => {
            const statusBadge = schedule.status == '1' 
                ? '<span class="badge badge-success">Dikonfirmasi</span>' 
                : '<span class="badge badge-warning">Menunggu</span>';
            
            const keteranganPreview = schedule.keterangan 
                ? (schedule.keterangan.length > 50 ? schedule.keterangan.substring(0, 50) + '...' : schedule.keterangan)
                : '-';
            
            return `
                <tr>
                    <td>${schedule.tanggal}</td>
                    <td>${schedule.waktu}</td>
                    <td>${schedule.bk ? schedule.bk.nama : 'N/A'}</td>
                    <td>${keteranganPreview}</td>
                    <td>${statusBadge}</td>
                    <td>
                        ${schedule.status == '0' ? `
                            <button class="btn btn-sm btn-danger" onclick="cancelSchedule(${schedule.id})">
                                <i class="fas fa-times"></i> Batalkan
                            </button>
                        ` : `
                            <span class="text-muted">-</span>
                        `}
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Show request BK modal
    function showRequestBKModal() {
        document.getElementById('requestBKModal').style.display = 'block';
    }
    
    // Close request BK modal
    function closeRequestBKModal() {
        document.getElementById('requestBKModal').style.display = 'none';
        document.getElementById('requestBKForm').reset();
    }

    // Submit request BK
    async function submitRequestBK() {
        const token = getToken();
        if (!token) return;

        const bkId = document.getElementById('bkSelect').value;
        const tanggal = document.getElementById('requestTanggal').value;
        const waktu = document.getElementById('requestWaktu').value;
        const keterangan = document.getElementById('requestKeterangan').value;

        if (!bkId || !tanggal || !waktu || !keterangan) {
            alert('Harap lengkapi semua field yang wajib diisi!');
            return;
        }

        const siswaId = await getSiswaId();
        if (!siswaId) {
            alert('Gagal mendapatkan data siswa. Silakan refresh halaman.');
            return;
        }

        try {
            const response = await fetch('/api/siswa/penjadwalan', {
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
                    keterangan: keterangan,
                    status: '0' // Menunggu konfirmasi
                })
            });

            const result = await response.json();

            if (result.success) {
                alert('Jadwal konseling berhasil diajukan! Menunggu konfirmasi dari Guru BK.');
                closeRequestBKModal();
                fetchSchedules(); // Refresh table
            } else {
                alert('Gagal mengajukan jadwal: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengajukan jadwal');
        }
    }

    // Cancel schedule
    async function cancelSchedule(id) {
        if (!confirm('Apakah Anda yakin ingin membatalkan jadwal ini?')) {
            return;
        }

        const token = getToken();
        if (!token) return;

        try {
            const response = await fetch(`/api/siswa/penjadwalan/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (result.success) {
                alert('Jadwal berhasil dibatalkan!');
                fetchSchedules(); // Refresh table
            } else {
                alert('Gagal membatalkan jadwal: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat membatalkan jadwal');
        }
    }
    
    function refreshSessions() {
        fetchSchedules();
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('requestBKModal');
        if (event.target === modal) {
            closeRequestBKModal();
        }
    }
</script>
@endpush