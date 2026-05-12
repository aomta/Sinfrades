# 🌐 Sistem Manajemen Infrastruktur Desa

Sistem Manajemen Infrastruktur Desa adalah aplikasi berbasis web yang digunakan untuk membantu pengelolaan sarana dan prasarana desa secara digital.  
Aplikasi ini mendukung pelaporan kerusakan, pengajuan pembangunan, maintenance infrastruktur, pengelolaan anggaran, serta manajemen pengguna berdasarkan role.

---

# ✨ Fitur Utama

## 👥 Role Pengguna
### 1. Admin
- Mengelola seluruh data sistem
- Mengelola user
- Verifikasi laporan kerusakan
- Mengatur status pengajuan pembangunan
- CRUD data infrastruktur
- CRUD maintenance
- CRUD anggaran

### 2. Petugas
- Mengelola maintenance
- Mengelola data infrastruktur
- Verifikasi laporan kerusakan

### 3. Warga
- Melihat data infrastruktur
- Mengirim laporan kerusakan
- Mengajukan pembangunan
- Melihat status laporan & pengajuan

---

# 🏗️ Modul Sistem

## 📌 Infrastruktur
- Tambah data infrastruktur
- Edit data
- Hapus data
- Detail infrastruktur
- Filter kategori & kondisi

Kategori:
- Jalan
- Jembatan
- Drainase
- Irigasi
- Lampu Jalan
- Gedung Desa
- Posyandu
- Sekolah
- Tempat Ibadah
- Sanitasi Umum
- Air Bersih

---

## 🚨 Laporan Kerusakan
- Upload laporan kerusakan
- Upload foto kerusakan
- Status laporan:
  - Menunggu
  - Diproses
  - Selesai
- Edit & hapus laporan

---

## 🛠️ Maintenance
- Data perawatan infrastruktur
- Hasil pemeriksaan
- Catatan maintenance
- Kondisi setelah maintenance

---

## 💰 Anggaran
- Pemasukan
- Pengeluaran
- Rekap anggaran
- Sisa anggaran
- Filter bulan & tahun

---

## 🏗️ Pengajuan Pembangunan
- Pengajuan proyek pembangunan
- Prioritas pembangunan
- Estimasi biaya
- Status pengajuan

---

## 👤 Manajemen User
- Data warga
- Data admin

---

# 🛠️ Tech Stack

- PHP 8+
- Laravel 10
- Bootstrap 5
- MySQL
- Laragon
- Railway (Deployment)

---

# 📂 Struktur Folder Penting

```bash
app/
├── Http/Controllers
├── Models

resources/views/
├── infrastruktur
├── laporan
├── maintenance
├── pengajuan
├── anggaran
├── users

routes/
└── web.php
```

---

# ⚙️ Instalasi

## 1. Clone Repository

```bash
git clone https://github.com/username/nama-repository.git
```

---

## 2. Masuk Folder Project

```bash
cd nama-repository
```

---

## 3. Install Dependency

```bash
composer install
```

---

## 4. Copy File Environment

```bash
cp .env.example .env
```

---

## 5. Generate Key

```bash
php artisan key:generate
```

---

## 6. Konfigurasi Database

Edit file `.env`

```env
DB_DATABASE=db_desa_inf
DB_USERNAME=root
DB_PASSWORD=
```

---

## 7. Migrasi Database

```bash
php artisan migrate
```

---

## 8. Seeder Admin

```bash
php artisan db:seed
```

---

## 9. Jalankan Server

```bash
php artisan serve
```

---

# 🔑 Akun Default Admin

```txt
Email    : admin@gmail.com
Password : password
```

---

---

# 🚀 Deployment

Project dapat di-deploy menggunakan:
- Railway

---

# 📄 License

Project ini dibuat untuk kebutuhan pembelajaran dan pengembangan sistem desa digital.

---

# 👨‍💻 Developer

Developed using Laravel & Bootstrap.
