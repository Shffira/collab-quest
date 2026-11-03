# Kontrak API: CollabQuest To-Do List

Dokumen ini mendefinisikan spesifikasi kontrak antarmuka API antara **Peran A (Backend)** dan **Peran B (Frontend)**. Kontrak ini menjadi acuan tunggal agar pengembangan backend dan frontend dapat berjalan secara paralel dan independen.

---

## 1. Ikhtisar & Arsitektur

- **Base URL API**: `/api`
- **Autentikasi**: Laravel Sanctum (Bearer Token pada HTTP Header `Authorization`)
- **Format Pertukaran Data**: JSON (`Content-Type: application/json`, `Accept: application/json`)
- **Format Tanggal**: ISO 8601 atau format tanggal standar `YYYY-MM-DD`

---

## 2. Ringkasan Endpoint

| Method | Endpoint | Autentikasi | Deskripsi |
| :--- | :--- | :--- | :--- |
| `POST` | `/api/register` | Publik | Registrasi akun pengguna baru |
| `POST` | `/api/login` | Publik | Otentikasi & pembuatan bearer token |
| `GET` | `/api/profile` | Bearer Token | Mengambil data profil pengguna yang sedang login |
| `POST` | `/api/logout` | Bearer Token | Menghapus token aktif (logout) |
| `GET` | `/api/tasks` | Bearer Token | Mengambil seluruh daftar tugas milik pengguna |
| `POST` | `/api/tasks` | Bearer Token | Membuat tugas baru |
| `PUT` | `/api/tasks/{id}` | Bearer Token | Memperbarui data tugas (judul / deadline) |
| `PATCH` | `/api/tasks/{id}/status` | Bearer Token | Memperbarui status tugas (`todo` atau `done`) |
| `DELETE` | `/api/tasks/{id}` | Bearer Token | Menghapus tugas |

---

## 3. Spesifikasi Detail Endpoint

### 3.1. Register Pengguna
- **Method**: `POST`
- **URL**: `/api/register`
- **Header**:
  - `Content-Type: application/json`
  - `Accept: application/json`
- **Request Body**:
```json
{
  "name": "Ahmad Raihan",
  "email": "raihan@sekolah.sch.id",
  "password": "password123"
}
```
- **Validasi**:
  - `name`: Wajib (string, maksimal 100 karakter)
  - `email`: Wajib (email valid, unik pada tabel users)
  - `password`: Wajib (string, minimal 8 karakter)
- **Response Sukses (201 Created)**:
```json
{
  "message": "Register berhasil",
  "data": {
    "id": 1,
    "name": "Ahmad Raihan",
    "email": "raihan@sekolah.sch.id",
    "created_at": "2026-11-03T09:40:00.000000Z"
  }
}
```
- **Response Gagal Validasi (422 Unprocessable Entity)**:
```json
{
  "message": "Data registrasi yang diberikan tidak valid.",
  "errors": {
    "email": ["Email sudah terdaftar."],
    "password": ["Kata sandi minimal harus 8 karakter."]
  }
}
```

---

### 3.2. Login Pengguna
- **Method**: `POST`
- **URL**: `/api/login`
- **Header**:
  - `Content-Type: application/json`
  - `Accept: application/json`
- **Request Body**:
```json
{
  "email": "raihan@sekolah.sch.id",
  "password": "password123"
}
```
- **Validasi**:
  - `email`: Wajib (email valid)
  - `password`: Wajib (string)
- **Response Sukses (200 OK)**:
```json
{
  "message": "Login berhasil",
  "token": "1|sanctum_plain_text_token_string_here",
  "user": {
    "id": 1,
    "name": "Ahmad Raihan",
    "email": "raihan@sekolah.sch.id"
  }
}
```
- **Response Gagal Autentikasi (401 Unauthorized)**:
```json
{
  "message": "Email atau password salah"
}
```

---

### 3.3. Profil Pengguna
- **Method**: `GET`
- **URL**: `/api/profile`
- **Header**:
  - `Authorization: Bearer <token>`
  - `Accept: application/json`
- **Response Sukses (200 OK)**:
```json
{
  "data": {
    "id": 1,
    "name": "Ahmad Raihan",
    "email": "raihan@sekolah.sch.id",
    "email_verified_at": null,
    "created_at": "2026-11-03T09:40:00.000000Z",
    "updated_at": "2026-11-03T09:40:00.000000Z"
  }
}
```
- **Response Tanpa Token / Token Kedaluwarsa (401 Unauthorized)**:
```json
{
  "message": "Unauthenticated."
}
```

---

### 3.4. Logout Pengguna
- **Method**: `POST`
- **URL**: `/api/logout`
- **Header**:
  - `Authorization: Bearer <token>`
  - `Accept: application/json`
- **Response Sukses (200 OK)**:
```json
{
  "message": "Logout berhasil"
}
```

---

### 3.5. Ambil Daftar Tugas (Index)
- **Method**: `GET`
- **URL**: `/api/tasks`
- **Header**:
  - `Authorization: Bearer <token>`
  - `Accept: application/json`
- **Response Sukses (200 OK)**:
```json
{
  "data": [
    {
      "id": 1,
      "user_id": 1,
      "title": "Sepakati kontrak API dan buat dokumentasi",
      "deadline": "2026-11-05",
      "status": "done",
      "created_at": "2026-11-03T09:45:00.000000Z",
      "updated_at": "2026-11-03T10:15:00.000000Z"
    },
    {
      "id": 2,
      "user_id": 1,
      "title": "Membangun tampilan dashboard To-Do List",
      "deadline": "2026-11-08",
      "status": "todo",
      "created_at": "2026-11-03T10:20:00.000000Z",
      "updated_at": "2026-11-03T10:20:00.000000Z"
    }
  ]
}
```

---

### 3.6. Tambah Tugas Baru (Store)
- **Method**: `POST`
- **URL**: `/api/tasks`
- **Header**:
  - `Authorization: Bearer <token>`
  - `Content-Type: application/json`
  - `Accept: application/json`
- **Request Body**:
```json
{
  "title": "Menyelesaikan integrasi mock data dan API asli",
  "deadline": "2026-11-10"
}
```
- **Validasi**:
  - `title`: Wajib (string, maksimal 255 karakter)
  - `deadline`: Opsional (format tanggal `YYYY-MM-DD`)
- **Response Sukses (201 Created)**:
```json
{
  "message": "Tugas dibuat",
  "data": {
    "id": 3,
    "user_id": 1,
    "title": "Menyelesaikan integrasi mock data dan API asli",
    "deadline": "2026-11-10",
    "status": "todo",
    "created_at": "2026-11-03T11:00:00.000000Z",
    "updated_at": "2026-11-03T11:00:00.000000Z"
  }
}
```

---

### 3.7. Ubah Data Tugas (Update)
- **Method**: `PUT`
- **URL**: `/api/tasks/{id}`
- **Header**:
  - `Authorization: Bearer <token>`
  - `Content-Type: application/json`
  - `Accept: application/json`
- **Request Body**:
```json
{
  "title": "Menyelesaikan integrasi mock data dan API asli (Revisi)",
  "deadline": "2026-11-12"
}
```
- **Response Sukses (200 OK)**:
```json
{
  "message": "Tugas diubah",
  "data": {
    "id": 3,
    "user_id": 1,
    "title": "Menyelesaikan integrasi mock data dan API asli (Revisi)",
    "deadline": "2026-11-12",
    "status": "todo",
    "created_at": "2026-11-03T11:00:00.000000Z",
    "updated_at": "2026-11-03T11:05:00.000000Z"
  }
}
```
- **Response Bukan Pemilik Tugas (403 Forbidden)**:
```json
{
  "message": "Anda tidak berhak mengakses tugas ini"
}
```

---

### 3.8. Ubah Status Tugas (Update Status)
- **Method**: `PATCH`
- **URL**: `/api/tasks/{id}/status`
- **Header**:
  - `Authorization: Bearer <token>`
  - `Content-Type: application/json`
  - `Accept: application/json`
- **Request Body**:
```json
{
  "status": "done"
}
```
- **Validasi**:
  - `status`: Wajib (`in:todo,done`)
- **Response Sukses (200 OK)**:
```json
{
  "message": "Status diubah",
  "data": {
    "id": 3,
    "user_id": 1,
    "title": "Menyelesaikan integrasi mock data dan API asli",
    "deadline": "2026-11-10",
    "status": "done",
    "created_at": "2026-11-03T11:00:00.000000Z",
    "updated_at": "2026-11-03T11:10:00.000000Z"
  }
}
```

---

### 3.9. Hapus Tugas (Destroy)
- **Method**: `DELETE`
- **URL**: `/api/tasks/{id}`
- **Header**:
  - `Authorization: Bearer <token>`
  - `Accept: application/json`
- **Response Sukses (200 OK)**:
```json
{
  "message": "Tugas dihapus"
}
```

---

## 4. Implementasi Mock pada Frontend

Sesuai instruksi alur kerja paralel:
1. Frontend mengimplementasikan adapter mock terpusat di `resources/js/api.js`.
2. Mock mensimulasikan latency jaringan riil (300ms - 400ms) untuk menguji visual loading state (`animate-pulse` dan indikator putar SVG).
3. Mock menyimpan data secara interaktif dan persisten pada `localStorage` browser.
4. Ketika Backend siap, Frontend dapat beralih ke Backend API Nyata kapan saja melalui switcher antarmuka atau konfigurasi mode.
