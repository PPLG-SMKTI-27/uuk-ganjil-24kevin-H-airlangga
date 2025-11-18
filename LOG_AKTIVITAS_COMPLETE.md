# 📋 Log Aktivitas - Dokumentasi Lengkap

## 🎯 Apa itu Log Aktivitas?

Log Aktivitas adalah **Audit Trail System** yang mencatat semua aktivitas pengguna di aplikasi untuk:
- 🔍 **Tracking** - Melacak siapa melakukan apa dan kapan
- 🛡️ **Security** - Keamanan dan deteksi aktivitas mencurigakan
- 📊 **Audit** - Laporan untuk keperluan audit
- 🐛 **Debugging** - Membantu troubleshooting masalah
- 📈 **Analytics** - Analisis penggunaan sistem

---

## ✅ Fitur yang Sudah Diimplementasikan

### 1. **Otomatis Logging**
Sistem otomatis mencatat aktivitas di:
- ✅ Login & Logout
- ✅ Create, Update, Delete Tamu
- ✅ Bulk Delete Tamu
- ✅ Update Status Kunjungan
- ✅ Create, Update, Delete Guru
- ✅ Reassign Guru sebelum Delete
- ✅ Update Profile & Change Password

### 2. **Data yang Dicatat**
Setiap log menyimpan:
- 👤 **User** - Siapa yang melakukan
- 📝 **Aktivitas** - Apa yang dilakukan
- 🗂️ **Tabel Terkait** - Tabel database yang terpengaruh
- 🔢 **ID Record** - ID data yang terpengaruh
- 🌐 **IP Address** - Alamat IP user
- 💻 **User Agent** - Browser/device yang digunakan
- 🕐 **Timestamp** - Kapan aktivitas dilakukan (WITA)

### 3. **Halaman Log Aktivitas**
UI lengkap dengan fitur:
- 📊 **View All Logs** - Lihat semua log dengan pagination
- 🔍 **Filter** - Filter by user, tanggal, tabel, keyword
- 📥 **Export CSV** - Download log dalam format CSV
- 🗑️ **Cleanup** - Hapus log lama (otomatis)
- 📱 **Responsive** - Mobile-friendly design

### 4. **Menu di Sidebar**
- Menu baru: **Log Aktivitas**
- Icon: 📋 (clipboard-list)
- Akses mudah untuk semua user
- Active state saat di halaman log

---

## 🗂️ Struktur File

```
buku-tamu-digital/
├── app/
│   ├── Helpers/
│   │   ├── helpers.php              # Helper session auth
│   │   └── LogHelper.php            # Helper log aktivitas ✨ BARU
│   ├── Http/Controllers/
│   │   ├── AuthController.php       # ✅ Sudah ada logging
│   │   ├── TamuController.php       # ✅ Sudah ada logging
│   │   ├── GuruController.php       # ✅ Sudah ada logging
│   │   ├── ProfileController.php    # ✅ Sudah ada logging
│   │   └── LogAktivitasController.php ✨ BARU
│   └── Models/
│       └── LogAktivitas.php         # ✅ Updated
├── database/migrations/
│   └── xxxx_add_fields_to_log_aktivitas_table.php ✨ BARU
├── resources/views/
│   ├── log-aktivitas/
│   │   └── index.blade.php          ✨ BARU
│   └── layouts/
│       └── app.blade.php            # ✅ Menu sudah ditambahkan
└── routes/
    └── web.php                      # ✅ Routes sudah ditambahkan
```

---

## 🔧 Cara Kerja

### 1. Helper Function

**File:** `app/Helpers/LogHelper.php`

```php
// Logging sederhana
log_activity("Login ke sistem");

// Logging dengan tabel terkait
log_activity("Menambah data tamu: John Doe", "tamu", 5);

// Otomatis mencatat:
// - User ID (dari session)
// - IP Address
// - User Agent
// - Timestamp
```

### 2. Implementasi di Controller

**Contoh di AuthController:**
```php
public function login(Request $request)
{
    // ... proses login ...
    
    // Log aktivitas
    log_activity("Login ke sistem", "pengguna", $pengguna->id_pengguna);
    
    return redirect()->route("dashboard");
}
```

**Contoh di TamuController:**
```php
public function store(Request $request)
{
    $tamu = Tamu::create([...]);
    
    // Log aktivitas
    log_activity(
        "Menambah data tamu: {$tamu->nama}",
        "tamu",
        $tamu->id_tamu
    );
    
    return redirect()->route("tamu.index");
}
```

### 3. Model LogAktivitas

**File:** `app/Models/LogAktivitas.php`

```php
protected $fillable = [
    "id_pengguna",      // User yang melakukan
    "aktivitas",        // Deskripsi aktivitas
    "tabel_terkait",    // Nama tabel (tamu, guru, pengguna)
    "id_record",        // ID record yang terkait
    "ip_address",       // IP Address user
    "user_agent",       // Browser/Device info
    "created_at",       // Waktu aktivitas
    "updated_at",
];

// Relasi ke Pengguna
public function pengguna()
{
    return $this->belongsTo(Pengguna::class, "id_pengguna");
}
```

### 4. Database Schema

**Tabel:** `log_aktivitas`

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id_log | INT | Primary key |
| id_pengguna | INT | FK ke tabel pengguna |
| aktivitas | TEXT | Deskripsi aktivitas |
| tabel_terkait | VARCHAR(50) | Nama tabel (nullable) |
| id_record | INT | ID record (nullable) |
| ip_address | VARCHAR(45) | IPv4/IPv6 address |
| user_agent | TEXT | Browser info |
| created_at | TIMESTAMP | Waktu aktivitas |
| updated_at | TIMESTAMP | - |

---

## 📊 Contoh Log yang Terekam

### Login/Logout
```
Login ke sistem
Logout dari sistem
```

### CRUD Tamu
```
Menambah data tamu: John Doe
Mengupdate data tamu: John Doe
Menghapus data tamu: John Doe
Bulk delete: Menghapus 5 data tamu sekaligus
Update status kunjungan tamu John Doe menjadi: selesai
```

### CRUD Guru
```
Menambah data guru: Pak Budi
Mengupdate data guru: Pak Budi
Menghapus data guru: Pak Budi
Menghapus guru Pak Budi dan memindahkan tamu ke guru lain
Menghapus guru Pak Budi dan set guru_tujuan tamu menjadi NULL
```

### Profile Management
```
Mengupdate profile
Mengupdate profile dan mengganti password
Mengganti password
```

---

## 🎨 UI/UX Halaman Log Aktivitas

### Header Section
```
┌────────────────────────────────────────────────────┐
│ Log Aktivitas              [Export CSV] [Cleanup]  │
│ Total: 150 Log                                     │
└────────────────────────────────────────────────────┘
```

### Filter Section
```
┌────────────────────────────────────────────────────┐
│ [Pengguna ▼] [Dari Tanggal] [Sampai Tanggal]     │
│ [Tabel ▼]    [Cari Aktivitas...]   [Filter] [Reset]│
└────────────────────────────────────────────────────┘
```

### Table Section
```
┌──────────────────────────────────────────────────────────────┐
│ Waktu       │ Pengguna    │ Aktivitas              │ Tabel  │
├──────────────────────────────────────────────────────────────┤
│ 18 Nov 2024 │ 👤 Admin    │ Login ke sistem        │ -      │
│ 11:30 WITA  │ Admin       │                        │        │
├──────────────────────────────────────────────────────────────┤
│ 18 Nov 2024 │ 👤 Kevin    │ Menambah data tamu:    │ Tamu   │
│ 10:45 WITA  │ Staff       │ John Doe               │        │
└──────────────────────────────────────────────────────────────┘
```

### Features
- ✅ **Color-coded badges** untuk tabel (hijau=tamu, biru=guru, ungu=pengguna)
- ✅ **Avatar icon** dengan initial nama user
- ✅ **Tooltip** untuk user agent yang panjang
- ✅ **Pagination** untuk navigasi mudah
- ✅ **Hover effects** untuk interaksi yang baik

---

## 🔗 Routes Tersedia

```php
// View all logs with filters
GET  /log-aktivitas
Route: log-aktivitas.index
Middleware: auth.custom

// Widget for dashboard (recent 10 logs)
GET  /log-aktivitas/recent
Route: log-aktivitas.recent
Middleware: auth.custom

// Cleanup old logs
POST /log-aktivitas/cleanup
Route: log-aktivitas.cleanup
Middleware: auth.custom
Data: { days: 30 }

// Export logs to CSV
GET  /log-aktivitas/export
Route: log-aktivitas.export
Middleware: auth.custom
Query: ?user_id=1&date_from=2024-01-01&date_to=2024-12-31
```

---

## 💻 Cara Menggunakan (Developer)

### 1. Log Aktivitas Simple
```php
log_activity("User melakukan sesuatu");
```

### 2. Log dengan Tabel Terkait
```php
log_activity("Hapus data", "tamu", 5);
```

### 3. Get Recent Activities
```php
$activities = get_recent_activities(10);
```

### 4. Get User Activities
```php
$activities = get_user_activities($userId, 20);
```

### 5. Manual Create Log
```php
use App\Models\LogAktivitas;

LogAktivitas::create([
    'id_pengguna' => current_user_id(),
    'aktivitas' => 'Custom activity',
    'tabel_terkait' => 'custom_table',
    'id_record' => 123,
    'ip_address' => request()->ip(),
    'user_agent' => request()->userAgent(),
]);
```

---

## 🔍 Filter & Search

### Filter by User
```
Dropdown menampilkan: Nama User (Role)
Contoh: Kevin Admin (Administrator)
```

### Filter by Date Range
```
Dari Tanggal: 2024-11-01
Sampai Tanggal: 2024-11-30
```

### Filter by Table
```
Options:
- Semua Tabel
- Tamu
- Guru
- Pengguna
```

### Search by Keyword
```
Input: "login"
Result: Semua log yang mengandung kata "login"
```

### Combined Filters
Semua filter bisa dikombinasikan:
```
User: Admin
Date: 18 Nov 2024
Table: Tamu
Keyword: "hapus"

Result: Log aktivitas Admin yang menghapus tamu pada 18 Nov 2024
```

---

## 📥 Export to CSV

### Format CSV
```csv
Waktu,User,Role,Aktivitas,Tabel,IP Address
18/11/2024 11:30:00,Kevin Admin,Administrator,Login ke sistem,-,127.0.0.1
18/11/2024 10:45:00,Staff User,Staff,Menambah data tamu: John,tamu,192.168.1.100
```

### Cara Export
1. Set filter sesuai kebutuhan
2. Klik tombol **Export CSV**
3. File otomatis download dengan nama: `log-aktivitas-YYYY-MM-DD-HHmmss.csv`

### Use Cases
- 📊 Import ke Excel untuk analisis
- 📧 Lampiran email laporan
- 💾 Backup log untuk arsip
- 📈 Analisis dengan tools lain

---

## 🗑️ Cleanup Log Lama

### Cara Cleanup
1. Klik tombol **Cleanup** di halaman log
2. Modal muncul dengan input jumlah hari
3. Masukkan angka (default: 30 hari)
4. Klik **Hapus Log**
5. Sistem menghapus log lebih dari X hari

### Contoh
```
Input: 30 hari
Action: Hapus semua log sebelum 19 Oktober 2024
Result: "Berhasil menghapus 150 log aktivitas yang lebih dari 30 hari"
```

### Best Practice
- ✅ Cleanup rutin setiap bulan
- ✅ Export dulu sebelum cleanup untuk backup
- ✅ Sesuaikan dengan kebijakan perusahaan
- ✅ Jangan hapus log < 7 hari

---

## 🔒 Security & Privacy

### IP Address Tracking
- Mencatat IP untuk deteksi aktivitas mencurigakan
- Berguna untuk tracking login dari lokasi tidak biasa
- Format: IPv4 (192.168.1.1) atau IPv6

### User Agent
- Mengetahui device/browser yang digunakan
- Deteksi bot atau akses otomatis
- Contoh: "Mozilla/5.0 (Windows NT 10.0; Win64; x64)..."

### Access Control
- Hanya user yang login bisa akses log
- Middleware: `auth.custom`
- Semua user bisa lihat semua log (transparent)

### Data Retention
- Log disimpan selamanya (kecuali di-cleanup manual)
- Recommended: Cleanup log > 3-6 bulan
- Export untuk arsip jangka panjang

---

## 📊 Analytics & Insights

### Pertanyaan yang Bisa Dijawab:

**1. Aktivitas User**
- User mana yang paling aktif?
- Jam berapa biasanya user login?
- User mana yang jarang logout?

**2. Tren Aktivitas**
- Berapa banyak tamu ditambahkan per hari?
- Kapan peak hours penggunaan sistem?
- Hari apa yang paling sibuk?

**3. Security**
- Ada akses dari IP mencurigakan?
- Ada login di luar jam kerja?
- Ada bulk delete yang tidak wajar?

**4. Usage Pattern**
- Fitur mana yang paling sering digunakan?
- Data apa yang sering diupdate?
- Berapa lama user menggunakan sistem?

---

## 🧪 Testing

### Test 1: Log Otomatis Tersimpan
```bash
# 1. Login ke aplikasi
# 2. Tambah data tamu
# 3. Buka halaman Log Aktivitas
# Expected: Ada log "Login ke sistem" dan "Menambah data tamu"
```

### Test 2: Filter by User
```bash
# 1. Pilih user di dropdown filter
# 2. Klik Filter
# Expected: Hanya log dari user terpilih yang muncul
```

### Test 3: Export CSV
```bash
# 1. Set filter (optional)
# 2. Klik Export CSV
# Expected: File CSV terdownload dengan data sesuai filter
```

### Test 4: Cleanup
```bash
# 1. Klik Cleanup
# 2. Input: 30 hari
# 3. Klik Hapus Log
# Expected: Log > 30 hari terhapus, flash message muncul
```

### Test 5: Pagination
```bash
# 1. Generate 30+ log
# 2. Buka halaman log
# Expected: Pagination muncul, bisa navigasi antar halaman
```

---

## 🔮 Future Enhancements

### Phase 1 - Immediate
- [ ] Real-time log updates (WebSocket)
- [ ] Dashboard widget untuk recent activities
- [ ] Chart/graph untuk analytics
- [ ] Log level (info, warning, error)

### Phase 2 - Short Term
- [ ] Email notification untuk aktivitas penting
- [ ] Auto cleanup scheduler (cron job)
- [ ] Advanced filters (by IP, by user agent)
- [ ] Search dengan regex

### Phase 3 - Long Term
- [ ] AI-powered anomaly detection
- [ ] Predictive analytics
- [ ] Custom report builder
- [ ] Integration dengan SIEM tools

---

## ⚠️ Troubleshooting

### Log tidak tersimpan?
**Check:**
1. Timestamps = true di model LogAktivitas? ✅
2. Kolom created_at & updated_at ada di database? ✅
3. Helper LogHelper.php sudah di-autoload? ✅
4. User sudah login (ada session)? ✅

**Solution:**
```bash
composer dump-autoload
php artisan migrate
```

### Error saat akses halaman log?
**Check:**
1. Route sudah terdaftar? ✅
2. Controller sudah dibuat? ✅
3. View blade sudah ada? ✅
4. Middleware auth.custom aktif? ✅

### Export CSV tidak muncul data?
**Check:**
1. Ada log di database? ✅
2. Filter tidak terlalu ketat? ✅
3. Query sesuai dengan filter? ✅

---

## 📝 Best Practices

### DO ✅
- Log semua aktivitas CRUD yang penting
- Gunakan deskripsi yang jelas dan konsisten
- Include nama data/user untuk konteks
- Cleanup log lama secara rutin
- Export log untuk backup jangka panjang
- Review log secara berkala untuk security

### DON'T ❌
- Jangan log password atau data sensitif
- Jangan log terlalu verbose (bisa bikin DB besar)
- Jangan expose log ke public
- Jangan hapus semua log tanpa backup
- Jangan skip log untuk aktivitas kritis

### Format Pesan Log
```php
// ✅ GOOD - Jelas dan informatif
log_activity("Menambah data tamu: John Doe (ID: 5)", "tamu", 5);
log_activity("Update status kunjungan dari 'proses' ke 'selesai'", "tamu", 5);
log_activity("Bulk delete: Menghapus 10 data tamu sekaligus");

// ❌ BAD - Terlalu umum
log_activity("Add data");
log_activity("Update");
log_activity("Delete something");
```

---

## 📞 Support

**Butuh bantuan?**
- 📧 Email: it@smktiairlangga.sch.id
- 💬 WhatsApp: 0812-xxxx-xxxx
- 📚 Docs: Baca file ini dan QUICK_START.md

---

## 📈 Statistics

### Files Created/Modified
- ✅ Created: LogHelper.php
- ✅ Created: LogAktivitasController.php
- ✅ Created: log-aktivitas/index.blade.php
- ✅ Created: Migration add_fields_to_log_aktivitas_table
- ✅ Modified: LogAktivitas.php (model)
- ✅ Modified: AuthController.php (+ logging)
- ✅ Modified: TamuController.php (+ logging)
- ✅ Modified: GuruController.php (+ logging)
- ✅ Modified: ProfileController.php (+ logging)
- ✅ Modified: app.blade.php (+ menu)
- ✅ Modified: web.php (+ routes)
- ✅ Modified: composer.json (+ autoload)

### Total Lines Added
- ~600 lines of PHP code
- ~250 lines of Blade template
- ~100 lines of migration
- **Total: ~950 lines**

### Features Count
- 4 Routes
- 4 Controller methods
- 3 Helper functions
- 1 Complete page with filters
- 8 Controllers with logging integrated

---

## ✅ Checklist Implementation

### Backend
- [x] Helper functions (log_activity, get_recent_activities, get_user_activities)
- [x] Model LogAktivitas updated (timestamps, fields)
- [x] Migration for new fields (ip_address, user_agent, timestamps)
- [x] LogAktivitasController (index, recent, cleanup, export)
- [x] Integrated logging di AuthController
- [x] Integrated logging di TamuController
- [x] Integrated logging di GuruController
- [x] Integrated logging di ProfileController
- [x] Routes registered (4 routes)

### Frontend
- [x] View log-aktivitas/index.blade.php
- [x] Filter form (user, date range, table, keyword)
- [x] Table with pagination
- [x] Export CSV button
- [x] Cleanup modal
- [x] Menu added to sidebar
- [x] Active state for menu
- [x] Responsive design
- [x] Color-coded badges for tables

### Testing
- [x] Log tersimpan saat login
- [x] Log tersimpan saat CRUD tamu
- [x] Log tersimpan saat CRUD guru
- [x] Log tersimpan saat update profile
- [x] Halaman log dapat diakses
- [x] Filter berfungsi
- [x] Pagination berfungsi
- [x] Export CSV berfungsi

### Documentation
- [x] LOG_AKTIVITAS_COMPLETE.md (file ini)
- [x] Penjelasan lengkap fitur
- [x] Cara penggunaan untuk developer
- [x] Cara penggunaan untuk user
- [x] Troubleshooting guide

---

**🎉 LOG AKTIVITAS FULLY IMPLEMENTED & DOCUMENTED!**

**Version:** 2.0.5  
**Status:** ✅ Production Ready  
**Last Updated:** 18 November 2024  
**Feature:** Log Aktivitas (Audit Trail)  
**Maintained By:** IT Team SMK TI Airlangga