@extends('layouts.app')

@section('title', 'Logbook Mengajar - SIAKAD SMA')
@section('page-title', 'Logbook Mengajar')
@section('breadcrumb', 'Guru / Logbook')

@php $role = 'guru'; @endphp

@push('styles')
<style>
    .logbook-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 28px;
    }
    .lb-stat-card {
        background: white;
        border-radius: 14px;
        padding: 22px 28px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        display: flex;
        align-items: center;
        gap: 18px;
    }
    .lb-stat-icon {
        width: 56px; height: 56px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; color: white; flex-shrink: 0;
    }
    .lb-stat-info h3 { font-size: 32px; font-weight: 800; margin: 0; color: #1e293b; }
    .lb-stat-info p  { font-size: 13px; color: #64748b; margin: 2px 0 0; }

    /* Logbook List */
    .logbook-card { background: white; border-radius: 14px; box-shadow: 0 2px 12px rgba(0,0,0,0.07); overflow: hidden; }
    .logbook-card-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 18px 24px; border-bottom: 1px solid #f1f5f9;
    }
    .logbook-card-header h3 { margin: 0; font-size: 16px; color: #1e293b; display: flex; align-items: center; gap: 8px; }

    .logbook-entry {
        border-left: 4px solid #e2e8f0;
        padding: 20px 24px;
        display: grid;
        grid-template-columns: 80px 1fr auto;
        gap: 20px;
        align-items: start;
        transition: background 0.15s;
        cursor: pointer;
    }
    .logbook-entry:hover { background: #f8fafc; }
    .logbook-entry + .logbook-entry { border-top: 1px solid #f1f5f9; }
    .logbook-entry.diserahkan { border-left-color: #22c55e; }
    .logbook-entry.draft-lengkap { border-left-color: #f59e0b; }
    .logbook-entry.draft-kosong { border-left-color: #ef4444; }

    .entry-date {
        text-align: center;
        background: #f1f5f9;
        border-radius: 10px;
        padding: 10px 8px;
        line-height: 1.2;
    }
    .entry-date .day  { font-size: 26px; font-weight: 800; color: #1e40af; display: block; }
    .entry-date .month{ font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; }
    .entry-date .year { font-size: 11px; color: #94a3b8; }

    .entry-info h4 { margin: 0 0 6px; font-size: 15px; color: #1e293b; font-weight: 700; }
    .entry-info .meta { display: flex; flex-wrap: wrap; gap: 12px; font-size: 13px; color: #64748b; }
    .entry-info .meta span { display: flex; align-items: center; gap: 4px; }

    .entry-preview { margin-top: 10px; font-size: 13px; color: #475569; line-height: 1.5; }
    .entry-preview strong { color: #1e293b; }

    .entry-actions { display: flex; flex-direction: column; align-items: flex-end; gap: 8px; flex-shrink: 0; }

    .badge-status {
        padding: 5px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; white-space: nowrap;
    }
    .badge-diserahkan { background: #dcfce7; color: #15803d; }
    .badge-draft-lengkap { background: #fef9c3; color: #a16207; }
    .badge-draft-kosong  { background: #fee2e2; color: #b91c1c; }

    /* Detail / Edit Panel */
    .logbook-detail-panel {
        display: none;
        padding: 24px;
        border-top: 2px solid #e2e8f0;
        background: #f8fafc;
    }
    .logbook-detail-panel.open { display: block; }

    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .detail-info-box {
        background: white; border-radius: 10px; padding: 18px;
        border: 1px solid #e2e8f0;
    }
    .detail-info-box h5 { margin: 0 0 12px; font-size: 13px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
    .info-row { display: flex; justify-content: space-between; font-size: 13px; padding: 5px 0; border-bottom: 1px solid #f1f5f9; }
    .info-row:last-child { border-bottom: none; }
    .info-row .label { color: #64748b; }
    .info-row .val   { font-weight: 600; color: #1e293b; }

    .form-group-lb { margin-bottom: 16px; }
    .form-group-lb label { font-size: 13px; font-weight: 600; color: #374151; display: block; margin-bottom: 6px; }
    .form-group-lb textarea {
        width: 100%; padding: 12px; border: 1.5px solid #e2e8f0; border-radius: 8px;
        font-size: 14px; resize: vertical; min-height: 90px; outline: none; font-family: inherit;
        transition: border-color 0.2s;
    }
    .form-group-lb textarea:focus { border-color: #3b82f6; }
    .form-group-lb textarea:disabled { background: #f8fafc; color: #64748b; cursor: not-allowed; }

    .detail-actions {
        display: flex; justify-content: flex-end; gap: 10px; margin-top: 18px;
        padding-top: 16px; border-top: 1px solid #e2e8f0;
    }

    .btn-serahkan {
        background: #22c55e; color: white; border: none; padding: 10px 22px;
        border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 14px;
        transition: background 0.2s;
    }
    .btn-serahkan:hover { background: #16a34a; }
    .btn-serahkan:disabled { background: #86efac; cursor: not-allowed; }

    .empty-logbook { text-align: center; padding: 60px 24px; color: #94a3b8; }
    .empty-logbook i { font-size: 48px; display: block; margin-bottom: 12px; }

    .alert-info {
        background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px;
        padding: 12px 16px; font-size: 13px; color: #1d4ed8; margin-bottom: 16px;
        display: flex; align-items: center; gap: 8px;
    }
</style>
@endpush

@section('content')
<div class="content-container">

    <!-- Stats Cards -->
    <div class="logbook-stats">
        <div class="lb-stat-card">
            <div class="lb-stat-icon" style="background: #3b82f6;"><i class="fas fa-book-open"></i></div>
            <div class="lb-stat-info">
                <h3 id="statEntriBulanIni">-</h3>
                <p>Entri Bulan Ini</p>
            </div>
        </div>
        <div class="lb-stat-card">
            <div class="lb-stat-icon" style="background: #f59e0b;"><i class="fas fa-paper-plane"></i></div>
            <div class="lb-stat-info">
                <h3 id="statPerluDiserahkan">-</h3>
                <p>Perlu Diserahkan</p>
            </div>
        </div>
    </div>

    <!-- Logbook List -->
    <div class="logbook-card">
        <div class="logbook-card-header">
            <h3><i class="fas fa-list-alt" style="color:#3b82f6;"></i> Daftar Entri Logbook</h3>
            <span id="loadingIndicator" style="font-size:13px; color:#94a3b8;"><i class="fas fa-spinner fa-spin"></i> Memuat...</span>
        </div>
        <div id="logbookList"></div>
    </div>

</div>

<!-- Modal Detail / Edit Logbook -->
<div id="logbookModal" class="modal" style="display:none;">
    <div class="modal-content" style="max-width:700px;">
        <div class="modal-header">
            <h3><i class="fas fa-book"></i> <span id="modalTitle">Detail Logbook</span></h3>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body" id="modalBody">
            <p style="text-align:center;"><i class="fas fa-spinner fa-spin"></i> Memuat...</p>
        </div>
        <div class="modal-footer" id="modalFooter" style="display:none;">
            <button class="btn btn-secondary" onclick="closeModal()">Tutup</button>
            <button class="btn btn-primary" id="btnSimpanLogbook" onclick="simpanLogbook()">
                <i class="fas fa-save"></i> Simpan
            </button>
            <button class="btn btn-serahkan" id="btnSerahkan" onclick="serahkanLogbook()">
                <i class="fas fa-paper-plane"></i> Serahkan ke Admin
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const BULAN = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    let allLogbooks = [];
    let activeLogbookId = null;

    document.addEventListener('DOMContentLoaded', initLogbook);

    function getToken() {
        const t = localStorage.getItem('token');
        if (!t) { window.location.href = '/login'; return null; }
        return t;
    }

    async function initLogbook() {
        const token = getToken(); if (!token) return;

        try {
            // Update sidebar name
            const meRes = await fetch('/api/me', { headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' } });
            const me = await meRes.json();
            const guru = me.data?.profile;
            if (guru) {
                const sn = document.getElementById('sidebarUserName');
                const sr = document.getElementById('sidebarUserRole');
                if (sn) sn.textContent = guru.nama;
                if (sr && guru) {
                    const mapelName = (guru.mapels && guru.mapels.length > 0) ? guru.mapels[0].nama_mapel : '';
                    sr.textContent = mapelName ? `Guru ${mapelName}` : 'Guru';
                }
            }

            // Load logbooks
            const res = await fetch('/api/guru/logbook', {
                headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' }
            });
            const result = await res.json();

            document.getElementById('loadingIndicator').style.display = 'none';

            if (!result.success) throw new Error(result.message);

            allLogbooks = result.data || [];
            const stats  = result.stats || {};

            document.getElementById('statEntriBulanIni').textContent    = stats.entri_bulan_ini ?? 0;
            document.getElementById('statPerluDiserahkan').textContent  = stats.perlu_diserahkan ?? 0;

            renderLogbookList(allLogbooks);

        } catch (err) {
            console.error(err);
            document.getElementById('loadingIndicator').innerHTML = '<span style="color:#ef4444;">Gagal memuat data</span>';
        }
    }

    function renderLogbookList(list) {
        const container = document.getElementById('logbookList');
        if (!list.length) {
            container.innerHTML = `<div class="empty-logbook">
                <i class="fas fa-book-open"></i>
                <p>Belum ada entri logbook. Buat absensi terlebih dahulu untuk memulai.</p>
            </div>`;
            return;
        }

        container.innerHTML = list.map(lb => {
            const absen = lb.absen || {};
            const mapelNama = absen.mapel?.nama_mapel || '-';
            const tanggal = absen.tanggal ? new Date(absen.tanggal) : null;
            const day   = tanggal ? tanggal.getDate() : '-';
            const month = tanggal ? BULAN[tanggal.getMonth()] : '';
            const year  = tanggal ? tanggal.getFullYear() : '';

            const isLengkap = lb.materi_pembelajaran && lb.metode_pembelajaran && lb.tugas_evaluasi;
            let statusClass, badgeClass, badgeText;

            if (lb.status === 'diserahkan') {
                statusClass = 'diserahkan'; badgeClass = 'badge-diserahkan'; badgeText = 'DISERAHKAN';
            } else if (isLengkap) {
                statusClass = 'draft-lengkap'; badgeClass = 'badge-draft-lengkap'; badgeText = 'SIAP DISERAHKAN';
            } else {
                statusClass = 'draft-kosong'; badgeClass = 'badge-draft-kosong'; badgeText = 'PERLU DILENGKAPI';
            }

            const hadir = lb.total_hadir ?? 0;
            const total = lb.total_siswa ?? 0;

            return `<div class="logbook-entry ${statusClass}" onclick="openModal(${lb.id})">
                <div class="entry-date">
                    <span class="day">${day}</span>
                    <span class="month">${month}</span>
                    <span class="year">${year}</span>
                </div>
                <div class="entry-info">
                    <h4>${mapelNama} — Kelas ${absen.tingkat || '-'}</h4>
                    <div class="meta">
                        <span><i class="fas fa-clock"></i> ${(absen.jam_mulai||'').substring(0,5)} – ${(absen.jam_selesai||'').substring(0,5)}</span>
                        <span><i class="fas fa-users"></i> ${hadir}/${total} hadir</span>
                        <span><i class="fas fa-layer-group"></i> ${absen.pertemuan || '-'}</span>
                    </div>
                    ${lb.materi_pembelajaran ? `<div class="entry-preview"><strong>Materi:</strong> ${lb.materi_pembelajaran.substring(0,120)}${lb.materi_pembelajaran.length>120?'...':''}</div>` : ''}
                </div>
                <div class="entry-actions">
                    <span class="badge-status ${badgeClass}">${badgeText}</span>
                    <span style="font-size:12px; color:#94a3b8;">
                        <i class="fas fa-eye"></i> Detail
                    </span>
                </div>
            </div>`;
        }).join('');
    }

    async function openModal(id) {
        activeLogbookId = id;
        document.getElementById('logbookModal').style.display = 'block';
        document.getElementById('modalBody').innerHTML = '<p style="text-align:center; padding:32px;"><i class="fas fa-spinner fa-spin"></i> Memuat...</p>';
        document.getElementById('modalFooter').style.display = 'none';

        const token = getToken(); if (!token) return;
        const res = await fetch(`/api/guru/logbook/${id}`, {
            headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' }
        });
        const result = await res.json();
        if (!result.success) { alert('Gagal memuat detail'); return; }

        renderModal(result.data);
    }

    function renderModal(lb) {
        const absen = lb.absen || {};
        const mapelNama = absen.mapel?.nama_mapel || '-';
        const isDiserahkan = lb.status === 'diserahkan';
        const disabled = isDiserahkan ? 'disabled' : '';

        document.getElementById('modalTitle').textContent = `${mapelNama} — ${absen.tingkat || ''}`;

        const tanggal = absen.tanggal ? new Date(absen.tanggal).toLocaleDateString('id-ID', { day:'2-digit', month:'long', year:'numeric' }) : '-';

        document.getElementById('modalBody').innerHTML = `
            ${isDiserahkan ? `<div class="alert-info"><i class="fas fa-lock"></i> Logbook ini sudah diserahkan ke admin dan tidak dapat diubah.</div>` : ''}

            <div class="detail-grid" style="margin-bottom:20px;">
                <div class="detail-info-box">
                    <h5><i class="fas fa-info-circle"></i> Info Sesi</h5>
                    <div class="info-row"><span class="label">Tanggal</span><span class="val">${tanggal}</span></div>
                    <div class="info-row"><span class="label">Jam</span><span class="val">${(absen.jam_mulai||'').substring(0,5)} – ${(absen.jam_selesai||'').substring(0,5)}</span></div>
                    <div class="info-row"><span class="label">Pertemuan</span><span class="val">${absen.pertemuan || '-'}</span></div>
                    <div class="info-row"><span class="label">Tingkat</span><span class="val">Kelas ${absen.tingkat || '-'}</span></div>
                </div>
                <div class="detail-info-box">
                    <h5><i class="fas fa-users"></i> Kehadiran</h5>
                    <div class="info-row"><span class="label">Hadir</span><span class="val" style="color:#22c55e;">${lb.total_hadir ?? 0}</span></div>
                    <div class="info-row"><span class="label">Total Siswa</span><span class="val">${lb.total_siswa ?? 0}</span></div>
                    <div class="info-row"><span class="label">Mapel</span><span class="val">${mapelNama}</span></div>
                    <div class="info-row"><span class="label">Status</span><span class="val">${isDiserahkan ? '✅ Diserahkan' : '📝 Draft'}</span></div>
                </div>
            </div>

            <div class="form-group-lb">
                <label><i class="fas fa-book"></i> Materi Pembelajaran *</label>
                <textarea id="inputMateri" ${disabled} placeholder="Isi materi yang diajarkan...">${lb.materi_pembelajaran || ''}</textarea>
            </div>
            <div class="form-group-lb">
                <label><i class="fas fa-chalkboard"></i> Metode Pembelajaran *</label>
                <textarea id="inputMetode" ${disabled} placeholder="Contoh: Ceramah interaktif, diskusi kelompok, tanya jawab...">${lb.metode_pembelajaran || ''}</textarea>
            </div>
            <div class="form-group-lb">
                <label><i class="fas fa-tasks"></i> Tugas & Evaluasi *</label>
                <textarea id="inputTugas" ${disabled} placeholder="Contoh: Latihan soal hal. 45-47, dikumpulkan minggu depan...">${lb.tugas_evaluasi || ''}</textarea>
            </div>

            ${isDiserahkan && lb.diserahkan_at ? `<p style="font-size:12px; color:#64748b; margin-top:8px;"><i class="fas fa-check-circle" style="color:#22c55e;"></i> Diserahkan pada ${new Date(lb.diserahkan_at).toLocaleString('id-ID')}</p>` : ''}
        `;

        document.getElementById('modalFooter').style.display = 'flex';
        document.getElementById('btnSimpanLogbook').style.display = isDiserahkan ? 'none' : '';
        document.getElementById('btnSerahkan').style.display = isDiserahkan ? 'none' : '';
    }

    async function simpanLogbook() {
        const token = getToken(); if (!token) return;
        const btn = document.getElementById('btnSimpanLogbook');
        btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';

        const payload = {
            materi_pembelajaran: document.getElementById('inputMateri').value.trim(),
            metode_pembelajaran:  document.getElementById('inputMetode').value.trim(),
            tugas_evaluasi:       document.getElementById('inputTugas').value.trim(),
        };

        try {
            const res = await fetch(`/api/guru/logbook/${activeLogbookId}`, {
                method: 'PUT',
                headers: { Authorization: `Bearer ${token}`, 'Content-Type': 'application/json', Accept: 'application/json' },
                body: JSON.stringify(payload)
            });
            const result = await res.json();
            if (result.success) {
                closeModal();
                await initLogbook();
            } else {
                alert('Gagal menyimpan: ' + result.message);
            }
        } catch (e) { alert('Terjadi kesalahan'); }
        finally { btn.disabled = false; btn.innerHTML = '<i class="fas fa-save"></i> Simpan'; }
    }

    async function serahkanLogbook() {
        const token = getToken(); if (!token) return;

        const materi = document.getElementById('inputMateri')?.value.trim();
        const metode = document.getElementById('inputMetode')?.value.trim();
        const tugas  = document.getElementById('inputTugas')?.value.trim();

        if (!materi || !metode || !tugas) {
            alert('Harap lengkapi semua field (Materi, Metode Pembelajaran, Tugas & Evaluasi) sebelum menyerahkan.');
            return;
        }

        if (!confirm('Yakin ingin menyerahkan logbook ini ke admin? Setelah diserahkan tidak dapat diubah lagi.')) return;

        // Simpan dulu sebelum serahkan
        const savePay = { materi_pembelajaran: materi, metode_pembelajaran: metode, tugas_evaluasi: tugas };
        await fetch(`/api/guru/logbook/${activeLogbookId}`, {
            method: 'PUT',
            headers: { Authorization: `Bearer ${token}`, 'Content-Type': 'application/json', Accept: 'application/json' },
            body: JSON.stringify(savePay)
        });

        const btn = document.getElementById('btnSerahkan');
        btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyerahkan...';

        try {
            const res = await fetch(`/api/guru/logbook/${activeLogbookId}/serahkan`, {
                method: 'POST',
                headers: { Authorization: `Bearer ${token}`, Accept: 'application/json' }
            });
            const result = await res.json();
            if (result.success) {
                closeModal();
                await initLogbook();
                alert('✅ Logbook berhasil diserahkan ke admin!');
            } else {
                alert('Gagal: ' + result.message);
            }
        } catch (e) { alert('Terjadi kesalahan'); }
        finally { btn.disabled = false; btn.innerHTML = '<i class="fas fa-paper-plane"></i> Serahkan ke Admin'; }
    }

    function closeModal() {
        document.getElementById('logbookModal').style.display = 'none';
        activeLogbookId = null;
    }

    window.onclick = e => {
        if (e.target === document.getElementById('logbookModal')) closeModal();
    };
</script>
@endpush