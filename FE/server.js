// Server untuk Siakad SMA Mishbahul Ulum
const http = require('http');
const fs = require('fs');
const path = require('path');
const url = require('url');

const PORT = 3000;
const ROOT_DIR = process.cwd();

const MIME_TYPES = {
    '.html': 'text/html; charset=utf-8',
    '.css': 'text/css',
    '.js': 'text/javascript',
    '.json': 'application/json',
    '.png': 'image/png',
    '.jpg': 'image/jpeg',
    '.jpeg': 'image/jpeg',
    '.gif': 'image/gif',
    '.svg': 'image/svg+xml',
    '.ico': 'image/x-icon'
};

const server = http.createServer((req, res) => {
    console.log(`📥 ${req.method} ${req.url}`);
    
    const parsedUrl = url.parse(req.url);
    let pathname = parsedUrl.pathname;
    
    // Default ke index.html
    if (pathname === '/') {
        pathname = '/index.html';
    }
    
    // Bersihkan path
    const cleanPath = pathname.replace(/\.\./g, '').replace(/\/+/g, '/');
    let filePath = path.join(ROOT_DIR, cleanPath);
    
    // Cek apakah file ada
    fs.stat(filePath, (err, stats) => {
        if (err) {
            console.log(`❌ File tidak ditemukan: ${filePath}`);
            
            // Coba tambah .html
            if (path.extname(filePath) === '') {
                const htmlPath = filePath + '.html';
                fs.stat(htmlPath, (err2, stats2) => {
                    if (err2) {
                        serve404(res, req.url);
                    } else {
                        serveFile(res, htmlPath, stats2);
                    }
                });
            } else {
                serve404(res, req.url);
            }
            return;
        }
        
        if (stats.isDirectory()) {
            // Coba index.html dalam folder
            const indexPath = path.join(filePath, 'index.html');
            fs.stat(indexPath, (err, indexStats) => {
                if (err) {
                    serve404(res, req.url);
                } else {
                    serveFile(res, indexPath, indexStats);
                }
            });
            return;
        }
        
        serveFile(res, filePath, stats);
    });
});

function serveFile(res, filePath, stats) {
    const ext = path.extname(filePath).toLowerCase();
    const mimeType = MIME_TYPES[ext] || 'application/octet-stream';
    
    fs.readFile(filePath, (err, data) => {
        if (err) {
            console.error('Error membaca file:', err);
            serve404(res, filePath);
            return;
        }
        
        res.writeHead(200, {
            'Content-Type': mimeType,
            'Content-Length': stats.size,
            'Cache-Control': 'no-cache'
        });
        res.end(data);
        console.log(`✅ Berhasil melayani: ${filePath}`);
    });
}

function serve404(res, requestedPath) {
    const notFoundPath = path.join(ROOT_DIR, '404.html');
    
    fs.readFile(notFoundPath, (err, data) => {
        if (err) {
            res.writeHead(404, { 'Content-Type': 'text/html; charset=utf-8' });
            res.end(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>404 Not Found</title>
                    <style>
                        body { 
                            font-family: Arial, sans-serif; 
                            text-align: center; 
                            padding: 50px; 
                            background: linear-gradient(135deg, #E8F7EF, #FFFFFF);
                        }
                        h1 { color: #009B48; }
                        p { color: #666; }
                        .logo { font-size: 4rem; color: #009B48; margin-bottom: 20px; }
                        a { 
                            display: inline-block; 
                            margin: 10px; 
                            padding: 10px 20px; 
                            background: #009B48; 
                            color: white; 
                            text-decoration: none; 
                            border-radius: 5px; 
                        }
                    </style>
                </head>
                <body>
                    <div class="logo">📚</div>
                    <h1>404 - Halaman Tidak Ditemukan</h1>
                    <p>Path: ${requestedPath}</p>
                    <p><a href="/">Beranda</a></p>
                    <p><a href="/login.html">Login</a></p>
                </body>
                </html>
            `);
            return;
        }
        
        res.writeHead(404, { 'Content-Type': 'text/html; charset=utf-8' });
        res.end(data);
    });
}

// Start server
server.listen(PORT, () => {
    console.log('\n=============================================');
    console.log('🚀 SIAKAD SMA MISBAHUL ULUM - SERVER READY');
    console.log('=============================================');
    console.log(`🌐 URL: http://localhost:${PORT}`);
    console.log('📂 Root Directory:', ROOT_DIR);
    console.log('---------------------------------------------');
    console.log('🔗 LINK YANG TERSEDIA:');
    console.log(`   • http://localhost:${PORT}/ (redirect ke login)`);
    console.log(`   • http://localhost:${PORT}/login.html`);
    console.log(`   • http://localhost:${PORT}/admin/dashboard.html`);
    console.log(`   • http://localhost:${PORT}/siswa/dashboard.html`);
    console.log(`   • http://localhost:${PORT}/404.html`);
    console.log('---------------------------------------------');
    console.log('📝 AKUN DEMO:');
    console.log('   • Username: admin | Password: admin123');
    console.log('   • Username: siswa01 | Password: siswa123');
    console.log('=============================================\n');
});

// Handle shutdown
process.on('SIGINT', () => {
    console.log('\n👋 Server dihentikan');
    process.exit(0);
});

server.on('error', (err) => {
    if (err.code === 'EADDRINUSE') {
        console.error(`❌ Port ${PORT} sedang digunakan!`);
        console.log('💡 Coba: node server.js 8080');
    } else {
        console.error('❌ Server error:', err);
    }
    process.exit(1);
});