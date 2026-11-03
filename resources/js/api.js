/**
 * CollabQuest Centralized API Client
 * Peran B - Frontend
 *
 * Mendukung dua mode:
 * 1. 'mock': Menggunakan mock data lokal (localStorage) dengan simulasi delay & validasi (sesuai kontrak OpenAPI).
 * 2. 'real': Menggunakan fetch() asli ke endpoint Laravel Sanctum (/api/...).
 *
 * Bebas emoji, terpusat, dan mudah diganti sewaktu API Backend siap.
 */

const STORAGE_KEYS = {
    TOKEN: 'collabquest_token',
    USER: 'collabquest_user',
    API_MODE: 'collabquest_api_mode', // 'mock' | 'real'
    MOCK_TASKS: 'collabquest_mock_tasks',
};

const DEFAULT_MOCK_TASKS = [
    {
        id: 1,
        user_id: 1,
        title: 'Sepakati kontrak API dan buat dokumentasi docs/kontrak-api.md',
        deadline: new Date(Date.now() + 86400000 * 1).toISOString().split('T')[0],
        status: 'done',
        created_at: new Date(Date.now() - 86400000 * 2).toISOString(),
        updated_at: new Date().toISOString(),
    },
    {
        id: 2,
        user_id: 1,
        title: 'Implementasi halaman autentikasi (Login & Register) dengan Blade',
        deadline: new Date(Date.now() + 86400000 * 2).toISOString().split('T')[0],
        status: 'done',
        created_at: new Date(Date.now() - 86400000 * 1).toISOString(),
        updated_at: new Date().toISOString(),
    },
    {
        id: 3,
        user_id: 1,
        title: 'Bangun dashboard tugas dengan penanganan loading, data kosong, dan aksi CRUD',
        deadline: new Date(Date.now() + 86400000 * 3).toISOString().split('T')[0],
        status: 'todo',
        created_at: new Date().toISOString(),
        updated_at: new Date().toISOString(),
    },
    {
        id: 4,
        user_id: 1,
        title: 'Uji integrasi API Sanctum dan verifikasi bearer token otorisasi',
        deadline: new Date(Date.now() + 86400000 * 5).toISOString().split('T')[0],
        status: 'todo',
        created_at: new Date().toISOString(),
        updated_at: new Date().toISOString(),
    },
];

class ApiClient {
    constructor() {
        this.baseUrl = window.location.origin + '/api';
        this.initMockStorage();
    }

    // --- Mode Management ---
    getMode() {
        return localStorage.getItem(STORAGE_KEYS.API_MODE) || 'mock';
    }

    setMode(mode) {
        if (mode !== 'mock' && mode !== 'real') return;
        localStorage.setItem(STORAGE_KEYS.API_MODE, mode);
        window.dispatchEvent(new CustomEvent('collabquest:mode-changed', { detail: { mode } }));
    }

    // --- Auth State ---
    getToken() {
        return localStorage.getItem(STORAGE_KEYS.TOKEN) || null;
    }

    setToken(token) {
        if (token) {
            localStorage.setItem(STORAGE_KEYS.TOKEN, token);
        } else {
            localStorage.removeItem(STORAGE_KEYS.TOKEN);
        }
    }

    getUser() {
        try {
            const raw = localStorage.getItem(STORAGE_KEYS.USER);
            return raw ? JSON.parse(raw) : null;
        } catch {
            return null;
        }
    }

    setUser(user) {
        if (user) {
            localStorage.setItem(STORAGE_KEYS.USER, JSON.stringify(user));
        } else {
            localStorage.removeItem(STORAGE_KEYS.USER);
        }
    }

    clearAuth() {
        localStorage.removeItem(STORAGE_KEYS.TOKEN);
        localStorage.removeItem(STORAGE_KEYS.USER);
    }

    isAuthenticated() {
        return !!this.getToken();
    }

    // --- Mock Storage Helper ---
    initMockStorage() {
        if (!localStorage.getItem(STORAGE_KEYS.MOCK_TASKS)) {
            localStorage.setItem(STORAGE_KEYS.MOCK_TASKS, JSON.stringify(DEFAULT_MOCK_TASKS));
        }
        if (!localStorage.getItem(STORAGE_KEYS.API_MODE)) {
            localStorage.setItem(STORAGE_KEYS.API_MODE, 'mock');
        }
    }

    resetMockTasks() {
        localStorage.setItem(STORAGE_KEYS.MOCK_TASKS, JSON.stringify(DEFAULT_MOCK_TASKS));
    }

    getMockTasks() {
        try {
            return JSON.parse(localStorage.getItem(STORAGE_KEYS.MOCK_TASKS) || '[]');
        } catch {
            return [];
        }
    }

    saveMockTasks(tasks) {
        localStorage.setItem(STORAGE_KEYS.MOCK_TASKS, JSON.stringify(tasks));
    }

    simulateNetworkDelay(ms = 350) {
        return new Promise((resolve) => setTimeout(resolve, ms));
    }

    // --- Centralized Request Helper for Real API ---
    async realRequest(endpoint, options = {}) {
        const url = `${this.baseUrl}${endpoint}`;
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            ...(options.headers || {}),
        };

        const token = this.getToken();
        if (token) {
            headers['Authorization'] = `Bearer ${token}`;
        }

        const config = {
            ...options,
            headers,
        };

        let response;
        try {
            response = await fetch(url, config);
        } catch (error) {
            throw {
                status: 0,
                message: 'Tidak dapat terhubung ke server backend. Pastikan server Laravel aktif.',
                errors: { network: ['Koneksi jaringan gagal'] },
            };
        }

        let json = null;
        try {
            json = await response.json();
        } catch {
            json = null;
        }

        if (!response.ok) {
            if (response.status === 401) {
                this.clearAuth();
            }
            throw {
                status: response.status,
                message: json?.message || 'Terjadi kesalahan pada permintaan API.',
                errors: json?.errors || null,
            };
        }

        return json;
    }

    // ==========================================
    // AUTH METHODS
    // ==========================================

    async register({ name, email, password }) {
        if (this.getMode() === 'mock') {
            await this.simulateNetworkDelay(400);

            const errors = {};
            if (!name || !name.trim()) errors.name = ['Nama lengkap wajib diisi'];
            if (!email || !email.includes('@')) errors.email = ['Format alamat email tidak valid'];
            if (!password || password.length < 8) errors.password = ['Kata sandi minimal harus 8 karakter'];

            if (Object.keys(errors).length > 0) {
                throw {
                    status: 422,
                    message: 'Data registrasi yang diberikan tidak valid.',
                    errors,
                };
            }

            const mockUser = {
                id: Math.floor(Math.random() * 9000) + 100,
                name: name.trim(),
                email: email.trim().toLowerCase(),
                created_at: new Date().toISOString(),
            };

            return {
                message: 'Register berhasil',
                data: mockUser,
            };
        }

        return await this.realRequest('/register', {
            method: 'POST',
            body: JSON.stringify({ name, email, password }),
        });
    }

    async login({ email, password }) {
        if (this.getMode() === 'mock') {
            await this.simulateNetworkDelay(400);

            const errors = {};
            if (!email || !email.trim()) errors.email = ['Email wajib diisi'];
            if (!password || !password.trim()) errors.password = ['Kata sandi wajib diisi'];

            if (Object.keys(errors).length > 0) {
                throw {
                    status: 422,
                    message: 'Data login tidak valid.',
                    errors,
                };
            }

            // Simulasi kredensial salah jika email tertentu
            if (email === 'salah@example.com') {
                throw {
                    status: 401,
                    message: 'Email atau password salah',
                };
            }

            const mockUser = {
                id: 1,
                name: email.split('@')[0].replace(/[._]/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase()) || 'Pengguna CollabQuest',
                email: email.trim().toLowerCase(),
                created_at: new Date().toISOString(),
            };

            const mockToken = 'mock_sanctum_token_' + btoa(Date.now().toString());

            this.setToken(mockToken);
            this.setUser(mockUser);

            return {
                message: 'Login berhasil',
                token: mockToken,
                user: mockUser,
            };
        }

        const response = await this.realRequest('/login', {
            method: 'POST',
            body: JSON.stringify({ email, password }),
        });

        if (response.token) {
            this.setToken(response.token);
            this.setUser(response.user || null);
        }

        return response;
    }

    async getProfile() {
        if (this.getMode() === 'mock') {
            await this.simulateNetworkDelay(250);
            if (!this.isAuthenticated()) {
                throw { status: 401, message: 'Unauthenticated.' };
            }

            const user = this.getUser() || {
                id: 1,
                name: 'Pengguna Demo Mock',
                email: 'demo@collabquest.local',
                created_at: new Date().toISOString(),
            };

            return { data: user };
        }

        const response = await this.realRequest('/profile', { method: 'GET' });
        if (response.data) {
            this.setUser(response.data);
        }
        return response;
    }

    async logout() {
        if (this.getMode() === 'mock') {
            await this.simulateNetworkDelay(250);
            this.clearAuth();
            return { message: 'Logout berhasil' };
        }

        try {
            await this.realRequest('/logout', { method: 'POST' });
        } finally {
            this.clearAuth();
        }
        return { message: 'Logout berhasil' };
    }

    // ==========================================
    // TASKS CRUD METHODS
    // ==========================================

    async getTasks() {
        if (this.getMode() === 'mock') {
            await this.simulateNetworkDelay(350);
            if (!this.isAuthenticated()) {
                throw { status: 401, message: 'Unauthenticated.' };
            }

            const tasks = this.getMockTasks();
            return { data: tasks };
        }

        return await this.realRequest('/tasks', { method: 'GET' });
    }

    async createTask({ title, deadline }) {
        if (this.getMode() === 'mock') {
            await this.simulateNetworkDelay(350);
            if (!this.isAuthenticated()) {
                throw { status: 401, message: 'Unauthenticated.' };
            }

            const errors = {};
            if (!title || !title.trim()) {
                errors.title = ['Judul tugas wajib diisi'];
            } else if (title.trim().length > 255) {
                errors.title = ['Judul tugas maksimal 255 karakter'];
            }

            if (Object.keys(errors).length > 0) {
                throw {
                    status: 422,
                    message: 'Data tugas tidak valid.',
                    errors,
                };
            }

            const tasks = this.getMockTasks();
            const nextId = tasks.reduce((max, t) => Math.max(max, t.id || 0), 0) + 1;

            const newTask = {
                id: nextId,
                user_id: this.getUser()?.id || 1,
                title: title.trim(),
                deadline: deadline || null,
                status: 'todo',
                created_at: new Date().toISOString(),
                updated_at: new Date().toISOString(),
            };

            tasks.unshift(newTask);
            this.saveMockTasks(tasks);

            return {
                message: 'Tugas dibuat',
                data: newTask,
            };
        }

        return await this.realRequest('/tasks', {
            method: 'POST',
            body: JSON.stringify({ title, deadline: deadline || null }),
        });
    }

    async updateTask(id, { title, deadline }) {
        if (this.getMode() === 'mock') {
            await this.simulateNetworkDelay(350);
            if (!this.isAuthenticated()) {
                throw { status: 401, message: 'Unauthenticated.' };
            }

            const errors = {};
            if (!title || !title.trim()) {
                errors.title = ['Judul tugas wajib diisi'];
            } else if (title.trim().length > 255) {
                errors.title = ['Judul tugas maksimal 255 karakter'];
            }

            if (Object.keys(errors).length > 0) {
                throw {
                    status: 422,
                    message: 'Data tugas tidak valid.',
                    errors,
                };
            }

            const tasks = this.getMockTasks();
            const index = tasks.findIndex((t) => t.id === Number(id));

            if (index === -1) {
                throw { status: 404, message: 'Tugas tidak ditemukan.' };
            }

            tasks[index] = {
                ...tasks[index],
                title: title.trim(),
                deadline: deadline || null,
                updated_at: new Date().toISOString(),
            };

            this.saveMockTasks(tasks);

            return {
                message: 'Tugas diubah',
                data: tasks[index],
            };
        }

        return await this.realRequest(`/tasks/${id}`, {
            method: 'PUT',
            body: JSON.stringify({ title, deadline: deadline || null }),
        });
    }

    async updateTaskStatus(id, status) {
        if (this.getMode() === 'mock') {
            await this.simulateNetworkDelay(250);
            if (!this.isAuthenticated()) {
                throw { status: 401, message: 'Unauthenticated.' };
            }

            if (status !== 'todo' && status !== 'done') {
                throw {
                    status: 422,
                    message: 'Status harus berupa todo atau done.',
                    errors: { status: ['Status tidak valid'] },
                };
            }

            const tasks = this.getMockTasks();
            const index = tasks.findIndex((t) => t.id === Number(id));

            if (index === -1) {
                throw { status: 404, message: 'Tugas tidak ditemukan.' };
            }

            tasks[index].status = status;
            tasks[index].updated_at = new Date().toISOString();

            this.saveMockTasks(tasks);

            return {
                message: 'Status diubah',
                data: tasks[index],
            };
        }

        return await this.realRequest(`/tasks/${id}/status`, {
            method: 'PATCH',
            body: JSON.stringify({ status }),
        });
    }

    async deleteTask(id) {
        if (this.getMode() === 'mock') {
            await this.simulateNetworkDelay(300);
            if (!this.isAuthenticated()) {
                throw { status: 401, message: 'Unauthenticated.' };
            }

            const tasks = this.getMockTasks();
            const filtered = tasks.filter((t) => t.id !== Number(id));

            if (filtered.length === tasks.length) {
                throw { status: 404, message: 'Tugas tidak ditemukan.' };
            }

            this.saveMockTasks(filtered);

            return {
                message: 'Tugas dihapus',
            };
        }

        return await this.realRequest(`/tasks/${id}`, {
            method: 'DELETE',
        });
    }
}

// Instance singleton
const api = new ApiClient();

// Expose ke global window
window.AppAPI = api;

export default api;
