@extends('layouts.app')

@section('title', 'Atur Jadwal Pelajaran - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Atur Jadwal Pelajaran')
@section('breadcrumb', 'Admin / Jadwal Pelajaran')

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
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        align-items: end;
    }

    .schedule-controls .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .schedule-controls label {
        font-size: 14px;
        color: #555;
        font-weight: 600;
    }

    .schedule-controls select,
    .schedule-controls input {
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        background: #fff;
    }

    .slot-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .slot-badge.mapel {
        background: #e3f2fd;
        color: #1e88e5;
    }

    .slot-badge.kegiatan {
        background: #fff3e0;
        color: #fb8c00;
    }

    .jadwal-table select,
    .jadwal-table input {
        width: 100%;
        min-width: 140px;
        padding: 6px 10px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 13px;
    }

    .jadwal-table .row-actions {
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .row-status {
        font-size: 12px;
        color: #888;
        margin-top: 6px;
    }

    @media (max-width: 768px) {
        .schedule-controls .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
    <div class="content-container">
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-calendar-alt"></i> Atur Jadwal Pelajaran</h3>
                <div class="card-actions" style="display: flex; gap: 10px;">
                    <a href="{{ route('admin.jadwal-master') }}" class="btn btn-secondary" style="background-color: #6c757d; color: white;">
                        <i class="fas fa-calendar-week"></i> Lihat Jadwal Master
                    </a>
                    <button class="btn btn-primary" id="loadScheduleBtn">
                        <i class="fas fa-search"></i> Muat Jadwal
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="schedule-controls">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="tingkatSelect">Tingkat</label>
                            <select id="tingkatSelect">
                                <option value="">-- Pilih Tingkat --</option>
                                <option value="X">X</option>
                                <option value="XI">XI</option>
                                <option value="XII">XII</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="hariSelect">Hari</label>
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
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="data-table jadwal-table" id="jadwalTable">
                        <thead>
                            <tr>
                                <th>Jam</th>
                                <th>Slot</th>
                                <th>Tipe</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="jadwalBody">
                            <tr>
                                <td colspan="7" style="text-align: center;">Pilih tingkat dan hari terlebih dahulu.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="margin-top: 20px; text-align: right;">
                    <button class="btn btn-success" id="saveAllBtn" style="display: none; padding: 10px 20px; font-size: 15px;">
                        <i class="fas fa-save"></i> Simpan Semua Jadwal
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const daysOrder = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const tingkatList = ['X', 'XI', 'XII'];
    let mapelList = [];
    let guruList = [];
    let slotList = [];

    document.addEventListener('DOMContentLoaded', () => {
        initSchedulePage();
        const loadBtn = document.getElementById('loadScheduleBtn');
        if (loadBtn) {
            loadBtn.addEventListener('click', loadSchedule);
        }
        const saveAllBtn = document.getElementById('saveAllBtn');
        if (saveAllBtn) {
            saveAllBtn.addEventListener('click', saveAllSchedule);
        }
    });

    async function initSchedulePage() {
        const token = getToken();
        if (!token) return;

        loadTingkatOptions();
        await Promise.all([
            loadMapel(),
            loadGuru(),
            loadSlots()
        ]);
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

    function loadTingkatOptions() {
        const select = document.getElementById('tingkatSelect');
        if (!select) return;
        select.innerHTML = '<option value="">-- Pilih Tingkat --</option>';
        tingkatList.forEach(tingkat => {
            select.innerHTML += `<option value="${tingkat}">${tingkat}</option>`;
        });
    }

    async function loadMapel() {
        const token = getToken();
        if (!token) return;

        const response = await fetch('/api/admin/mapel', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();
        if (result.success) {
            mapelList = result.data || [];
        }
    }

    async function loadGuru() {
        const token = getToken();
        if (!token) return;

        const response = await fetch('/api/admin/guru', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();
        if (result.success) {
            guruList = result.data || [];
        }
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

    async function loadSchedule() {
        const tingkat = document.getElementById('tingkatSelect').value;
        const hari = document.getElementById('hariSelect').value;

        if (!tingkat || !hari) {
            alert('Pilih tingkat dan hari terlebih dahulu.');
            return;
        }

        const token = getToken();
        if (!token) return;

        const response = await fetch(`/api/admin/jadwal-pelajaran?tingkat=${tingkat}&hari=${hari}` , {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json'
            }
        });

        const result = await response.json();
        const jadwalData = result.success ? (result.data || []) : [];

        renderScheduleTable(hari, jadwalData, tingkat);
    }

    function renderScheduleTable(hari, jadwalData, tingkat) {
        const tbody = document.getElementById('jadwalBody');
        const slotsForDay = slotList
            .filter(slot => !slot.hari || slot.hari === hari)
            .sort((a, b) => a.jam_mulai.localeCompare(b.jam_mulai));

        const jadwalMap = {};
        jadwalData.forEach(item => {
            if (item.slot_id) {
                jadwalMap[`slot-${item.slot_id}`] = item;
            } else {
                jadwalMap[`time-${item.jam_mulai}-${item.jam_selesai}`] = item;
            }
        });

        if (slotsForDay.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align: center;">Slot jadwal belum tersedia.</td></tr>';
            document.getElementById('saveAllBtn').style.display = 'none';
            return;
        }

        document.getElementById('saveAllBtn').style.display = 'inline-block';

        let mapelCounter = 1;

        tbody.innerHTML = slotsForDay.map(slot => {
            const slotKey = slot.id ? `slot-${slot.id}` : `time-${slot.jam_mulai}-${slot.jam_selesai}`;
            const jadwal = jadwalMap[slotKey];
            const tipe = jadwal?.tipe || slot.tipe || 'mapel';
            const mapelId = jadwal?.mapel_id || jadwal?.mapel?.id || '';
            const guruId = jadwal?.guru_id || jadwal?.guru?.id || '';
            const keterangan = jadwal?.keterangan || (tipe === 'kegiatan' ? (slot.label || '') : '');

            let slotDisplay = '';
            if (tipe === 'mapel') {
                slotDisplay = `Jam ${mapelCounter}`;
                mapelCounter++;
            } else {
                slotDisplay = keterangan || slot.label || 'Kegiatan';
            }

            return `
                <tr data-slot-id="${slot.id}" data-jadwal-id="${jadwal?.id || ''}" data-slot-tipe="${tipe}">
                    <td>${slot.jam_mulai} - ${slot.jam_selesai}</td>
                    <td>${slotDisplay}</td>
                    <td>
                        <select class="tipe-select" onchange="toggleTipeInput(this)" style="padding: 6px; border-radius: 6px; border: 1px solid #ddd; font-size: 13px;">
                            <option value="mapel" ${tipe === 'mapel' ? 'selected' : ''}>Mapel</option>
                            <option value="kegiatan" ${tipe === 'kegiatan' ? 'selected' : ''}>Kegiatan</option>
                        </select>
                    </td>
                    <td>
                        <select class="mapel-select" ${tipe === 'kegiatan' ? 'disabled' : ''}>
                            <option value="">-- Pilih Mapel --</option>
                            ${mapelList.map(mapel => `
                                <option value="${mapel.id}" ${mapelId === mapel.id ? 'selected' : ''}>
                                    ${mapel.kode_mapel} - ${mapel.nama_mapel}
                                </option>
                            `).join('')}
                        </select>
                    </td>
                    <td>
                        <select class="guru-select" ${tipe === 'kegiatan' ? 'disabled' : ''}>
                            <option value="">-- Pilih Guru --</option>
                            ${guruList.map(guru => `
                                <option value="${guru.id}" ${guruId === guru.id ? 'selected' : ''}>
                                    ${guru.nama}
                                </option>
                            `).join('')}
                        </select>
                    </td>
                    <td>
                        <input type="text" class="keterangan-input" value="${keterangan}">
                    </td>
                    <td>
                        <div class="row-actions">
                            <button class="btn-icon btn-danger" onclick="clearRowInput(${slot.id})" title="Kosongkan Baris">
                                <i class="fas fa-eraser"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        }).join('');
    }

    async function saveAllSchedule() {
        const tingkat = document.getElementById('tingkatSelect').value;
        const hari = document.getElementById('hariSelect').value;

        if (!tingkat || !hari) {
            alert('Pilih tingkat dan hari terlebih dahulu.');
            return;
        }

        const token = getToken();
        if (!token) return;

        const tbody = document.getElementById('jadwalBody');
        const rows = tbody.querySelectorAll('tr[data-slot-id]');
        const jadwalsData = [];

        rows.forEach(row => {
            const slotId = row.dataset.slotId;
            const jadwalId = row.dataset.jadwalId;
            const tipeSelect = row.querySelector('.tipe-select');
            const tipe = tipeSelect ? tipeSelect.value : (row.dataset.slotTipe || 'mapel');
            
            let mapelId = null;
            let guruId = null;
            let keterangan = null;

            if (tipe === 'mapel') {
                const mapelSelect = row.querySelector('.mapel-select');
                const guruSelect = row.querySelector('.guru-select');
                mapelId = mapelSelect ? mapelSelect.value : null;
                guruId = guruSelect ? guruSelect.value : null;
            }

            const keteranganInput = row.querySelector('.keterangan-input');
            
            keterangan = keteranganInput ? keteranganInput.value.trim() : null;

            jadwalsData.push({
                id: jadwalId || null,
                slot_id: Number(slotId),
                tipe: tipe,
                mapel_id: mapelId ? Number(mapelId) : null,
                guru_id: guruId ? Number(guruId) : null,
                keterangan: keterangan || null
            });
        });

        if (jadwalsData.length === 0) {
            alert('Tidak ada data jadwal untuk disimpan.');
            return;
        }

        const payload = {
            hari: hari,
            tingkat: tingkat,
            jadwals: jadwalsData
        };

        const saveBtn = document.getElementById('saveAllBtn');
        const originalText = saveBtn.innerHTML;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        saveBtn.disabled = true;

        try {
            const response = await fetch('/api/admin/jadwal-pelajaran/bulk', {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();
            if (response.ok && result.success) {
                alert('Semua jadwal berhasil disimpan!');
                // Reload schedule to get the latest IDs
                loadSchedule();
            } else {
                const errors = result.errors ? Object.values(result.errors).flat().join('\\n') : (result.message || 'Gagal menyimpan jadwal');
                alert(errors);
            }
        } catch (error) {
            console.error(error);
            alert('Terjadi kesalahan sistem saat menyimpan jadwal.');
        } finally {
            saveBtn.innerHTML = originalText;
            saveBtn.disabled = false;
        }
    }

    function clearRowInput(slotId) {
        const row = document.querySelector(`tr[data-slot-id="${slotId}"]`);
        if (!row) return;

        const tipeSelect = row.querySelector('.tipe-select');
        if (tipeSelect) {
            tipeSelect.value = 'mapel';
            toggleTipeInput(tipeSelect);
        }
        
        const mapelSelect = row.querySelector('.mapel-select');
        const guruSelect = row.querySelector('.guru-select');
        if (mapelSelect) mapelSelect.value = '';
        if (guruSelect) guruSelect.value = '';

        const keteranganInput = row.querySelector('.keterangan-input');
        if (keteranganInput) keteranganInput.value = '';
    }

    function toggleTipeInput(selectElement) {
        const row = selectElement.closest('tr');
        const tipe = selectElement.value;
        const mapelSelect = row.querySelector('.mapel-select');
        const guruSelect = row.querySelector('.guru-select');
        
        row.dataset.slotTipe = tipe;

        if (tipe === 'kegiatan') {
            if (mapelSelect) {
                mapelSelect.disabled = true;
                mapelSelect.value = '';
            }
            if (guruSelect) {
                guruSelect.disabled = true;
                guruSelect.value = '';
            }
        } else {
            if (mapelSelect) mapelSelect.disabled = false;
            if (guruSelect) guruSelect.disabled = false;
        }
    }
</script>
@endpush
