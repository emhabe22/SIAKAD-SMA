<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback BK - SIAKAD SMA Mishbahul Ulum</title>
    <link rel="stylesheet" href="../../assets/css/main.css">
    <link rel="stylesheet" href="../../assets/css/layout.css">
    <link rel="stylesheet" href="../../assets/css/components.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Styles khusus untuk halaman feedback */
        .feedback-container {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .feedback-controls {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .controls-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            align-items: end;
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

        .control-select, .control-input {
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            background: white;
        }

        .feedback-tabs {
            display: flex;
            gap: 8px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .feedback-tab {
            padding: 10px 20px;
            background: #f8f9fa;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .feedback-tab.active {
            background: #2196F3;
            color: white;
        }

        .feedback-tab:hover:not(.active) {
            background: #e9ecef;
        }

        /* Feedback cards */
        .feedback-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
        }

        .feedback-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .feedback-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .feedback-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .student-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .student-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .student-details h4 {
            margin: 0;
            color: #333;
        }

        .student-details p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 14px;
        }

        .feedback-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-unread {
            background: #FF9800;
            color: white;
        }

        .status-read {
            background: #4CAF50;
            color: white;
        }

        .status-urgent {
            background: #F44336;
            color: white;
        }

        .feedback-content {
            margin-bottom: 15px;
        }

        .feedback-content h5 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 16px;
        }

        .feedback-content p {
            margin: 0;
            color: #555;
            line-height: 1.5;
        }

        .feedback-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #777;
        }

        .feedback-date {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .feedback-actions {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
        }

        .btn-action.reply {
            background: #4CAF50;
            color: white;
        }

        .btn-action.reply:hover {
            background: #388E3C;
        }

        .btn-action.view {
            background: #2196F3;
            color: white;
        }

        .btn-action.view:hover {
            background: #1976D2;
        }

        .btn-action.archive {
            background: #9E9E9E;
            color: white;
        }

        .btn-action.archive:hover {
            background: #757575;
        }

        /* Feedback form */
        .feedback-form-container {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .feedback-form-container h3 {
            margin: 0 0 20px 0;
            color: #333;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }

        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            resize: vertical;
            min-height: 100px;
        }

        .form-group textarea:focus {
            outline: none;
            border-color: #2196F3;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.1);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .empty-state-icon {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            margin: 0 0 10px 0;
            color: #666;
        }

        .empty-state p {
            color: #999;
            margin-bottom: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .controls-grid {
                grid-template-columns: 1fr;
            }

            .feedback-tabs {
                overflow-x: auto;
                flex-wrap: nowrap;
            }

            .feedback-cards {
                grid-template-columns: 1fr;
            }

            .feedback-header {
                flex-direction: column;
                gap: 10px;
                align-items: stretch;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="user-profile">
                <img src="../../assets/images/user-avatar.png" alt="Avatar BK">
                <div class="user-info">
                    <h4>Nama Konselor BK</h4>
                    <span class="role-badge">Bimbingan Konseling</span>
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <ul>
                <li>
                    <a href="../dashboard.html">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="../validasi.html">
                        <i class="fas fa-check-circle"></i>
                        <span>Validasi Siswa</span>
                    </a>
                </li>
                <li class="active">
                    <a href="../feedback.html">
                        <i class="fas fa-comments"></i>
                        <span>Feedback</span>
                        <span class="badge">5</span>
                    </a>
                </li>
                <li>
                    <a href="../surat-pemanggilan.html">
                        <i class="fas fa-envelope"></i>
                        <span>Surat Pemanggilan</span>
                    </a>
                </li>
                <li>
                    <a href="../laporan.html">
                        <i class="fas fa-chart-bar"></i>
                        <span>Laporan</span>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="../../login.html">
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
                <h1>Feedback Bimbingan Konseling</h1>
                <p class="breadcrumb">BK / Feedback</p>
            </div>
            <div class="header-right">
                <div class="notifications">
                    <i class="fas fa-bell"></i>
                    <span class="notification-count">5</span>
                </div>
                <div class="date-display">
                    <span id="current-date">Senin, 15 Januari 2024</span>
                </div>
            </div>
        </header>

        <!-- Feedback Controls -->
        <div class="feedback-controls">
            <div class="controls-grid">
                <div class="control-group">
                    <label>Filter Status</label>
                    <select class="control-select" id="statusFilter">
                        <option value="all">Semua Status</option>
                        <option value="unread">Belum Dibaca</option>
                        <option value="read">Sudah Dibaca</option>
                        <option value="urgent">Urgent</option>
                        <option value="archived">Diarsipkan</option>
                    </select>
                </div>
                <div class="control-group">
                    <label>Dari Tanggal</label>
                    <input type="date" class="control-input" id="startDate" value="2024-01-01">
                </div>
                <div class="control-group">
                    <label>Sampai Tanggal</label>
                    <input type="date" class="control-input" id="endDate" value="2024-01-15">
                </div>
                <div class="control-group">
                    <label>Pencarian</label>
                    <input type="text" class="control-input" id="searchInput" placeholder="Cari nama siswa atau topik...">
                </div>
            </div>

            <div class="feedback-tabs">
                <button class="feedback-tab active" data-type="all">
                    <i class="fas fa-inbox"></i> Semua Feedback
                </button>
                <button class="feedback-tab" data-type="from-students">
                    <i class="fas fa-user-graduate"></i> Dari Siswa
                </button>
                <button class="feedback-tab" data-type="from-parents">
                    <i class="fas fa-users"></i> Dari Orang Tua
                </button>
                <button class="feedback-tab" data-type="from-teachers">
                    <i class="fas fa-chalkboard-teacher"></i> Dari Guru
                </button>
                <button class="feedback-tab" data-type="my-replies">
                    <i class="fas fa-reply"></i> Balasan Saya
                </button>
            </div>
        </div>

        <!-- Feedback Cards -->
        <div class="feedback-cards" id="feedbackCards">
            <!-- Data akan diisi oleh JavaScript -->
        </div>

        <!-- Empty State -->
        <div id="emptyState" class="empty-state" style="display: none;">
            <div class="empty-state-icon">
                <i class="fas fa-comments"></i>
            </div>
            <h3>Tidak ada feedback</h3>
            <p>Tidak ada feedback untuk filter yang dipilih.</p>
            <button class="btn btn-primary" onclick="resetFilters()">
                <i class="fas fa-redo"></i> Reset Filter
            </button>
        </div>

        <!-- New Feedback Form -->
        <div class="feedback-form-container" id="feedbackForm" style="display: none;">
            <h3><i class="fas fa-comment-medical"></i> Beri Feedback Baru</h3>
            <form id="newFeedbackForm">
                <div class="form-group">
                    <label for="feedbackTo">Kepada</label>
                    <select class="control-select" id="feedbackTo" required>
                        <option value="">Pilih siswa/guru/orang tua</option>
                        <option value="student">Siswa - Andi Pratama (XII IPA 1)</option>
                        <option value="teacher">Guru - Bu Ani (Matematika)</option>
                        <option value="parent">Orang Tua - Bapak Budi</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="feedbackSubject">Subjek</label>
                    <input type="text" class="control-input" id="feedbackSubject" placeholder="Masukkan subjek feedback" required>
                </div>
                <div class="form-group">
                    <label for="feedbackMessage">Pesan</label>
                    <textarea id="feedbackMessage" placeholder="Tulis pesan feedback di sini..." required></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" onclick="cancelFeedback()">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Kirim Feedback
                    </button>
                </div>
            </form>
        </div>

        <!-- New Feedback Button -->
        <div style="text-align: center; margin-top: 30px;">
            <button class="btn btn-primary btn-lg" onclick="showFeedbackForm()">
                <i class="fas fa-plus"></i> Beri Feedback Baru
            </button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../../assets/js/main.js"></script>
    <script>
        class BKFeedback {
            constructor() {
                this.feedbackData = [];
                this.currentFilter = 'all';
                this.init();
            }

            init() {
                this.updateDate();
                this.loadFeedbackData();
                this.setupEventListeners();
            }

            updateDate() {
                const now = new Date();
                const options = { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                };
                document.getElementById('current-date').textContent = 
                    now.toLocaleDateString('id-ID', options);
                
                // Set today as end date
                const today = now.toISOString().split('T')[0];
                document.getElementById('endDate').value = today;
            }

            loadFeedbackData() {
                this.feedbackData = this.getMockFeedbackData();
                this.renderFeedbackCards();
            }

            getMockFeedbackData() {
                return [
                    {
                        id: 'FB-001',
                        student: 'Andi Pratama',
                        class: 'XII IPA 1',
                        type: 'from-student',
                        subject: 'Terima kasih atas bimbingannya',
                        message: 'Terima kasih atas bimbingan bapak/ibu. Saya sudah bisa mengatasi masalah belajar saya dan nilai semakin membaik.',
                        date: '15 Jan 2024 09:30',
                        status: 'read',
                        avatar: 'https://via.placeholder.com/50'
                    },
                    {
                        id: 'FB-002',
                        student: 'Siti Nurhaliza',
                        class: 'XI IPS 2',
                        type: 'from-parent',
                        subject: 'Feedback konseling karir',
                        message: 'Anak saya sangat terbantu dengan sesi konseling karir kemarin. Sekarang dia lebih fokus pada tujuan masa depannya.',
                        date: '14 Jan 2024 14:15',
                        status: 'unread',
                        avatar: 'https://via.placeholder.com/50'
                    },
                    {
                        id: 'FB-003',
                        student: 'Rizki Ramadhan',
                        class: 'X MIPA',
                        type: 'from-student',
                        subject: 'Permintaan follow up',
                        message: 'Saya ingin melanjutkan konseling untuk masalah sosial yang belum tuntas. Kapan kita bisa bertemu lagi?',
                        date: '13 Jan 2024 10:45',
                        status: 'urgent',
                        avatar: 'https://via.placeholder.com/50'
                    },
                    {
                        id: 'FB-004',
                        student: 'Bu Ani, S.Pd',
                        class: 'Guru Matematika',
                        type: 'from-teacher',
                        subject: 'Rujukan siswa',
                        message: 'Saya ingin merujuk siswa bernama Ahmad dari kelas X MIPA 2 yang mengalami penurunan nilai drastis.',
                        date: '12 Jan 2024 16:20',
                        status: 'read',
                        avatar: 'https://via.placeholder.com/50'
                    },
                    {
                        id: 'FB-005',
                        student: 'Dewi Sartika',
                        class: 'XI IPS 3',
                        type: 'from-student',
                        subject: 'Kemajuan setelah konseling',
                        message: 'Setelah konseling, saya bisa mengatur waktu belajar dengan lebih baik. Terima kasih banyak!',
                        date: '11 Jan 2024 08:30',
                        status: 'read',
                        avatar: 'https://via.placeholder.com/50'
                    }
                ];
            }

            renderFeedbackCards() {
                const container = document.getElementById('feedbackCards');
                const filteredData = this.filterFeedbackData();
                
                container.innerHTML = '';
                
                if (filteredData.length === 0) {
                    document.getElementById('emptyState').style.display = 'block';
                    return;
                }
                
                document.getElementById('emptyState').style.display = 'none';
                
                filteredData.forEach(feedback => {
                    const card = document.createElement('div');
                    card.className = 'feedback-card';
                    card.innerHTML = `
                        <div class="feedback-header">
                            <div class="student-info">
                                <div class="student-avatar">
                                    <img src="${feedback.avatar}" alt="${feedback.student}">
                                </div>
                                <div class="student-details">
                                    <h4>${feedback.student}</h4>
                                    <p>${feedback.class}</p>
                                </div>
                            </div>
                            <span class="feedback-status status-${feedback.status}">
                                ${this.getStatusText(feedback.status)}
                            </span>
                        </div>
                        
                        <div class="feedback-content">
                            <h5>${feedback.subject}</h5>
                            <p>${feedback.message}</p>
                        </div>
                        
                        <div class="feedback-meta">
                            <div class="feedback-date">
                                <i class="far fa-clock"></i>
                                <span>${feedback.date}</span>
                            </div>
                            <div class="feedback-actions">
                                <button class="btn-action reply" onclick="bkFeedback.replyFeedback('${feedback.id}')">
                                    <i class="fas fa-reply"></i> Balas
                                </button>
                                <button class="btn-action view" onclick="bkFeedback.viewFeedback('${feedback.id}')">
                                    <i class="fas fa-eye"></i> Lihat
                                </button>
                                <button class="btn-action archive" onclick="bkFeedback.archiveFeedback('${feedback.id}')">
                                    <i class="fas fa-archive"></i> Arsip
                                </button>
                            </div>
                        </div>
                    `;
                    container.appendChild(card);
                });
            }

            filterFeedbackData() {
                let filtered = [...this.feedbackData];
                
                // Filter by type tab
                if (this.currentFilter !== 'all') {
                    filtered = filtered.filter(item => item.type === this.currentFilter);
                }
                
                // Filter by status
                const statusFilter = document.getElementById('statusFilter').value;
                if (statusFilter !== 'all') {
                    filtered = filtered.filter(item => item.status === statusFilter);
                }
                
                // Filter by search
                const searchTerm = document.getElementById('searchInput').value.toLowerCase();
                if (searchTerm) {
                    filtered = filtered.filter(item => 
                        item.student.toLowerCase().includes(searchTerm) ||
                        item.subject.toLowerCase().includes(searchTerm) ||
                        item.message.toLowerCase().includes(searchTerm)
                    );
                }
                
                // Filter by date range
                const startDate = new Date(document.getElementById('startDate').value);
                const endDate = new Date(document.getElementById('endDate').value);
                endDate.setHours(23, 59, 59, 999); // End of day
                
                filtered = filtered.filter(item => {
                    const itemDate = new Date(this.parseDateString(item.date));
                    return itemDate >= startDate && itemDate <= endDate;
                });
                
                return filtered;
            }

            parseDateString(dateString) {
                // Simple date parser for mock data
                const parts = dateString.split(' ');
                return parts[0] + ' ' + parts[1] + ' 2024 ' + parts[2];
            }

            getStatusText(status) {
                const statusMap = {
                    'unread': 'Belum Dibaca',
                    'read': 'Sudah Dibaca',
                    'urgent': 'Urgent',
                    'archived': 'Diarsipkan'
                };
                return statusMap[status] || status;
            }

            setupEventListeners() {
                // Feedback tabs
                document.querySelectorAll('.feedback-tab').forEach(tab => {
                    tab.addEventListener('click', () => {
                        const type = tab.dataset.type;
                        this.currentFilter = type;
                        
                        // Update active tab
                        document.querySelectorAll('.feedback-tab').forEach(t => {
                            t.classList.remove('active');
                        });
                        tab.classList.add('active');
                        
                        this.renderFeedbackCards();
                    });
                });

                // Filter controls
                document.getElementById('statusFilter').addEventListener('change', () => {
                    this.renderFeedbackCards();
                });

                document.getElementById('startDate').addEventListener('change', () => {
                    this.renderFeedbackCards();
                });

                document.getElementById('endDate').addEventListener('change', () => {
                    this.renderFeedbackCards();
                });

                document.getElementById('searchInput').addEventListener('input', () => {
                    this.renderFeedbackCards();
                });

                // New feedback form
                document.getElementById('newFeedbackForm').addEventListener('submit', (e) => {
                    e.preventDefault();
                    this.submitFeedback();
                });
            }

            replyFeedback(feedbackId) {
                const feedback = this.feedbackData.find(f => f.id === feedbackId);
                if (feedback) {
                    alert(`Membalas feedback dari ${feedback.student}`);
                    // In real app, open reply form
                }
            }

            viewFeedback(feedbackId) {
                const feedback = this.feedbackData.find(f => f.id === feedbackId);
                if (feedback) {
                    alert(`Melihat detail feedback dari ${feedback.student}\n\nSubjek: ${feedback.subject}\nPesan: ${feedback.message}`);
                    // Mark as read
                    if (feedback.status === 'unread') {
                        feedback.status = 'read';
                        this.renderFeedbackCards();
                    }
                }
            }

            archiveFeedback(feedbackId) {
                if (confirm('Apakah Anda yakin ingin mengarsipkan feedback ini?')) {
                    const feedback = this.feedbackData.find(f => f.id === feedbackId);
                    if (feedback) {
                        feedback.status = 'archived';
                        this.renderFeedbackCards();
                        alert('Feedback telah diarsipkan');
                    }
                }
            }

            submitFeedback() {
                const to = document.getElementById('feedbackTo').value;
                const subject = document.getElementById('feedbackSubject').value;
                const message = document.getElementById('feedbackMessage').value;
                
                if (!to || !subject || !message) {
                    alert('Harap lengkapi semua field');
                    return;
                }
                
                // Add new feedback to data
                const newFeedback = {
                    id: 'FB-' + (this.feedbackData.length + 1).toString().padStart(3, '0'),
                    student: this.getRecipientName(to),
                    class: this.getRecipientClass(to),
                    type: 'my-replies',
                    subject: subject,
                    message: message,
                    date: new Date().toLocaleDateString('id-ID', { 
                        day: '2-digit', 
                        month: 'short', 
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    }),
                    status: 'read',
                    avatar: '../../assets/images/user-avatar.png'
                };
                
                this.feedbackData.unshift(newFeedback);
                this.renderFeedbackCards();
                
                // Reset form
                document.getElementById('newFeedbackForm').reset();
                document.getElementById('feedbackForm').style.display = 'none';
                
                alert('Feedback berhasil dikirim!');
            }

            getRecipientName(to) {
                switch(to) {
                    case 'student': return 'Andi Pratama';
                    case 'teacher': return 'Bu Ani';
                    case 'parent': return 'Bapak Budi';
                    default: return 'Unknown';
                }
            }

            getRecipientClass(to) {
                switch(to) {
                    case 'student': return 'XII IPA 1';
                    case 'teacher': return 'Guru Matematika';
                    case 'parent': return 'Orang Tua';
                    default: return '';
                }
            }
        }

        // Global functions
        function showFeedbackForm() {
            document.getElementById('feedbackForm').style.display = 'block';
            document.getElementById('feedbackForm').scrollIntoView({ behavior: 'smooth' });
        }

        function cancelFeedback() {
            document.getElementById('newFeedbackForm').reset();
            document.getElementById('feedbackForm').style.display = 'none';
        }

        function resetFilters() {
            document.getElementById('statusFilter').value = 'all';
            document.getElementById('startDate').value = '2024-01-01';
            document.getElementById('endDate').value = new Date().toISOString().split('T')[0];
            document.getElementById('searchInput').value = '';
            
            // Reset tabs
            document.querySelectorAll('.feedback-tab').forEach(tab => {
                tab.classList.remove('active');
                if (tab.dataset.type === 'all') {
                    tab.classList.add('active');
                }
            });
            
            bkFeedback.currentFilter = 'all';
            bkFeedback.renderFeedbackCards();
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', () => {
            window.bkFeedback = new BKFeedback();
        });
    </script>
</body>
</html>