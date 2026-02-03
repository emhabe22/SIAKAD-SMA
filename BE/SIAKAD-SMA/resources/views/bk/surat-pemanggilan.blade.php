<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pemanggilan - BK SIAKAD</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/layout.css">
    <link rel="stylesheet" href="../assets/css/components.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="user-profile">
                <img src="../assets/images/user-avatar.png" alt="Avatar BK">
                <div class="user-info">
                    <h4>Nama Konselor BK</h4>
                    <span class="role-badge">Bimbingan Konseling</span>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="dashboard.html">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="validasi.html">
                        <i class="fas fa-check-circle"></i>
                        <span>Validasi Siswa</span>
                    </a>
                </li>
                <li>
                    <a href="feedback.html">
                        <i class="fas fa-comments"></i>
                        <span>Feedback</span>
                    </a>
                </li>
                <li class="active">
                    <a href="surat-pemanggilan.html">
                        <i class="fas fa-envelope"></i>
                        <span>Surat Pemanggilan</span>
                        <span class="badge">2</span>
                    </a>
                </li>
                <li>
                    <a href="laporan.html">
                        <i class="fas fa-chart-bar"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="../login.html">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-left">
                <h1>Surat Pemanggilan</h1>
                <p class="breadcrumb">BK / Surat Pemanggilan</p>
            </div>
            <div class="header-right">
                <button class="btn btn-primary" onclick="createNewLetter()">
                    <i class="fas fa-plus"></i> Buat Surat Baru
                </button>
            </div>
        </header>

        <!-- Tabs Navigation -->
        <div class="tabs-container">
            <div class="tabs">
                <button class="tab-btn active" onclick="switchTab('draft')">
                    <i class="fas fa-edit"></i> Draft
                    <span class="tab-badge">3</span>
                </button>
                <button class="tab-btn" onclick="switchTab('sent')">
                    <i class="fas fa-paper-plane"></i> Terkirim
                    <span class="tab-badge">12</span>
                </button>
                <button class="tab-btn" onclick="switchTab('confirmed')">
                    <i class="fas fa-check-double"></i> Dikonfirmasi
                </button>
                <button class="tab-btn" onclick="switchTab('archived')">
                    <i class="fas fa-archive"></i> Arsip
                </button>
            </div>
        </div>

        <!-- Letters List -->
        <div class="card">
            <div class="card-header">
                <h3 id="tabTitle">Surat Draft</h3>
                <div class="card-actions">
                    <button class="btn-icon" onclick="exportLetters()">
                        <i class="fas fa-download"></i>
                    </button>
                    <button class="btn-icon" onclick="printLetters()">
                        <i class="fas fa-print"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="letters-container" id="draftTab">
                    <!-- Draft Letters -->
                    <div class="letter-card">
                        <div class="letter-header">
                            <div class="letter-info">
                                <h4>Pemanggilan Orang Tua - Andi Pratama</h4>
                                <div class="letter-meta">
                                    <span><i class="fas fa-user"></i> Andi Pratama (XII IPA 1)</span>
                                    <span><i class="fas fa-calendar"></i> Dibuat: 15 Jan 2024</span>
                                    <span><i class="fas fa-clock"></i> Status: <span class="status-draft">Draft</span></span>
                                </div>
                            </div>
                            <div class="letter-actions">
                                <button class="btn-icon" onclick="editLetter(1)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-icon btn-success" onclick="sendLetter(1)">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                                <button class="btn-icon btn-danger" onclick="deleteLetter(1)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="letter-content">
                            <p><strong>Perihal:</strong> Pembahasan penurunan nilai akademik dan kehadiran</p>
                            <p><strong>Kepada:</strong> Bapak/Ibu Orang Tua/Wali dari Andi Pratama</p>
                            <p><strong>Agenda:</strong> Konseling mengenai penurunan performa belajar dan rencana perbaikan</p>
                        </div>
                    </div>

                    <div class="letter-card">
                        <div class="letter-header">
                            <div class="letter-info">
                                <h4>Pemanggilan Siswa - Siti Nurhaliza</h4>
                                <div class="letter-meta">
                                    <span><i class="fas fa-user"></i> Siti Nurhaliza (XI IPS 2)</span>
                                    <span><i class="fas fa-calendar"></i> Dibuat: 14 Jan 2024</span>
                                    <span><i class="fas fa-clock"></i> Status: <span class="status-draft">Draft</span></span>
                                </div>
                            </div>
                            <div class="letter-actions">
                                <button class="btn-icon" onclick="editLetter(2)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-icon btn-success" onclick="sendLetter(2)">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                                <button class="btn-icon btn-danger" onclick="deleteLetter(2)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div class="letter-content">
                            <p><strong>Perihal:</strong> Konseling pilihan jurusan perguruan tinggi</p>
                            <p><strong>Kepada:</strong> Siti Nurhaliza dan Orang Tua/Wali</p>
                            <p><strong>Agenda:</strong> Diskusi mengenai rencana studi lanjut dan persiapan ujian</p>
                        </div>
                    </div>
                </div>

                <!-- Sent Letters (hidden by default) -->
                <div class="letters-container" id="sentTab" style="display: none;">
                    <div class="letter-card">
                        <div class="letter-header">
                            <div class="letter-info">
                                <h4>Pemanggilan - Ahmad Hidayat</h4>
                                <div class="letter-meta">
                                    <span><i class="fas fa-user"></i> Ahmad Hidayat (X MIPA 2)</span>
                                    <span><i class="fas fa-calendar"></i> Dikirim: 13 Jan 2024</span>
                                    <span><i class="fas fa-clock"></i> Status: <span class="status-sent">Terkirim</span></span>
                                </div>
                            </div>
                            <div class="letter-actions">
                                <button class="btn-icon" onclick="viewLetter(3)">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn-icon" onclick="resendLetter(3)">
                                    <i class="fas fa-redo"></i>
                                </button>
                                <button class="btn-icon" onclick="printSingleLetter(3)">
                                    <i class="fas fa-print"></i>
                                </button>
                            </div>
                        </div>
                        <div class="letter-content">
                            <p><strong>Perihal:</strong> Pembahasan masalah kedisiplinan</p>
                            <p><strong>Jadwal:</strong> Senin, 22 Januari 2024, 10:00 WIB</p>
                            <p><strong>Lokasi:</strong> Ruang BK SMA Mishbahul Ulum</p>
                        </div>
                    </div>
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

        <!-- Quick Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: #FF9800;">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="stat-info">
                    <h3>3</h3>
                    <p>Draft Surat</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #2196F3;">
                    <i class="fas fa-paper-plane"></i>
                </div>
                <div class="stat-info">
                    <h3>12</h3>
                    <p>Terkirim (Bulan Ini)</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #4CAF50;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>8</h3>
                    <p>Dikonfirmasi</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #9C27B0;">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <h3>67%</h3>
                    <p>Response Rate</p>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card">
            <div class="card-header">
                <h3><i class="fas fa-history"></i> Aktivitas Terkait Surat</h3>
            </div>
            <div class="card-body">
                <div class="activity-timeline">
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <div class="activity-content">
                            <h5>Surat dikirim ke Ahmad Hidayat</h5>
                            <p>Surat pemanggilan untuk pembahasan masalah kedisiplinan telah dikirim</p>
                            <span class="activity-time">13 Jan 2024, 14:30</span>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="activity-content">
                            <h5>Konfirmasi dari orang tua Siti</h5>
                            <p>Orang tua Siti Nurhaliza telah mengkonfirmasi kehadiran untuk konseling karir</p>
                            <span class="activity-time">12 Jan 2024, 10:15</span>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="activity-content">
                            <h5>Surat baru dibuat</h5>
                            <p>Draft surat pemanggilan untuk Andi Pratama telah dibuat</p>
                            <span class="activity-time">11 Jan 2024, 16:45</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create/Edit Letter -->
    <div id="letterModal" class="modal">
        <div class="modal-content wide-modal">
            <div class="modal-header">
                <h3 id="modalTitle">Buat Surat Pemanggilan Baru</h3>
                <span class="close" onclick="closeLetterModal()">&times;</span>
            </div>
            <div class="modal-body">
                <form id="letterForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="studentName">Nama Siswa *</label>
                            <select id="studentName" required>
                                <option value="">-- Pilih Siswa --</option>
                                <option value="1">Andi Pratama (XII IPA 1)</option>
                                <option value="2">Siti Nurhaliza (XI IPS 2)</option>
                                <option value="3">Ahmad Hidayat (X MIPA 2)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="letterType">Jenis Surat *</label>
                            <select id="letterType" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="orangtua">Pemanggilan Orang Tua</option>
                                <option value="siswa">Pemanggilan Siswa</option>
                                <option value="bersama">Pemanggilan Bersama</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="meetingDate">Tanggal Pertemuan *</label>
                            <input type="date" id="meetingDate" required>
                        </div>
                        <div class="form-group">
                            <label for="meetingTime">Waktu Pertemuan *</label>
                            <input type="time" id="meetingTime" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="location">Lokasi Pertemuan *</label>
                        <input type="text" id="location" value="Ruang BK SMA Mishbahul Ulum" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Perihal *</label>
                        <input type="text" id="subject" placeholder="Masukkan perihal surat..." required>
                    </div>

                    <div class="form-group">
                        <label for="agenda">Agenda Pertemuan *</label>
                        <textarea id="agenda" rows="3" placeholder="Jelaskan agenda pertemuan..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="details">Detail Masalah *</label>
                        <textarea id="details" rows="4" placeholder="Deskripsikan masalah yang akan dibahas..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Template Surat</label>
                        <div class="template-selector">
                            <div class="template-option" onclick="selectTemplate('standard')">
                                <i class="fas fa-file-alt"></i>
                                <span>Standar</span>
                            </div>
                            <div class="template-option" onclick="selectTemplate('formal')">
                                <i class="fas fa-file-contract"></i>
                                <span>Formal</span>
                            </div>
                            <div class="template-option" onclick="selectTemplate('urgent')">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>Penting</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Preview Surat</label>
                        <div class="letter-preview">
                            <div class="letter-header-preview">
                                <h4>SMA MISHBAHUL ULUM</h4>
                                <p>Jl. Pendidikan No. 123, Kota Malang</p>
                                <p>Telp: (0341) 123456 | Email: sma@mishbahululum.sch.id</p>
                            </div>
                            <div class="letter-body-preview">
                                <p id="previewDate">Malang, 15 Januari 2024</p>
                                <p id="previewPerihal"><strong>Perihal:</strong> Pemanggilan Orang Tua/Wali</p>
                                <p id="previewKepada"><strong>Kepada Yth:</strong> Orang Tua/Wali dari [Nama Siswa]</p>
                                <div id="previewContent">
                                    <p>Dengan hormat,</p>
                                    <p>Melalui surat ini, kami mengundang Bapak/Ibu untuk hadir pada:</p>
                                    <p><strong>Hari/Tanggal:</strong> [Tanggal]</p>
                                    <p><strong>Waktu:</strong> [Waktu]</p>
                                    <p><strong>Tempat:</strong> [Lokasi]</p>
                                    <p><strong>Agenda:</strong> [Agenda]</p>
                                    <p>Demikian surat ini kami sampaikan, atas perhatian dan kehadirannya kami ucapkan terima kasih.</p>
                                </div>
                                <div class="letter-footer-preview">
                                    <p>Hormat kami,</p>
                                    <p><strong>Konselor BK</strong></p>
                                    <p>SMA Mishbahul Ulum</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeLetterModal()">Batal</button>
                <button class="btn btn-primary" onclick="saveAsDraft()">
                    <i class="fas fa-save"></i> Simpan Draft
                </button>
                <button class="btn btn-success" onclick="sendLetterNow()">
                    <i class="fas fa-paper-plane"></i> Kirim Sekarang
                </button>
            </div>
        </div>
    </div>

    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/letters.js"></script>
    <script>
        let currentTab = 'draft';
        let currentLetterId = null;

        function switchTab(tabName) {
            currentTab = tabName;
            
            // Update active tab button
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.currentTarget.classList.add('active');
            
            // Show/hide tab content
            document.getElementById('draftTab').style.display = 'none';
            document.getElementById('sentTab').style.display = 'none';
            
            document.getElementById(tabName + 'Tab').style.display = 'block';
            
            // Update title
            const titles = {
                'draft': 'Surat Draft',
                'sent': 'Surat Terkirim',
                'confirmed': 'Surat Dikonfirmasi',
                'archived': 'Surat Arsip'
            };
            document.getElementById('tabTitle').textContent = titles[tabName];
        }

        function createNewLetter() {
            currentLetterId = null;
            document.getElementById('modalTitle').textContent = 'Buat Surat Pemanggilan Baru';
            document.getElementById('letterForm').reset();
            updatePreview();
            document.getElementById('letterModal').style.display = 'block';
        }

        function editLetter(id) {
            currentLetterId = id;
            document.getElementById('modalTitle').textContent = 'Edit Surat Pemanggilan';
            // Load letter data here
            document.getElementById('letterModal').style.display = 'block';
        }

        function viewLetter(id) {
            alert(`Melihat surat #${id}`);
            // Implement view functionality
        }

        function sendLetter(id) {
            if (confirm('Kirim surat ini?')) {
                alert(`Surat #${id} telah dikirim!`);
                // Implement send functionality
            }
        }

        function resendLetter(id) {
            if (confirm('Kirim ulang surat ini?')) {
                alert(`Surat #${id} telah dikirim ulang!`);
                // Implement resend functionality
            }
        }

        function deleteLetter(id) {
            if (confirm('Hapus surat ini?')) {
                alert(`Surat #${id} telah dihapus!`);
                // Implement delete functionality
            }
        }

        function closeLetterModal() {
            document.getElementById('letterModal').style.display = 'none';
        }

        function selectTemplate(template) {
            const options = document.querySelectorAll('.template-option');
            options.forEach(opt => opt.classList.remove('selected'));
            event.currentTarget.classList.add('selected');
            
            // Update preview based on template
            updatePreview();
        }

        function updatePreview() {
            const date = new Date().toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            document.getElementById('previewDate').textContent = `Malang, ${date}`;
            
            // Update other preview fields as form fields change
            const formFields = ['studentName', 'subject', 'agenda', 'meetingDate', 'meetingTime', 'location'];
            formFields.forEach(field => {
                const input = document.getElementById(field);
                if (input) {
                    input.addEventListener('input', updatePreview);
                }
            });
        }

        function saveAsDraft() {
            if (document.getElementById('letterForm').checkValidity()) {
                alert('Surat berhasil disimpan sebagai draft!');
                closeLetterModal();
            } else {
                alert('Harap lengkapi semua field yang wajib diisi!');
            }
        }

        function sendLetterNow() {
            if (document.getElementById('letterForm').checkValidity()) {
                if (confirm('Kirim surat sekarang?')) {
                    alert('Surat berhasil dikirim!');
                    closeLetterModal();
                }
            } else {
                alert('Harap lengkapi semua field yang wajib diisi!');
            }
        }

        function exportLetters() {
            alert('Fitur export surat akan segera tersedia!');
        }

        function printLetters() {
            window.print();
        }

        function printSingleLetter(id) {
            alert(`Mencetak surat #${id}`);
            // Implement print single letter
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Set today's date as default for meeting date
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('meetingDate').value = today;
            
            // Update preview on form changes
            updatePreview();
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target === document.getElementById('letterModal')) {
                closeLetterModal();
            }
        };
    </script>
    <script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        
        if (mobileMenuToggle && sidebar) {
            mobileMenuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                mobileMenuToggle.innerHTML = sidebar.classList.contains('active') 
                    ? '<i class="fas fa-times"></i>' 
                    : '<i class="fas fa-bars"></i>';
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 1024) {
                    if (!sidebar.contains(event.target) && 
                        !mobileMenuToggle.contains(event.target) && 
                        sidebar.classList.contains('active')) {
                        sidebar.classList.remove('active');
                        mobileMenuToggle.innerHTML = '<i class="fas fa-bars"></i>';
                    }
                }
            });
        }
        
        // Update active link in sidebar
        const currentPage = window.location.pathname.split('/').pop();
        const navLinks = document.querySelectorAll('.sidebar-nav a');
        navLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (href === currentPage || 
                (href === 'dashboard.html' && currentPage === '') ||
                (href.includes(currentPage) && currentPage !== '')) {
                link.classList.add('active');
            }
        });
    });
</script>
</body>
</html>