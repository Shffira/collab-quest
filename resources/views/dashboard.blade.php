@extends('layouts.app')

@section('title', 'Dashboard Tugas - CollabQuest')

@section('content')
<div class="min-h-screen flex flex-col bg-[#F5F8F5]">
    <!-- Top Navigation Bar -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-[#E2EBE1]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-4">
            <!-- Brand -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-[#E2EDE5] text-[#244B2E] flex items-center justify-center border border-[#CCE0CF]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div>
                    <span class="text-base font-bold text-[#1B3823] tracking-tight">CollabQuest</span>
                    <span class="hidden sm:inline-block ml-2 px-2 py-0.5 rounded-full text-[10px] font-semibold bg-[#EAEFE9] text-[#4A5E4D]">Frontend v1.0</span>
                </div>
            </div>

            <!-- Right Controls: Mode Switcher & User Profile -->
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Mode Switcher Pill -->
                <button type="button" id="btn-mode-switcher"
                    class="flex items-center gap-2 px-3 py-1.5 rounded-full border text-xs font-medium transition cursor-pointer"
                    title="Klik untuk beralih antara Mock API dan Backend API Nyata">
                    <span id="nav-mode-dot" class="w-2 h-2 rounded-full"></span>
                    <span id="nav-mode-text">Memuat...</span>
                    <svg class="w-3.5 h-3.5 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4" />
                    </svg>
                </button>

                <!-- User Profile Dropdown Button -->
                <button type="button" id="btn-open-profile"
                    class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-full bg-[#FAFBF9] hover:bg-[#EAEFE9] border border-[#D5E1D7] text-xs font-medium text-[#244B2E] transition cursor-pointer">
                    <div id="user-avatar" class="w-6 h-6 rounded-full bg-[#244B2E] text-white flex items-center justify-center font-bold text-[11px]">
                        U
                    </div>
                    <span id="user-display-name" class="max-w-[120px] truncate hidden md:inline">Pengguna</span>
                </button>

                <!-- Logout Button -->
                <button type="button" id="btn-logout"
                    class="p-2 rounded-full text-[#749077] hover:text-[#C53030] hover:bg-[#FDF2F2] transition cursor-pointer"
                    title="Keluar dari akun">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 py-8">
        <!-- Hero & Welcome Banner -->
        <div class="relative bg-gradient-to-r from-[#244B2E] to-[#2E5E3A] rounded-3xl p-6 sm:p-8 text-white shadow-sm mb-8 overflow-hidden">
            <!-- Subtle background decorative SVG lines -->
            <div class="absolute -right-12 -bottom-12 w-64 h-64 rounded-full bg-white/5 pointer-events-none"></div>
            <div class="absolute right-20 -top-12 w-48 h-48 rounded-full bg-white/5 pointer-events-none"></div>

            <div class="relative z-10 max-w-2xl">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 text-[11px] font-medium tracking-wide mb-3 backdrop-blur-xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#A3E635]"></span>
                    Manajemen Tugas Terpadu
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold tracking-tight" id="hero-greeting">
                    Selamat Datang, Pengguna
                </h2>
                <p class="text-white/80 text-xs sm:text-sm mt-1.5">
                    Kelola dan selesaikan seluruh tugas kolaboratif Anda secara teratur dan efisien.
                </p>
            </div>

            <!-- Stats Overview Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mt-6 pt-6 border-t border-white/15">
                <!-- Stat: Total -->
                <div class="bg-white/10 backdrop-blur-xs rounded-2xl p-3.5 border border-white/10">
                    <div class="text-[11px] text-white/70 font-medium">Total Tugas</div>
                    <div class="text-xl sm:text-2xl font-bold mt-0.5" id="stat-total">0</div>
                </div>

                <!-- Stat: Todo -->
                <div class="bg-white/10 backdrop-blur-xs rounded-2xl p-3.5 border border-white/10">
                    <div class="text-[11px] text-white/70 font-medium">Perlu Dikerjakan</div>
                    <div class="text-xl sm:text-2xl font-bold mt-0.5" id="stat-todo">0</div>
                </div>

                <!-- Stat: Done -->
                <div class="bg-white/10 backdrop-blur-xs rounded-2xl p-3.5 border border-white/10">
                    <div class="text-[11px] text-white/70 font-medium">Telah Selesai</div>
                    <div class="text-xl sm:text-2xl font-bold mt-0.5" id="stat-done">0</div>
                </div>

                <!-- Stat: Progress Rate -->
                <div class="bg-white/10 backdrop-blur-xs rounded-2xl p-3.5 border border-white/10">
                    <div class="text-[11px] text-white/70 font-medium">Tingkat Selesai</div>
                    <div class="flex items-center justify-between mt-0.5">
                        <span class="text-xl sm:text-2xl font-bold" id="stat-percentage">0%</span>
                    </div>
                    <div class="w-full bg-white/20 h-1.5 rounded-full mt-1.5 overflow-hidden">
                        <div id="stat-progress-bar" class="bg-[#A3E635] h-full rounded-full transition-all duration-500" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action & Filter Bar -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
            <!-- Search & Filters -->
            <div class="flex flex-wrap items-center gap-2.5 flex-1">
                <!-- Search Input -->
                <div class="relative flex-1 min-w-[220px] max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#749077]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="input-search"
                        class="w-full pl-9 pr-4 py-2 bg-white border border-[#D5E1D7] rounded-xl text-xs sm:text-sm text-[#1E2B21] placeholder-[#8EA391] focus:outline-none focus:ring-2 focus:ring-[#387348]/20 focus:border-[#2E5E3A] transition shadow-2xs"
                        placeholder="Cari tugas berdasarkan judul...">
                </div>

                <!-- Filter Status Pills -->
                <div class="inline-flex p-1 bg-white border border-[#D5E1D7] rounded-xl shadow-2xs text-xs font-medium">
                    <button type="button" class="filter-tab px-3 py-1.5 rounded-lg transition cursor-pointer bg-[#244B2E] text-white" data-filter="all">
                        Semua
                    </button>
                    <button type="button" class="filter-tab px-3 py-1.5 rounded-lg transition cursor-pointer text-[#4A5E4D] hover:text-[#1B3823]" data-filter="todo">
                        Belum Selesai
                    </button>
                    <button type="button" class="filter-tab px-3 py-1.5 rounded-lg transition cursor-pointer text-[#4A5E4D] hover:text-[#1B3823]" data-filter="done">
                        Selesai
                    </button>
                </div>

                <!-- Sort Dropdown -->
                <div class="relative">
                    <select id="select-sort"
                        class="appearance-none bg-white border border-[#D5E1D7] rounded-xl px-3 py-2 pr-8 text-xs font-medium text-[#3A4A3C] focus:outline-none focus:ring-2 focus:ring-[#387348]/20 focus:border-[#2E5E3A] shadow-2xs cursor-pointer">
                        <option value="latest">Urut: Terbaru</option>
                        <option value="deadline_asc">Urut: Deadline Terdekat</option>
                        <option value="deadline_desc">Urut: Deadline Terjauh</option>
                        <option value="title">Urut: Judul (A-Z)</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none text-[#749077]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Add Task Button -->
            <div class="flex items-center gap-2">
                <button type="button" id="btn-open-create-modal"
                    class="w-full sm:w-auto px-5 py-2.5 rounded-xl font-medium text-xs sm:text-sm text-white bg-[#244B2E] hover:bg-[#1B3823] active:bg-[#142A1B] shadow-sm transition flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Tugas Baru</span>
                </button>
            </div>
        </div>

        <!-- Task List Area -->
        <div id="tasks-container" class="space-y-3">
            <!-- Content will be injected dynamically via JavaScript -->
        </div>

        <!-- Loading State Skeleton -->
        <div id="tasks-skeleton" class="space-y-3">
            <div class="bg-white rounded-2xl border border-[#E2EBE1] p-5 shadow-2xs animate-pulse flex items-center justify-between gap-4">
                <div class="flex items-center gap-3.5 flex-1">
                    <div class="w-6 h-6 rounded-full bg-[#EAEFE9]"></div>
                    <div class="space-y-2 flex-1">
                        <div class="h-4 bg-[#EAEFE9] rounded-md w-3/4"></div>
                        <div class="h-3 bg-[#EAEFE9] rounded-md w-1/4"></div>
                    </div>
                </div>
                <div class="w-16 h-8 bg-[#EAEFE9] rounded-lg"></div>
            </div>
            <div class="bg-white rounded-2xl border border-[#E2EBE1] p-5 shadow-2xs animate-pulse flex items-center justify-between gap-4">
                <div class="flex items-center gap-3.5 flex-1">
                    <div class="w-6 h-6 rounded-full bg-[#EAEFE9]"></div>
                    <div class="space-y-2 flex-1">
                        <div class="h-4 bg-[#EAEFE9] rounded-md w-1/2"></div>
                        <div class="h-3 bg-[#EAEFE9] rounded-md w-1/3"></div>
                    </div>
                </div>
                <div class="w-16 h-8 bg-[#EAEFE9] rounded-lg"></div>
            </div>
            <div class="bg-white rounded-2xl border border-[#E2EBE1] p-5 shadow-2xs animate-pulse flex items-center justify-between gap-4">
                <div class="flex items-center gap-3.5 flex-1">
                    <div class="w-6 h-6 rounded-full bg-[#EAEFE9]"></div>
                    <div class="space-y-2 flex-1">
                        <div class="h-4 bg-[#EAEFE9] rounded-md w-2/3"></div>
                        <div class="h-3 bg-[#EAEFE9] rounded-md w-1/4"></div>
                    </div>
                </div>
                <div class="w-16 h-8 bg-[#EAEFE9] rounded-lg"></div>
            </div>
        </div>

        <!-- Empty State Container -->
        <div id="tasks-empty" class="hidden bg-white rounded-3xl border border-[#E2EBE1] p-10 sm:p-14 text-center shadow-xs">
            <div class="w-16 h-16 mx-auto rounded-2xl bg-[#EAF3EB] text-[#244B2E] flex items-center justify-center mb-4 border border-[#CCE0CF]">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-base sm:text-lg font-semibold text-[#1F2E23]">Belum Ada Tugas Tersedia</h3>
            <p class="text-xs sm:text-sm text-[#6B7E6F] mt-1 max-w-sm mx-auto">
                Daftar tugas Anda masih kosong. Silakan tambahkan tugas baru untuk mulai mengorganisir pekerjaan Anda.
            </p>
            <button type="button" id="btn-empty-create"
                class="mt-5 inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-medium text-xs text-white bg-[#244B2E] hover:bg-[#1B3823] transition cursor-pointer shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Buat Tugas Pertama</span>
            </button>
        </div>

        <!-- Filter Empty State Container -->
        <div id="tasks-filter-empty" class="hidden bg-white rounded-3xl border border-[#E2EBE1] p-8 text-center shadow-xs">
            <div class="w-12 h-12 mx-auto rounded-xl bg-[#FAFBF9] text-[#749077] flex items-center justify-center mb-3 border border-[#E2EBE1]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <h3 class="text-sm font-semibold text-[#1F2E23]">Tugas Tidak Ditemukan</h3>
            <p class="text-xs text-[#6B7E6F] mt-1">
                Tidak ada tugas yang sesuai dengan kriteria pencarian atau filter yang dipilih.
            </p>
        </div>
    </main>

    <!-- Modal: Tambah Tugas -->
    <div id="modal-create" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <div class="modal-backdrop fixed inset-0 bg-stone-900/40 backdrop-blur-xs transition-opacity"></div>
        <div class="relative bg-white rounded-3xl border border-[#E2EBE1] shadow-xl max-w-md w-full p-6 sm:p-7 z-10 transform transition-all">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-[#E2EDE5] text-[#244B2E] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-[#1F2E23]">Tambah Tugas Baru</h3>
                </div>
                <button type="button" class="btn-close-modal text-[#749077] hover:text-[#1F2E23] p-1.5 rounded-lg transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="form-create-task" class="space-y-4">
                <!-- Title -->
                <div>
                    <label for="create-title" class="block text-xs font-medium text-[#2E3D31] mb-1.5">Judul Tugas <span class="text-[#C53030]">*</span></label>
                    <input type="text" id="create-title" required maxlength="255"
                        class="w-full px-3.5 py-2.5 bg-[#FAFBF9] border border-[#D5E1D7] rounded-xl text-xs sm:text-sm text-[#1E2B21] placeholder-[#8EA391] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#387348]/20 focus:border-[#2E5E3A] transition"
                        placeholder="Contoh: Menyusun laporan praktikum jaringan">
                    <p id="error-create-title" class="hidden text-xs text-[#C53030] mt-1"></p>
                </div>

                <!-- Deadline -->
                <div>
                    <label for="create-deadline" class="block text-xs font-medium text-[#2E3D31] mb-1.5">Batas Waktu (Deadline)</label>
                    <div class="relative">
                        <input type="date" id="create-deadline"
                            class="w-full px-3.5 py-2.5 bg-[#FAFBF9] border border-[#D5E1D7] rounded-xl text-xs sm:text-sm text-[#1E2B21] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#387348]/20 focus:border-[#2E5E3A] transition">
                    </div>
                    <p id="error-create-deadline" class="hidden text-xs text-[#C53030] mt-1"></p>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-[#EAEFE9]">
                    <button type="button" class="btn-close-modal px-4 py-2.5 rounded-xl border border-[#D5E1D7] text-xs font-medium text-[#4A5E4D] hover:bg-[#FAFBF9] transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" id="btn-submit-create"
                        class="px-5 py-2.5 rounded-xl font-medium text-xs text-white bg-[#244B2E] hover:bg-[#1B3823] transition flex items-center gap-2 cursor-pointer shadow-xs">
                        <svg id="spinner-create" class="hidden animate-spin w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Simpan Tugas</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Edit Tugas -->
    <div id="modal-edit" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <div class="modal-backdrop fixed inset-0 bg-stone-900/40 backdrop-blur-xs transition-opacity"></div>
        <div class="relative bg-white rounded-3xl border border-[#E2EBE1] shadow-xl max-w-md w-full p-6 sm:p-7 z-10 transform transition-all">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-[#E2EDE5] text-[#244B2E] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-[#1F2E23]">Ubah Data Tugas</h3>
                </div>
                <button type="button" class="btn-close-modal text-[#749077] hover:text-[#1F2E23] p-1.5 rounded-lg transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="form-edit-task" class="space-y-4">
                <input type="hidden" id="edit-id">

                <!-- Title -->
                <div>
                    <label for="edit-title" class="block text-xs font-medium text-[#2E3D31] mb-1.5">Judul Tugas <span class="text-[#C53030]">*</span></label>
                    <input type="text" id="edit-title" required maxlength="255"
                        class="w-full px-3.5 py-2.5 bg-[#FAFBF9] border border-[#D5E1D7] rounded-xl text-xs sm:text-sm text-[#1E2B21] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#387348]/20 focus:border-[#2E5E3A] transition">
                    <p id="error-edit-title" class="hidden text-xs text-[#C53030] mt-1"></p>
                </div>

                <!-- Deadline -->
                <div>
                    <label for="edit-deadline" class="block text-xs font-medium text-[#2E3D31] mb-1.5">Batas Waktu (Deadline)</label>
                    <input type="date" id="edit-deadline"
                        class="w-full px-3.5 py-2.5 bg-[#FAFBF9] border border-[#D5E1D7] rounded-xl text-xs sm:text-sm text-[#1E2B21] focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#387348]/20 focus:border-[#2E5E3A] transition">
                    <p id="error-edit-deadline" class="hidden text-xs text-[#C53030] mt-1"></p>
                </div>

                <div class="flex items-center justify-end gap-2.5 pt-3 border-t border-[#EAEFE9]">
                    <button type="button" class="btn-close-modal px-4 py-2.5 rounded-xl border border-[#D5E1D7] text-xs font-medium text-[#4A5E4D] hover:bg-[#FAFBF9] transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" id="btn-submit-edit"
                        class="px-5 py-2.5 rounded-xl font-medium text-xs text-white bg-[#244B2E] hover:bg-[#1B3823] transition flex items-center gap-2 cursor-pointer shadow-xs">
                        <svg id="spinner-edit" class="hidden animate-spin w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Perbarui Tugas</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Konfirmasi Hapus Tugas -->
    <div id="modal-delete" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <div class="modal-backdrop fixed inset-0 bg-stone-900/40 backdrop-blur-xs transition-opacity"></div>
        <div class="relative bg-white rounded-3xl border border-[#E2EBE1] shadow-xl max-w-sm w-full p-6 text-center z-10 transform transition-all">
            <div class="w-12 h-12 mx-auto rounded-2xl bg-[#FDF2F2] text-[#C53030] flex items-center justify-center mb-3.5 border border-[#F7CDCD]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>
            <h3 class="text-base font-semibold text-[#1F2E23]">Hapus Tugas?</h3>
            <p class="text-xs text-[#6B7E6F] mt-1">
                Tindakan ini tidak dapat dibatalkan. Tugas berjudul <span id="delete-task-title" class="font-medium text-[#1F2E23]"></span> akan dihapus permanen.
            </p>
            <div class="flex items-center justify-center gap-2.5 mt-6">
                <button type="button" class="btn-close-modal flex-1 px-4 py-2.5 rounded-xl border border-[#D5E1D7] text-xs font-medium text-[#4A5E4D] hover:bg-[#FAFBF9] transition cursor-pointer">
                    Batal
                </button>
                <button type="button" id="btn-confirm-delete"
                    class="flex-1 px-4 py-2.5 rounded-xl font-medium text-xs text-white bg-[#C53030] hover:bg-[#9B2424] transition flex items-center justify-center gap-2 cursor-pointer shadow-xs">
                    <svg id="spinner-delete" class="hidden animate-spin w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span>Hapus Sekarang</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: Pengaturan API & Profil Pengguna -->
    <div id="modal-profile" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
        <div class="modal-backdrop fixed inset-0 bg-stone-900/40 backdrop-blur-xs transition-opacity"></div>
        <div class="relative bg-white rounded-3xl border border-[#E2EBE1] shadow-xl max-w-md w-full p-6 sm:p-7 z-10 transform transition-all">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-[#E2EDE5] text-[#244B2E] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-[#1F2E23]">Profil & Pengaturan API</h3>
                </div>
                <button type="button" class="btn-close-modal text-[#749077] hover:text-[#1F2E23] p-1.5 rounded-lg transition cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Profile Info Box -->
            <div class="space-y-3.5 text-xs text-[#2E3D31] bg-[#FAFBF9] p-4 rounded-2xl border border-[#D5E1D7]">
                <div class="flex justify-between items-center pb-2 border-b border-[#EAEFE9]">
                    <span class="text-[#6B7E6F]">Nama Akun</span>
                    <span id="profile-name" class="font-semibold text-[#1F2E23]">-</span>
                </div>
                <div class="flex justify-between items-center pb-2 border-b border-[#EAEFE9]">
                    <span class="text-[#6B7E6F]">Email Terdaftar</span>
                    <span id="profile-email" class="font-medium text-[#1F2E23]">-</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-[#6B7E6F]">Bearer Token</span>
                    <span id="profile-token-preview" class="font-mono text-[11px] text-[#4A5E4D] max-w-[170px] truncate">-</span>
                </div>
            </div>

            <!-- Mode Switcher Section -->
            <div class="mt-5 pt-5 border-t border-[#EAEFE9]">
                <label class="block text-xs font-semibold text-[#1F2E23] mb-1.5">Sumber Integrasi API</label>
                <p class="text-[11px] text-[#6B7E6F] mb-3">
                    Pilih sumber data tugas sesuai tahap pengerjaan (Mock JSON terpusat untuk frontend mandiri, atau API Sanctum saat backend aktif).
                </p>

                <div class="grid grid-cols-2 gap-2">
                    <button type="button" id="btn-select-mock"
                        class="p-3 rounded-xl border text-left transition cursor-pointer flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-semibold text-xs">Mock API</span>
                            <span id="badge-mock-active" class="w-2 h-2 rounded-full bg-[#387348]"></span>
                        </div>
                        <span class="text-[10px] text-[#5C745F]">Mock data lokal sesuai kontrak awal</span>
                    </button>
                    <button type="button" id="btn-select-real"
                        class="p-3 rounded-xl border text-left transition cursor-pointer flex flex-col justify-between">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-semibold text-xs">Backend Nyata</span>
                            <span id="badge-real-active" class="w-2 h-2 rounded-full bg-[#CBD5E1]"></span>
                        </div>
                        <span class="text-[10px] text-[#5C745F]">Endpoint Laravel Sanctum (/api)</span>
                    </button>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="mt-5 pt-4 border-t border-[#EAEFE9] flex items-center justify-between">
                <button type="button" id="btn-reset-mock-data"
                    class="text-[11px] font-medium text-[#C53030] hover:underline cursor-pointer">
                    Atur Ulang Data Mock
                </button>
                <button type="button" class="btn-close-modal px-4 py-2 rounded-xl bg-[#244B2E] text-white text-xs font-medium hover:bg-[#1B3823] transition cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        // State
        let allTasks = [];
        let currentFilter = 'all';
        let currentSort = 'latest';
        let searchQuery = '';
        let taskToDeleteId = null;

        // Elements
        const tasksContainer = document.getElementById('tasks-container');
        const tasksSkeleton = document.getElementById('tasks-skeleton');
        const tasksEmpty = document.getElementById('tasks-empty');
        const tasksFilterEmpty = document.getElementById('tasks-filter-empty');

        const statTotal = document.getElementById('stat-total');
        const statTodo = document.getElementById('stat-todo');
        const statDone = document.getElementById('stat-done');
        const statPercentage = document.getElementById('stat-percentage');
        const statProgressBar = document.getElementById('stat-progress-bar');
        const heroGreeting = document.getElementById('hero-greeting');

        const navModeDot = document.getElementById('nav-mode-dot');
        const navModeText = document.getElementById('nav-mode-text');
        const btnModeSwitcher = document.getElementById('btn-mode-switcher');
        const userDisplayName = document.getElementById('user-display-name');
        const userAvatar = document.getElementById('user-avatar');

        const inputSearch = document.getElementById('input-search');
        const selectSort = document.getElementById('select-sort');
        const filterTabs = document.querySelectorAll('.filter-tab');

        // Modal Elements
        const modalCreate = document.getElementById('modal-create');
        const modalEdit = document.getElementById('modal-edit');
        const modalDelete = document.getElementById('modal-delete');
        const modalProfile = document.getElementById('modal-profile');

        const formCreateTask = document.getElementById('form-create-task');
        const formEditTask = document.getElementById('form-edit-task');

        const btnOpenCreateModal = document.getElementById('btn-open-create-modal');
        const btnEmptyCreate = document.getElementById('btn-empty-create');
        const btnOpenProfile = document.getElementById('btn-open-profile');
        const btnLogout = document.getElementById('btn-logout');
        const btnConfirmDelete = document.getElementById('btn-confirm-delete');
        const btnResetMock = document.getElementById('btn-reset-mock-data');

        // Check authentication
        if (!window.AppAPI.isAuthenticated()) {
            window.location.href = '/login';
            return;
        }

        // ==========================================
        // UI & AUTH INITIALIZATION
        // ==========================================
        function updateModeNavUI() {
            const mode = window.AppAPI.getMode();
            if (mode === 'mock') {
                navModeDot.className = 'w-2 h-2 rounded-full bg-[#387348]';
                navModeText.textContent = 'Mode: Mock Data';
                btnModeSwitcher.className = 'flex items-center gap-2 px-3 py-1.5 rounded-full border border-[#CFDFD2] bg-[#F2F7F3] text-xs font-medium text-[#244B2E] hover:bg-[#E5EFE6] transition cursor-pointer';
            } else {
                navModeDot.className = 'w-2 h-2 rounded-full bg-[#2B6CB0]';
                navModeText.textContent = 'Mode: API Sanctum';
                btnModeSwitcher.className = 'flex items-center gap-2 px-3 py-1.5 rounded-full border border-[#BEE3F8] bg-[#EBF8FF] text-xs font-medium text-[#2B6CB0] hover:bg-[#BEE3F8] transition cursor-pointer';
            }

            // Sync profile modal badges
            const badgeMock = document.getElementById('badge-mock-active');
            const badgeReal = document.getElementById('badge-real-active');
            const btnMock = document.getElementById('btn-select-mock');
            const btnReal = document.getElementById('btn-select-real');

            if (badgeMock && badgeReal && btnMock && btnReal) {
                if (mode === 'mock') {
                    badgeMock.className = 'w-2 h-2 rounded-full bg-[#387348]';
                    badgeReal.className = 'w-2 h-2 rounded-full bg-[#CBD5E1]';
                    btnMock.className = 'p-3 rounded-xl border border-[#2E5E3A] bg-[#F2F7F3] text-left transition cursor-pointer flex flex-col justify-between';
                    btnReal.className = 'p-3 rounded-xl border border-[#E2EBE1] bg-white hover:bg-[#FAFBF9] text-left transition cursor-pointer flex flex-col justify-between';
                } else {
                    badgeMock.className = 'w-2 h-2 rounded-full bg-[#CBD5E1]';
                    badgeReal.className = 'w-2 h-2 rounded-full bg-[#2B6CB0]';
                    btnMock.className = 'p-3 rounded-xl border border-[#E2EBE1] bg-white hover:bg-[#FAFBF9] text-left transition cursor-pointer flex flex-col justify-between';
                    btnReal.className = 'p-3 rounded-xl border border-[#2B6CB0] bg-[#EBF8FF] text-left transition cursor-pointer flex flex-col justify-between';
                }
            }
        }

        async function loadUserProfile() {
            try {
                const res = await window.AppAPI.getProfile();
                const user = res.data || window.AppAPI.getUser();
                if (user) {
                    const name = user.name || 'Pengguna';
                    heroGreeting.textContent = `Selamat Datang, ${name}`;
                    userDisplayName.textContent = name;
                    userAvatar.textContent = name.charAt(0).toUpperCase();

                    document.getElementById('profile-name').textContent = name;
                    document.getElementById('profile-email').textContent = user.email || '-';
                    const token = window.AppAPI.getToken() || '';
                    document.getElementById('profile-token-preview').textContent = token ? (token.substring(0, 16) + '...') : '-';
                }
            } catch (err) {
                if (err.status === 401) {
                    window.location.href = '/login';
                }
            }
        }

        updateModeNavUI();
        await loadUserProfile();

        // Mode switch triggers
        btnModeSwitcher.addEventListener('click', () => openModal(modalProfile));

        document.getElementById('btn-select-mock').addEventListener('click', async () => {
            if (window.AppAPI.getMode() !== 'mock') {
                window.AppAPI.setMode('mock');
                updateModeNavUI();
                window.showToast('Beralih ke mode Mock API', 'info');
                await fetchAndRenderTasks();
            }
        });

        document.getElementById('btn-select-real').addEventListener('click', async () => {
            if (window.AppAPI.getMode() !== 'real') {
                window.AppAPI.setMode('real');
                updateModeNavUI();
                window.showToast('Beralih ke mode Backend API Nyata', 'info');
                await fetchAndRenderTasks();
            }
        });

        // Logout
        btnLogout.addEventListener('click', async () => {
            try {
                await window.AppAPI.logout();
            } catch (_) {}
            window.showToast('Anda telah keluar dari akun.', 'info');
            setTimeout(() => {
                window.location.href = '/login';
            }, 400);
        });

        // Open Profile
        btnOpenProfile.addEventListener('click', () => openModal(modalProfile));

        // Reset Mock Data
        btnResetMock.addEventListener('click', async () => {
            if (confirm('Atur ulang seluruh data mock ke kondisi awal?')) {
                window.AppAPI.resetMockTasks();
                closeAllModals();
                window.showToast('Data mock berhasil diatur ulang ke kondisi default.', 'success');
                await fetchAndRenderTasks();
            }
        });

        // ==========================================
        // FETCH & RENDER TASKS
        // ==========================================
        async function fetchAndRenderTasks() {
            tasksContainer.classList.add('hidden');
            tasksEmpty.classList.add('hidden');
            tasksFilterEmpty.classList.add('hidden');
            tasksSkeleton.classList.remove('hidden');

            try {
                const response = await window.AppAPI.getTasks();
                allTasks = response.data || [];
                renderTasks();
            } catch (err) {
                if (err.status === 401) {
                    window.showToast('Sesi autentikasi telah berakhir. Silakan login kembali.', 'error');
                    setTimeout(() => window.location.href = '/login', 1200);
                    return;
                }
                tasksSkeleton.classList.add('hidden');
                tasksEmpty.classList.remove('hidden');
                window.showToast(err.message || 'Gagal memuat daftar tugas.', 'error');
            }
        }

        function calculateStats() {
            const total = allTasks.length;
            const done = allTasks.filter(t => t.status === 'done').length;
            const todo = total - done;
            const percentage = total > 0 ? Math.round((done / total) * 100) : 0;

            statTotal.textContent = total;
            statTodo.textContent = todo;
            statDone.textContent = done;
            statPercentage.textContent = `${percentage}%`;
            statProgressBar.style.width = `${percentage}%`;
        }

        function getFilteredAndSortedTasks() {
            let list = [...allTasks];

            // Filter status
            if (currentFilter === 'todo') {
                list = list.filter(t => t.status === 'todo');
            } else if (currentFilter === 'done') {
                list = list.filter(t => t.status === 'done');
            }

            // Search query
            if (searchQuery.trim()) {
                const q = searchQuery.toLowerCase();
                list = list.filter(t => (t.title || '').toLowerCase().includes(q));
            }

            // Sorting
            if (currentSort === 'latest') {
                list.sort((a, b) => new Date(b.created_at || 0) - new Date(a.created_at || 0));
            } else if (currentSort === 'deadline_asc') {
                list.sort((a, b) => {
                    if (!a.deadline) return 1;
                    if (!b.deadline) return -1;
                    return new Date(a.deadline) - new Date(b.deadline);
                });
            } else if (currentSort === 'deadline_desc') {
                list.sort((a, b) => {
                    if (!a.deadline) return 1;
                    if (!b.deadline) return -1;
                    return new Date(b.deadline) - new Date(a.deadline);
                });
            } else if (currentSort === 'title') {
                list.sort((a, b) => (a.title || '').localeCompare(b.title || ''));
            }

            return list;
        }

        function formatDeadline(dateStr) {
            if (!dateStr) {
                return {
                    text: 'Tanpa batas waktu',
                    badgeClass: 'bg-[#F0F2EF] text-[#6B7E6F] border-[#E2EBE1]',
                    urgent: false,
                };
            }

            const target = new Date(dateStr + 'T00:00:00');
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const diffTime = target.getTime() - today.getTime();
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            const options = { day: 'numeric', month: 'short', year: 'numeric' };
            const formattedDate = target.toLocaleDateString('id-ID', options);

            if (diffDays < 0) {
                return {
                    text: `${formattedDate} (Lewat ${Math.abs(diffDays)} hari)`,
                    badgeClass: 'bg-[#FDF2F2] text-[#9E2A2B] border-[#F7CDCD]',
                    urgent: true,
                };
            } else if (diffDays === 0) {
                return {
                    text: `${formattedDate} (Hari Ini)`,
                    badgeClass: 'bg-[#FAF5EC] text-[#8C6D23] border-[#EEDBBA]',
                    urgent: true,
                };
            } else if (diffDays <= 3) {
                return {
                    text: `${formattedDate} (${diffDays} hari lagi)`,
                    badgeClass: 'bg-[#FAF5EC] text-[#8C6D23] border-[#EEDBBA]',
                    urgent: false,
                };
            } else {
                return {
                    text: formattedDate,
                    badgeClass: 'bg-[#EBF2EA] text-[#345E3D] border-[#CFDFD2]',
                    urgent: false,
                };
            }
        }

        function escapeHtml(str) {
            if (!str) return '';
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }

        function renderTasks() {
            tasksSkeleton.classList.add('hidden');
            calculateStats();

            if (allTasks.length === 0) {
                tasksContainer.classList.add('hidden');
                tasksFilterEmpty.classList.add('hidden');
                tasksEmpty.classList.remove('hidden');
                return;
            }

            const filteredList = getFilteredAndSortedTasks();

            if (filteredList.length === 0) {
                tasksContainer.classList.add('hidden');
                tasksEmpty.classList.add('hidden');
                tasksFilterEmpty.classList.remove('hidden');
                return;
            }

            tasksEmpty.classList.add('hidden');
            tasksFilterEmpty.classList.add('hidden');
            tasksContainer.classList.remove('hidden');
            tasksContainer.innerHTML = '';

            filteredList.forEach(task => {
                const isDone = task.status === 'done';
                const deadlineInfo = formatDeadline(task.deadline);

                const card = document.createElement('div');
                card.className = `group bg-white rounded-2xl border transition-all duration-200 p-4 sm:p-5 shadow-2xs hover:shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4 ${
                    isDone ? 'border-[#E2EBE1] bg-[#FCFDFC]' : 'border-[#D5E1D7] hover:border-[#A8C4AD]'
                }`;

                card.innerHTML = `
                    <div class="flex items-start sm:items-center gap-3.5 flex-1 min-w-0">
                        <!-- Toggle Status Button -->
                        <button type="button" class="btn-toggle-status shrink-0 mt-0.5 sm:mt-0 w-6 h-6 rounded-full border transition flex items-center justify-center cursor-pointer ${
                            isDone
                                ? 'bg-[#244B2E] border-[#244B2E] text-white hover:bg-[#1B3823]'
                                : 'border-[#8FA893] hover:border-[#244B2E] bg-white text-transparent hover:text-[#8FA893]'
                        }" data-id="${task.id}" data-current="${task.status}" title="${isDone ? 'Tandai belum selesai' : 'Tandai selesai'}">
                            <svg class="w-3.5 h-3.5 stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </button>

                        <!-- Title and Meta -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-medium text-xs sm:text-sm text-[#1E2B21] transition ${
                                    isDone ? 'line-through text-[#7A8E7E]' : ''
                                }">
                                    ${escapeHtml(task.title)}
                                </span>
                            </div>

                            <div class="flex flex-wrap items-center gap-2 mt-2">
                                <!-- Status Badge -->
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold border ${
                                    isDone
                                        ? 'bg-[#EAF3EB] text-[#244B2E] border-[#CCE0CF]'
                                        : 'bg-[#FAF5EC] text-[#8C6D23] border-[#EEDBBA]'
                                }">
                                    <span class="w-1.5 h-1.5 rounded-full ${isDone ? 'bg-[#2E5E3A]' : 'bg-[#D97706]'}"></span>
                                    ${isDone ? 'Selesai' : 'Belum Selesai'}
                                </span>

                                <!-- Deadline Badge -->
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-medium border ${deadlineInfo.badgeClass}">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    ${deadlineInfo.text}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center gap-1.5 self-end sm:self-center shrink-0 pt-2 sm:pt-0 border-t sm:border-t-0 border-[#EAEFE9] w-full sm:w-auto justify-end">
                        <button type="button" class="btn-edit-task p-2 rounded-xl text-[#5C745F] hover:text-[#244B2E] hover:bg-[#EAEFE9] transition cursor-pointer"
                            data-id="${task.id}" data-title="${escapeHtml(task.title)}" data-deadline="${task.deadline || ''}" title="Ubah tugas">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </button>
                        <button type="button" class="btn-delete-task p-2 rounded-xl text-[#749077] hover:text-[#C53030] hover:bg-[#FDF2F2] transition cursor-pointer"
                            data-id="${task.id}" data-title="${escapeHtml(task.title)}" title="Hapus tugas">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                `;

                tasksContainer.appendChild(card);
            });

            // Bind toggle status events
            document.querySelectorAll('.btn-toggle-status').forEach(btn => {
                btn.addEventListener('click', async (e) => {
                    const id = btn.getAttribute('data-id');
                    const currentStatus = btn.getAttribute('data-current');
                    const nextStatus = currentStatus === 'done' ? 'todo' : 'done';

                    btn.disabled = true;
                    try {
                        await window.AppAPI.updateTaskStatus(id, nextStatus);
                        // Update local cache
                        const item = allTasks.find(t => t.id === Number(id));
                        if (item) item.status = nextStatus;
                        renderTasks();
                        window.showToast(`Status tugas diubah menjadi: ${nextStatus === 'done' ? 'Selesai' : 'Belum Selesai'}`, 'success');
                    } catch (err) {
                        window.showToast(err.message || 'Gagal mengubah status tugas.', 'error');
                        btn.disabled = false;
                    }
                });
            });

            // Bind edit events
            document.querySelectorAll('.btn-edit-task').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.getAttribute('data-id');
                    const title = btn.getAttribute('data-title');
                    const deadline = btn.getAttribute('data-deadline');

                    document.getElementById('edit-id').value = id;
                    document.getElementById('edit-title').value = title;
                    document.getElementById('edit-deadline').value = deadline;

                    hideEditErrors();
                    openModal(modalEdit);
                });
            });

            // Bind delete events
            document.querySelectorAll('.btn-delete-task').forEach(btn => {
                btn.addEventListener('click', () => {
                    taskToDeleteId = btn.getAttribute('data-id');
                    const title = btn.getAttribute('data-title');
                    document.getElementById('delete-task-title').textContent = `"${title}"`;
                    openModal(modalDelete);
                });
            });
        }

        // ==========================================
        // FILTER & SEARCH HANDLERS
        // ==========================================
        inputSearch.addEventListener('input', (e) => {
            searchQuery = e.target.value;
            renderTasks();
        });

        selectSort.addEventListener('change', (e) => {
            currentSort = e.target.value;
            renderTasks();
        });

        filterTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                filterTabs.forEach(t => {
                    t.className = 'filter-tab px-3 py-1.5 rounded-lg transition cursor-pointer text-[#4A5E4D] hover:text-[#1B3823]';
                });
                tab.className = 'filter-tab px-3 py-1.5 rounded-lg transition cursor-pointer bg-[#244B2E] text-white';
                currentFilter = tab.getAttribute('data-filter');
                renderTasks();
            });
        });

        // ==========================================
        // MODAL MANAGEMENT
        // ==========================================
        function openModal(modal) {
            modal.classList.remove('hidden');
        }

        function closeAllModals() {
            modalCreate.classList.add('hidden');
            modalEdit.classList.add('hidden');
            modalDelete.classList.add('hidden');
            modalProfile.classList.add('hidden');
        }

        document.querySelectorAll('.btn-close-modal').forEach(btn => {
            btn.addEventListener('click', closeAllModals);
        });

        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.addEventListener('click', closeAllModals);
        });

        btnOpenCreateModal.addEventListener('click', () => {
            formCreateTask.reset();
            hideCreateErrors();
            openModal(modalCreate);
        });

        btnEmptyCreate.addEventListener('click', () => {
            formCreateTask.reset();
            hideCreateErrors();
            openModal(modalCreate);
        });

        // Escape key closes modals
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeAllModals();
        });

        // Error helper
        function hideCreateErrors() {
            document.getElementById('error-create-title').classList.add('hidden');
            document.getElementById('error-create-deadline').classList.add('hidden');
        }
        function hideEditErrors() {
            document.getElementById('error-edit-title').classList.add('hidden');
            document.getElementById('error-edit-deadline').classList.add('hidden');
        }

        // ==========================================
        // FORM SUBMISSION: CREATE TASK
        // ==========================================
        formCreateTask.addEventListener('submit', async (e) => {
            e.preventDefault();
            hideCreateErrors();

            const title = document.getElementById('create-title').value.trim();
            const deadline = document.getElementById('create-deadline').value || null;

            const submitBtn = document.getElementById('btn-submit-create');
            const spinner = document.getElementById('spinner-create');

            submitBtn.disabled = true;
            spinner.classList.remove('hidden');

            try {
                const response = await window.AppAPI.createTask({ title, deadline });
                closeAllModals();
                window.showToast('Tugas baru berhasil disimpan!', 'success');
                await fetchAndRenderTasks();
            } catch (err) {
                if (err.errors) {
                    if (err.errors.title) {
                        const el = document.getElementById('error-create-title');
                        el.textContent = err.errors.title[0];
                        el.classList.remove('hidden');
                    }
                    if (err.errors.deadline) {
                        const el = document.getElementById('error-create-deadline');
                        el.textContent = err.errors.deadline[0];
                        el.classList.remove('hidden');
                    }
                }
                window.showToast(err.message || 'Gagal menyimpan tugas baru.', 'error');
            } finally {
                submitBtn.disabled = false;
                spinner.classList.add('hidden');
            }
        });

        // ==========================================
        // FORM SUBMISSION: EDIT TASK
        // ==========================================
        formEditTask.addEventListener('submit', async (e) => {
            e.preventDefault();
            hideEditErrors();

            const id = document.getElementById('edit-id').value;
            const title = document.getElementById('edit-title').value.trim();
            const deadline = document.getElementById('edit-deadline').value || null;

            const submitBtn = document.getElementById('btn-submit-edit');
            const spinner = document.getElementById('spinner-edit');

            submitBtn.disabled = true;
            spinner.classList.remove('hidden');

            try {
                await window.AppAPI.updateTask(id, { title, deadline });
                closeAllModals();
                window.showToast('Data tugas berhasil diperbarui!', 'success');
                await fetchAndRenderTasks();
            } catch (err) {
                if (err.errors) {
                    if (err.errors.title) {
                        const el = document.getElementById('error-edit-title');
                        el.textContent = err.errors.title[0];
                        el.classList.remove('hidden');
                    }
                    if (err.errors.deadline) {
                        const el = document.getElementById('error-edit-deadline');
                        el.textContent = err.errors.deadline[0];
                        el.classList.remove('hidden');
                    }
                }
                window.showToast(err.message || 'Gagal memperbarui data tugas.', 'error');
            } finally {
                submitBtn.disabled = false;
                spinner.classList.add('hidden');
            }
        });

        // ==========================================
        // CONFIRM DELETE
        // ==========================================
        btnConfirmDelete.addEventListener('click', async () => {
            if (!taskToDeleteId) return;

            const spinner = document.getElementById('spinner-delete');
            btnConfirmDelete.disabled = true;
            spinner.classList.remove('hidden');

            try {
                await window.AppAPI.deleteTask(taskToDeleteId);
                closeAllModals();
                window.showToast('Tugas berhasil dihapus permanen.', 'success');
                await fetchAndRenderTasks();
            } catch (err) {
                window.showToast(err.message || 'Gagal menghapus tugas.', 'error');
            } finally {
                btnConfirmDelete.disabled = false;
                spinner.classList.add('hidden');
                taskToDeleteId = null;
            }
        });

        // Initial Load
        await fetchAndRenderTasks();
    });
</script>
@endpush
