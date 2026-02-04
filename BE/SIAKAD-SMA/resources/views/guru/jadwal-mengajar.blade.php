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
