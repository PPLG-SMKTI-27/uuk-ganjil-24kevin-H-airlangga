# Changelog

Semua perubahan penting pada project Buku Tamu Digital akan didokumentasikan di file ini.

## [2.0.0] - 2024-01-15

### ✨ Added - Fitur Baru

#### Sistem Notifikasi
- **NotificationController** - Controller baru untuk mengelola notifikasi
- API endpoint `/api/notifications` untuk mengambil daftar notifikasi
- API endpoint `/api/notifications/count` untuk menghitung notifikasi baru
- API endpoint `/api/notifications/{id}/read` untuk tandai notifikasi dibaca
- API endpoint `/api/notifications/read-all` untuk tandai semua notifikasi dibaca
- Notification modal dengan UI yang menarik
- Badge counter dinamis untuk notifikasi baru
- Auto-refresh badge setiap 30 detik
- Icon dinamis berdasarkan status kunjungan
- Notifikasi menampilkan 20 tamu terbaru

#### Sistem Profile
- **ProfileController** - Controller baru untuk mengelola profile pengguna
- API endpoint `/api/profile` untuk mendapatkan data profile
- API endpoint `/api/profile/update` untuk update profile
- API endpoint `/api/profile/change-password` untuk ganti password
- Profile modal dengan 2 mode: View dan Edit
- Form edit profile dengan validasi lengkap
- Fitur ganti password dengan validasi password lama
- Alert system untuk feedback user
- Auto-reload data setelah update berhasil

### 🔧 Changed - Perubahan

#### NotificationController.php
- Menggunakan `tanggal_kunjungan` dan `waktu_masuk` untuk sorting (bukan `created_at`)
- Menambahkan error handling dengan try-catch
- Menambahkan relasi `guru`, `jenisKunjungan`, dan `createdBy`
- Format pesan lebih informatif dengan nama guru tujuan
- Icon dinamis: `user-plus`, `check-circle`, `times-circle`, `clock`

#### Model Pengguna.php
- Menambahkan casting `last_login` sebagai datetime
- Memperbaiki relasi `peran()` dengan foreign key yang benar
- Memperbaiki relasi `tamu()` dengan foreign key yang benar

#### Layout app.blade.php
- Menambahkan CSRF token meta tag untuk AJAX requests
- Update profile modal dengan form edit yang lengkap
- Menambahkan JavaScript untuk handle form submission
- Alert system untuk success/error messages
- Auto-refresh notification badge
- Smooth transition antara View & Edit mode

#### Routes web.php
- Menambahkan route untuk NotificationController
- Menambahkan route untuk ProfileController
- Semua route API diproteksi dengan middleware auth.custom

### 🐛 Fixed - Perbaikan Bug

1. **Fix NotificationController Query**
   - Menghapus `whereNull('deleted_at')` karena model Tamu tidak menggunakan soft delete
   - Menggunakan `tanggal_kunjungan` sebagai ganti `created_at`
   - Menambahkan import `Carbon` yang hilang

2. **Fix ProfileController Auth Issue**
   - Menggunakan `where()->first()` sebagai ganti `find()` untuk model custom
   - Menambahkan proper type casting untuk `$user`
   - Fix method `save()` tidak exist pada interface Authenticatable

3. **Fix Model Relations**
   - Perbaiki relasi Pengguna dengan Peran (foreign key)
   - Perbaiki relasi Pengguna dengan Tamu (foreign key)

4. **Fix CSRF Token**
   - Menambahkan meta tag CSRF token di layout
   - AJAX requests otomatis include CSRF token

5. **Fix Notification Badge**
   - Badge tidak update otomatis → Fixed dengan interval 30 detik
   - Counter tidak akurat → Fixed dengan query yang benar

### 🎨 UI/UX Improvements

#### Notifikasi Modal
- Gradient header (blue to purple)
- Icon dinamis per status
- Badge counter untuk notifikasi belum dibaca
- Background highlight untuk notifikasi baru (bg-blue-50)
- Hover effect pada setiap item
- Loading state & error handling
- Empty state dengan icon dan pesan

#### Profile Modal
- Avatar circle dengan icon user
- Gradient header yang menarik
- Card-style information display
- Smooth transition antara View & Edit mode
- Form dengan Tailwind styling modern
- Alert inline untuk feedback
- Button dengan icon dan loading state
- Responsive untuk semua device

### 📱 Responsive Design
- Modal menyesuaikan ukuran layar (max-h-90vh)
- Padding & spacing optimal untuk semua device
- Form input mudah diisi di mobile
- Button cukup besar untuk touch interaction
- Scroll otomatis jika konten panjang

### 🔒 Security Improvements
- Password di-hash dengan bcrypt
- CSRF protection untuk semua POST request
- Validasi input yang ketat:
  - Nama: Required, max 100 karakter
  - Email: Required, valid format, unique
  - Password: Min 6 karakter, harus ada konfirmasi
- Verifikasi password lama sebelum ganti password baru

### 📚 Documentation
- **FITUR_BARU.md** - Dokumentasi lengkap fitur notifikasi & profile
- **QUICK_START.md** - Panduan cepat untuk pengguna
- **CHANGELOG.md** - File ini, melacak semua perubahan

### 🧪 Testing Notes
- [x] Notifikasi dapat diakses dan menampilkan data
- [x] Badge notifikasi update otomatis
- [x] Profile modal menampilkan data user yang login
- [x] Edit profile (nama & email) berfungsi
- [x] Ganti password berfungsi dengan validasi
- [x] Validasi error ditampilkan dengan benar
- [x] Responsive di mobile dan desktop
- [x] CSRF token berfungsi untuk AJAX requests

---

## [1.0.0] - 2024-01-01

### Added - Initial Release
- Sistem login dan autentikasi
- Dashboard dengan statistik
- CRUD Tamu
- CRUD Guru
- CRUD Jenis Kunjungan
- Public landing page untuk pengajuan kunjungan
- Sidebar navigation
- Tailwind CSS styling
- Chart.js untuk visualisasi data

---

## [2.0.5] - 2024-11-18

### ✨ Added - Log Aktivitas (Audit Trail System)

#### Helper Functions
- **log_activity()** - Helper untuk mencatat aktivitas user
- **get_recent_activities()** - Ambil aktivitas terbaru
- **get_user_activities()** - Ambil aktivitas user tertentu
- File: `app/Helpers/LogHelper.php`

#### LogAktivitasController (NEW)
- Method `index()` - View semua log dengan filter dan pagination
- Method `recent()` - Widget untuk dashboard (10 log terbaru)
- Method `cleanup()` - Hapus log lama otomatis
- Method `export()` - Export log ke CSV format

#### Otomatis Logging Terintegrasi di:
- ✅ **AuthController** - Login & Logout
- ✅ **TamuController** - Create, Update, Delete, Bulk Delete, Update Status
- ✅ **GuruController** - Create, Update, Delete, Reassign & Delete
- ✅ **ProfileController** - Update Profile & Change Password

#### UI Components
- Halaman Log Aktivitas lengkap (`log-aktivitas/index.blade.php`)
- Filter by: User, Date Range, Table, Keyword
- Export to CSV dengan filter
- Cleanup modal untuk hapus log lama
- Menu baru di sidebar: "Log Aktivitas"
- Color-coded badges untuk tabel (tamu=hijau, guru=biru, pengguna=ungu)

### 🔧 Changed - Model & Database

#### LogAktivitas Model
- Aktifkan `timestamps = true`
- Tambah field: `ip_address`, `user_agent`
- Tambah casts untuk datetime
- Relasi ke Pengguna

#### Database Migration
- Tambah kolom `ip_address` (VARCHAR 45)
- Tambah kolom `user_agent` (TEXT)
- Tambah kolom `created_at` & `updated_at` (TIMESTAMP)

### 📊 Data yang Dicatat per Log

Setiap aktivitas otomatis mencatat:
- 👤 User yang melakukan (dari session)
- 📝 Deskripsi aktivitas
- 🗂️ Tabel yang terpengaruh (tamu/guru/pengguna)
- 🔢 ID record yang terkait
- 🌐 IP Address user
- 💻 User Agent (browser/device)
- 🕐 Timestamp (timezone Asia/Makassar)

### 📋 Contoh Log

```
Login ke sistem
Menambah data tamu: John Doe
Mengupdate data tamu: John Doe
Menghapus data tamu: John Doe
Bulk delete: Menghapus 5 data tamu sekaligus
Update status kunjungan tamu John Doe menjadi: selesai
Menambah data guru: Pak Budi
Menghapus guru Pak Budi dan memindahkan tamu ke guru lain
Mengupdate profile dan mengganti password
Logout dari sistem
```

### 🔗 Routes Baru

```php
GET  /log-aktivitas          → View all logs
GET  /log-aktivitas/recent   → Widget dashboard
POST /log-aktivitas/cleanup  → Cleanup old logs
GET  /log-aktivitas/export   → Export to CSV
```

### 🎨 UI/UX Features

- **Filter System** - Multi-filter (user, date, table, keyword)
- **Pagination** - Laravel pagination untuk navigasi
- **Export CSV** - Download log dengan format CSV
- **Cleanup Modal** - Hapus log > X hari
- **Responsive Table** - Mobile-friendly design
- **Avatar Icons** - Initial nama user dengan warna gradient
- **Timezone WITA** - Semua waktu dalam format Asia/Makassar
- **Bahasa Indonesia** - Format waktu "18 November 2024, 14:30 WITA"

### 📚 Documentation

- **LOG_AKTIVITAS_COMPLETE.md** - Dokumentasi lengkap 667 baris
- Penjelasan fitur dan cara kerja
- Panduan untuk developer dan user
- Contoh implementasi
- Troubleshooting guide
- Best practices

### 🔒 Security & Privacy

- IP Address tracking untuk deteksi aktivitas mencurigakan
- User Agent untuk mengetahui device/browser
- Access control dengan middleware auth.custom
- Transparent logging - semua user bisa lihat semua log
- Data retention dengan fitur cleanup manual

### 🧪 Testing Notes

- [x] Log tersimpan otomatis saat login
- [x] Log tersimpan saat CRUD tamu/guru
- [x] Log tersimpan saat update profile/password
- [x] Halaman log dapat diakses via sidebar menu
- [x] Filter by user, date, table, keyword berfungsi
- [x] Pagination berfungsi untuk data banyak
- [x] Export CSV dengan filter berfungsi
- [x] Cleanup modal berfungsi
- [x] Timezone WITA dan bahasa Indonesia benar

---

## [2.0.4] - 2024-11-18

### 🔧 Fixed - Timezone Notifikasi

#### Masalah
- Notifikasi menampilkan waktu tidak akurat (contoh: "10 jam yang lalu" padahal baru beberapa menit)
- Timestamps tidak otomatis terisi di model Tamu
- Timezone conversion tidak benar

#### Solusi

**1. Aktifkan Timestamps di Model Tamu**
- Changed `public $timestamps = false` → `true`
- Laravel otomatis isi created_at & updated_at

**2. Migration untuk Timestamps**
- Tambah kolom created_at & updated_at jika belum ada
- Update existing records: set created_at = tanggal_kunjungan

**3. Fix Timezone Conversion**
- Parse UTC dari database dengan `createFromFormat()`
- Convert ke Asia/Makassar dengan `setTimezone()`
- Locale Indonesia dengan `Carbon::setLocale('id')`

**4. Update NotificationController**
- Gunakan `created_at` bukan `tanggal_kunjungan` untuk sorting
- Format waktu: "14:30 WITA"
- Format tanggal: "18 November 2024"
- Relative time: "5 menit yang lalu"

### ⏰ Timezone & Locale Updates

#### Config App
```php
"timezone" => "Asia/Makassar",  // UTC+8 (WITA)
"locale" => "id",               // Bahasa Indonesia
```

#### Carbon Translations
- "5 minutes ago" → "5 menit yang lalu"
- "1 hour ago" → "1 jam yang lalu"
- "yesterday" → "kemarin"
- Nama bulan: Januari, Februari, Maret, dst
- Nama hari: Senin, Selasa, Rabu, dst

### 📚 Documentation

- **TIMEZONE_LOCALE_UPDATE.md** - Dokumentasi timezone & locale
- **FIX_TIMEZONE_NOTIFIKASI.md** - Dokumentasi fix notifikasi
- Penjelasan konversi UTC ke WITA
- Contoh penggunaan Carbon
- Testing guide

### 🧪 Testing

- [x] Notifikasi menampilkan waktu real-time yang akurat
- [x] Format tanggal dalam bahasa Indonesia
- [x] Format waktu dengan suffix " WITA"
- [x] diffForHumans dalam bahasa Indonesia
- [x] Data baru otomatis dapat created_at

---

## [2.0.3] - 2024-01-15

### ✨ Added - Foreign Key Handling untuk Delete Guru

#### Smart Delete Strategy
- **Check Before Delete** - Otomatis cek apakah guru memiliki data tamu
- **Reassign Option** - Pindahkan tamu ke guru lain sebelum hapus
- **Set NULL Option** - Hapus tanpa pengganti (set guru_tujuan NULL)
- Method `checkDelete()` di GuruController untuk API check
- Method `reassignAndDelete()` di GuruController untuk reassign & delete
- Route GET `/guru/{id}/check-delete`
- Route POST `/guru/{id}/reassign-delete`

#### UI Components
- Modal konfirmasi delete sederhana (jika guru tidak punya tamu)
- Modal reassign dengan dropdown guru pengganti (jika guru punya tamu)
- Informasi jumlah tamu yang terkait dengan guru
- Opsi flexible: reassign atau set NULL

### 🔧 Changed - Perubahan Delete Guru

#### GuruController.php
- Update method `destroy()` dengan foreign key check
- Tolak delete jika guru masih punya tamu (tanpa reassign)
- Return informative error message dengan jumlah tamu
- Tambah try-catch untuk exception handling

#### View guru/index.blade.php
- Ganti form delete dengan button + JavaScript
- Function `checkAndDelete()` - Check via AJAX sebelum delete
- Function `showDeleteModal()` - Modal konfirmasi sederhana
- Function `showReassignModal()` - Modal dengan dropdown reassign
- Dynamic form action berdasarkan kondisi

### 🐛 Fixed - Foreign Key Constraint Error

1. **Fix: SQLSTATE[23000] Integrity constraint violation**
   - Error: Cannot delete guru yang masih punya tamu
   - Solusi: Check dulu, beri opsi reassign atau set NULL
   - User experience: Modal yang jelas dan informatif

2. **Improved Error Messages**
   - Sebelum: Generic database error
   - Sesudah: "Tidak dapat menghapus guru {nama} karena masih memiliki {count} data kunjungan tamu"

3. **Safe Delete Operations**
   - Validation guru pengganti exist
   - Transaction-safe operations
   - Proper error handling dengan try-catch

### 🎨 UI/UX Improvements

#### Scenario 1: Guru Tanpa Tamu
- Modal konfirmasi sederhana
- Icon trash dan peringatan jelas
- Langsung hapus tanpa kompleksitas

#### Scenario 2: Guru Dengan Tamu
- Modal dengan informasi jumlah tamu
- Dropdown pilih guru pengganti
- Opsi kosongkan dropdown untuk set NULL
- Pesan informatif untuk setiap opsi

### 📚 Documentation
- **DELETE_GURU_FOREIGN_KEY.md** - Dokumentasi lengkap solusi foreign key
- Penjelasan masalah dan solusi
- Comparison database level vs application level
- Best practices dan troubleshooting

### 🧪 Testing Notes
- [x] Hapus guru tanpa tamu → berhasil
- [x] Hapus guru dengan tamu tanpa reassign → ditolak dengan pesan
- [x] Hapus guru dengan tamu + reassign → berhasil
- [x] Hapus guru dengan tamu + set NULL → berhasil
- [x] Cancel delete → tidak ada perubahan
- [x] Error handling berfungsi dengan baik

---

## [2.0.2] - 2024-01-15

### ✨ Added - Fitur Delete Tamu

#### Hard Delete untuk Tamu
- **Single Delete** - Hapus satu data tamu secara permanen
- **Bulk Delete** - Hapus multiple data tamu sekaligus
- Method `bulkDelete()` di TamuController
- Route POST `/tamu/bulk-delete`
- Checkbox select all/individual di tabel tamu
- Tombol bulk delete dengan counter badge
- Konfirmasi popup yang informatif dengan nama tamu
- AJAX untuk bulk delete tanpa reload halaman

#### Helper Functions (NEW)
- `current_user()` - Get user object from session
- `current_user_id()` - Get user ID from session
- `current_user_name()` - Get user name from session
- `current_user_email()` - Get user email from session
- `is_logged_in()` - Check if user is logged in
- `user_has_role($role)` - Check if user has specific role
- Registered di `composer.json` autoload files

### 🔧 Changed - Perubahan Delete Tamu

#### TamuController.php
- Update method `destroy()` untuk hard delete (permanent)
- Tambah method `bulkDelete()` untuk delete multiple records
- Improved error handling dengan try-catch
- Return informative success/error messages
- Simpan nama tamu sebelum delete untuk flash message

#### Tamu Model
- Tambah `deleted_at`, `created_at`, `updated_at` ke fillable
- Tambah casting untuk datetime fields (optional untuk soft delete)

#### View tamu/index.blade.php
- Tambah checkbox di header untuk select all
- Tambah checkbox per row untuk individual select
- Tombol bulk delete dengan counter badge dinamis
- JavaScript functions:
  - `toggleSelectAll()` - Toggle semua checkbox
  - `updateBulkDeleteBtn()` - Update visibility tombol bulk delete
  - `confirmDelete()` - Konfirmasi single delete dengan nama
  - `confirmBulkDelete()` - Konfirmasi bulk delete dengan AJAX
- Improved konfirmasi message dengan nama tamu dan jumlah data

### 🐛 Fixed - Perbaikan Helper Functions

1. **Fix ProfileController Auth Issue**
   - Aplikasi menggunakan session manual, bukan Laravel Auth
   - `Auth::user()` mengembalikan null
   - Solusi: Buat helper functions di `app/Helpers/helpers.php`
   - Update ProfileController menggunakan `current_user()`
   - Register helper di composer.json

2. **Fix Composer Autoload**
   - Tambah autoload files untuk helpers.php
   - Run `composer dump-autoload` untuk load helper functions

### 📚 Documentation
- **DELETE_TAMU_FEATURE.md** - Dokumentasi lengkap fitur delete tamu
- **SUMMARY_UPDATE.md** - Summary semua update yang dilakukan
- **FIX_PROFILE_ISSUE.md** - Updated dengan helper functions solution

### 🧪 Testing Notes
- [x] Single delete berfungsi dengan konfirmasi nama
- [x] Bulk delete berfungsi dengan counter
- [x] Select all checkbox berfungsi
- [x] Data terhapus permanen dari database (hard delete)
- [x] Flash messages muncul dengan benar
- [x] AJAX bulk delete tanpa reload
- [x] Helper functions berfungsi di ProfileController
- [x] Session auth bekerja dengan baik

---

## Future Roadmap

### [2.1.0] - Planned
- [ ] Real-time notification dengan WebSocket/Pusher
- [ ] Notification persistence di database
- [ ] Mark as read functionality yang real
- [ ] Filter notifikasi by type
- [ ] Push notification ke browser
- [ ] Email notification untuk admin

### [2.2.0] - Planned
- [ ] Upload foto profile
- [ ] Change theme preference (light/dark mode)
- [ ] Two-factor authentication
- [ ] Activity log untuk audit trail
- [ ] Export data profile
- [ ] Social media integration

### [3.0.0] - Planned
- [ ] Mobile app (React Native / Flutter)
- [ ] QR Code untuk check-in/check-out
- [ ] Laporan dan analytics advanced
- [ ] Multi-language support
- [ ] API documentation (Swagger/OpenAPI)

---

## Version History

| Version | Release Date | Status | Notes |
|---------|-------------|--------|-------|
| 2.0.5 | 2024-11-18 | ✅ Current | Log Aktivitas (Audit Trail) |
| 2.0.4 | 2024-11-18 | 📦 Released | Fix Timezone Notifikasi |
| 2.0.3 | 2024-01-15 | 📦 Released | Delete Guru Foreign Key Fix |
| 2.0.2 | 2024-01-15 | 📦 Released | Delete Tamu & Helper Functions |
| 2.0.0 | 2024-01-15 | 📦 Released | Notifikasi & Profile |
| 1.0.0 | 2024-01-01 | 📦 Released | Initial Release |

---

## Contributors
- IT Team SMK TI Airlangga

## Support
- Email: it@smktiairlangga.sch.id
- WhatsApp: 0812-xxxx-xxxx

---

**Format Changelog:**
- `Added` untuk fitur baru
- `Changed` untuk perubahan fitur yang sudah ada
- `Deprecated` untuk fitur yang akan dihapus
- `Removed` untuk fitur yang sudah dihapus
- `Fixed` untuk bug fixes
- `Security` untuk security fixes
