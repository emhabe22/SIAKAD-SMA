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
