<div align="center">

# 🏭 WMS — Sistem Manajemen Gudang

### Warehouse Management System berbasis Laravel 13 + Bootstrap 5

[![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat-square&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

</div>

---

## 📖 Tentang Proyek

**WMS (Warehouse Management System)** adalah aplikasi web untuk mengelola operasional gudang secara digital. Aplikasi ini dibangun dengan **Laravel 13**, **Bootstrap 5**, dan **Chart.js**, dilengkapi dengan antarmuka berbahasa Indonesia yang modern dan responsif.

### ✨ Fitur Utama

| Modul | Deskripsi |
|-------|-----------|
| 📊 **Dashboard** | Ringkasan metrik (total produk, transaksi bulan ini, stok menipis), grafik aliran stok 6 bulan, distribusi kategori, transaksi terakhir |
| 📦 **Manajemen Produk** | CRUD produk dengan kode unik, satuan, lokasi rak, stok minimum, pencarian & filter kategori |
| 🏷️ **Manajemen Kategori** | CRUD kategori dengan proteksi penghapusan jika masih memiliki produk |
| 📥 **Barang Masuk (Stock In)** | Pencatatan transaksi masuk, auto-generate nomor transaksi, cetak struk, pembatalan dengan reverse stok |
| 📤 **Barang Keluar (Stock Out)** | Pencatatan transaksi keluar, validasi stok cukup, cetak struk, pembatalan dengan reverse stok |
| 📈 **Pemantauan Stok** | Monitoring stok real-time dengan filter status (Safe 🟢 / Warning 🟡 / Out of Stock 🔴), API notifikasi stok menipis |
| 📄 **Laporan** | Filter berdasarkan jenis/tanggal/kategori, pratinjau, export CSV (Excel), dan cetak/print PDF |
| 👤 **Profil** | Edit informasi akun, ganti kata sandi, hapus akun |
| 🔔 **Notifikasi** | Bell icon di topbar dengan notifikasi stok menipis secara dinamis |

### 🛠️ Tech Stack

- **Backend:** Laravel 13.x (PHP 8.3+)
- **Frontend:** Bootstrap 5.3, Bootstrap Icons, Chart.js, Alpine.js
- **Database:** SQLite (default) / MySQL / PostgreSQL
- **Auth:** Laravel Breeze
- **Build Tool:** Vite 8.x
- **CSS:** Tailwind CSS (untuk halaman auth Breeze) + Custom CSS Bootstrap

---

## 📋 Prasyarat

Sebelum menginstal, pastikan komputer Anda telah terpasang:

| Software | Versi Minimum | Cek Versi |
|----------|---------------|-----------|
| **PHP** | 8.3+ | `php -v` |
| **Composer** | 2.x | `composer -V` |
| **Node.js** | 18.x+ | `node -v` |
| **npm** | 9.x+ | `npm -v` |
| **Git** | 2.x | `git --version` |
| **VS Code** | terbaru | — |

> 💡 **Ekstensi PHP yang wajib aktif:** `pdo`, `pdo_sqlite` (atau `pdo_mysql`), `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`.

---

## 🚀 Panduan Instalasi di VS Code

### Langkah 1 — Clone Repository

Buka **Terminal** di VS Code (`Ctrl + ~`) lalu jalankan:

```bash
git clone https://github.com/USERNAME/warehouse-management-system.git
cd warehouse-management-system
```

Atau gunakan VS Code Command Palette (`Ctrl + Shift + P`):

```
> Git: Clone
```

Masukkan URL repository, lalu pilih folder tujuan.

---

### Langkah 2 — Buka Project di VS Code

```bash
code .
```

Atau buka VS Code → **File → Open Folder** → pilih folder `warehouse-management-system`.

---

### Langkah 3 — Install Dependency PHP

```bash
composer install
```

> Jika muncul error terkait versi PHP, pastikan PHP 8.3+ sudah terpasang dan terdaftar di PATH sistem.

---

### Langkah 4 — Install Dependency Frontend

```bash
npm install
```

---

### Langkah 5 — Konfigurasi Environment

Salin file environment:

```bash
cp .env.example .env      # Linux / macOS
copy .env.example .env    # Windows CMD / PowerShell
```

Generate application key:

```bash
php artisan key:generate
```

> File `.env` sudah dikonfigurasi dengan **SQLite** sebagai database default. Tidak perlu setup database tambahan.

#### (Opsional) Konfigurasi Database MySQL

Jika ingin menggunakan MySQL, edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wms_gudang
DB_USERNAME=root
DB_PASSWORD=
```

Buat database terlebih dahulu via phpMyAdmin atau MySQL CLI:

```sql
CREATE DATABASE wms_gudang;
```

---

### Langkah 6 — Jalankan Migration & Seeder

```bash
php artisan migrate --seed
```

Perintah ini akan:
- Membuat semua tabel database (users, categories, products, stock_ins, stock_outs, dll.)
- Mengisi data dummy: 5 kategori, 13 produk, transaksi masuk/keluar 6 bulan terakhir
- Membuat akun administrator

---

### Langkah 7 — Build Asset Frontend

```bash
npm run build
```

> Untuk development dengan auto-reload, gunakan `npm run dev` (Vite akan berjalan di background).

---

### Langkah 8 — Jalankan Server

```bash
php artisan serve
```

Buka browser dan akses:

```
http://localhost:8000
```

### 🔑 Akun Login Default

| Field | Value |
|-------|-------|
| **Email** | `admin@wms.co.id` |
| **Password** | `password123` |

---

## ⚡ Cara Cepat (One-Command Setup)

Laravel menyediakan script setup otomatis yang menjalankan semua langkah di atas sekaligus:

```bash
composer run setup
```

Kemudian jalankan server:

```bash
php artisan serve
```

---

## 🧑‍💻 Rekomendasi Ekstensi VS Code

Buka **Extensions** (`Ctrl + Shift + X`) dan install ekstensi berikut untuk pengalaman development terbaik:

| Ekstensi | ID | Fungsi |
|----------|----|--------|
| **PHP Intelephense** | `bmewburn.vscode-intelephense-client` | Autocomplete, IntelliSense, refactoring PHP |
| **Laravel Blade Snippets** | `onecentlin.laravel-blade` | Snippet & syntax highlighting Blade |
| **Laravel Artisan** | `ryannaddy.laravel-artisan` | Jalankan perintah Artisan dari Command Palette |
| **Laravel goto view** | `codingyu.laravel-goto-view` | Navigasi cepat ke file view Blade |
| **Tailwind CSS IntelliSense** | `bradlc.vscode-tailwindcss` | Autocomplete class Tailwind |
| **Live Server** | `ritwickdey.liveserver` | Preview perubahan frontend real-time |
| **GitLens** | `eamodio.gitlens` | Visualisasi Git yang powerful |
| **Prettier** | `esbenp.prettier-vscode` | Code formatter untuk JS/CSS/Blade |
| **SQLite Viewer** | `qwtel.sqlite-viewer` | Lihat database SQLite langsung di VS Code |

---

## 📂 Struktur Project

```
warehouse-management-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Controller (Dashboard, Product, StockIn, dll.)
│   │   └── Requests/          # Form Request validation
│   ├── Models/                # Eloquent Models (Product, Category, StockIn, dll.)
│   ├── Providers/             # Service Providers
│   └── Services/
│       └── InventoryService.php   # Logika bisnis transaksi stok
├── database/
│   ├── migrations/            # Skema database
│   └── seeders/               # Data dummy
├── resources/
│   ├── css/                   # Tailwind CSS (untuk halaman auth)
│   ├── js/                    # Alpine.js
│   └── views/                 # Blade templates (Bootstrap 5)
│       ├── layouts/           # app.blade.php, guest.blade.php
│       ├── dashboard.blade.php
│       ├── products/          # CRUD produk
│       ├── categories/        # CRUD kategori
│       ├── stock-in/          # Transaksi masuk + receipt
│       ├── stock-out/         # Transaksi keluar + receipt
│       ├── inventory/         # Pemantauan stok
│       ├── reports/           # Laporan + print
│       └── auth/              # Login, register, dll.
├── routes/
│   ├── web.php                # Route aplikasi
│   └── auth.php               # Route autentikasi
├── config/                    # Konfigurasi Laravel
├── public/                    # Asset publik (logo, build)
└── .env                       # Konfigurasi environment
```

---

## 🖥️ Perintah Berguna

| Perintah | Fungsi |
|----------|--------|
| `php artisan serve` | Jalankan development server |
| `php artisan migrate --seed` | Migrasi & isi data dummy |
| `php artisan migrate:fresh --seed` | Reset database & isi ulang data |
| `php artisan tinker` | REPL interaktif Laravel |
| `php artisan route:list` | Lihat daftar semua route |
| `php artisan make:model NamaModel` | Generate model baru |
| `php artisan make:controller NamaController` | Generate controller baru |
| `npm run dev` | Jalankan Vite (hot reload) |
| `npm run build` | Build asset untuk production |
| `php artisan test` | Jalankan test suite |
| `php artisan optimize` | Cache config & route (production) |
| `php artisan config:clear` | Hapus cache config |

---

## 🔧 Development Workflow

### Mode Development (dengan auto-reload)

Jalankan semua service sekaligus menggunakan script `dev`:

```bash
composer run dev
```

Perintah ini akan menjalankan secara paralel:
- 🌐 **Server** Laravel (`php artisan serve`)
- 🔄 **Queue** worker
- 📋 **Log** viewer (Pail)
- ⚡ **Vite** dev server (hot reload)

### Mode Production

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan serve
```

---

## 📸 Screenshot

> Tambahkan screenshot aplikasi di folder `public/screenshots/` dan referensikan di sini.

```
![Dashboard](public/screenshots/dashboard.png)
![Products](public/screenshots/products.png)
![Stock In](public/screenshots/stock-in.png)
```

---

## ❓ Troubleshooting

<details>
<summary><b>Error: "No application encryption key has been specified"</b></summary>

Jalankan perintah berikut:

```bash
php artisan key:generate
```
</details>

<details>
<summary><b>Error: "could not find driver" (database)</b></summary>

Pastikan ekstensi PHP database sudah aktif di `php.ini`:
- Untuk SQLite: aktifkan `extension=pdo_sqlite`
- Untuk MySQL: aktifkan `extension=pdo_mysql`

Cek dengan:
```bash
php -m | findstr pdo
```
</details>

<details>
<summary><b>Error: "composer install" gagal</b></summary>

Pastikan PHP 8.3+ terpasang:
```bash
php -v
```

Jika versi tidak sesuai, update PHP atau gunakan [XAMPP](https://www.apachefriends.org/) / [Laragon](https://laragon.org/).
</details>

<details>
<summary><b>Error: "npm install" gagal</b></summary>

Pastikan Node.js 18+ terpasang:
```bash
node -v
```

Update npm:
```bash
npm install -g npm@latest
```
</details>

<details>
<summary><b>Halaman blank / asset tidak termuat</b></summary>

Build ulang asset frontend:
```bash
npm run build
```

Atau jalankan Vite dev server:
```bash
npm run dev
```
</details>

<details>
<summary><b>Cara reset database ke kondisi awal</b></summary>

```bash
php artisan migrate:fresh --seed
```

Perintah ini menghapus semua tabel, membuat ulang, dan mengisi data dummy.
</details>

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Untuk berkontribusi:

1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/nama-fitur`)
3. Commit perubahan (`git commit -m 'Tambah fitur baru'`)
4. Push ke branch (`git push origin feature/nama-fitur`)
5. Buat **Pull Request**

---

## 📝 License

Proyek ini bersifat open-source di bawah lisensi [MIT](https://opensource.org/licenses/MIT).

---

<div align="center">

**Dibuat dengan ❤️ menggunakan Laravel + Bootstrap 5**

</div>
