<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIAKAD SMA Mishbahul Ulum')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @stack('styles')
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar Navigation -->
    @include('components.sidebar')

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-left">
                <h1>@yield('page-title')</h1>
                <p class="breadcrumb">@yield('breadcrumb', 'Home / Dashboard')</p>
            </div>
            <div class="header-right">
                <div class="notifications">
                    <i class="fas fa-bell"></i>
                    <span class="notification-count">@yield('notification-count', '0')</span>
                </div>
                <div class="date-display">
                    <span id="current-date"></span>
                    <span id="current-time"></span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        @yield('content')

        <!-- Footer -->
        <footer class="main-footer">
            <p>&copy; 2024 SMA Mishbahul Ulum. All rights reserved.</p>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
    
    <script>
        // Update current date and time
        function updateDateTime() {
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const dateStr = now.toLocaleDateString('id-ID', options);
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            
            document.getElementById('current-date').textContent = dateStr;
            document.getElementById('current-time').textContent = timeStr;
        }
        
        updateDateTime();
        setInterval(updateDateTime, 60000); // Update every minute

        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                mainContent.classList.toggle('sidebar-active');
            });
        }

        // Logout handler
        function handleLogout(event) {
            event.preventDefault();
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                localStorage.removeItem('token');
                window.location.href = '/login';
            }
        }
    </script>
</body>
</html>
