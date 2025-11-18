# Update Timezone & Locale - Asia/Makassar & Bahasa Indonesia

## 📋 Overview

Update aplikasi untuk menggunakan:
- **Timezone:** Asia/Makassar (WITA - Waktu Indonesia Tengah)
- **Locale:** Bahasa Indonesia (id)

---

## 🌏 Timezone Asia/Makassar

### Karakteristik
- **Kode Timezone:** `Asia/Makassar`
- **Offset UTC:** UTC+8
- **Nama Zona:** WITA (Waktu Indonesia Tengah)
- **Wilayah:** Sulawesi, Kalimantan, Bali, Nusa Tenggara

### Perbedaan dengan Timezone Lain
| Timezone | Offset | Nama | Wilayah |
|----------|--------|------|---------|
| Asia/Jakarta | UTC+7 | WIB | Jawa, Sumatra |
| **Asia/Makassar** | **UTC+8** | **WITA** | **Sulawesi, Kalimantan** |
| Asia/Jayapura | UTC+9 | WIT | Papua, Maluku |

---

## 🔧 Perubahan yang Dilakukan

### 1. Config App (`config/app.php`)

#### Timezone
```php
// SEBELUM
"timezone" => "UTC",

// SESUDAH
"timezone" => "Asia/Makassar",
```

#### Locale
```php
// SEBELUM
"locale" => env("APP_LOCALE", "en"),
"faker_locale" => env("APP_FAKER_LOCALE", "en_US"),

// SESUDAH
"locale" => env("APP_LOCALE", "id"),
"faker_locale" => env("APP_FAKER_LOCALE", "id_ID"),
```

### 2. Environment File (`.env`)

```env
# SEBELUM
APP_LOCALE=en

# SESUDAH
APP_LOCALE=id
```

### 3. NotificationController

```php
public function getNotifications()
{
    // Set timezone dan locale
    Carbon::setLocale("id"); // Bahasa Indonesia
    
    // Parse dengan timezone Asia/Makassar
    $tanggalKunjungan = Carbon::parse($tamu->tanggal_kunjungan)
        ->timezone("Asia/Makassar");
    
    $now = Carbon::now("Asia/Makassar");
    
    // Format waktu dalam bahasa Indonesia
    "time" => $tanggalKunjungan->diffForHumans($now),
    
    // Format tanggal: "18 November 2024"
    "tanggal" => Carbon::parse($tamu->tanggal_kunjungan)
        ->timezone("Asia/Makassar")
        ->translatedFormat("d F Y"),
    
    // Format waktu: "14:30 WITA"
    "waktu" => Carbon::parse($tamu->waktu_masuk)
        ->timezone("Asia/Makassar")
        ->format("H:i") . " WITA",
}
```

---

## 📅 Format Tanggal & Waktu

### Contoh Output

#### Sebelum (UTC, English)
```
Time: 3 hours ago
Date: 18 Nov 2024
Time: 06:30
```

#### Sesudah (Asia/Makassar, Indonesia)
```
Time: 3 jam yang lalu
Date: 18 November 2024
Time: 14:30 WITA
```

### Format yang Digunakan

| Field | Format Method | Output Example |
|-------|---------------|----------------|
| **Relative Time** | `diffForHumans()` | "3 jam yang lalu", "2 hari yang lalu" |
| **Tanggal Lengkap** | `translatedFormat("d F Y")` | "18 November 2024" |
| **Tanggal Hari** | `translatedFormat("l, d F Y")` | "Senin, 18 November 2024" |
| **Jam** | `format("H:i")` | "14:30" |
| **Jam + Zona** | `format("H:i") . " WITA"` | "14:30 WITA" |

---

## 🇮🇩 Bahasa Indonesia (Locale)

### Carbon Translations

Carbon otomatis menerjemahkan ke bahasa Indonesia:

| English | Indonesia |
|---------|-----------|
| seconds ago | beberapa detik yang lalu |
| 1 minute ago | 1 menit yang lalu |
| 5 minutes ago | 5 menit yang lalu |
| 1 hour ago | 1 jam yang lalu |
| 3 hours ago | 3 jam yang lalu |
| yesterday | kemarin |
| 2 days ago | 2 hari yang lalu |
| 1 week ago | 1 minggu yang lalu |
| 1 month ago | 1 bulan yang lalu |
| 1 year ago | 1 tahun yang lalu |

### Nama Hari (translatedFormat)

| English | Indonesia |
|---------|-----------|
| Monday | Senin |
| Tuesday | Selasa |
| Wednesday | Rabu |
| Thursday | Kamis |
| Friday | Jumat |
| Saturday | Sabtu |
| Sunday | Minggu |

### Nama Bulan (translatedFormat)

| English | Indonesia |
|---------|-----------|
| January | Januari |
| February | Februari |
| March | Maret |
| April | April |
| May | Mei |
| June | Juni |
| July | Juli |
| August | Agustus |
| September | September |
| October | Oktober |
| November | November |
| December | Desember |

---

## 💻 Penggunaan di Code

### Basic Usage

```php
use Carbon\Carbon;

// Set locale Indonesia
Carbon::setLocale('id');

// Get current time di Makassar
$now = Carbon::now('Asia/Makassar');
echo $now->translatedFormat('l, d F Y H:i:s');
// Output: Senin, 18 November 2024 14:30:00

// Relative time dalam bahasa Indonesia
$date = Carbon::parse('2024-11-15 10:00:00')->timezone('Asia/Makassar');
echo $date->diffForHumans();
// Output: 3 hari yang lalu
```

### Dalam Notifikasi

```php
// Parse tanggal kunjungan
$tanggalKunjungan = Carbon::parse($tamu->tanggal_kunjungan)
    ->timezone('Asia/Makassar');

// Cek apakah baru (< 24 jam)
$now = Carbon::now('Asia/Makassar');
$isNew = $tanggalKunjungan->diffInHours($now) < 24;

// Format untuk display
$notification = [
    'time' => $tanggalKunjungan->diffForHumans($now),
    // "2 jam yang lalu"
    
    'tanggal' => $tanggalKunjungan->translatedFormat('d F Y'),
    // "18 November 2024"
    
    'waktu' => $tanggalKunjungan->format('H:i') . ' WITA',
    // "14:30 WITA"
];
```

### Dalam Blade Template

```blade
{{-- Format tanggal --}}
{{ \Carbon\Carbon::parse($tamu->tanggal_kunjungan)
    ->timezone('Asia/Makassar')
    ->translatedFormat('l, d F Y') }}
{{-- Output: Senin, 18 November 2024 --}}

{{-- Relative time --}}
{{ \Carbon\Carbon::parse($tamu->created_at)
    ->timezone('Asia/Makassar')
    ->diffForHumans() }}
{{-- Output: 3 jam yang lalu --}}
```

---

## 🧪 Testing

### Test di Tinker

```bash
php artisan tinker
```

```php
use Carbon\Carbon;

// Set locale Indonesia
Carbon::setLocale('id');

// Test timezone
$now = Carbon::now('Asia/Makassar');
echo $now->translatedFormat('l, d F Y H:i:s') . ' WITA';
// Output: Senin, 18 November 2024 14:30:00 WITA

// Test relative time
$past = Carbon::now('Asia/Makassar')->subHours(3);
echo $past->diffForHumans();
// Output: 3 jam yang lalu

// Test parsing dari database
$date = Carbon::parse('2024-11-18 14:30:00')->timezone('Asia/Makassar');
echo $date->translatedFormat('d F Y H:i') . ' WITA';
// Output: 18 November 2024 14:30 WITA
```

### Test API Notifikasi

```bash
curl http://localhost:8000/api/notifications
```

**Expected Response:**
```json
[
  {
    "id": 1,
    "icon": "user-plus",
    "title": "Pengunjung Baru",
    "message": "John Doe mengajukan kunjungan ke Pak Budi",
    "time": "3 jam yang lalu",
    "read": false,
    "data": {
      "tanggal": "18 November 2024",
      "waktu": "14:30 WITA"
    }
  }
]
```

---

## 🔄 Migrasi dari UTC ke Asia/Makassar

### Data yang Sudah Ada di Database

Jika data di database menggunakan UTC, perlu konversi saat display:

```php
// Data di database: UTC
$dbTime = '2024-11-18 06:30:00'; // UTC

// Konversi ke WITA (UTC+8)
$witaTime = Carbon::parse($dbTime)
    ->timezone('Asia/Makassar');

echo $witaTime->format('H:i'); // 14:30 (06:30 + 8 jam)
```

### Best Practice

**Simpan di database:** UTC atau timestamp  
**Display ke user:** Asia/Makassar (WITA)

```php
// Saat menyimpan ke database
$tamu->waktu_masuk = Carbon::now('Asia/Makassar')->utc();

// Saat menampilkan ke user
$displayTime = Carbon::parse($tamu->waktu_masuk)
    ->timezone('Asia/Makassar')
    ->format('H:i') . ' WITA';
```

---

## 📱 Contoh di Notifikasi Modal

### Sebelum Update
```
Pengunjung Baru
John Doe mengajukan kunjungan ke Pak Budi
3 hours ago

Tanggal: 18 Nov 2024
Waktu: 06:30
```

### Setelah Update
```
Pengunjung Baru
John Doe mengajukan kunjungan ke Pak Budi
3 jam yang lalu

Tanggal: 18 November 2024
Waktu: 14:30 WITA
```

---

## ⚙️ Commands untuk Clear Cache

Setelah update config, jalankan:

```bash
# Clear config cache
php artisan config:clear

# Clear application cache
php artisan cache:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear

# Atau clear semua sekaligus
php artisan optimize:clear
```

---

## 📝 Checklist Implementasi

### Backend
- [x] Update `config/app.php` timezone ke `Asia/Makassar`
- [x] Update `config/app.php` locale ke `id`
- [x] Update `.env` `APP_LOCALE=id`
- [x] Update NotificationController dengan timezone WITA
- [x] Set Carbon locale ke Indonesia
- [x] Format tanggal dengan `translatedFormat()`
- [x] Tambahkan suffix " WITA" pada waktu

### Testing
- [x] Test Carbon locale Indonesia
- [x] Test timezone Asia/Makassar
- [x] Test API notifikasi format tanggal
- [x] Test diffForHumans dalam bahasa Indonesia
- [x] Clear cache config dan application

### Documentation
- [x] Dokumentasi perubahan timezone
- [x] Dokumentasi format tanggal/waktu
- [x] Contoh penggunaan Carbon
- [x] Testing guide

---

## 🔧 Troubleshooting

### Masih Bahasa Inggris?

**Solusi:**
```bash
# Clear cache
php artisan config:clear
php artisan cache:clear

# Restart server
php artisan serve
```

### Waktu Masih UTC?

**Check:**
1. Config `config/app.php` sudah `Asia/Makassar`?
2. Sudah clear config cache?
3. Carbon parse sudah pakai `->timezone('Asia/Makassar')`?

### diffForHumans Tidak Terjemahkan?

**Solusi:**
```php
// Pastikan set locale sebelum diffForHumans
Carbon::setLocale('id');
$date->diffForHumans();
```

---

## 🌟 Benefits

### User Experience
✅ Waktu sesuai dengan waktu lokal Makassar  
✅ Bahasa yang familiar (Indonesia)  
✅ Format tanggal yang mudah dibaca  
✅ Zona waktu WITA yang jelas  

### Developer Experience
✅ Konsistensi timezone di seluruh aplikasi  
✅ Carbon locale otomatis translate  
✅ Easy to understand format  
✅ No confusion dengan timezone  

---

## 📚 Resources

- [Carbon Documentation](https://carbon.nesbot.com/docs/)
- [PHP Timezones List](https://www.php.net/manual/en/timezones.asia.php)
- [Laravel Localization](https://laravel.com/docs/11.x/localization)

---

**Version:** 2.0.4  
**Last Updated:** 18 November 2024  
**Timezone:** Asia/Makassar (WITA)  
**Locale:** Indonesia (id)  
**Status:** ✅ Production Ready