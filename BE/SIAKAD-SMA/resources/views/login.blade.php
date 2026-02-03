<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Siakad SMA Mishbahul Ulum</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/auth.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #2E7D32;
            --primary-light: #4CAF50;
            --primary-lighter: #81C784;
            --accent: #FF5722;
            --accent-light: #FF8A65;
            --background: #F8FDFF;
            --card-bg: #FFFFFF;
            --text-dark: #1A237E;
            --text-medium: #424242;
            --text-light: #757575;
            --border: #E3F2FD;
            --shadow: 0 10px 30px rgba(46, 125, 50, 0.1);
            --shadow-hover: 0 20px 40px rgba(46, 125, 50, 0.15);
            --radius-sm: 12px;
            --radius-md: 20px;
            --radius-lg: 30px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #F8FDFF 0%, #E8F5E9 50%, #C8E6C9 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Decorative Background Elements */
        .bg-decoration {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .circle {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(129, 199, 132, 0.2), rgba(76, 175, 80, 0.1));
            filter: blur(40px);
        }

        .circle-1 {
            width: 400px;
            height: 400px;
            top: -200px;
            right: -100px;
            animation: float 20s infinite ease-in-out;
        }

        .circle-2 {
            width: 300px;
            height: 300px;
            bottom: -150px;
            left: -50px;
            animation: float 25s infinite ease-in-out reverse;
            background: linear-gradient(135deg, rgba(255, 87, 34, 0.15), rgba(255, 138, 101, 0.1));
        }

        .circle-3 {
            width: 200px;
            height: 200px;
            top: 50%;
            left: 10%;
            animation: float 15s infinite ease-in-out;
            background: linear-gradient(135deg, rgba(46, 125, 50, 0.15), rgba(129, 199, 132, 0.1));
        }

        /* Main Container - Non Linear Layout */
        .container {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            max-width: 1000px;
            width: 100%;
            min-height: 650px;
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            overflow: hidden;
            position: relative;
            z-index: 2;
            box-shadow: var(--shadow);
            animation: slideUp 0.8s ease-out;
        }

        /* Left Panel - Welcome Section */
        .welcome-panel {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .welcome-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .logo-section {
            position: relative;
            z-index: 2;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 40px;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: var(--primary);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: 800;
            color: white;
            letter-spacing: 1px;
        }

        .logo-text span:first-child {
            color: #FFEB3B;
        }

        .logo-text span:last-child {
            color: #81C784;
        }

        .welcome-content {
            position: relative;
            z-index: 2;
            margin-top: 40px;
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: white;
            line-height: 1.2;
            margin-bottom: 15px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .welcome-title span {
            color: #FFEB3B;
            display: block;
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
            max-width: 300px;
        }

        .support-info {
            position: relative;
            z-index: 2;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .support-text {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .support-email {
            color: white;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .support-email:hover {
            color: #FFEB3B;
        }

        /* Right Panel - Login Form */
        .login-panel {
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        /* PERBAIKAN: Warna tulisan LOGIN lebih cerah dan kontras */
        .login-title {
            font-size: 2.8rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 3px;
        }

        .login-title::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 5px;
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            border-radius: 3px;
        }

        .login-subtitle {
            color: var(--text-medium);
            font-size: 1.1rem;
            margin-top: 30px;
            font-weight: 500;
        }

        /* Form Layout - Non Linear */
        .form-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .form-group {
            position: relative;
        }

        /* PERBAIKAN: Label tanpa ikon, lebih clean */
        .input-label {
            display: block;
            margin-bottom: 12px;
            color: var(--text-dark);
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .input-wrapper {
            position: relative;
            border-radius: var(--radius-sm);
            overflow: hidden;
            transition: var(--transition);
            background: var(--background);
            border: 2px solid var(--border);
        }

        .input-wrapper:focus-within {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(46, 125, 50, 0.15);
        }

        /* HAPUS: Ikon di dalam input */
        input {
            width: 100%;
            padding: 20px 25px;
            border: none;
            background: transparent;
            font-size: 1.1rem;
            color: var(--text-dark);
            outline: none;
            font-weight: 500;
        }

        input::placeholder {
            color: #A5D6A7;
            opacity: 0.9;
            font-weight: 400;
            font-size: 1rem;
        }

        /* Options Row - Non Linear Layout */
        .options-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 25px 0 35px;
        }

        .remember-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .checkbox {
            width: 22px;
            height: 22px;
            border: 2px solid var(--border);
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            background: white;
        }

        .checkbox.checked {
            background: var(--primary);
            border-color: var(--primary);
        }

        .checkbox i {
            color: white;
            font-size: 0.9rem;
            opacity: 0;
            transition: var(--transition);
        }

        .checkbox.checked i {
            opacity: 1;
        }

        .checkbox-label {
            color: var(--text-medium);
            font-size: 0.95rem;
            cursor: pointer;
            font-weight: 500;
        }

        .forgot-link {
            color: var(--accent);
            text-decoration: none;
            font-size: 0.95rem;
            font-weight: 600;
            transition: var(--transition);
            text-align: right;
            display: block;
            padding: 5px 0;
            position: relative;
        }

        .forgot-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: var(--transition);
        }

        .forgot-link:hover {
            color: var(--accent-light);
        }

        .forgot-link:hover::after {
            width: 100%;
        }

        /* Login Button */
        .btn-login {
            width: 100%;
            padding: 22px;
            background: linear-gradient(135deg, var(--accent) 0%, var(--accent-light) 100%);
            color: white;
            border: none;
            border-radius: var(--radius-sm);
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(255, 87, 34, 0.25);
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(255, 87, 34, 0.35);
            background: linear-gradient(135deg, var(--accent-light) 0%, var(--accent) 100%);
        }

        .btn-login:active {
            transform: translateY(-2px);
        }

        .btn-login::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }

        .btn-login:hover::after {
            left: 100%;
        }

        /* Demo Accounts Section - Grid Layout */
        .demo-section {
            margin-top: 40px;
            padding: 30px;
            background: linear-gradient(135deg, #F1F8E9 0%, #E8F5E9 100%);
            border-radius: var(--radius-md);
            border: 2px solid var(--primary-lighter);
            position: relative;
        }

        .demo-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: var(--radius-md) var(--radius-md) 0 0;
        }

        .demo-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
            color: var(--text-dark);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .demo-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .demo-card {
            background: white;
            padding: 18px;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: var(--transition);
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .demo-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: var(--shadow);
        }

        .demo-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary), var(--accent));
            opacity: 0;
            transition: var(--transition);
        }

        .demo-card:hover::before {
            opacity: 1;
        }

        .demo-role {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .demo-cred {
            font-size: 0.85rem;
            color: var(--text-light);
            line-height: 1.5;
        }

        /* Footer */
        .login-footer {
            margin-top: 30px;
            text-align: center;
            padding-top: 25px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .footer-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .footer-link:hover {
            color: var(--accent);
            text-decoration: underline;
        }

        .signup-link {
            color: var(--accent);
            text-decoration: none;
            font-weight: 700;
        }

        .signup-link:hover {
            text-decoration: underline;
        }

        .version {
            background: linear-gradient(135deg, var(--primary-lighter), var(--primary-light));
            color: white;
            padding: 6px 18px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(46, 125, 50, 0.1);
        }

        /* Message Container */
        #message-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            max-width: 350px;
        }

        .message {
            padding: 18px 22px;
            border-radius: var(--radius-sm);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInRight 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: var(--shadow);
        }

        .message.success {
            background: linear-gradient(135deg, #E8F5E9, #F1F8E9);
            color: var(--primary);
            border-color: rgba(76, 175, 80, 0.3);
        }

        .message.error {
            background: linear-gradient(135deg, #FFEBEE, #FFCDD2);
            color: #D32F2F;
            border-color: rgba(244, 67, 54, 0.3);
        }

        .message.info {
            background: linear-gradient(135deg, #E3F2FD, #BBDEFB);
            color: #1976D2;
            border-color: rgba(33, 150, 243, 0.3);
        }

        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* Responsive */
        @media (max-width: 900px) {
            .container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }

            .welcome-panel {
                padding: 40px;
            }

            .login-panel {
                padding: 40px;
            }

            .demo-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .container {
                min-height: auto;
            }

            .welcome-panel,
            .login-panel {
                padding: 30px;
            }

            .options-container {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .forgot-link {
                text-align: left;
            }

            .login-footer {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .login-title {
                font-size: 2.2rem;
                letter-spacing: 2px;
            }

            input {
                padding: 18px 20px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Background Decorations -->
    <div class="bg-decoration">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
        <div class="circle circle-3"></div>
    </div>

    <!-- Message Container -->
    <div id="message-container"></div>

    <!-- Main Container -->
    <div class="container">
        <!-- Left Panel - Welcome -->
        <div class="welcome-panel">
            <div class="logo-section">
                <div class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="logo-text">
                        <span>SIAKAD</span>
                        <span>SMAMU</span>
                    </div>
                </div>

                <div class="welcome-content">
                    <h1 class="welcome-title">
                        Selamat Datang di
                        <span>Sistem Akademik</span>
                    </h1>
                    <p class="welcome-subtitle">
                        Platform terintegrasi untuk manajemen pembelajaran, penilaian, dan komunikasi sekolah yang efisien.
                    </p>
                </div>
            </div>

            <div class="support-info">
                <p class="support-text">
                    Butuh bantuan? Hubungi tim support kami:
                </p>
                <a href="mailto:support@smamu.sch.id" class="support-email">
                    <i class="fas fa-envelope"></i>
                    support@smamu.sch.id
                </a>
            </div>
        </div>

        <!-- Right Panel - Login Form -->
        <div class="login-panel">
            <div class="login-header">
                <!-- PERBAIKAN: Warna tulisan LOGIN lebih cerah -->
                <h2 class="login-title">LOGIN</h2>
                <p class="login-subtitle">Masuk ke akun Anda untuk mengakses sistem</p>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <form id="login-form" action="/api/login" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- Username/Email Field -->
                    <div class="form-group">
                        <label class="input-label" for="username">
                            Username / Email
                        </label>
                        <div class="input-wrapper">
                            <input type="text"
                                   id="username"
                                   name="username"
                                   placeholder="s\a01"
                                   required>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label class="input-label" for="password">
                            Password
                        </label>
                        <div class="input-wrapper">
                            <input type="password"
                                   id="password"
                                   name="password"
                                   placeholder="Masukkan password Anda"
                                   required>
                        </div>
                    </div>
                    <!-- Login Button -->
                    <button type="submit" class="btn-login" id="login-btn">
                        <span id="btn-text">MASUK</span>
                        <i class="fas fa-arrow-right" id="btn-icon"></i>
                        <div id="loading-spinner" style="display: none; width: 20px; height: 20px; border: 3px solid rgba(255, 255, 255, 0.3); border-top: 3px solid white; border-radius: 50%; animation: spin 1s linear infinite;"></div>
                    </button>
                </form>

                <!-- Footer -->
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('login-form');
            if (!form) return;

            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                const btn = document.getElementById('login-btn');
                const btnText = document.getElementById('btn-text');
                const btnIcon = document.getElementById('btn-icon');
                const spinner = document.getElementById('loading-spinner');

                if (btn) btn.disabled = true;
                if (btnText) btnText.style.opacity = '0.7';
                if (btnIcon) btnIcon.style.display = 'none';
                if (spinner) spinner.style.display = 'block';

                const response = await fetch('/api/login', {
                    method: 'POST',
                    body: new FormData(this),
                    headers: { 'Accept': 'application/json' }
                });

                const res = await response.json();

                if (res.success) {
                    localStorage.setItem('token', res.data.token);
                    window.location.href = res.data.redirect_url;
                    return;
                }

                alert(res.message);

                if (btn) btn.disabled = false;
                if (btnText) btnText.style.opacity = '1';
                if (btnIcon) btnIcon.style.display = 'inline-block';
                if (spinner) spinner.style.display = 'none';
            });
        });
    </script>


    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
