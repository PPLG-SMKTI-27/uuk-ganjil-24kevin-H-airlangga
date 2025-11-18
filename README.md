Berikut adalah file **README.md** yang sudah disesuaikan untuk project **Buku Tamu Digital SMK TI Airlangga**:

**README.md**
```markdown
# Buku Tamu Digital - SMK TI Airlangga

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

## 📋 Tentang Project

Aplikasi **Buku Tamu Digital** adalah sistem manajemen kunjungan tamu yang dikembangkan untuk SMK TI Airlangga. Aplikasi ini digunakan untuk mencatat dan mengelola kunjungan tamu seperti orang tua siswa, calon siswa, mahasiswa penelitian, dan tamu lainnya.

### ✨ Fitur Utama

- **🔐 Sistem Autentikasi** - Login dengan role-based access (Admin & Staff TU)
- **👥 Manajemen Data Tamu** - Input, edit, dan hapus data tamu
- **📊 Dashboard Analytics** - Statistik kunjungan harian/bulanan
- **📋 Kategorisasi Tamu** - Berdasarkan jenis kunjungan (Orang Tua, Penelitian, dll)
- **👨‍🏫 Guru Tujuan** - Pencatatan guru yang dituju tamu
- **⏱️ Tracking Waktu** - Pencatatan waktu masuk dan keluar tamu
- **📈 Laporan & Export** - Generate laporan kunjungan
- **🎨 Modern UI** - Interface responsive dengan Tailwind CSS

## 🚀 Teknologi yang Digunakan

- **Backend:** Laravel 10.x
- **Frontend:** Tailwind CSS, Blade Templates
- **Database:** MySQL
- **Authentication:** Custom Session-based
- **Icons:** Font Awesome 6

## 📦 Instalasi & Setup

### Prerequisites
- PHP 8.1+
- Composer
- MySQL 5.7+
- Node.js (untuk assets development)

### Step-by-Step Installation

1. **Clone Repository**
   ```bash
   git clone https://github.com/your-username/buku-tamu-digital.git
   cd buku-tamu-digital
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Database**
   Edit file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=buku_tamu
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Import Database**
   ```bash
   # Import SQL file yang sudah disediakan
   mysql -u root -p buku_tamu < database/buku_tamu.sql
   ```

6. **Build Assets**
   ```bash
   npm run build
   # atau untuk development
   npm run dev
   ```

7. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```

8. **Akses Aplikasi**
   Buka http://localhost:8000

## 👥 Akun Demo

### Admin
- **Email:** kevinadmin@gmail.com
- **Password:** password
- **Akses:** Full access ke semua fitur

### Staff TU
- **Email:** kevintu@gmail.com
- **Password:** password
- **Akses:** Input dan manage data tamu

## 🗃️ Struktur Database

### Tabel Utama
- `pengguna` - Data user sistem
- `peran` - Role user (Admin, Staff TU)
- `tamu` - Data kunjungan tamu
- `guru` - Data guru tujuan
- `jenis_kunjungan` - Kategori kunjungan
- `log_aktivitas` - Audit trail sistem

### Relasi Database
```
pengguna → peran (one to many)
tamu → guru (many to one)
tamu → jenis_kunjungan (many to one)
tamu → pengguna (created_by)
```

## 🎯 Cara Penggunaan

### Untuk Staff TU:
1. Login dengan akun Staff TU
2. Klik "Tambah Tamu" untuk input data kunjungan baru
3. Isi form dengan data tamu yang lengkap
4. Update status kunjungan (proses/selesai/dibatalkan)
5. Lihat riwayat kunjungan di halaman Data Tamu

### Untuk Admin:
1. Login dengan akun Admin
2. Akses dashboard untuk melihat statistik
3. Kelola semua data tamu
4. Manage data guru dan pengguna
5. Generate laporan kunjungan

## 📱 Fitur Mobile
Aplikasi fully responsive dan dapat diakses melalui:
- ✅ Desktop & Laptop
- ✅ Tablet
- ✅ Smartphone

## 🔧 Development

### Menjalankan Development Server
```bash
php artisan serve
npm run dev
```

### Membuat Migration Baru
```bash
php artisan make:migration nama_migration
```

### Membuat Model & Controller
```bash
php artisan make:model NamaModel
php artisan make:controller NamaController
```

### Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## 📄 API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/tamu` | Get semua data tamu |
| POST | `/api/tamu` | Create data tamu baru |
| GET | `/api/tamu/{id}` | Get detail tamu |
| PUT | `/api/tamu/{id}` | Update data tamu |
| DELETE | `/api/tamu/{id}` | Delete data tamu |

## 🤝 Kontribusi

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📞 Support

Jika mengalami kendala atau memiliki pertanyaan, silakan hubungi:

- **Email:** support@smktiairlangga.sch.id
- **Issues:** [GitHub Issues](https://github.com/your-username/buku-tamu-digital/issues)

## 📝 License

Project ini dilisensikan di bawah MIT License - lihat file [LICENSE](LICENSE) untuk detail lengkap.

## 👨‍💻 Developer

Dikembangkan oleh **Tim Developer SMK TI Airlangga**

---

<div align="center">
  
### 📊 Statistik Project

![GitHub last commit](https://img.shields.io/github/last-commit/your-username/buku-tamu-digital)
![GitHub issues](https://img.shields.io/github/issues/your-username/buku-tamu-digital)
![GitHub pull requests](https://img.shields.io/github/issues-pr/your-username/buku-tamu-digital)

**⭐ Jangan lupa beri star jika project ini membantu!**

</div>
```

## 📁 File README.md Lainnya (Opsional)

**CONTRIBUTING.md**
```markdown
# Pedoman Kontribusi

## Cara Berkontribusi
1. Fork repository ini
2. Buat branch fitur (`git checkout -b feature/nama-fitur`)
3. Commit perubahan (`git commit -m 'Menambah fitur baru'`)
4. Push ke branch (`git push origin feature/nama-fitur`)
5. Buat Pull Request

## Standar Kode
- Gunakan PSR-12 coding standard
- Tulis dokumentasi yang jelas
- Test sebelum submit PR
```

**CHANGELOG.md**
```markdown
# Changelog

## [1.0.0] - 2024-XX-XX
### Added
- Sistem autentikasi custom
- CRUD data tamu
- Dashboard dengan statistik
- Management guru tujuan
- Export laporan

### Fixed
- Bug session management
- Responsive design issues
```

File README.md ini sudah mencakup semua informasi penting tentang project Buku Tamu Digital dan siap untuk digunakan di repository GitHub Anda!
