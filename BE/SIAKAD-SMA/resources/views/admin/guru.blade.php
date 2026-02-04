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

        <!-- Main Content Container -->
        <div class="content-container">


            <!-- Stats Cards -->
            <div class="stats-grid compact">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #4CAF50;">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-info">
                        <h3>42</h3>
                        <p>Guru Aktif</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #2196F3;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="stat-info">
                        <h3>18</h3>
                        <p>Wali Kelas</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #FF9800;">
                        <i class="fas fa-female"></i>
                    </div>
                    <div class="stat-info">
                        <h3>25</h3>
                        <p>Guru Perempuan</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #9C27B0;">
                        <i class="fas fa-male"></i>
                    </div>
                    <div class="stat-info">
                        <h3>17</h3>
                        <p>Guru Laki-laki</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon" style="background: #F44336;">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3>3</h3>
                        <p>Pensiun</p>
                    </div>
                </div>
            </div>

            <!-- Teachers Table -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-list"></i> Daftar Guru</h3>
                    <div class="card-actions">
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
                                    <th>Mata Pelajaran</th>
                                    <th>Status</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td><strong>198003012004011001</strong></td>
                                    <td>
                                        <div class="teacher-cell">
                                            <img src="https://via.placeholder.com/35" alt="Teacher" class="teacher-thumb">
                                            <div>
                                                <strong>Budi Santoso, S.Pd</strong>
                                                <small>budi.santoso@smamishbahululum.sch.id</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-teacher">Guru</span>
                                        <span class="badge badge-homeroom">Wali Kelas</span>
                                    </td>
                                    <td>Matematika</td>
                                    <td><span class="status-badge active">Aktif</span></td>
                                    <td>Laki-laki</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon" onclick="viewTeacher(1)" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-icon" onclick="editTeacher(1)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon btn-danger" onclick="deleteTeacher(1)" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td><strong>197805152000032002</strong></td>
                                    <td>
                                        <div class="teacher-cell">
                                            <img src="https://via.placeholder.com/35" alt="Teacher" class="teacher-thumb">
                                            <div>
                                                <strong>Siti Nurhaliza, M.Pd</strong>
                                                <small>siti.nurhaliza@smamishbahululum.sch.id</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-coordinator">Koordinator</span>
                                    </td>
                                    <td>Bahasa Indonesia</td>
                                    <td><span class="status-badge active">Aktif</span></td>
                                    <td>Perempuan</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon" onclick="viewTeacher(2)" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-icon" onclick="editTeacher(2)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon btn-danger" onclick="deleteTeacher(2)" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td><strong>196512101987031003</strong></td>
                                    <td>
                                        <div class="teacher-cell">
                                            <img src="https://via.placeholder.com/35" alt="Teacher" class="teacher-thumb">
                                            <div>
                                                <strong>Dr. Ahmad Hidayat, M.Si</strong>
                                                <small>ahmad.hidayat@smamishbahululum.sch.id</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-headmaster">Kepala Sekolah</span>
                                    </td>
                                    <td>Fisika</td>
                                    <td><span class="status-badge active">Aktif</span></td>
                                    <td>Laki-laki</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon" onclick="viewTeacher(3)" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-icon" onclick="editTeacher(3)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon btn-danger" onclick="deleteTeacher(3)" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td><strong>199002152015022004</strong></td>
                                    <td>
                                        <div class="teacher-cell">
                                            <img src="https://via.placeholder.com/35" alt="Teacher" class="teacher-thumb">
                                            <div>
                                                <strong>Dewi Sartika, S.Pd</strong>
                                                <small>dewi.sartika@smamishbahululum.sch.id</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-teacher">Guru</span>
                                    </td>
                                    <td>Kimia</td>
                                    <td><span class="status-badge active">Aktif</span></td>
                                    <td>Perempuan</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon" onclick="viewTeacher(4)" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-icon" onclick="editTeacher(4)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon btn-danger" onclick="deleteTeacher(4)" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td><strong>196005151985031005</strong></td>
                                    <td>
                                        <div class="teacher-cell">
                                            <img src="https://via.placeholder.com/35" alt="Teacher" class="teacher-thumb">
                                            <div>
                                                <strong>Mulyadi, S.Pd</strong>
                                                <small>mulyadi@smamishbahululum.sch.id</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-teacher">Guru</span>
                                    </td>
                                    <td>Biologi</td>
                                    <td><span class="status-badge retired">Pensiun</span></td>
                                    <td>Laki-laki</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-icon" onclick="viewTeacher(5)" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn-icon" onclick="editTeacher(5)" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn-icon btn-danger" onclick="deleteTeacher(5)" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
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
        <div class="modal-content wide-modal">
            <div class="modal-header">
                <h3 id="modalTitle">Tambah Guru Baru</h3>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="teacherForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="text" id="nip" placeholder="Masukkan NIP">
                        </div>
                        <div class="form-group">
                            <label for="nuptk">NUPTK</label>
                            <input type="text" id="nuptk" placeholder="Masukkan NUPTK">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="fullName">Nama Lengkap *</label>
                            <input type="text" id="fullName" required placeholder="Masukkan nama lengkap">
                        </div>
                        <div class="form-group">
                            <label for="title">Gelar</label>
                            <input type="text" id="title" placeholder="Contoh: S.Pd, M.Pd">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="birthPlace">Tempat Lahir</label>
                            <input type="text" id="birthPlace" placeholder="Masukkan tempat lahir">
                        </div>
                        <div class="form-group">
                            <label for="birthDate">Tanggal Lahir</label>
                            <input type="date" id="birthDate">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="gender">Jenis Kelamin *</label>
                            <select id="gender" required>
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="religion">Agama</label>
                            <select id="religion">
                                <option value="">-- Pilih --</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="position">Jabatan *</label>
                            <select id="position" required>
                                <option value="">-- Pilih Jabatan --</option>
                                <option value="teacher">Guru</option>
                                <option value="homeroom">Wali Kelas</option>
                                <option value="coordinator">Koordinator</option>
                                <option value="headmaster">Kepala Sekolah</option>
                                <option value="vice-headmaster">Wakil Kepala Sekolah</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subject">Mata Pelajaran *</label>
                            <select id="subject" required>
                                <option value="">-- Pilih Mapel --</option>
                                <option value="matematika">Matematika</option>
                                <option value="fisika">Fisika</option>
                                <option value="kimia">Kimia</option>
                                <option value="biologi">Biologi</option>
                                <option value="bahasa-indonesia">Bahasa Indonesia</option>
                                <option value="bahasa-inggris">Bahasa Inggris</option>
                                <option value="sejarah">Sejarah</option>
                                <option value="geografi">Geografi</option>
                                <option value="ekonomi">Ekonomi</option>
                                <option value="sosiologi">Sosiologi</option>
                                <option value="seni-budaya">Seni Budaya</option>
                                <option value="penjas">Penjaskes</option>
                                <option value="bk">Bimbingan Konseling</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="education">Pendidikan Terakhir</label>
                            <select id="education">
                                <option value="">-- Pilih --</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="major">Jurusan</label>
                            <input type="text" id="major" placeholder="Masukkan jurusan pendidikan">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea id="address" rows="3" placeholder="Masukkan alamat"></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Telepon</label>
                            <input type="tel" id="phone" placeholder="Masukkan nomor telepon">
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" required placeholder="Masukkan email">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="joinDate">Tanggal Masuk *</label>
                            <input type="date" id="joinDate" required>
                        </div>
                        <div class="form-group">
                            <label for="status">Status *</label>
                            <select id="status" required>
                                <option value="active">Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                                <option value="retired">Pensiun</option>
                                <option value="study">Cuti Studi</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Hak Akses Sistem</label>
                        <div class="access-controls">
                            <label class="checkbox-label">
                                <input type="checkbox" name="access" value="siswa" checked>
                                <span>Data Siswa</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="access" value="guru" checked>
                                <span>Data Guru</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="access" value="nilai">
                                <span>Input Nilai</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="access" value="absensi">
                                <span>Absensi</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="access" value="jadwal">
                                <span>Jadwal Mengajar</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="access" value="laporan">
                                <span>Laporan</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Upload Dokumen</label>
                        <div class="file-upload-area">
                            <div class="upload-placeholder">
                                <i class="fas fa-file-upload"></i>
                                <p>Upload berkas (CV, Ijazah, Sertifikat)</p>
                                <span>Format: PDF, DOC, JPG, PNG (Maks. 5MB)</span>
                            </div>
                            <input type="file" id="documentUpload" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        </div>
                        <div class="file-list" id="fileList"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal()">Batal</button>
                <button class="btn btn-primary" onclick="saveTeacher()">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </div>
    </div>

    <!-- Modal View Teacher -->
    <div id="viewModal" class="modal">
        <div class="modal-content wide-modal">
            <div class="modal-header">
                <h3>Detail Guru</h3>
                <span class="close" onclick="closeViewModal()">&times;</span>
            </div>
            <div class="modal-body">
                <div class="teacher-detail-view">
                    <div class="teacher-header">
                        <div class="teacher-photo-large">
                            <img src="https://via.placeholder.com/120" alt="Teacher Photo" id="viewPhoto">
                        </div>
                        <div class="teacher-info-large">
                            <h2 id="viewName">Budi Santoso, S.Pd</h2>
                            <p class="teacher-nip" id="viewNIP">NIP: 198003012004011001</p>
                            <div class="teacher-tags">
                                <span class="badge badge-teacher" id="viewPosition">Guru Matematika</span>
                                <span class="status-badge active" id="viewStatus">Aktif</span>
                            </div>
                        </div>
                    </div>

                    <div class="detail-tabs">
                        <div class="tab-buttons">
                            <button class="tab-btn active" onclick="showTab('personal')">Data Pribadi</button>
                            <button class="tab-btn" onclick="showTab('professional')">Data Profesional</button>
                            <button class="tab-btn" onclick="showTab('teaching')">Data Mengajar</button>
                            <button class="tab-btn" onclick="showTab('documents')">Dokumen</button>
                        </div>

                        <div class="tab-content active" id="personalTab">
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <label>NUPTK:</label>
                                    <span id="viewNUPTK">1234567890123456</span>
                                </div>
                                <div class="detail-item">
                                    <label>Tempat/Tgl Lahir:</label>
                                    <span id="viewBirth">Malang, 01 Maret 1980</span>
                                </div>
                                <div class="detail-item">
                                    <label>Jenis Kelamin:</label>
                                    <span id="viewGender">Laki-laki</span>
                                </div>
                                <div class="detail-item">
                                    <label>Agama:</label>
                                    <span id="viewReligion">Islam</span>
                                </div>
                                <div class="detail-item full-width">
                                    <label>Alamat:</label>
                                    <span id="viewAddress">Jl. Pendidikan No. 45, Kota Malang, Jawa Timur</span>
                                </div>
                                <div class="detail-item">
                                    <label>Telepon:</label>
                                    <span id="viewPhone">081234567890</span>
                                </div>
                                <div class="detail-item">
                                    <label>Email:</label>
                                    <span id="viewEmail">budi.santoso@smamishbahululum.sch.id</span>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content" id="professionalTab">
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <label>Jabatan:</label>
                                    <span id="viewJobTitle">Guru & Wali Kelas</span>
                                </div>
                                <div class="detail-item">
                                    <label>Mata Pelajaran:</label>
                                    <span id="viewSubject">Matematika</span>
                                </div>
                                <div class="detail-item">
                                    <label>Pendidikan Terakhir:</label>
                                    <span id="viewEducation">S1 Pendidikan Matematika</span>
                                </div>
                                <div class="detail-item">
                                    <label>Tanggal Masuk:</label>
                                    <span id="viewJoinDate">01 Januari 2004</span>
                                </div>
                                <div class="detail-item">
                                    <label>Status Kepegawaian:</label>
                                    <span id="viewEmployment">PNS</span>
                                </div>
                                <div class="detail-item">
                                    <label>Masa Kerja:</label>
                                    <span id="viewServiceYear">20 tahun</span>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content" id="teachingTab">
                            <div class="teaching-schedule">
                                <h4>Jadwal Mengajar</h4>
                                <div class="schedule-list">
                                    <div class="schedule-item">
                                        <span class="day">Senin</span>
                                        <span class="time">08:00 - 09:30</span>
                                        <span class="class">X MIPA 1</span>
                                        <span class="room">Ruang 201</span>
                                    </div>
                                    <div class="schedule-item">
                                        <span class="day">Selasa</span>
                                        <span class="time">10:00 - 11:30</span>
                                        <span class="class">XI IPA 2</span>
                                        <span class="room">Ruang 305</span>
                                    </div>
                                    <div class="schedule-item">
                                        <span class="day">Rabu</span>
                                        <span class="time">13:00 - 14:30</span>
                                        <span class="class">XII IPS 1</span>
                                        <span class="room">Ruang 402</span>
                                    </div>
                                </div>
                            </div>
                            <div class="class-responsibility">
                                <h4>Tanggung Jawab Kelas</h4>
                                <div class="class-list">
                                    <span class="class-badge">Wali Kelas X MIPA 1</span>
                                    <span class="class-badge">Koordinator Matematika</span>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content" id="documentsTab">
                            <div class="document-list">
                                <div class="document-item">
                                    <i class="fas fa-file-pdf"></i>
                                    <div class="document-info">
                                        <h5>CV_Budi_Santoso.pdf</h5>
                                        <span>Curriculum Vitae</span>
                                    </div>
                                    <button class="btn-icon">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                                <div class="document-item">
                                    <i class="fas fa-file-image"></i>
                                    <div class="document-info">
                                        <h5>Ijazah_S1.jpg</h5>
                                        <span>Ijazah Sarjana</span>
                                    </div>
                                    <button class="btn-icon">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                                <div class="document-item">
                                    <i class="fas fa-file-certificate"></i>
                                    <div class="document-info">
                                        <h5>Sertifikat_Pengajar.pdf</h5>
                                        <span>Sertifikat Kompetensi</span>
                                    </div>
                                    <button class="btn-icon">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeViewModal()">Tutup</button>
                <button class="btn btn-primary" onclick="editFromView()">
                    <i class="fas fa-edit"></i> Edit Data
                </button>
                <button class="btn btn-success" onclick="generateTeacherReport()">
                    <i class="fas fa-file-alt"></i> Generate Report
                </button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="../assets/js/main.js"></script>
<script src="../assets/js/admin-teachers.js"></script>
<script>
        let currentTeacherId = null;
        let isEditMode = false;

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize DataTable
            $('#teachersTable').DataTable({
                pageLength: 10,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });

            // Mobile menu
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const sidebar = document.getElementById('sidebar');

            if (mobileMenuToggle && sidebar) {
                mobileMenuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    mobileMenuToggle.innerHTML = sidebar.classList.contains('active')
                        ? '<i class="fas fa-times"></i>'
                        : '<i class="fas fa-bars"></i>';
                });
            }

            // Multiple file upload
            document.getElementById('documentUpload').addEventListener('change', function(e) {
                const files = e.target.files;
                const fileList = document.getElementById('fileList');
                fileList.innerHTML = '';

                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const fileItem = document.createElement('div');
                    fileItem.className = 'file-item';
                    fileItem.innerHTML = `
                        <i class="fas fa-file"></i>
                        <div class="file-info">
                            <span class="file-name">${file.name}</span>
                            <span class="file-size">${formatFileSize(file.size)}</span>
                        </div>
                        <button type="button" class="remove-file" onclick="removeFile(${i})">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    fileList.appendChild(fileItem);
                }
            });
        });

        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        function removeFile(index) {
            // Implement file removal logic
            alert(`File ${index} dihapus`);
        }

        function showAddModal() {
            isEditMode = false;
            currentTeacherId = null;
            document.getElementById('modalTitle').textContent = 'Tambah Guru Baru';
            document.getElementById('teacherForm').reset();
            document.getElementById('fileList').innerHTML = '';
            document.getElementById('teacherModal').style.display = 'block';
        }

        function editTeacher(id) {
            isEditMode = true;
            currentTeacherId = id;
            document.getElementById('modalTitle').textContent = 'Edit Data Guru';
            // Load teacher data into form
            loadTeacherData(id);
            document.getElementById('teacherModal').style.display = 'block';
        }

        function viewTeacher(id) {
            currentTeacherId = id;
            // Load teacher data for view
            loadViewData(id);
            document.getElementById('viewModal').style.display = 'block';
        }

        function loadTeacherData(id) {
            // Simulate loading data
            const teacherData = {
                nip: '198003012004011001',
                nuptk: '1234567890123456',
                fullName: 'Budi Santoso',
                title: 'S.Pd',
                birthPlace: 'Malang',
                birthDate: '1980-03-01',
                gender: 'L',
                religion: 'Islam',
                position: 'teacher',
                subject: 'matematika',
                education: 'S1',
                major: 'Pendidikan Matematika',
                address: 'Jl. Pendidikan No. 45, Kota Malang',
                phone: '081234567890',
                email: 'budi.santoso@smamishbahululum.sch.id',
                joinDate: '2004-01-01',
                status: 'active'
            };

            // Populate form
            Object.keys(teacherData).forEach(key => {
                const element = document.getElementById(key);
                if (element) {
                    element.value = teacherData[key];
                }
            });
        }

        function loadViewData(id) {
            // Simulate loading view data
            const viewData = {
                name: 'Budi Santoso, S.Pd',
                nip: '198003012004011001',
                nuptk: '1234567890123456',
                position: 'Guru Matematika',
                status: 'active',
                birth: 'Malang, 01 Maret 1980',
                gender: 'Laki-laki',
                religion: 'Islam',
                address: 'Jl. Pendidikan No. 45, Kota Malang, Jawa Timur',
                phone: '081234567890',
                email: 'budi.santoso@smamishbahululum.sch.id',
                jobTitle: 'Guru & Wali Kelas',
                subject: 'Matematika',
                education: 'S1 Pendidikan Matematika',
                joinDate: '01 Januari 2004',
                employment: 'PNS',
                serviceYear: '20 tahun'
            };

            // Populate view
            Object.keys(viewData).forEach(key => {
                const element = document.getElementById('view' + key.charAt(0).toUpperCase() + key.slice(1));
                if (element) {
                    element.textContent = viewData[key];
                    if (element.classList && element.classList.contains('status-badge')) {
                        element.className = 'status-badge ' + viewData[key];
                    }
                }
            });
        }

        function saveTeacher() {
            const form = document.getElementById('teacherForm');
            if (form.checkValidity()) {
                if (isEditMode) {
                    alert(`Data guru #${currentTeacherId} berhasil diperbarui!`);
                } else {
                    alert('Guru baru berhasil ditambahkan!');
                }
                closeModal();
            } else {
                alert('Harap lengkapi semua field yang wajib diisi!');
            }
        }

        function deleteTeacher(id) {
            if (confirm('Apakah Anda yakin ingin menghapus guru ini?')) {
                alert(`Guru #${id} berhasil dihapus!`);
                // Implement delete functionality
            }
        }

        function filterTable() {
            const statusFilter = document.getElementById('filterStatus').value;
            const positionFilter = document.getElementById('filterPosition').value;
            const subjectFilter = document.getElementById('filterSubject').value;
            const searchTerm = document.getElementById('searchTeacher').value.toLowerCase();

            // Implement filtering logic
            console.log(`Filtering: Status=${statusFilter}, Position=${positionFilter}, Subject=${subjectFilter}, Search=${searchTerm}`);
        }

        function resetFilters() {
            document.getElementById('filterStatus').value = 'all';
            document.getElementById('filterPosition').value = 'all';
            document.getElementById('filterSubject').value = 'all';
            document.getElementById('searchTeacher').value = '';
            filterTable();
        }

        function exportToExcel() {
            alert('Data guru berhasil diexport ke Excel!');
        }

        function printTable() {
            window.print();
        }

        function refreshTable() {
            alert('Tabel guru diperbarui!');
        }

        function assignHomeroom() {
            alert('Membuka form penugasan wali kelas...');
        }

        function generateSchedule() {
            alert('Generate jadwal mengajar...');
        }

        function exportTeacherData() {
            alert('Export data guru...');
        }

        function sendBulkEmail() {
            alert('Membuka form email massal...');
        }

        function closeModal() {
            document.getElementById('teacherModal').style.display = 'none';
        }

        function closeViewModal() {
            document.getElementById('viewModal').style.display = 'none';
        }

        function editFromView() {
            closeViewModal();
            editTeacher(currentTeacherId);
        }

        function generateTeacherReport() {
            alert('Generate report untuk guru...');
        }

        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Remove active class from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabName + 'Tab').classList.add('active');

            // Add active class to clicked button
            event.currentTarget.classList.add('active');
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
