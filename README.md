# CollabQuest - Collaborative To-Do List Application

Aplikasi manajemen daftar tugas kolaboratif berbasis **Laravel 11/12**, **Blade**, **Tailwind CSS**, dan **Vanilla JavaScript (Fetch API)**. Proyek ini dibangun dengan menerapkan alur kerja paralel antara **Peran A (Backend)** dan **Peran B (Frontend)** menggunakan acuan kontrak API terpusat.

---

## Informasi Anggota & Peran

- **Repository**: [https://github.com/Shffira/collab-quest](https://github.com/Shffira/collab-quest)
- **Peran A (Backend)**: Raihanmul (`feat/backend`) - API Laravel Sanctum, Migration, Controller, Swagger OpenAPI.
- **Peran B (Frontend)**: Twins / Shffira (`feat/Frontend`) - Desain UI/UX Sage Minimalist, Blade Views, JavaScript Fetch Client Terpusat, Integrasi Mock & API Nyata.

---

## Panduan Instalasi & Menjalankan

### 1. Prasyarat Sistem
- PHP >= 8.2
- Composer
- Node.js >= 18 & npm

### 2. Langkah Instalasi

```bash
# 1. Clone repositori
git clone https://github.com/Shffira/collab-quest.git
cd collab-quest

# 2. Checkout ke branch frontend
git checkout feat/Frontend

# 3. Instal dependensi PHP & JavaScript
composer install
npm install

# 4. Salin berkas lingkungan & generate application key
cp .env.example .env
php artisan key:generate

# 5. Kompilasi aset Vite
npm run build
# atau untuk mode pengembangan (hot reload):
# npm run dev

# 6. Jalankan server lokal Laravel
php artisan serve
```

Aplikasi dapat diakses melalui peramban web di: `http://127.0.0.1:8000`

---

## Fitur & Implementasi Frontend (Peran B)

Antarmuka dirancang dengan pendekatan **Sage & Forest Minimalist** (mengacu pada referensi desain palet natural), tampilan bersih, tipografi modern, dan **tanpa emoji** (seluruh ikon menggunakan SVG murni).

1. **Halaman Autentikasi**:
   - **Login Pengguna** (`/login`): Dilengkapi validasi form, penanganan error 401 & 422, fitur tombol cepat *Isi Otomatis Akun Demo*, dan visibilitas password.
   - **Registrasi Akun Baru** (`/register`): Formulir pendaftaran akun dengan validasi field nama, email, dan kata sandi minimal 8 karakter.
2. **Dashboard Manajemen Tugas** (`/dashboard` atau `/`):
   - **Kartu Statistik Ringkas**: Menampilkan total tugas, tugas dalam pengerjaan (todo), tugas selesai (done), serta persentase progres dengan progress bar interaktif.
   - **Filter & Pencarian**: Pencarian judul tugas secara real-time, filter status (*Semua*, *Belum Selesai*, *Selesai*), dan pilihan urutan tugas (*Terbaru*, *Deadline Terdekat*, *Deadline Terjauh*, *Judul A-Z*).
   - **Aksi Tugas Lengkap (CRUD)**:
     - Tambah tugas baru dengan modal formulir.
     - Ubah judul dan batas waktu tugas melalui modal edit.
     - Toggle status cepat (selesai/belum selesai) hanya dengan satu klik pada tombol centang.
     - Hapus tugas dengan konfirmasi dialog modal yang aman.
3. **Kondisi Antarmuka Komprehensif**:
   - **Loading State**: Animasi *skeleton shimmer* (`animate-pulse`) saat memuat data dan ikon putar pada tombol aksi.
   - **Empty State**: Tampilan grafis SVG minimalis ketika belum ada tugas atau hasil filter kosong.
   - **Validasi & Error Handling**: Penanda kesalahan pada masing-masing field form dan banner notifikasi toast.
   - **Sistem Toast Notifikasi**: Umpan balik visual dinamis untuk setiap aksi sukses atau gagal.
4. **Adapter API Terpusat (`resources/js/api.js`)**:
   - Berfungsi sebagai jembatan independen yang mengabstraksi komunikasi data.
   - Mendukung **dua mode operasional**:
     - **Mode Mock**: Menyimpan dan memanipulasi data di `localStorage` peramban, mensimulasikan latensi jaringan (350ms) agar transisi loading terlihat nyata, dan memvalidasi input sesuai aturan Laravel.
     - **Mode Backend Nyata (Sanctum)**: Mengirimkan permintaan HTTP `fetch` ke endpoint `/api/...` dengan menyertakan header `Authorization: Bearer <token>`.
   - Tersedia tombol switcher mode langsung pada navigasi atas dan modal profil pengguna.

---

## Evaluasi & Jawaban Tugas (Langkah 04)

### 1. Apa perbedaan mock dan API nyata?

| Aspek | Mock API | API Nyata (Real Backend) |
| :--- | :--- | :--- |
| **Lokasi Eksekusi** | Berjalan di sisi klien (in-memory / `localStorage` peramban) tanpa server backend. | Berjalan di server backend (Laravel) dan berkomunikasi melalui protokol jaringan HTTP/HTTPS. |
| **Penyimpanan Data** | Bersifat lokal pada peramban pengguna; tidak terdistribusi antar perangkat atau akun pengguna lain. | Tersimpan secara persisten pada basis data terpusat (MySQL/PostgreSQL/SQLite) dengan relasi multi-user yang terisolasi. |
| **Autentikasi & Keamanan** | Mensimulasikan format token secara lokal untuk pengujian alur UI, tanpa verifikasi kriptografi hash server. | Menggunakan sistem token kriptografis riil (Laravel Sanctum) dengan verifikasi hash password, masa berlaku token, dan enkripsi sesi. |
| **Peran dalam Pengembangan** | Memungkinkan tim frontend menyelesaikan seluruh antarmuka, penanganan error, dan visualisasi state tanpa terhambat oleh progress backend. | Menjadi sumber kebenaran data (*single source of truth*) yang siap digunakan di lingkungan produksi (*production*). |

### 2. Perbedaan kontrak apa yang kalian temukan, dan bagaimana menyelesaikannya?

- **Temuan Selisih Kontrak**:
  - Pada diskusi awal, penamaan endpoint daftar tugas dapat berupa `/todos` atau `/tasks`. Backend menyepakati dan menetapkan `/api/tasks`.
  - Struktur respons pembaruan status tugas: terdapat opsi antara `PUT /api/tasks/{id}` yang mengirim seluruh data, atau `PATCH /api/tasks/{id}/status` yang spesifik mengubah field `status`. Backend mengimplementasikan endpoint khusus `PATCH /api/tasks/{id}/status` dengan validasi ketat `in:todo,done`.
  - Format pembungkus data respons: Backend membungkus koleksi tugas di dalam atribut `{ "data": [...] }` dan pesan sukses pada `{ "message": "..." }`.
- **Cara Penyelesaian**:
  - Semua penyesuaian dicatat dan diselaraskan pada dokumen [`docs/kontrak-api.md`](docs/kontrak-api.md).
  - Client terpusat di `resources/js/api.js` disesuaikan agar format mock dan format fetch nyata 100% identik dengan implementasi controller backend (`AuthController` dan `TaskController`).
  - Dengan modul API terpusat, perubahan struktur endpoint backend hanya memerlukan modifikasi pada satu berkas (`api.js`) tanpa perlu mengubah kode komponen Blade di berbagai tempat.

---

## Struktur Berkas Frontend

```
resources/
├── css/
│   └── app.css               # Definisi palet tema Sage & Forest, font, utilitas Tailwind v4
├── js/
│   ├── api.js                # API Client terpusat (Mock Storage + Fetch API Sanctum)
│   └── app.js                # Entry point bundle Vite
└── views/
    ├── layouts/
    │   └── app.blade.php     # Layout utama Blade, sistem toast notifikasi, tanpa emoji
    ├── auth/
    │   ├── login.blade.php   # Tampilan login, demo quick fill, dan switcher mode
    │   └── register.blade.php# Tampilan registrasi pengguna baru
    └── dashboard.blade.php   # Dashboard tugas, statistik, modal CRUD, filter & search
docs/
└── kontrak-api.md            # Dokumentasi spesifikasi kontrak API OpenAPI
```
