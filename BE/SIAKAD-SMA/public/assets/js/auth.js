// auth.js - Authentication Module
class AuthManager {
    constructor() {
        this.apiBaseUrl = 'https://api.sma-mishbahululum.sch.id';
        this.init();
    }

    init() {
        this.checkAuthStatus();
        this.setupEventListeners();
    }

    checkAuthStatus() {
        const token = localStorage.getItem('authToken');
        const userData = localStorage.getItem('userData');
        
        if (token && userData) {
            try {
                const parsedData = JSON.parse(userData);
                this.updateUIForUser(parsedData);
                return parsedData;
            } catch (error) {
                console.error('Error parsing user data:', error);
                this.logout();
            }
        }
        return null;
    }

    updateUIForUser(userData) {
        // Update user info in all pages
        const userElements = document.querySelectorAll('[data-user]');
        userElements.forEach(element => {
            const field = element.dataset.user;
            if (userData[field]) {
                element.textContent = userData[field];
            }
        });
        
        // Update avatar
        const avatarElements = document.querySelectorAll('.user-avatar');
        avatarElements.forEach(element => {
            if (userData.name) {
                const initials = userData.name
                    .split(' ')
                    .map(n => n[0])
                    .join('')
                    .toUpperCase()
                    .substring(0, 2);
                element.textContent = initials;
            }
        });
    }

    async login(username, password) {
        try {
            // Show loading
            this.showLoading(true);
            
            // In production, this would be an API call
            // const response = await fetch(`${this.apiBaseUrl}/auth/login`, {
            //     method: 'POST',
            //     headers: { 'Content-Type': 'application/json' },
            //     body: JSON.stringify({ username, password })
            // });
            
            // Simulate API delay
            await new Promise(resolve => setTimeout(resolve, 1500));
            
            // Demo authentication
            const demoAccounts = {
                'admin': { role: 'admin', name: 'Administrator' },
                'siswa01': { role: 'siswa', name: 'Siswa Demo' },
                'guru01': { role: 'guru', name: 'Guru Demo' },
                'bk01': { role: 'bk', name: 'Guru BK Demo' }
            };
            
            const account = demoAccounts[username];
            
            if (account && this.validatePassword(username, password)) {
                const userData = {
                    id: 1,
                    username: username,
                    name: account.name,
                    role: account.role,
                    email: `${username}@smamu.sch.id`,
                    token: 'demo-token-' + Date.now()
                };
                
                // Store in localStorage
                localStorage.setItem('authToken', userData.token);
                localStorage.setItem('userData', JSON.stringify(userData));
                localStorage.setItem('userRole', account.role);
                localStorage.setItem('isAuthenticated', 'true');
                
                // Update UI
                this.updateUIForUser(userData);
                
                // Show success
                this.showMessage('success', 'Login berhasil!');
                
                // Redirect
                setTimeout(() => {
                    window.location.href = `${account.role}/dashboard.html`;
                }, 1500);
                
                return { success: true, data: userData };
            } else {
                throw new Error('Username atau password salah');
            }
            
        } catch (error) {
            this.showMessage('error', error.message);
            return { success: false, error: error.message };
        } finally {
            this.showLoading(false);
        }
    }

    validatePassword(username, password) {
        // Simple demo validation
        const demoPasswords = {
            'admin': 'admin123',
            'siswa01': 'siswa123',
            'guru01': 'guru123',
            'bk01': 'bk123'
        };
        return demoPasswords[username] === password;
    }

    logout(redirect = true) {
        // Clear all auth data
        localStorage.removeItem('authToken');
        localStorage.removeItem('userData');
        localStorage.removeItem('userRole');
        localStorage.removeItem('isAuthenticated');
        
        if (redirect) {
            window.location.href = '../login.html';
        }
    }

    showMessage(type, text) {
        const container = document.getElementById('message-container');
        if (!container) return;
        
        const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
        container.innerHTML = `
            <div class="message ${type}">
                <i class="fas fa-${icon}"></i> ${text}
            </div>
        `;
        container.style.display = 'block';
        
        // Auto hide
        if (type === 'success') {
            setTimeout(() => {
                container.style.display = 'none';
            }, 3000);
        }
    }

    showLoading(show) {
        const loginBtn = document.getElementById('login-btn');
        const btnText = document.getElementById('btn-text');
        const spinner = document.getElementById('loading-spinner');
        
        if (loginBtn && btnText && spinner) {
            if (show) {
                loginBtn.disabled = true;
                btnText.style.display = 'none';
                spinner.style.display = 'inline-block';
            } else {
                loginBtn.disabled = false;
                btnText.style.display = 'inline';
                spinner.style.display = 'none';
            }
        }
    }

    setupEventListeners() {
        // Login form
        const loginForm = document.getElementById('login-form');
        if (loginForm) {
            loginForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const username = document.getElementById('username').value.trim();
                const password = document.getElementById('password').value;
                
                if (!username || !password) {
                    this.showMessage('error', 'Username dan password harus diisi');
                    return;
                }
                
                await this.login(username, password);
            });
        }
        
        // Demo accounts
        document.querySelectorAll('.demo-account').forEach(account => {
            account.addEventListener('click', () => {
                const text = account.textContent;
                const lines = text.split('\n');
                const user = lines[1]?.match(/Username:\s*(\w+)/)?.[1];
                const pass = lines[2]?.match(/Password:\s*(\w+)/)?.[1];
                
                if (user && pass) {
                    document.getElementById('username').value = user;
                    document.getElementById('password').value = pass;
                    document.getElementById('remember').checked = true;
                    this.showMessage('info', `Akun ${user} telah diisi. Klik "MASUK" untuk melanjutkan.`);
                }
            });
        });
        
        // Logout buttons
        document.querySelectorAll('[data-action="logout"]').forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                if (confirm('Apakah Anda yakin ingin logout?')) {
                    this.logout();
                }
            });
        });
        
        // Password toggle
        const togglePassword = document.getElementById('toggle-password');
        if (togglePassword) {
            togglePassword.addEventListener('click', function() {
                const passwordInput = document.getElementById('password');
                const icon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        }
    }

    // Check if user has required role
    hasRole(requiredRole) {
        const userRole = localStorage.getItem('userRole');
        return userRole === requiredRole;
    }

    // Protect routes based on role
    protectRoute(requiredRole) {
        const isAuthenticated = localStorage.getItem('isAuthenticated');
        const userRole = localStorage.getItem('userRole');
        
        if (isAuthenticated !== 'true' || userRole !== requiredRole) {
            this.showMessage('error', 'Anda tidak memiliki akses ke halaman ini');
            setTimeout(() => {
                window.location.href = '../login.html';
            }, 2000);
            return false;
        }
        return true;
    }

    // Get current user data
    getCurrentUser() {
        const userData = localStorage.getItem('userData');
        return userData ? JSON.parse(userData) : null;
    }

    // Check if user is authenticated
    isAuthenticated() {
        return localStorage.getItem('isAuthenticated') === 'true';
    }
}

// Initialize auth manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.auth = new AuthManager();
    
    // Auto check auth status on protected pages
    const protectedPages = ['dashboard.html', 'absensi.html', 'bk.html'];
    const currentPage = window.location.pathname.split('/').pop();
    
    if (protectedPages.includes(currentPage)) {
        if (!window.auth.isAuthenticated()) {
            window.location.href = '../login.html';
        }
    }
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AuthManager;
}

// assets/js/auth.js

class Auth {
    constructor() {
        this.currentUser = null;
        this.init();
    }

    init() {
        // Cek token saat halaman dimuat
        this.checkAuth();
        
        // Event listener untuk form login
        const loginForm = document.getElementById('loginForm');
        if (loginForm) {
            loginForm.addEventListener('submit', (e) => this.handleLogin(e));
            
            // Role selection
            const roleOptions = document.querySelectorAll('.role-option');
            roleOptions.forEach(option => {
                option.addEventListener('click', () => {
                    roleOptions.forEach(opt => opt.classList.remove('selected'));
                    option.classList.add('selected');
                    document.getElementById('role').value = 
                        option.getAttribute('data-role');
                });
            });
        }
        
        // Event listener untuk logout
        const logoutBtn = document.getElementById('logoutBtn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', () => this.logout());
        }
    }

    checkAuth() {
        const token = localStorage.getItem('token');
        const userData = localStorage.getItem('user');
        
        if (token && userData) {
            try {
                this.currentUser = JSON.parse(userData);
                this.updateUI();
                return true;
            } catch (e) {
                this.logout();
                return false;
            }
        }
        return false;
    }

    async handleLogin(e) {
        e.preventDefault();
        
        const form = e.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData);
        
        // Validasi
        if (!this.validateLogin(data)) {
            return;
        }
        
        // Tampilkan loading
        this.showLoading(true);
        
        try {
            // Simulasi API call
            await this.simulateLogin(data);
            
            // Simpan data user
            const user = {
                id: Date.now(),
                username: data.username,
                role: data.role,
                name: this.getUserNameByRole(data.role)
            };
            
            localStorage.setItem('token', this.generateToken());
            localStorage.setItem('user', JSON.stringify(user));
            
            // Redirect berdasarkan role
            this.redirectByRole(data.role);
            
        } catch (error) {
            this.showError(error.message);
        } finally {
            this.showLoading(false);
        }
    }

    validateLogin(data) {
        const errorContainer = document.getElementById('authError');
        
        if (!data.username || !data.password || !data.role) {
            this.showError('Harap isi semua field yang diperlukan');
            return false;
        }
        
        if (data.password.length < 6) {
            this.showError('Password minimal 6 karakter');
            return false;
        }
        
        errorContainer.style.display = 'none';
        return true;
    }

    simulateLogin(data) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                // Simulasi login berhasil
                if (data.username === 'admin' && data.password === 'admin123') {
                    resolve({ success: true });
                } else if (data.username === 'guru' && data.password === 'guru123') {
                    resolve({ success: true });
                } else if (data.username === 'siswa' && data.password === 'siswa123') {
                    resolve({ success: true });
                } else if (data.username === 'bk' && data.password === 'bk123') {
                    resolve({ success: true });
                } else {
                    reject(new Error('Username atau password salah'));
                }
            }, 1000);
        });
    }

    getUserNameByRole(role) {
        const names = {
            'admin': 'Administrator',
            'guru': 'Guru Mata Pelajaran',
            'siswa': 'Siswa',
            'bk': 'Guru BK'
        };
        return names[role] || 'Pengguna';
    }

    generateToken() {
        return Math.random().toString(36).substring(2) + 
               Math.random().toString(36).substring(2);
    }

    redirectByRole(role) {
        const redirects = {
            'admin': '/admin/dashboard.html',
            'guru': '/guru/dashboard.html',
            'siswa': '/siswa/dashboard.html',
            'bk': '/bk/dashboard.html'
        };
        
        setTimeout(() => {
            window.location.href = redirects[role] || '/';
        }, 500);
    }

    logout() {
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        window.location.href = '/login.html';
    }

    updateUI() {
        if (!this.currentUser) return;
        
        // Update nama user di UI
        const userElements = document.querySelectorAll('.user-name');
        userElements.forEach(el => {
            el.textContent = this.currentUser.name;
        });
        
        // Update role badge
        const roleElements = document.querySelectorAll('.user-role');
        roleElements.forEach(el => {
            el.textContent = this.currentUser.role.toUpperCase();
        });
    }

    showError(message) {
        const errorContainer = document.getElementById('authError');
        if (errorContainer) {
            errorContainer.textContent = message;
            errorContainer.style.display = 'block';
        } else {
            alert(message);
        }
    }

    showLoading(show) {
        const submitBtn = document.querySelector('button[type="submit"]');
        const spinner = submitBtn?.querySelector('.spinner');
        
        if (submitBtn) {
            submitBtn.disabled = show;
            if (spinner) {
                spinner.style.display = show ? 'inline-block' : 'none';
            }
        }
    }

    // Middleware untuk proteksi halaman
    requireAuth(requiredRole = null) {
        if (!this.checkAuth()) {
            window.location.href = '/login.html';
            return false;
        }
        
        if (requiredRole && this.currentUser.role !== requiredRole) {
            window.location.href = '/404.html';
            return false;
        }
        
        return true;
    }

    // Get current user info
    getUser() {
        return this.currentUser;
    }

    // Check if user has permission
    hasPermission(permission) {
        if (!this.currentUser) return false;
        
        const permissions = {
            'admin': ['manage_all', 'view_all', 'edit_all'],
            'guru': ['manage_students', 'view_schedule', 'input_grades'],
            'siswa': ['view_grades', 'view_schedule', 'request_bk'],
            'bk': ['manage_bk', 'view_students', 'schedule_sessions']
        };
        
        return permissions[this.currentUser.role]?.includes(permission) || false;
    }
}

// Inisialisasi auth
const auth = new Auth();

// Export untuk penggunaan di file lain
window.Auth = auth;

