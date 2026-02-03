<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | Siakad SMA Mishbahul Ulum</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #E8F7EF, #FFFFFF);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }
        
        .error-container {
            text-align: center;
            max-width: 600px;
            padding: 3rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 155, 72, 0.1);
        }
        
        .error-code {
            font-size: 8rem;
            font-weight: 800;
            background: linear-gradient(135deg, #009B48, #00C853);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            line-height: 1;
            margin-bottom: 1rem;
        }
        
        .error-title {
            font-size: 2rem;
            color: #006B33;
            margin-bottom: 1rem;
        }
        
        .error-message {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .error-details {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 10px;
            margin: 1.5rem 0;
            text-align: left;
            font-family: monospace;
            font-size: 0.9rem;
            color: #666;
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }
        
        .btn {
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #009B48, #00C853);
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 155, 72, 0.3);
        }
        
        .btn-outline {
            background: transparent;
            color: #009B48;
            border: 2px solid #009B48;
        }
        
        .btn-outline:hover {
            background: rgba(0, 155, 72, 0.1);
        }
        
        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .logo-icon {
            font-size: 3rem;
            color: #009B48;
        }
        
        .logo-text h1 {
            margin: 0;
            font-size: 1.5rem;
            text-align: left;
        }
        
        .logo-text p {
            margin: 0;
            font-size: 0.9rem;
            color: #666;
            text-align: left;
        }
        
        .footer {
            margin-top: 3rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
            color: #888;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .error-container {
                padding: 2rem;
                margin: 1rem;
            }
            
            .error-code {
                font-size: 6rem;
            }
            
            .error-title {
                font-size: 1.5rem;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="logo-text">
                <h1>Siakad SMA Mishbahul Ulum</h1>
                <p>Sistem Informasi Akademik Terpadu</p>
            </div>
        </div>
        
        <div class="error-code">404</div>
        <div class="error-title">Halaman Tidak Ditemukan</div>
        
        <div class="error-message">
            <p>Halaman yang Anda cari tidak ditemukan atau mungkin telah dipindahkan.</p>
            <p>Silakan periksa URL atau gunakan navigasi di bawah:</p>
        </div>
        
        <div class="error-details">
            <p><strong>Path yang diminta:</strong> <span id="requested-path"></span></p>
            <p><strong>Timestamp:</strong> <span id="error-timestamp"></span></p>
        </div>
        
        <div class="action-buttons">
            <a href="/" class="btn btn-primary">
                <i class="fas fa-home"></i> Kembali ke Beranda
            </a>
            <a href="login.html" class="btn btn-outline">
                <i class="fas fa-sign-in-alt"></i> Halaman Login
            </a>
            <a href="javascript:history.back()" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        
        <div class="footer">
            <p>&copy; 2024 Siakad SMA Mishbahul Ulum. Versi 1.0.0</p>
            <p style="font-size: 0.8rem; margin-top: 0.5rem;">
                Jika masalah ini terus berlanjut, hubungi administrator sistem.
            </p>
        </div>
    </div>

    <script>
        // Fill error details
        document.getElementById('requested-path').textContent = window.location.pathname;
        document.getElementById('error-timestamp').textContent = new Date().toLocaleString('id-ID');
        
        // Auto redirect after 30 seconds
        setTimeout(() => {
            window.location.href = '/';
        }, 30000);
        
        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                window.history.back();
            }
            if (e.key === 'Home' || e.key === 'h') {
                window.location.href = '/';
            }
            if (e.key === 'l') {
                window.location.href = 'login.html';
            }
        });
    </script>
    
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>