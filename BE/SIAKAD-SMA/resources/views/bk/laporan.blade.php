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
<!-- Report Summary -->
<div class="report-summary">
    <div class="summary-card">
        <h3>Total Kasus</h3>
        <span class="summary-value">156</span>
        <span class="summary-label">Kasus ditangani</span>
    </div>
    <div class="summary-card">
        <h3>Kasus Selesai</h3>
        <span class="summary-value">128</span>
        <span class="summary-label">Resolved cases</span>
    </div>
    <div class="summary-card">
        <h3>Rate Success</h3>
        <span class="summary-value">82%</span>
        <span class="summary-label">Tingkat keberhasilan</span>
    </div>
    <div class="summary-card">
        <h3>Rata-rata Waktu</h3>
        <span class="summary-value">14</span>
        <span class="summary-label">Hari per kasus</span>
    </div>
</div>

<!-- Reports Controls -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-filter"></i> Filter Laporan</h3>
    </div>
    <div class="card-body">
        <div class="controls-grid">
            <div class="control-group">
                <label>Periode Laporan</label>
                <select class="form-control" id="periodSelect">
                    <option value="month">Bulan Ini</option>
                    <option value="week">Minggu Ini</option>
                    <option value="quarter">Triwulan Ini</option>
                    <option value="semester">Semester Ini</option>
                    <option value="year">Tahun Ini</option>
                </select>
            </div>
            <div class="control-group">
                <label>Bulan</label>
                <select class="form-control" id="monthSelect">
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
            <div class="control-group">
                <label>Tahun</label>
                <select class="form-control" id="yearSelect">
                    <option value="2023">2023</option>
                    <option value="2024" selected>2024</option>
                </select>
            </div>
            <div class="control-group">
                <label>Jenis Kasus</label>
                <select class="form-control" id="caseTypeSelect">
                    <option value="all">Semua Jenis</option>
                    <option value="academic">Akademik</option>
                    <option value="social">Sosial</option>
                    <option value="career">Karir</option>
                    <option value="personal">Pribadi</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Cases Table -->
<div class="card">
    <div class="card-header">
        <h3><i class="fas fa-list"></i> Daftar Kasus Konseling</h3>
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
                        <th>ID Kasus</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Jenis Kasus</th>
                        <th>Tanggal Mulai</th>
                        <th>Status</th>
                        <th>Konselor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>BK-2024-001</td>
                        <td><strong>Andi Pratama</strong></td>
                        <td>XII IPA 1</td>
                        <td><span class="tag academic">Akademik</span></td>
                        <td>15 Jan 2024</td>
                        <td><span class="status-badge completed">Selesai</span></td>
                        <td>Bu Ani</td>
                        <td>
                            <button class="btn-icon" onclick="viewCase(1)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="editCase(1)">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>BK-2024-002</td>
                        <td><strong>Siti Nurhaliza</strong></td>
                        <td>XI IPS 2</td>
                        <td><span class="tag career">Karir</span></td>
                        <td>14 Jan 2024</td>
                        <td><span class="status-badge in-progress">Dalam Proses</span></td>
                        <td>Pak Budi</td>
                        <td>
                            <button class="btn-icon" onclick="viewCase(2)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="editCase(2)">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>BK-2024-003</td>
                        <td><strong>Rizki Ramadhan</strong></td>
                        <td>X MIPA</td>
                        <td><span class="tag social">Sosial</span></td>
                        <td>13 Jan 2024</td>
                        <td><span class="status-badge pending">Pending</span></td>
                        <td>Bu Ani</td>
                        <td>
                            <button class="btn-icon" onclick="viewCase(3)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="editCase(3)">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>BK-2024-004</td>
                        <td><strong>M. Rizki Fadillah</strong></td>
                        <td>XII IPA 1</td>
                        <td><span class="tag personal">Pribadi</span></td>
                        <td>12 Jan 2024</td>
                        <td><span class="status-badge completed">Selesai</span></td>
                        <td>Pak Budi</td>
                        <td>
                            <button class="btn-icon" onclick="viewCase(4)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="editCase(4)">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>BK-2024-005</td>
                        <td><strong>Dewi Sartika</strong></td>
                        <td>XI IPS 3</td>
                        <td><span class="tag academic">Akademik</span></td>
                        <td>10 Jan 2024</td>
                        <td><span class="status-badge in-progress">Dalam Proses</span></td>
                        <td>Bu Ani</td>
                        <td>
                            <button class="btn-icon" onclick="viewCase(5)">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-icon" onclick="editCase(5)">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function viewCase(id) {
        alert('Melihat detail kasus #' + id);
    }

    function editCase(id) {
        alert('Mengedit kasus #' + id);
    }

    function exportReport() {
        alert('Export laporan ke Excel');
    }

    function printReport() {
        window.print();
    }

    // Set current month
    document.addEventListener('DOMContentLoaded', function() {
        const currentMonth = new Date().getMonth() + 1;
        document.getElementById('monthSelect').value = currentMonth;
    });
</script>

<style>
    .report-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .summary-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .summary-card h3 {
        margin: 0 0 10px 0;
        color: #333;
        font-size: 18px;
    }

    .summary-value {
        font-size: 32px;
        font-weight: bold;
        color: #2196F3;
        display: block;
        margin-bottom: 5px;
    }

    .summary-label {
        font-size: 14px;
        color: #666;
    }

    .controls-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
    }

    .control-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .control-group label {
        font-size: 14px;
        color: #555;
        font-weight: 500;
    }

    .tag {
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .tag.academic { background: #4CAF50; color: white; }
    .tag.social { background: #2196F3; color: white; }
    .tag.career { background: #FF9800; color: white; }
    .tag.personal { background: #9C27B0; color: white; }

    @media (max-width: 768px) {
        .controls-grid {
            grid-template-columns: 1fr;
        }
        
        .report-summary {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush
