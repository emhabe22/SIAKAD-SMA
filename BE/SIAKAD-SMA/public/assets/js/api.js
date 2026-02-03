// api.js - API Communication Module
class APIManager {
    constructor() {
        // API configuration
        this.config = {
            baseURL: window.API_BASE_URL || 'https://api.sma-mishbahululum.sch.id',
            timeout: 30000,
            retryAttempts: 3,
            retryDelay: 1000
        };
        
        // Default headers
        this.defaultHeaders = {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        };
        
        // Request interceptor
        this.requestInterceptor = null;
        
        // Response interceptor
        this.responseInterceptor = null;
        
        // Initialize
        this.init();
    }

    init() {
        // Add auth token to headers if available
        this.updateAuthHeader();
        
        // Setup interceptors
        this.setupInterceptors();
    }

    /**
     * Update authorization header
     */
    updateAuthHeader() {
        const token = localStorage.getItem('authToken');
        if (token) {
            this.defaultHeaders['Authorization'] = `Bearer ${token}`;
        } else {
            delete this.defaultHeaders['Authorization'];
        }
    }

    /**
     * Setup request and response interceptors
     */
    setupInterceptors() {
        // Request interceptor
        this.requestInterceptor = (config) => {
            // Update auth header before each request
            this.updateAuthHeader();
            
            // Add timestamp
            config.headers['X-Request-Timestamp'] = Date.now();
            
            return config;
        };

        // Response interceptor
        this.responseInterceptor = (response) => {
            // Handle token expiration
            if (response.status === 401) {
                this.handleUnauthorized();
                throw new Error('Session expired. Please login again.');
            }
            
            // Handle server errors
            if (response.status >= 500) {
                throw new Error('Server error. Please try again later.');
            }
            
            return response;
        };
    }

    /**
     * Make HTTP request
     */
    async request(endpoint, method = 'GET', data = null, options = {}) {
        const url = `${this.config.baseURL}${endpoint}`;
        const headers = { ...this.defaultHeaders, ...options.headers };
        
        // Request configuration
        let config = {
            method,
            headers,
            timeout: this.config.timeout,
            ...options
        };

        // Add request body for POST, PUT, PATCH
        if (data && ['POST', 'PUT', 'PATCH'].includes(method)) {
            config.body = JSON.stringify(data);
        }

        try {
            // Apply request interceptor
            if (this.requestInterceptor) {
                config = this.requestInterceptor(config) || config;
            }

            let response;
            let attempts = 0;
            
            // Retry logic
            while (attempts <= this.config.retryAttempts) {
                try {
                    response = await this.fetchWithTimeout(url, config);
                    break;
                } catch (error) {
                    attempts++;
                    if (attempts > this.config.retryAttempts) throw error;
                    await this.delay(this.config.retryDelay);
                }
            }

            // Apply response interceptor
            if (this.responseInterceptor) {
                response = this.responseInterceptor(response) || response;
            }

            // Parse response
            let responseData;
            const contentType = response.headers.get('content-type');
            
            if (contentType && contentType.includes('application/json')) {
                responseData = await response.json();
            } else {
                responseData = await response.text();
            }

            // Handle non-200 responses
            if (!response.ok) {
                throw this.createError(response, responseData);
            }

            return {
                success: true,
                data: responseData,
                status: response.status,
                headers: response.headers
            };

        } catch (error) {
            console.error('API Request Error:', error);
            throw this.normalizeError(error);
        }
    }

    /**
     * Fetch with timeout
     */
    async fetchWithTimeout(url, options) {
        const { timeout, ...fetchOptions } = options;
        
        const controller = new AbortController();
        const id = setTimeout(() => controller.abort(), timeout);
        
        try {
            const response = await fetch(url, {
                ...fetchOptions,
                signal: controller.signal
            });
            clearTimeout(id);
            return response;
        } catch (error) {
            clearTimeout(id);
            throw error;
        }
    }

    /**
     * Delay helper for retries
     */
    delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    /**
     * Create standardized error object
     */
    createError(response, data) {
        const error = new Error(data?.message || `HTTP ${response.status}`);
        error.status = response.status;
        error.data = data;
        error.response = response;
        return error;
    }

    /**
     * Normalize error
     */
    normalizeError(error) {
        // Network error
        if (error.name === 'AbortError') {
            return {
                success: false,
                error: {
                    code: 'TIMEOUT',
                    message: 'Request timeout. Please check your connection.',
                    details: error
                }
            };
        }
        
        // Network offline
        if (!navigator.onLine) {
            return {
                success: false,
                error: {
                    code: 'NETWORK_OFFLINE',
                    message: 'No internet connection. Please check your network.',
                    details: error
                }
            };
        }
        
        // Other errors
        return {
            success: false,
            error: {
                code: error.code || 'UNKNOWN_ERROR',
                message: error.message || 'An unexpected error occurred.',
                details: error
            }
        };
    }

    /**
     * Handle unauthorized access
     */
    handleUnauthorized() {
        // Clear auth data
        localStorage.removeItem('authToken');
        localStorage.removeItem('userData');
        localStorage.removeItem('userRole');
        localStorage.setItem('isAuthenticated', 'false');
        
        // Redirect to login
        if (!window.location.pathname.includes('login.html')) {
            window.location.href = '../login.html';
        }
    }

    /**
     * API Methods
     */
    
    // Authentication
    async login(credentials) {
        return this.request('/auth/login', 'POST', credentials);
    }

    async logout() {
        return this.request('/auth/logout', 'POST');
    }

    async refreshToken() {
        return this.request('/auth/refresh', 'POST');
    }

    // Students
    async getStudents(params = {}) {
        const query = new URLSearchParams(params).toString();
        const endpoint = query ? `/students?${query}` : '/students';
        return this.request(endpoint);
    }

    async getStudent(id) {
        return this.request(`/students/${id}`);
    }

    async createStudent(data) {
        return this.request('/students', 'POST', data);
    }

    async updateStudent(id, data) {
        return this.request(`/students/${id}`, 'PUT', data);
    }

    async deleteStudent(id) {
        return this.request(`/students/${id}`, 'DELETE');
    }

    // Teachers
    async getTeachers(params = {}) {
        const query = new URLSearchParams(params).toString();
        const endpoint = query ? `/teachers?${query}` : '/teachers';
        return this.request(endpoint);
    }

    async getTeacher(id) {
        return this.request(`/teachers/${id}`);
    }

    async createTeacher(data) {
        return this.request('/teachers', 'POST', data);
    }

    async updateTeacher(id, data) {
        return this.request(`/teachers/${id}`, 'PUT', data);
    }

    async deleteTeacher(id) {
        return this.request(`/teachers/${id}`, 'DELETE');
    }

    // Classes
    async getClasses(params = {}) {
        return this.request('/classes', 'GET', null, { params });
    }

    async createClass(data) {
        return this.request('/classes', 'POST', data);
    }

    // Subjects
    async getSubjects(params = {}) {
        return this.request('/subjects', 'GET', null, { params });
    }

    // Attendance
    async getAttendance(params = {}) {
        return this.request('/attendance', 'GET', null, { params });
    }

    async submitAttendance(data) {
        return this.request('/attendance', 'POST', data);
    }

    // Bimbingan Konseling
    async getBKRequests(params = {}) {
        return this.request('/bk/requests', 'GET', null, { params });
    }

    async createBKRequest(data) {
        return this.request('/bk/requests', 'POST', data);
    }

    async updateBKRequest(id, data) {
        return this.request(`/bk/requests/${id}`, 'PUT', data);
    }

    // Reports
    async generateReport(type, params = {}) {
        return this.request(`/reports/${type}`, 'POST', params);
    }

    // Dashboard Stats
    async getDashboardStats() {
        return this.request('/dashboard/stats');
    }

    /**
     * File Upload
     */
    async uploadFile(endpoint, file, fieldName = 'file') {
        const formData = new FormData();
        formData.append(fieldName, file);
        
        const headers = {
            'Authorization': this.defaultHeaders.Authorization
        };
        
        return this.request(endpoint, 'POST', formData, { headers });
    }

    /**
     * File Download
     */
    async downloadFile(endpoint, filename) {
        const response = await this.request(endpoint, 'GET', null, {
            responseType: 'blob'
        });
        
        if (response.success) {
            const blob = new Blob([response.data]);
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        }
        
        return response;
    }

    /**
     * Real-time updates (WebSocket simulation)
     */
    setupWebSocket() {
        // This is a simulation for production
        // In real implementation, use WebSocket or SSE
        
        // Simulate real-time updates every 30 seconds
        setInterval(() => {
            this.emitEvent('data-update', {
                timestamp: new Date().toISOString(),
                message: 'Data updated'
            });
        }, 30000);
    }

    emitEvent(event, data) {
        const eventObj = new CustomEvent(`api:${event}`, { detail: data });
        window.dispatchEvent(eventObj);
    }

    on(event, callback) {
        window.addEventListener(`api:${event}`, callback);
    }

    off(event, callback) {
        window.removeEventListener(`api:${event}`, callback);
    }

    /**
     * Cache management
     */
    setCache(key, data, ttl = 300000) { // 5 minutes default
        const cacheItem = {
            data,
            expiry: Date.now() + ttl
        };
        localStorage.setItem(`cache_${key}`, JSON.stringify(cacheItem));
    }

    getCache(key) {
        const item = localStorage.getItem(`cache_${key}`);
        if (!item) return null;
        
        const cacheItem = JSON.parse(item);
        if (Date.now() > cacheItem.expiry) {
            localStorage.removeItem(`cache_${key}`);
            return null;
        }
        
        return cacheItem.data;
    }

    clearCache(key = null) {
        if (key) {
            localStorage.removeItem(`cache_${key}`);
        } else {
            // Clear all cache
            Object.keys(localStorage).forEach(k => {
                if (k.startsWith('cache_')) {
                    localStorage.removeItem(k);
                }
            });
        }
    }

    /**
     * Rate limiting simulation
     */
    async withRateLimit(fn, key = 'default', limit = 5, windowMs = 60000) {
        const now = Date.now();
        const cacheKey = `ratelimit_${key}`;
        
        let requests = this.getCache(cacheKey) || [];
        
        // Remove old requests
        requests = requests.filter(time => now - time < windowMs);
        
        if (requests.length >= limit) {
            throw new Error('Rate limit exceeded. Please try again later.');
        }
        
        // Add current request
        requests.push(now);
        this.setCache(cacheKey, requests, windowMs);
        
        return fn();
    }

    /**
     * Batch requests
     */
    async batchRequests(requests) {
        const results = [];
        
        for (const request of requests) {
            try {
                const result = await this.request(request.endpoint, request.method, request.data, request.options);
                results.push({ success: true, data: result });
            } catch (error) {
                results.push({ success: false, error });
            }
        }
        
        return results;
    }

    /**
     * Health check
     */
    async healthCheck() {
        try {
            const response = await this.request('/health', 'GET', null, { timeout: 5000 });
            return {
                status: 'healthy',
                timestamp: new Date().toISOString(),
                responseTime: response.headers['X-Response-Time']
            };
        } catch (error) {
            return {
                status: 'unhealthy',
                timestamp: new Date().toISOString(),
                error: error.message
            };
        }
    }

    /**
     * Mock data for development
     */
    mock(method, endpoint, data = null, options = {}) {
        console.log(`[MOCK] ${method} ${endpoint}`, data);
        
        // Simulate API delay
        return new Promise(resolve => {
            setTimeout(() => {
                const mockData = this.getMockData(method, endpoint, data);
                resolve({
                    success: true,
                    data: mockData,
                    status: 200,
                    headers: new Headers()
                });
            }, 500);
        });
    }

    getMockData(method, endpoint, data) {
        // Mock data for different endpoints
        switch (endpoint) {
            case '/auth/login':
                return {
                    token: 'mock-jwt-token',
                    user: {
                        id: 1,
                        username: data?.username || 'demo',
                        name: 'Demo User',
                        role: 'admin',
                        email: 'demo@smamu.sch.id'
                    }
                };
                
            case '/students':
                return {
                    students: [
                        {
                            id: 1,
                            nis: '20240001',
                            nama: 'Ahmad Fauzi',
                            kelas: 'XII IPA 1',
                            jenis_kelamin: 'L',
                            status: 'aktif'
                        },
                        {
                            id: 2,
                            nis: '20240002',
                            nama: 'Siti Nurhaliza',
                            kelas: 'XII IPA 1',
                            jenis_kelamin: 'P',
                            status: 'aktif'
                        }
                    ],
                    total: 2,
                    page: 1,
                    limit: 10
                };
                
            case '/dashboard/stats':
                return {
                    totalStudents: 452,
                    totalTeachers: 38,
                    totalClasses: 18,
                    totalSubjects: 42,
                    attendanceRate: 94.5,
                    pendingBKRequests: 5
                };
                
            default:
                return { message: 'Mock data', endpoint, method };
        }
    }
}

// Initialize API Manager
document.addEventListener('DOMContentLoaded', () => {
    window.api = new APIManager();
    
    // Setup real-time updates
    window.api.setupWebSocket();
    
    // Listen for data updates
    window.api.on('data-update', (event) => {
        console.log('Data update received:', event.detail);
        // You can update UI here if needed
    });
    
    // Global error handler for API errors
    window.addEventListener('unhandledrejection', (event) => {
        if (event.reason?.error?.code === 'NETWORK_OFFLINE') {
            alert('Tidak ada koneksi internet. Silakan cek jaringan Anda.');
        }
    });
});

// Export for module usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = APIManager;
}
// assets/js/api.js

const API_BASE_URL = 'http://localhost:3000/api'; // Ganti dengan URL API sebenarnya

class API {
    constructor() {
        this.token = localStorage.getItem('token');
        this.initInterceptors();
    }

    initInterceptors() {
        // Interceptor untuk menambahkan token ke setiap request
        this.requestInterceptor = (config) => {
            if (this.token) {
                config.headers = {
                    ...config.headers,
                    'Authorization': `Bearer ${this.token}`,
                    'Content-Type': 'application/json'
                };
            }
            return config;
        };
    }

    async request(endpoint, options = {}) {
        const config = this.requestInterceptor({
            ...options,
            headers: options.headers || {}
        });

        try {
            const response = await fetch(`${API_BASE_URL}${endpoint}`, config);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            return await response.json();
        } catch (error) {
            console.error('API Error:', error);
            throw error;
        }
    }

    // Authentication
    async login(credentials) {
        return await this.request('/auth/login', {
            method: 'POST',
            body: JSON.stringify(credentials)
        });
    }

    async logout() {
        return await this.request('/auth/logout', {
            method: 'POST'
        });
    }

    // Admin Endpoints
    async getStudents(params = {}) {
        const query = new URLSearchParams(params).toString();
        return await this.request(`/admin/students${query ? `?${query}` : ''}`);
    }

    async addStudent(data) {
        return await this.request('/admin/students', {
            method: 'POST',
            body: JSON.stringify(data)
        });
    }

    async updateStudent(id, data) {
        return await this.request(`/admin/students/${id}`, {
            method: 'PUT',
            body: JSON.stringify(data)
        });
    }

    async deleteStudent(id) {
        return await this.request(`/admin/students/${id}`, {
            method: 'DELETE'
        });
    }

    // Guru Endpoints
    async getTeachingSchedule() {
        return await this.request('/guru/jadwal');
    }

    async submitAttendance(data) {
        return await this.request('/guru/absensi', {
            method: 'POST',
            body: JSON.stringify(data)
        });
    }

    async getLogbookEntries(params = {}) {
        const query = new URLSearchParams(params).toString();
        return await this.request(`/guru/logbook${query ? `?${query}` : ''}`);
    }

    // Siswa Endpoints
    async getStudentAttendance() {
        return await this.request('/siswa/absensi');
    }

    async getBKSessions() {
        return await this.request('/siswa/bk');
    }

    async requestBKConsultation(data) {
        return await this.request('/siswa/bk/request', {
            method: 'POST',
            body: JSON.stringify(data)
        });
    }

    // BK Endpoints
    async getBKValidations() {
        return await this.request('/bk/validasi');
    }

    async validateBKSession(id, data) {
        return await this.request(`/bk/validasi/${id}`, {
            method: 'PUT',
            body: JSON.stringify(data)
        });
    }

    async sendFeedback(data) {
        return await this.request('/bk/feedback', {
            method: 'POST',
            body: JSON.stringify(data)
        });
    }

    // Common Endpoints
    async getProfile() {
        return await this.request('/profile');
    }

    async updateProfile(data) {
        return await this.request('/profile', {
            method: 'PUT',
            body: JSON.stringify(data)
        });
    }

    async changePassword(data) {
        return await this.request('/auth/change-password', {
            method: 'POST',
            body: JSON.stringify(data)
        });
    }

    // File Upload
    async uploadFile(file, endpoint) {
        const formData = new FormData();
        formData.append('file', file);

        const response = await fetch(`${API_BASE_URL}${endpoint}`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${this.token}`
            },
            body: formData
        });

        if (!response.ok) {
            throw new Error('Upload failed');
        }

        return await response.json();
    }

    // Real-time updates dengan polling
    startPolling(endpoint, interval = 30000, callback) {
        this.pollingInterval = setInterval(async () => {
            try {
                const data = await this.request(endpoint);
                callback(data);
            } catch (error) {
                console.error('Polling error:', error);
            }
        }, interval);
    }

    stopPolling() {
        if (this.pollingInterval) {
            clearInterval(this.pollingInterval);
        }
    }

    // Websocket untuk real-time
    connectWebSocket() {
        const ws = new WebSocket(`ws://localhost:3000/ws?token=${this.token}`);
        
        ws.onopen = () => {
            console.log('WebSocket connected');
        };
        
        ws.onmessage = (event) => {
            const data = JSON.parse(event.data);
            this.handleWebSocketMessage(data);
        };
        
        ws.onerror = (error) => {
            console.error('WebSocket error:', error);
        };
        
        ws.onclose = () => {
            console.log('WebSocket disconnected');
            // Reconnect after 5 seconds
            setTimeout(() => this.connectWebSocket(), 5000);
        };
        
        return ws;
    }

    handleWebSocketMessage(data) {
        // Handle incoming WebSocket messages
        switch (data.type) {
            case 'notification':
                this.showNotification(data.message);
                break;
            case 'data_update':
                this.handleDataUpdate(data.payload);
                break;
            case 'session_expired':
                window.location.href = '/login.html';
                break;
        }
    }

    showNotification(message) {
        // Implement notification system
        if ('Notification' in window && Notification.permission === 'granted') {
            new Notification('SIAKAD', {
                body: message,
                icon: '/assets/images/logo.png'
            });
        } else {
            // Fallback to browser alert or custom notification
            alert(message);
        }
    }

    handleDataUpdate(payload) {
        // Dispatch custom event for data updates
        const event = new CustomEvent('dataUpdate', { detail: payload });
        window.dispatchEvent(event);
    }

    // Cache management
    async getWithCache(endpoint, cacheKey, ttl = 300000) { // 5 minutes default
        const cached = localStorage.getItem(cacheKey);
        const now = Date.now();
        
        if (cached) {
            const { data, timestamp } = JSON.parse(cached);
            if (now - timestamp < ttl) {
                return data;
            }
        }
        
        const freshData = await this.request(endpoint);
        localStorage.setItem(cacheKey, JSON.stringify({
            data: freshData,
            timestamp: now
        }));
        
        return freshData;
    }

    clearCache(key = null) {
        if (key) {
            localStorage.removeItem(key);
        } else {
            // Clear all API cache
            Object.keys(localStorage).forEach(k => {
                if (k.startsWith('api_cache_')) {
                    localStorage.removeItem(k);
                }
            });
        }
    }

    // Error handling utils
    handleError(error, fallbackMessage = 'Terjadi kesalahan') {
        console.error('API Error:', error);
        
        const userMessage = error.message || fallbackMessage;
        
        // Show error to user
        const errorEvent = new CustomEvent('apiError', {
            detail: { message: userMessage }
        });
        window.dispatchEvent(errorEvent);
        
        return { success: false, error: userMessage };
    }

    // Batch requests
    async batchRequests(requests) {
        const promises = requests.map(req => this.request(req.endpoint, req.options));
        return await Promise.allSettled(promises);
    }
}

// Inisialisasi API instance
const api = new API();

// Export untuk penggunaan global
window.API = api;

