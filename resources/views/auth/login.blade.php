@extends('layouts.app')

@section('title', 'Masuk - CollabQuest')

@section('content')
<div class="min-h-screen flex flex-col justify-center items-center px-4 py-12">
    <!-- Header Brand -->
    <div class="w-full max-w-md text-center mb-8">
        <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-[#E2EDE5] text-[#244B2E] mb-4 shadow-sm border border-[#CCE0CF]">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold tracking-tight text-[#1B3823]">CollabQuest</h1>
        <p class="text-sm text-[#5C745F] mt-1">Platform Manajemen Tugas Terpadu Siswa & Kolaborator</p>

        <!-- Mode Badge Switcher -->
        <div class="mt-4 inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white border border-[#CFDFD2] shadow-xs text-xs text-[#3A4A3C]">
            <span class="inline-block w-2 h-2 rounded-full" id="mode-indicator-dot"></span>
            <span class="font-medium" id="mode-indicator-text">Memuat Mode...</span>
            <button type="button" id="btn-toggle-mode" class="ml-1 underline font-semibold text-[#2E5E3A] hover:text-[#1B3823] cursor-pointer">
                Ganti Mode
            </button>
        </div>
    </div>

    <!-- Login Card -->
    <div class="w-full max-w-md bg-white rounded-3xl border border-[#E2EBE1] shadow-sm p-8 sm:p-10">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-[#1F2E23]">Masuk ke Akun</h2>
            <p class="text-xs text-[#6B7E6F] mt-1">Silakan masukkan email dan kata sandi Anda untuk melanjutkan.</p>
        </div>

        <!-- Alert Container -->
        <div id="login-alert" class="hidden mb-5 p-3.5 rounded-xl border text-xs font-medium flex items-start gap-2.5">
            <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div id="login-alert-text" class="flex-1"></div>
        </div>

        <!-- Form -->
        <form id="login-form" class="space-y-4">
            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-medium text-[#2E3D31] mb-1.5">Alamat Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#749077]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input type="email" id="email" name="email" required
                        class="w-full pl-10 pr-4 py-2.5 bg-[#FAFBF9] border border-[#D5E1D7] rounded-xl text-sm text-[#1E2B21] placeholder-[#8EA391] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#387348]/20 focus:border-[#2E5E3A] transition"
                        placeholder="nama@sekolah.sch.id">
                </div>
                <p id="error-email" class="hidden text-xs text-[#C53030] mt-1"></p>
            </div>

            <!-- Password -->
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-xs font-medium text-[#2E3D31]">Kata Sandi</label>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#749077]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" id="password" name="password" required
                        class="w-full pl-10 pr-10 py-2.5 bg-[#FAFBF9] border border-[#D5E1D7] rounded-xl text-sm text-[#1E2B21] placeholder-[#8EA391] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#387348]/20 focus:border-[#2E5E3A] transition"
                        placeholder="••••••••">
                    <button type="button" id="btn-toggle-password" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[#749077] hover:text-[#244B2E]">
                        <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <p id="error-password" class="hidden text-xs text-[#C53030] mt-1"></p>
            </div>

            <!-- Submit Button -->
            <button type="submit" id="btn-submit"
                class="w-full mt-2 py-3 px-4 rounded-xl font-medium text-sm text-white bg-[#244B2E] hover:bg-[#1B3823] active:bg-[#142A1B] shadow-sm transition flex items-center justify-center gap-2 cursor-pointer">
                <svg id="submit-spinner" class="hidden animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span id="submit-text">Masuk Sekarang</span>
            </button>
        </form>

        <!-- Quick Demo Fill -->
        <div class="mt-5 pt-5 border-t border-[#EAEFE9]">
            <button type="button" id="btn-fill-demo"
                class="w-full py-2.5 px-3 rounded-xl border border-[#CCE0CF] bg-[#F2F7F3] hover:bg-[#E5EFE6] text-xs font-medium text-[#244B2E] transition flex items-center justify-center gap-2 cursor-pointer">
                <svg class="w-3.5 h-3.5 text-[#2E5E3A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <span>Isi Otomatis Akun Demo (Mock)</span>
            </button>
        </div>

        <!-- Footer link -->
        <div class="mt-6 text-center text-xs text-[#5C745F]">
            Belum memiliki akun?
            <a href="/register" class="font-semibold text-[#244B2E] hover:underline ml-1">Daftar Akun Baru</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('login-form');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const submitBtn = document.getElementById('btn-submit');
        const submitSpinner = document.getElementById('submit-spinner');
        const submitText = document.getElementById('submit-text');
        const alertBox = document.getElementById('login-alert');
        const alertText = document.getElementById('login-alert-text');
        const errorEmail = document.getElementById('error-email');
        const errorPassword = document.getElementById('error-password');
        const btnTogglePass = document.getElementById('btn-toggle-password');
        const btnFillDemo = document.getElementById('btn-fill-demo');
        const modeDot = document.getElementById('mode-indicator-dot');
        const modeText = document.getElementById('mode-indicator-text');
        const btnToggleMode = document.getElementById('btn-toggle-mode');

        // Update mode indicator
        function updateModeUI() {
            const mode = window.AppAPI ? window.AppAPI.getMode() : 'mock';
            if (mode === 'mock') {
                modeDot.className = 'inline-block w-2 h-2 rounded-full bg-[#387348]';
                modeText.textContent = 'Mode: Mock API Terpusat';
                modeText.className = 'font-medium text-[#244B2E]';
            } else {
                modeDot.className = 'inline-block w-2 h-2 rounded-full bg-[#2B6CB0]';
                modeText.textContent = 'Mode: Backend API Nyata (Sanctum)';
                modeText.className = 'font-medium text-[#1A365D]';
            }
        }
        updateModeUI();

        btnToggleMode.addEventListener('click', () => {
            const current = window.AppAPI.getMode();
            const next = current === 'mock' ? 'real' : 'mock';
            window.AppAPI.setMode(next);
            updateModeUI();
            window.showToast(`Sumber API beralih ke: ${next === 'mock' ? 'Mock JSON Terpusat' : 'API Nyata (Sanctum)'}`, 'info');
        });

        // Toggle Password visibility
        btnTogglePass.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
        });

        // Demo Fill
        btnFillDemo.addEventListener('click', () => {
            emailInput.value = 'siswa@collabquest.local';
            passwordInput.value = 'password123';
            hideAlert();
            hideFieldErrors();
            window.showToast('Kredensial demo berhasil diisikan', 'info');
        });

        function showAlert(msg, isError = true) {
            alertText.textContent = msg;
            alertBox.classList.remove('hidden');
            if (isError) {
                alertBox.className = 'mb-5 p-3.5 rounded-xl border border-[#F7CDCD] bg-[#FDF2F2] text-[#8A2424] text-xs font-medium flex items-start gap-2.5';
            } else {
                alertBox.className = 'mb-5 p-3.5 rounded-xl border border-[#CCE0CF] bg-[#F0F6F2] text-[#244B2E] text-xs font-medium flex items-start gap-2.5';
            }
        }

        function hideAlert() {
            alertBox.classList.add('hidden');
        }

        function hideFieldErrors() {
            errorEmail.classList.add('hidden');
            errorEmail.textContent = '';
            errorPassword.classList.add('hidden');
            errorPassword.textContent = '';
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            hideAlert();
            hideFieldErrors();

            const email = emailInput.value.trim();
            const password = passwordInput.value;

            // Set loading
            submitBtn.disabled = true;
            submitSpinner.classList.remove('hidden');
            submitText.textContent = 'Memproses Autentikasi...';

            try {
                const response = await window.AppAPI.login({ email, password });
                window.showToast('Login berhasil! Mengalihkan ke dashboard...', 'success');
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 600);
            } catch (err) {
                if (err.errors) {
                    if (err.errors.email) {
                        errorEmail.textContent = err.errors.email[0];
                        errorEmail.classList.remove('hidden');
                    }
                    if (err.errors.password) {
                        errorPassword.textContent = err.errors.password[0];
                        errorPassword.classList.remove('hidden');
                    }
                }
                showAlert(err.message || 'Login gagal. Silakan periksa kredensial Anda.', true);
            } finally {
                submitBtn.disabled = false;
                submitSpinner.classList.add('hidden');
                submitText.textContent = 'Masuk Sekarang';
            }
        });
    });
</script>
@endpush
