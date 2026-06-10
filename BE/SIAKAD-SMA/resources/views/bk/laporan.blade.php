@extends('layouts.app')

@section('title', 'Laporan - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Laporan')
@section('breadcrumb', 'BK / Laporan')

@php
    $role = 'bk';
    $userName = 'Siti Nurhaliza, S.Pd';
    $userRole = 'Guru BK';
@endphp

@section('content')
<!-- Filter Section -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-filter"></i> Filter Laporan</h3>
    </div>
    <div class="card-body">
        <div class="filter-grid">
            <div class="filter-group">
                <label>Bulan</label>
                <select class="form-control" id="filterMonth">
                    <option value="">Semua Bulan</option>
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Tahun</label>
                <select class="form-control" id="filterYear">
                    <option value="">Semua Tahun</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                </select>
            </div>
            <div class="filter-group">
                <label>Status</label>
                <select class="form-control" id="filterStatus">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="filter-group">
                <label>&nbsp;</label>
                <button class="btn btn-primary" onclick="applyFilters()">
                    <i class="fas fa-search"></i> Terapkan Filter
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Report Summary -->
<div class="report-summary">
    <div class="summary-card">
        <h3>Total Konseling</h3>
        <span class="summary-value" id="totalCases">0</span>
        <span class="summary-label">Sesi konseling</span>
    </div>
    <div class="summary-card">
        <h3>Konseling Selesai</h3>
        <span class="summary-value" id="completedCases">0</span>
        <span class="summary-label">Status approved</span>
    </div>
    <div class="summary-card">
        <h3>Menunggu Review</h3>
        <span class="summary-value" id="pendingCases">0</span>
        <span class="summary-label">Status pending</span>
    </div>
</div>



<!-- Cases Table -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-list"></i> Daftar Konseling</h3>
        <div class="card-actions">
            <button class="btn btn-success" onclick="exportReport()">
                <i class="fas fa-file-excel"></i> Export Excel
            </button>
            <button class="btn btn-primary" onclick="printReport()">
                <i class="fas fa-print"></i> Cetak
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Siswa</th>
                        <th>Tingkat</th>
                        <th>Tanggal Konseling</th>
                        <th>Waktu</th>
                        <th>Konselor</th>
                        <th>Status</th>
                        <th>Ringkasan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="casesTableBody">
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 40px;">Memuat data konseling...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let allCases = [];
    let filteredCases = [];

    function getToken() {
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Token autentikasi tidak ditemukan. Silakan login ulang.');
            return null;
        }
        return token;
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        if (Number.isNaN(date.getTime())) {
            return dateString;
        }
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        });
    }

    function getStatusBadgeClass(status) {
        const statusMap = {
            'approved': 'completed',
            'pending': 'pending',
            'rejected': 'rejected'
        };
        return statusMap[status] || status;
    }

    function getStatusLabel(status) {
        const statusMap = {
            'approved': 'Selesai',
            'pending': 'Menunggu',
            'rejected': 'Ditolak'
        };
        return statusMap[status] || status;
    }

    async function fetchLaporanData() {
        const token = getToken();
        if (!token) return;

        try {
            const response = await fetch('/api/bk/penjadwalan', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                console.error('Gagal mengambil data konseling', response.statusText);
                document.getElementById('casesTableBody').innerHTML = '<tr><td colspan="9" style="text-align: center;">Gagal memuat data konseling</td></tr>';
                return;
            }

            const result = await response.json();
            allCases = result.data || [];
            
            console.log('Raw penjadwalan data:', allCases);
            
            // Map penjadwalan data directly
            allCases = allCases.map(penjadwalan => {
                const siswa = penjadwalan.siswa || {};
                const bk = penjadwalan.bk || {};
                return {
                    ...penjadwalan,
                    id: penjadwalan.id,
                    siswa_nama: siswa.nama || 'Siswa',
                    siswa_tingkat: siswa.tingkat || '-',
                    bk_nama: bk.nama || '-',
                    tanggal: penjadwalan.tanggal || '-',
                    waktu: penjadwalan.waktu || '-',
                    status: penjadwalan.status === '1' || penjadwalan.status === 1 ? 'approved' : 'pending',
                    ringkasan: penjadwalan.keterangan || '-',
                    catatan: penjadwalan.keterangan || '-'
                };
            });

            console.log('Mapped cases:', allCases);
            
            // Apply default filter (current month/year)
            applyFilters();
        } catch (error) {
            console.error('Error fetching laporan data:', error);
            document.getElementById('casesTableBody').innerHTML = '<tr><td colspan="9" style="text-align: center;">Terjadi kesalahan saat memuat data</td></tr>';
        }
    }

    function updateStats(cases) {
        const total = cases.length;
        const completed = cases.filter(c => c.status === 'approved').length;
        const pending = cases.filter(c => c.status === 'pending').length;

        document.getElementById('totalCases').textContent = total;
        document.getElementById('completedCases').textContent = completed;
        document.getElementById('pendingCases').textContent = pending;
    }

    function renderTable(cases) {
        const tbody = document.getElementById('casesTableBody');
        
        if (!cases || cases.length === 0) {
            tbody.innerHTML = '<tr><td colspan="9" style="text-align: center; padding: 20px;">Tidak ada data konseling untuk filter yang dipilih</td></tr>';
            return;
        }

        tbody.innerHTML = cases.map((c, idx) => `
            <tr>
                <td>#${c.id}</td>
                <td><strong>${c.siswa_nama}</strong></td>
                <td>${c.siswa_tingkat}</td>
                <td>${formatDate(c.tanggal)}</td>
                <td>${c.waktu}</td>
                <td>${c.bk_nama}</td>
                <td><span class="status-badge ${getStatusBadgeClass(c.status)}">${getStatusLabel(c.status)}</span></td>
                <td>${c.ringkasan ? c.ringkasan.substring(0, 30) + '...' : '-'}</td>
                <td>
                    <button class="btn-icon" onclick="viewCase(${c.id})" title="Lihat detail">
                        <i class="fas fa-eye"></i>
                    </button>
                </td>
            </tr>
        `).join('');
    }

    function applyFilters() {
        const month = document.getElementById('filterMonth').value;
        const year = document.getElementById('filterYear').value;
        const status = document.getElementById('filterStatus').value;

        filteredCases = allCases.filter(c => {
            const caseDate = new Date(c.tanggal);
            const caseMonth = (caseDate.getMonth() + 1).toString();
            const caseYear = caseDate.getFullYear().toString();

            const monthMatch = !month || caseMonth === month;
            const yearMatch = !year || caseYear === year;
            const statusMatch = !status || c.status === status;

            return monthMatch && yearMatch && statusMatch;
        });

        renderTable(filteredCases);
        updateStats(filteredCases);
    }

    function viewCase(id) {
        const kasus = allCases.find(c => c.id === id);
        if (!kasus) {
            alert('Data konseling tidak ditemukan');
            return;
        }

        alert(`
Nama Siswa: ${kasus.siswa_nama}
Tingkat: ${kasus.siswa_tingkat}
Tanggal: ${formatDate(kasus.tanggal)}
Waktu: ${kasus.waktu}
Konselor: ${kasus.bk_nama}
Status: ${getStatusLabel(kasus.status)}

Ringkasan:
${kasus.ringkasan || '-'}

Catatan:
${kasus.catatan || '-'}
        `);
    }

    function exportReport() {
        if (filteredCases.length === 0) {
            alert('Tidak ada data untuk diekspor');
            return;
        }

        let csv = 'ID,Nama Siswa,Tingkat,Tanggal,Waktu,Konselor,Status,Ringkasan\n';
        filteredCases.forEach(c => {
            csv += `"${c.id}","${c.siswa_nama}","${c.siswa_tingkat}","${formatDate(c.tanggal)}","${c.waktu}","${c.bk_nama}","${getStatusLabel(c.status)}","${c.ringkasan || ''}"\n`;
        });

        const blob = new Blob([csv], { type: 'text/csv' });
        const link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.download = `Laporan_Konseling_${new Date().toISOString().slice(0,10)}.csv`;
        link.click();
    }

    function printReport() {
        if (filteredCases.length === 0) {
            alert('Tidak ada data untuk dicetak');
            return;
        }
        window.print();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const currentMonth = new Date().getMonth() + 1;
        const currentYear = new Date().getFullYear();
        document.getElementById('filterMonth').value = currentMonth;
        document.getElementById('filterYear').value = currentYear;
        
        fetchLaporanData();
    });
</script>

<style>
    .filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 16px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-group label {
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .filter-group .form-control {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }

    /* Report Summary Styles */
    .report-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .summary-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 24px;
        border-radius: 10px;
        color: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .summary-card:nth-child(2) {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }

    .summary-card:nth-child(3) {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .summary-card h3 {
        margin: 0 0 16px 0;
        font-size: 16px;
        font-weight: 600;
        opacity: 0.9;
    }

    .summary-value {
        display: block;
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .summary-label {
        display: block;
        font-size: 13px;
        opacity: 0.85;
    }

    /* Table Styles */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead tr {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }

    .data-table th {
        padding: 12px 16px;
        text-align: left;
        font-weight: 600;
        color: #333;
        font-size: 14px;
    }

    .data-table tbody tr {
        border-bottom: 1px solid #dee2e6;
        transition: background-color 0.2s;
    }

    .data-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .data-table td {
        padding: 12px 16px;
        font-size: 14px;
        color: #555;
    }

    /* Status Badge Styles */
    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-badge.pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-badge.completed {
        background-color: #d4edda;
        color: #155724;
    }

    .status-badge.rejected {
        background-color: #f8d7da;
        color: #721c24;
    }

    /* Button Icon Styles */
    .btn-icon {
        background: none;
        border: none;
        color: #667eea;
        cursor: pointer;
        padding: 6px 10px;
        font-size: 16px;
        transition: color 0.2s;
    }

    .btn-icon:hover {
        color: #764ba2;
    }

    /* Card Actions */
    .card-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .btn {
        padding: 10px 16px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-primary {
        background-color: #667eea;
        color: white;
    }

    .btn-primary:hover {
        background-color: #5568d3;
    }

    .btn-success {
        background-color: #28a745;
        color: white;
    }

    .btn-success:hover {
        background-color: #218838;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .report-summary {
            grid-template-columns: 1fr;
        }

        .card-actions {
            flex-direction: column;
        }

        .table-responsive {
            overflow-x: auto;
        }
    }
</style>
@endpush
