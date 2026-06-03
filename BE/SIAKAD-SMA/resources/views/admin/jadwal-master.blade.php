@extends('layouts.app')

@section('title', 'Jadwal Master - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Jadwal Master')
@section('breadcrumb', 'Admin / Jadwal Pelajaran / Master')

@php
    $role = 'admin';
    $userName = 'Memuat...';
    $userRole = 'Memuat...';
@endphp

@push('styles')
<style>
    .schedule-controls {
        background: #ffffff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .schedule-controls .form-row {
        display: flex;
        gap: 16px;
        align-items: end;
    }

    .schedule-controls .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
        max-width: 300px;
    }

    .schedule-controls label {
        font-size: 14px;
        color: #555;
        font-weight: 600;
    }

    .schedule-controls select {
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        background: #fff;
    }

    .master-table th {
        text-align: center;
        background-color: #f8f9fa;
        padding: 12px;
    }

    .master-table td {
        padding: 12px;
        vertical-align: middle;
    }

    .cell-kegiatan {
        background-color: #fff3e0;
        text-align: center;
        font-weight: 600;
        color: #e65100;
    }

    .cell-mapel {
        background-color: #e3f2fd;
        border-radius: 6px;
        padding: 8px;
        text-align: center;
        border: 1px solid #bbdefb;
    }
    
    .cell-empty {
        background-color: #fafafa;
        color: #999;
        text-align: center;
        font-style: italic;
    }

    .mapel-name {
        font-weight: 600;
        color: #1565c0;
        display: block;
        margin-bottom: 4px;
    }

    .guru-name {
        font-size: 12px;
        color: #555;
        display: block;
    }

    .ruangan-info {
        font-size: 11px;
        color: #888;
        display: block;
        margin-top: 4px;
    }
</style>
@endpush

@section('content')
    <div class="content-container">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-calendar-week"></i> Jadwal Master</h3>
                <div class="card-actions">
                    <a href="{{ route('admin.jadwal-pelajaran') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Atur Jadwal
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="schedule-controls">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="hariSelect">Pilih Hari</label>
                            <select id="hariSelect">
                                <option value="">-- Pilih Hari --</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                                <option value="Sabtu">Sabtu</option>
                            </select>
                        </div>
                        <button class="btn btn-primary" id="loadMasterBtn" style="height: 42px;">
                            <i class="fas fa-search"></i> Tampilkan Jadwal
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="data-table master-table" id="masterTable">
                        <thead>
                            <tr>
                                <th width="10%">Jam</th>
                                <th width="10%">Waktu</th>
                                <th width="26%">Kelas X</th>
                                <th width="26%">Kelas XI</th>
                                <th width="26%">Kelas XII</th>
                            </tr>
                        </thead>
                        <tbody id="masterBody">
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 30px;">
                                    Silakan pilih hari terlebih dahulu untuk melihat jadwal master.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    let slotList = [];

    document.addEventListener('DOMContentLoaded', () => {
        initMasterPage();
        const loadBtn = document.getElementById('loadMasterBtn');
        if (loadBtn) {
            loadBtn.addEventListener('click', loadMasterSchedule);
        }
    });

    async function initMasterPage() {
        const token = getToken();
        if (!token) return;
        await loadSlots();
    }

    function getToken() {
        const token = localStorage.getItem('token');
        if (!token) {
            alert('Anda belum login. Silakan login terlebih dahulu.');
            window.location.href = '/login';
            return null;
        }
        return token;
    }

    async function loadSlots() {
        const token = getToken();
        if (!token) return;

        const response = await fetch('/api/jadwal-slots', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();
        if (result.success) {
            slotList = result.data || [];
        }
    }

    async function loadMasterSchedule() {
        const hari = document.getElementById('hariSelect').value;

        if (!hari) {
            alert('Pilih hari terlebih dahulu.');
            return;
        }

        const token = getToken();
        if (!token) return;

        const tbody = document.getElementById('masterBody');
        tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;"><i class="fas fa-spinner fa-spin"></i> Memuat jadwal...</td></tr>';

        try {
            const response = await fetch(`/api/admin/jadwal-pelajaran?hari=${hari}`, {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();
            const jadwalData = result.success ? (result.data || []) : [];
            
            renderMasterTable(hari, jadwalData);
        } catch (error) {
            console.error(error);
            tbody.innerHTML = '<tr><td colspan="5" style="text-align: center; color: red;">Terjadi kesalahan saat memuat jadwal.</td></tr>';
        }
    }

    function renderMasterTable(hari, jadwalData) {
        const tbody = document.getElementById('masterBody');
        
        // Filter slots for the selected day or universal slots (no day)
        const slotsForDay = slotList
            .filter(slot => !slot.hari || slot.hari === hari)
            .sort((a, b) => a.jam_mulai.localeCompare(b.jam_mulai));

        if (slotsForDay.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">Slot jadwal belum tersedia untuk hari ini.</td></tr>';
            return;
        }

        // Organize data by slot_id and tingkat
        const scheduleMatrix = {};
        jadwalData.forEach(item => {
            const slotKey = item.slot_id ? item.slot_id : `${item.jam_mulai}-${item.jam_selesai}`;
            if (!scheduleMatrix[slotKey]) {
                scheduleMatrix[slotKey] = {};
            }
            scheduleMatrix[slotKey][item.tingkat] = item;
        });

        let html = '';
        let mapelCounter = 1;

        slotsForDay.forEach(slot => {
            const slotKey = slot.id ? slot.id : `${slot.jam_mulai}-${slot.jam_selesai}`;
            const rowData = scheduleMatrix[slotKey] || {};
            
            // Determine if the row acts as mapel or kegiatan
            let isMapelRow = false;
            let isKegiatanRow = false;
            let rowKeterangan = '';

            ['X', 'XI', 'XII'].forEach(kelas => {
                const item = rowData[kelas];
                if (item) {
                    if (item.tipe === 'mapel') isMapelRow = true;
                    if (item.tipe === 'kegiatan') {
                        isKegiatanRow = true;
                        if (item.keterangan && !rowKeterangan) {
                            rowKeterangan = item.keterangan;
                        }
                    }
                }
            });

            // Fallback to global slot tipe if no class data is present
            if (!isMapelRow && !isKegiatanRow) {
                if (slot.tipe === 'mapel') isMapelRow = true;
                else isKegiatanRow = true;
            }

            let jamDisplay = '';
            if (isMapelRow) {
                jamDisplay = `Jam ${mapelCounter}`;
                mapelCounter++;
            } else {
                jamDisplay = rowKeterangan || slot.label || 'Kegiatan';
            }

            const waktu = `${slot.jam_mulai} - ${slot.jam_selesai}`;
            
            // Check if slot has a global label but render each class individually
            // so that if a class has a specific 'keterangan' (e.g. Apel Pagi), it shows up properly
            html += `
                <tr>
                    <td style="text-align: center; font-weight: bold;">${jamDisplay}</td>
                    <td style="text-align: center;">${waktu}</td>
                    ${renderCell(rowData['X'], slot)}
                    ${renderCell(rowData['XI'], slot)}
                    ${renderCell(rowData['XII'], slot)}
                </tr>
            `;
        });

        tbody.innerHTML = html;
    }

    function renderCell(item, slot) {
        if (!item) {
            // Jika kosong di database, tapi secara global ini adalah kegiatan (seperti Istirahat)
            if (slot && slot.tipe === 'kegiatan') {
                return `<td class="cell-kegiatan">${slot.label || 'Kegiatan'}</td>`;
            }
            return `<td class="cell-empty">- Kosong -</td>`;
        }

        if (item.tipe === 'kegiatan') {
            return `<td class="cell-kegiatan">${item.keterangan || slot?.label || 'Kegiatan'}</td>`;
        }

        const mapel = item.mapel ? item.mapel.nama_mapel : 'Mapel Tidak Diketahui';
        const guru = item.guru ? item.guru.nama : 'Guru Tidak Diketahui';

        return `
            <td>
                <div class="cell-mapel">
                    <span class="mapel-name">${mapel}</span>
                    <span class="guru-name"><i class="fas fa-user-tie"></i> ${guru}</span>
                </div>
            </td>
        `;
    }
</script>
@endpush
