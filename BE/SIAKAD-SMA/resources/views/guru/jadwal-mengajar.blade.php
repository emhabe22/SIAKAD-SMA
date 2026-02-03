@extends('layouts.app')

@section('title', 'Jadwal Mengajar - SIAKAD SMA Mishbahul Ulum')
@section('page-title', 'Jadwal Mengajar')
@section('breadcrumb', 'Guru / Jadwal Mengajar')

@php
    $role = 'guru';
    $userName = 'Budi Santoso, S.Pd';
    $userRole = 'Guru Matematika';
@endphp

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.css">
<style>
        /* Styles khusus untuk halaman jadwal mengajar */
        .teaching-schedule-container {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .schedule-controls {
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

        .view-tabs {
            display: flex;
            gap: 8px;
            margin-top: 20px;
        }

        .view-tab {
            padding: 10px 20px;
            background: #f8f9fa;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .view-tab.active {
            background: #2196F3;
            color: white;
        }

        .view-tab:hover:not(.active) {
            background: #e9ecef;
        }

        /* Calendar view */
        .calendar-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .calendar-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .calendar-header h3 {
            margin: 0;
            color: #333;
        }

        .calendar-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .calendar-action-btn {
            padding: 8px 16px;
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .calendar-action-btn:hover {
            background: #e9ecef;
        }

        #calendar {
            padding: 20px;
            min-height: 600px;
        }

        /* List view */
        .list-view-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .list-view-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
        }

        .list-view-header h3 {
            margin: 0;
            color: #333;
        }

        .schedule-table-container {
            overflow-x: auto;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
        }

        .schedule-table th {
            background: #f8f9fa;
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: #555;
            border-bottom: 2px solid #eee;
        }

        .schedule-table td {
            padding: 16px;
            border-bottom: 1px solid #eee;
        }

        .schedule-table tbody tr:hover {
            background: #f8f9fa;
        }

        .day-header {
            background: #2196F3;
            color: white;
            padding: 12px 20px;
            font-weight: 600;
            border-radius: 6px;
            margin: 20px 0 10px 0;
        }

        .class-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .class-item:hover {
            border-color: #2196F3;
            box-shadow: 0 4px 12px rgba(33, 150, 243, 0.1);
        }

        .class-info h4 {
            margin: 0 0 8px 0;
            color: #333;
        }

        .class-meta {
            display: flex;
            gap: 15px;
            color: #666;
            font-size: 14px;
        }

        .class-meta span {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .class-actions {
            display: flex;
            gap: 10px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-ongoing {
            background: #4CAF50;
            color: white;
        }

        .status-upcoming {
            background: #2196F3;
            color: white;
        }

        .status-completed {
            background: #9E9E9E;
            color: white;
        }

        .status-cancelled {
            background: #F44336;
            color: white;
        }

        /* Export options */
        .export-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-export {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.3s;
        }

        .btn-export:hover {
            background: #218838;
        }

        .btn-export.print {
            background: #007bff;
        }

        .btn-export.print:hover {
            background: #0056b3;
        }

        /* Stats cards */
        .schedule-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card-schedule {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-card-schedule h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 18px;
        }

        .stat-value-schedule {
            font-size: 32px;
            font-weight: bold;
            color: #2196F3;
            display: block;
            margin-bottom: 5px;
        }

        .stat-label-schedule {
            font-size: 14px;
            color: #666;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .controls-grid {
                grid-template-columns: 1fr;
            }

            .view-tabs {
                overflow-x: auto;
                flex-wrap: nowrap;
            }

            .view-tab {
                white-space: nowrap;
            }

            .calendar-actions {
                flex-direction: column;
                width: 100%;
            }

            .calendar-action-btn {
                width: 100%;
                justify-content: center;
            }

            .export-actions {
                flex-direction: column;
            }

            .btn-export {
                justify-content: center;
            }

            .class-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .class-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }

        /* Custom calendar event styles */
        .fc-event {
            border-radius: 6px;
            padding: 2px 4px;
            font-size: 12px;
        }

        .fc-daygrid-event {
            margin: 1px 2px;
        }

        .event-class {
            background: #2196F3;
            border-color: #2196F3;
        }

        .event-meeting {
            background: #FF9800;
            border-color: #FF9800;
        }

        .event-exam {
            background: #9C27B0;
            border-color: #9C27B0;
        }

        .event-holiday {
            background: #4CAF50;
            border-color: #4CAF50;
        }
    </style>
@endpush

@section('content')
        <div class="schedule-stats">
            <div class="stat-card-schedule">
                <h3>Jam Mengajar/Minggu</h3>
                <span class="stat-value-schedule">18</span>
                <span class="stat-label-schedule">Jam efektif</span>
            </div>
            <div class="stat-card-schedule">
                <h3>Total Kelas</h3>
                <span class="stat-value-schedule">8</span>
                <span class="stat-label-schedule">Kelas berbeda</span>
            </div>
            <div class="stat-card-schedule">
                <h3>Sesi Hari Ini</h3>
                <span class="stat-value-schedule">3</span>
                <span class="stat-label-schedule">Mengajar aktif</span>
            </div>
            <div class="stat-card-schedule">
                <h3>Kehadiran</h3>
                <span class="stat-value-schedule">94%</span>
                <span class="stat-label-schedule">Rate kehadiran</span>
            </div>
        </div>

        <!-- Schedule Controls -->
        <div class="schedule-controls">
            <div class="controls-grid">
                <div class="control-group">
                    <label>Periode</label>
                    <select class="control-select" id="periodSelect">
                        <option value="week">Minggu Ini</option>
                        <option value="month" selected>Bulan Ini</option>
                        <option value="semester">Semester Ini</option>
                        <option value="custom">Custom</option>
                    </select>
                </div>
                <div class="control-group">
                    <label>Bulan</label>
                    <select class="control-select" id="monthSelect">
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
                    <select class="control-select" id="yearSelect">
                        <option value="2023">2023</option>
                        <option value="2024" selected>2024</option>
                    </select>
                </div>
                <div class="control-group">
                    <label>Kelas</label>
                    <select class="control-select" id="classSelect">
                        <option value="all">Semua Kelas</option>
                        <option value="X MIPA 1">X MIPA 1</option>
                        <option value="X MIPA 2">X MIPA 2</option>
                        <option value="XI IPA 1">XI IPA 1</option>
                        <option value="XI IPA 2">XI IPA 2</option>
                        <option value="XII IPA 1">XII IPA 1</option>
                        <option value="XII IPA 2">XII IPA 2</option>
                        <option value="XII IPS 1">XII IPS 1</option>
                    </select>
                </div>
            </div>

            <div class="view-tabs">
                <button class="view-tab active" data-view="calendar">
                    <i class="fas fa-calendar"></i> Kalender
                </button>
                <button class="view-tab" data-view="list">
                    <i class="fas fa-list"></i> Daftar
                </button>
                <button class="view-tab" data-view="daily">
                    <i class="fas fa-calendar-day"></i> Harian
                </button>
                <button class="view-tab" data-view="weekly">
                    <i class="fas fa-calendar-week"></i> Mingguan
                </button>
            </div>
        </div>

        <!-- Calendar View -->
        <div id="calendarView" class="calendar-container">
            <div class="calendar-header">
                <h3><i class="fas fa-calendar-alt"></i> Kalender Jadwal Mengajar</h3>
                <div class="calendar-actions">
                    <button class="calendar-action-btn" id="todayBtn">
                        <i class="fas fa-home"></i> Hari Ini
                    </button>
                    <button class="calendar-action-btn" id="prevBtn">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span id="currentMonthYear">Januari 2024</span>
                    <button class="calendar-action-btn" id="nextBtn">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <button class="calendar-action-btn" id="addScheduleBtn">
                        <i class="fas fa-plus"></i> Tambah Jadwal
                    </button>
                </div>
            </div>
            <div id="calendar"></div>
        </div>

        <!-- List View -->
        <div id="listView" class="list-view-container" style="display: none;">
            <div class="list-view-header">
                <h3><i class="fas fa-list"></i> Daftar Jadwal Mengajar</h3>
            </div>
            <div class="schedule-table-container">
                <table class="schedule-table">
                    <thead>
                        <tr>
                            <th>Hari/Tanggal</th>
                            <th>Waktu</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Ruang</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="scheduleList">
                        <!-- Data akan diisi oleh JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Daily View -->
        <div id="dailyView" class="list-view-container" style="display: none;">
            <div class="list-view-header">
                <h3><i class="fas fa-calendar-day"></i> Jadwal Harian</h3>
                <div class="daily-nav">
                    <button class="calendar-action-btn" id="prevDay">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span id="currentDay">Senin, 15 Januari 2024</span>
                    <button class="calendar-action-btn" id="nextDay">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            <div id="dailySchedule">
                <!-- Data akan diisi oleh JavaScript -->
            </div>
        </div>

        <!-- Weekly View -->
        <div id="weeklyView" class="list-view-container" style="display: none;">
            <div class="list-view-header">
                <h3><i class="fas fa-calendar-week"></i> Jadwal Mingguan</h3>
                <div class="weekly-nav">
                    <button class="calendar-action-btn" id="prevWeek">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span id="currentWeek">Minggu 2, 15-21 Januari 2024</span>
                    <button class="calendar-action-btn" id="nextWeek">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            <div id="weeklySchedule">
                <!-- Data akan diisi oleh JavaScript -->
            </div>
        </div>

        <!-- Export Options -->
        <div class="export-actions">
            <button class="btn-export print" onclick="printSchedule()">
                <i class="fas fa-print"></i> Cetak Jadwal
            </button>
            <button class="btn-export" onclick="exportToPDF()">
                <i class="fas fa-file-pdf"></i> Export PDF
            </button>
            <button class="btn-export" onclick="exportToExcel()">
                <i class="fas fa-file-excel"></i> Export Excel
            </button>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.3/main.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/id.min.js"></script>
<script>
        // Set locale to Indonesian
        moment.locale('id');

        class TeachingSchedule {
            constructor() {
                this.calendar = null;
                this.currentView = 'calendar';
                this.init();
            }

            init() {
                this.updateDateTime();
                setInterval(() => this.updateDateTime(), 60000);
                this.initCalendar();
                this.loadScheduleData();
                this.setupEventListeners();
                this.setupNavigation();
            }

            updateDateTime() {
                const now = new Date();
                
                // Update date
                const dateOptions = { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                };
                document.getElementById('current-date').textContent = 
                    now.toLocaleDateString('id-ID', dateOptions);
                
                // Update time
                const timeOptions = { 
                    hour: '2-digit', 
                    minute: '2-digit',
                    hour12: false 
                };
                document.getElementById('current-time').textContent = 
                    now.toLocaleTimeString('id-ID', timeOptions);
            }

            initCalendar() {
                const calendarEl = document.getElementById('calendar');
                this.calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: false,
                    height: 'auto',
                    locale: 'id',
                    firstDay: 1, // Monday
                    eventDisplay: 'block',
                    events: this.getScheduleEvents(),
                    eventContent: this.renderEventContent,
                    eventClick: this.handleEventClick.bind(this),
                    datesSet: this.handleDatesSet.bind(this)
                });
                
                this.calendar.render();
            }

            getScheduleEvents() {
                // Mock data - in real app this would come from API
                return [
                    {
                        title: 'Matematika - X MIPA 1',
                        start: '2024-01-16T08:00:00',
                        end: '2024-01-16T09:30:00',
                        className: 'event-class',
                        extendedProps: {
                            class: 'X MIPA 1',
                            room: 'Ruang 201',
                            topic: 'Trigonometri',
                            type: 'teaching'
                        }
                    },
                    {
                        title: 'Matematika - XI IPA 2',
                        start: '2024-01-16T10:00:00',
                        end: '2024-01-16T11:30:00',
                        className: 'event-class',
                        extendedProps: {
                            class: 'XI IPA 2',
                            room: 'Ruang 305',
                            topic: 'Integral',
                            type: 'teaching'
                        }
                    },
                    {
                        title: 'Rapat Guru Matematika',
                        start: '2024-01-17T13:00:00',
                        end: '2024-01-17T15:00:00',
                        className: 'event-meeting',
                        extendedProps: {
                            type: 'meeting'
                        }
                    },
                    {
                        title: 'UTS Matematika - XII',
                        start: '2024-01-18T08:00:00',
                        end: '2024-01-18T12:00:00',
                        className: 'event-exam',
                        extendedProps: {
                            type: 'exam'
                        }
                    },
                    {
                        title: 'Libur Nasional',
                        start: '2024-01-22',
                        allDay: true,
                        className: 'event-holiday',
                        extendedProps: {
                            type: 'holiday'
                        }
                    }
                ];
            }

            renderEventContent(eventInfo) {
                const event = eventInfo.event;
                const extendedProps = event.extendedProps;
                
                let content = `<div class="fc-event-content">`;
                content += `<strong>${eventInfo.event.title}</strong>`;
                
                if (extendedProps.room) {
                    content += `<br><small><i class="fas fa-map-marker-alt"></i> ${extendedProps.room}</small>`;
                }
                
                if (extendedProps.topic) {
                    content += `<br><small><i class="fas fa-book"></i> ${extendedProps.topic}</small>`;
                }
                
                content += `</div>`;
                
                return { html: content };
            }

            handleEventClick(info) {
                const event = info.event;
                const extendedProps = event.extendedProps;
                
                let message = `Jadwal: ${event.title}\n`;
                message += `Waktu: ${moment(event.start).format('DD MMMM YYYY HH:mm')} - ${moment(event.end).format('HH:mm')}\n`;
                
                if (extendedProps.room) {
                    message += `Ruang: ${extendedProps.room}\n`;
                }
                
                if (extendedProps.topic) {
                    message += `Topik: ${extendedProps.topic}\n`;
                }
                
                if (extendedProps.type === 'teaching') {
                    message += '\nKlik OK untuk input absensi atau logbook.';
                    if (confirm(message)) {
                        this.openTeachingTools(event);
                    }
                } else {
                    alert(message);
                }
            }

            openTeachingTools(event) {
                // In real app, this would open modal for attendance or logbook
                const scheduleId = event.id;
                alert(`Membuka tools untuk jadwal ID: ${scheduleId}\nBisa input absensi atau logbook.`);
            }

            handleDatesSet(dateInfo) {
                const currentMonth = moment(dateInfo.start).format('MMMM YYYY');
                document.getElementById('currentMonthYear').textContent = currentMonth;
            }

            loadScheduleData() {
                this.renderListView();
                this.renderDailyView();
                this.renderWeeklyView();
            }

            renderListView() {
                const scheduleData = this.getMockScheduleData();
                const tbody = document.getElementById('scheduleList');
                tbody.innerHTML = '';

                scheduleData.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.day}, ${item.date}</td>
                        <td>${item.time}</td>
                        <td>${item.subject}</td>
                        <td>${item.class}</td>
                        <td>${item.room}</td>
                        <td><span class="status-badge ${item.statusClass}">${item.status}</span></td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="teachingSchedule.takeAttendance('${item.id}')">
                                <i class="fas fa-clipboard-check"></i> Absen
                            </button>
                            <button class="btn btn-sm btn-success" onclick="teachingSchedule.openLogbook('${item.id}')">
                                <i class="fas fa-book"></i> Logbook
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }

            renderDailyView() {
                const dailyData = this.getMockDailyData();
                const container = document.getElementById('dailySchedule');
                container.innerHTML = '';

                const dayHeader = document.createElement('div');
                dayHeader.className = 'day-header';
                dayHeader.textContent = 'Senin, 15 Januari 2024';
                container.appendChild(dayHeader);

                dailyData.forEach(item => {
                    const classItem = document.createElement('div');
                    classItem.className = 'class-item';
                    classItem.innerHTML = `
                        <div class="class-info">
                            <h4>${item.subject} - ${item.class}</h4>
                            <div class="class-meta">
                                <span><i class="fas fa-clock"></i> ${item.time}</span>
                                <span><i class="fas fa-map-marker-alt"></i> ${item.room}</span>
                                <span><i class="fas fa-book"></i> ${item.topic}</span>
                            </div>
                        </div>
                        <div class="class-actions">
                            <span class="status-badge ${item.statusClass}">${item.status}</span>
                            <button class="btn btn-sm btn-primary" onclick="teachingSchedule.takeAttendance('${item.id}')">
                                Absen
                            </button>
                            <button class="btn btn-sm btn-success" onclick="teachingSchedule.openLogbook('${item.id}')">
                                Logbook
                            </button>
                        </div>
                    `;
                    container.appendChild(classItem);
                });
            }

            renderWeeklyView() {
                const weeklyData = this.getMockWeeklyData();
                const container = document.getElementById('weeklySchedule');
                container.innerHTML = '';

                Object.keys(weeklyData).forEach(day => {
                    const dayHeader = document.createElement('div');
                    dayHeader.className = 'day-header';
                    dayHeader.textContent = day;
                    container.appendChild(dayHeader);

                    weeklyData[day].forEach(item => {
                        const classItem = document.createElement('div');
                        classItem.className = 'class-item';
                        classItem.innerHTML = `
                            <div class="class-info">
                                <h4>${item.subject} - ${item.class}</h4>
                                <div class="class-meta">
                                    <span><i class="fas fa-clock"></i> ${item.time}</span>
                                    <span><i class="fas fa-map-marker-alt"></i> ${item.room}</span>
                                    <span><i class="fas fa-book"></i> ${item.topic}</span>
                                </div>
                            </div>
                            <div class="class-actions">
                                <span class="status-badge ${item.statusClass}">${item.status}</span>
                                <button class="btn btn-sm btn-outline" onclick="teachingSchedule.viewDetails('${item.id}')">
                                    Detail
                                </button>
                            </div>
                        `;
                        container.appendChild(classItem);
                    });
                });
            }

            getMockScheduleData() {
                return [
                    {
                        id: '1',
                        day: 'Senin',
                        date: '15 Jan 2024',
                        time: '08:00-09:30',
                        subject: 'Matematika',
                        class: 'X MIPA 1',
                        room: 'Ruang 201',
                        status: 'Selesai',
                        statusClass: 'status-completed'
                    },
                    {
                        id: '2',
                        day: 'Selasa',
                        date: '16 Jan 2024',
                        time: '10:00-11:30',
                        subject: 'Matematika',
                        class: 'XI IPA 2',
                        room: 'Ruang 305',
                        status: 'Sedang Berlangsung',
                        statusClass: 'status-ongoing'
                    },
                    {
                        id: '3',
                        day: 'Rabu',
                        date: '17 Jan 2024',
                        time: '13:00-14:30',
                        subject: 'Matematika',
                        class: 'XII IPS 1',
                        room: 'Ruang 402',
                        status: 'Akan Datang',
                        statusClass: 'status-upcoming'
                    }
                ];
            }

            getMockDailyData() {
                return [
                    {
                        id: '1',
                        subject: 'Matematika',
                        class: 'X MIPA 1',
                        time: '08:00-09:30',
                        room: 'Ruang 201',
                        topic: 'Trigonometri',
                        status: 'Selesai',
                        statusClass: 'status-completed'
                    },
                    {
                        id: '2',
                        subject: 'Matematika',
                        class: 'XI IPA 2',
                        time: '10:00-11:30',
                        room: 'Ruang 305',
                        topic: 'Integral',
                        status: 'Akan Datang',
                        statusClass: 'status-upcoming'
                    }
                ];
            }

            getMockWeeklyData() {
                return {
                    'Senin, 15 Jan': [
                        {
                            id: '1',
                            subject: 'Matematika',
                            class: 'X MIPA 1',
                            time: '08:00-09:30',
                            room: 'Ruang 201',
                            topic: 'Trigonometri',
                            status: 'Selesai',
                            statusClass: 'status-completed'
                        }
                    ],
                    'Selasa, 16 Jan': [
                        {
                            id: '2',
                            subject: 'Matematika',
                            class: 'XI IPA 2',
                            time: '10:00-11:30',
                            room: 'Ruang 305',
                            topic: 'Integral',
                            status: 'Akan Datang',
                            statusClass: 'status-upcoming'
                        }
                    ],
                    'Rabu, 17 Jan': [
                        {
                            id: '3',
                            subject: 'Matematika',
                            class: 'XII IPS 1',
                            time: '13:00-14:30',
                            room: 'Ruang 402',
                            topic: 'Statistika',
                            status: 'Akan Datang',
                            statusClass: 'status-upcoming'
                        }
                    ]
                };
            }

            setupEventListeners() {
                // View tabs
                document.querySelectorAll('.view-tab').forEach(tab => {
                    tab.addEventListener('click', () => {
                        const view = tab.dataset.view;
                        this.switchView(view);
                        
                        // Update active tab
                        document.querySelectorAll('.view-tab').forEach(t => {
                            t.classList.remove('active');
                        });
                        tab.classList.add('active');
                    });
                });

                // Calendar controls
                document.getElementById('todayBtn').addEventListener('click', () => {
                    this.calendar.today();
                });

                document.getElementById('prevBtn').addEventListener('click', () => {
                    this.calendar.prev();
                });

                document.getElementById('nextBtn').addEventListener('click', () => {
                    this.calendar.next();
                });

                document.getElementById('addScheduleBtn').addEventListener('click', () => {
                    this.openAddScheduleModal();
                });

                // Filter controls
                document.getElementById('periodSelect').addEventListener('change', this.applyFilters.bind(this));
                document.getElementById('monthSelect').addEventListener('change', this.applyFilters.bind(this));
                document.getElementById('yearSelect').addEventListener('change', this.applyFilters.bind(this));
                document.getElementById('classSelect').addEventListener('change', this.applyFilters.bind(this));
            }

            setupNavigation() {
                // Daily navigation
                document.getElementById('prevDay').addEventListener('click', () => {
                    alert('Navigasi ke hari sebelumnya');
                });

                document.getElementById('nextDay').addEventListener('click', () => {
                    alert('Navigasi ke hari berikutnya');
                });

                // Weekly navigation
                document.getElementById('prevWeek').addEventListener('click', () => {
                    alert('Navigasi ke minggu sebelumnya');
                });

                document.getElementById('nextWeek').addEventListener('click', () => {
                    alert('Navigasi ke minggu berikutnya');
                });
            }

            switchView(view) {
                // Hide all views
                document.getElementById('calendarView').style.display = 'none';
                document.getElementById('listView').style.display = 'none';
                document.getElementById('dailyView').style.display = 'none';
                document.getElementById('weeklyView').style.display = 'none';

                // Show selected view
                document.getElementById(`${view}View`).style.display = 'block';
                this.currentView = view;
            }

            applyFilters() {
                const period = document.getElementById('periodSelect').value;
                const month = document.getElementById('monthSelect').value;
                const year = document.getElementById('yearSelect').value;
                const selectedClass = document.getElementById('classSelect').value;

                console.log('Applying filters:', { period, month, year, selectedClass });
                
                // In real app, this would reload data with filters
                alert(`Filter diterapkan:\nPeriode: ${period}\nBulan: ${month}\nTahun: ${year}\nKelas: ${selectedClass}`);
            }

            openAddScheduleModal() {
                alert('Membuka modal untuk menambah jadwal mengajar baru');
                // In real app, this would open a modal form
            }

            takeAttendance(scheduleId) {
                alert(`Membuka form absensi untuk jadwal ID: ${scheduleId}`);
                // In real app, redirect to attendance page
                // window.location.href = `absensi.html?schedule=${scheduleId}`;
            }

            openLogbook(scheduleId) {
                alert(`Membuka logbook untuk jadwal ID: ${scheduleId}`);
                // In real app, redirect to logbook page
                // window.location.href = `logbook.html?schedule=${scheduleId}`;
            }

            viewDetails(scheduleId) {
                alert(`Menampilkan detail jadwal ID: ${scheduleId}`);
            }
        }

        // Global functions for export
        function printSchedule() {
            window.print();
        }

        function exportToPDF() {
            alert('Fitur export PDF akan segera tersedia!');
        }

        function exportToExcel() {
            alert('Fitur export Excel akan segera tersedia!');
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', () => {
            window.teachingSchedule = new TeachingSchedule();
            
            // Set current month in select
            const currentMonth = new Date().getMonth() + 1;
            document.getElementById('monthSelect').value = currentMonth;
        });
    </script>
@endpush