# Dokumentasi Fitur Baru - Notifikasi & Profile

## 📋 Ringkasan Perubahan

Dokumen ini menjelaskan fitur-fitur baru yang telah ditambahkan dan diperbaiki pada sistem Buku Tamu Digital.

---

## ✅ 1. Sistem Notifikasi (DIPERBAIKI)

### Masalah Sebelumnya
- Notifikasi tidak bisa mengambil data terbaru dari tamu
- Error saat fetching data notifikasi

### Perbaikan yang Dilakukan

#### A. NotificationController.php
- ✅ Menambahkan error handling dengan try-catch
- ✅ Memperbaiki query untuk mengambil 20 notifikasi terbaru
- ✅ Menambahkan relasi dengan `guru`, `jenisKunjungan`, dan `createdBy`
- ✅ Menghapus `whereNull('deleted_at')` karena model Tamu tidak menggunakan soft delete
- ✅ Menambahkan icon dinamis berdasarkan status kunjungan:
  - `user-plus` - Untuk pengunjung baru
  - `check-circle` - Untuk kunjungan selesai
  - `times-circle` - Untuk kunjungan dibatalkan
  - `clock` - Untuk kunjungan diproses
- ✅ Format pesan yang lebih informatif dengan nama guru tujuan
- ✅ Menghitung notifikasi baru (< 24 jam) dengan akurat

#### B. Fitur Notifikasi
```javascript
// Auto-refresh badge setiap 30 detik
// Menampilkan notifikasi dengan status baca/belum dibaca
// Badge dinamis dengan counter
```

### Endpoint API

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/notifications` | Mendapatkan daftar notifikasi (20 terbaru) |
| GET | `/api/notifications/count` | Menghitung notifikasi baru (24 jam terakhir) |
| POST | `/api/notifications/{id}/read` | Tandai notifikasi sebagai dibaca |
| POST | `/api/notifications/read-all` | Tandai semua notifikasi sebagai dibaca |

### Response Format

#### GET /api/notifications
```json
[
  {
    "id": 1,
    "icon": "user-plus",
    "title": "Pengunjung Baru",
    "message": "John Doe mengajukan kunjungan ke Pak Budi",
    "time": "5 menit yang lalu",
    "read": false,
    "status": "menunggu",
    "data": {
      "tamu_id": 1,
      "nama": "John Doe",
      "tanggal": "15 Jan 2024",
      "waktu": "10:30",
      "guru": "Pak Budi",
      "status": "menunggu",
      "jenis": "Konsultasi"
    }
  }
]
```

---

## ✅ 2. Sistem Profile (BARU)

### Fitur Lengkap

#### A. ProfileController.php (BARU)
File baru yang menangani semua operasi profile pengguna.

**Metode yang Tersedia:**
1. `show()` - Menampilkan data profile user yang login
2. `update()` - Update nama, email, dan password
3. `changePassword()` - Khusus untuk ganti password

#### B. Fitur Profile Modal

**Mode Tampilan (View Mode):**
- ✅ Menampilkan nama lengkap user
- ✅ Menampilkan email user
- ✅ Menampilkan role/peran user
- ✅ Menampilkan last login
- ✅ Tombol Edit Profile
- ✅ Tombol Logout

**Mode Edit (Edit Mode):**
- ✅ Form edit nama lengkap
- ✅ Form edit email dengan validasi unique
- ✅ Form ganti password (opsional):
  - Input password lama
  - Input password baru (min 6 karakter)
  - Konfirmasi password baru
- ✅ Validasi real-time
- ✅ Alert sukses/error
- ✅ Auto-reload data setelah update berhasil

### Endpoint API

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/profile` | Mendapatkan data profile user yang login |
| POST | `/api/profile/update` | Update profile (nama, email, password) |
| POST | `/api/profile/change-password` | Ganti password saja |

### Request & Response

#### GET /api/profile
**Response:**
```json
{
  "success": true,
  "data": {
    "id_pengguna": 1,
    "nama": "Admin User",
    "email": "admin@smktiairlangga.sch.id",
    "peran": "Administrator",
    "last_login": "2024-01-15 10:30:00"
  }
}
```

#### POST /api/profile/update
**Request:**
```json
{
  "nama": "Admin User Updated",
  "email": "admin@example.com",
  "password_lama": "password123",
  "password_baru": "newpassword123",
  "password_baru_confirmation": "newpassword123"
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Profile berhasil diperbarui",
  "data": {
    "nama": "Admin User Updated",
    "email": "admin@example.com"
  }
}
```

**Response (Error):**
```json
{
  "success": false,
  "message": "Validasi gagal",
  "errors": {
    "email": ["Email sudah digunakan"],
    "password_baru": ["Password minimal 6 karakter"]
  }
}
```

---

## 🔧 Perubahan Teknis

### 1. Model Pengguna.php
```php
// Ditambahkan casting untuk last_login
protected $casts = [
    'last_login' => 'datetime',
];

// Diperbaiki relasi dengan foreign key yang benar
public function peran()
{
    return $this->belongsTo(Peran::class, 'peran_id', 'id_peran');
}
```

### 2. Layout app.blade.php
- ✅ Ditambahkan CSRF token meta tag untuk AJAX requests
- ✅ Profile modal dengan 2 mode (View & Edit)
- ✅ JavaScript untuk handle form submission
- ✅ Alert system untuk feedback user
- ✅ Auto-refresh notification badge setiap 30 detik

### 3. Routes (web.php)
```php
// Notification Routes
Route::get('/api/notifications', [NotificationController::class, 'getNotifications']);
Route::get('/api/notifications/count', [NotificationController::class, 'getNotificationCount']);
Route::post('/api/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
Route::post('/api/notifications/read-all', [NotificationController::class, 'markAllAsRead']);

// Profile Routes
Route::get('/api/profile', [ProfileController::class, 'show']);
Route::post('/api/profile/update', [ProfileController::class, 'update']);
Route::post('/api/profile/change-password', [ProfileController::class, 'changePassword']);
```

---

## 🎨 UI/UX Improvements

### Notifikasi Modal
- 🎨 Gradient header (blue to purple)
- 🎨 Icon dinamis per status
- 🎨 Badge counter untuk notifikasi belum dibaca
- 🎨 Background highlight untuk notifikasi baru (bg-blue-50)
- 🎨 Hover effect pada setiap item
- 🎨 Loading state & error handling

### Profile Modal
- 🎨 Avatar circle dengan icon user
- 🎨 Gradient header yang menarik
- 🎨 Card-style information display
- 🎨 Smooth transition antara View & Edit mode
- 🎨 Form dengan Tailwind styling modern
- 🎨 Alert inline untuk feedback
- 🎨 Button dengan icon dan loading state

---

## 🔒 Keamanan

### Validasi Input
1. **Nama**: Required, max 100 karakter
2. **Email**: Required, valid format, unique
3. **Password Lama**: Required jika ganti password
4. **Password Baru**: Min 6 karakter, harus ada konfirmasi

### Hash Password
```php
// Password di-hash dengan bcrypt
$user->password = Hash::make($validated['password_baru']);
```

### CSRF Protection
- Semua POST request menggunakan CSRF token
- Token otomatis di-inject ke AJAX headers

---

## 📱 Responsive Design

- ✅ Mobile-friendly modal (max-h-90vh, overflow-y-auto)
- ✅ Padding & spacing yang sesuai untuk semua device
- ✅ Form input yang mudah di-tap pada mobile
- ✅ Button yang cukup besar untuk touch interaction

---

## 🚀 Cara Penggunaan

### Untuk Developer

1. **Menambahkan Custom Notification:**
```php
// Di controller Anda
$notifications[] = [
    'id' => $id,
    'icon' => 'custom-icon',
    'title' => 'Judul Notifikasi',
    'message' => 'Pesan notifikasi',
    'time' => Carbon::now()->diffForHumans(),
    'read' => false,
    'data' => [/* custom data */]
];
```

2. **Mengakses Profile Data di Blade:**
```blade
{{ session('user_name') }}
{{ session('user_email') }}
```

3. **Custom Validation di ProfileController:**
```php
// Edit method update() di ProfileController
$validated = $request->validate([
    'field_baru' => ['required', 'string'],
]);
```

### Untuk User

1. **Melihat Notifikasi:**
   - Klik icon bell di header
   - Lihat badge untuk notifikasi baru
   - Klik "Lihat Semua Tamu" untuk detail lengkap

2. **Edit Profile:**
   - Klik nama/foto profile di sidebar
   - Klik tombol "Edit Profile"
   - Ubah data yang diinginkan
   - Klik "Simpan"

3. **Ganti Password:**
   - Buka profile modal
   - Klik "Edit Profile"
   - Scroll ke bagian "Ganti Password"
   - Isi password lama, baru, dan konfirmasi
   - Klik "Simpan"

---

## 🐛 Bug Fixes

1. ✅ Fix query `whereNull` yang error
2. ✅ Fix Auth::user() yang tidak bisa di-save
3. ✅ Fix relasi Pengguna dengan Peran
4. ✅ Fix Carbon not imported
5. ✅ Fix CSRF token untuk AJAX requests
6. ✅ Fix notification badge tidak update otomatis

---

## 📝 Testing Checklist

- [ ] Login sebagai admin
- [ ] Buka notification modal, pastikan ada data
- [ ] Refresh halaman, badge notifikasi harus muncul
- [ ] Buka profile modal, pastikan data user benar
- [ ] Edit nama dan email, simpan
- [ ] Ganti password dengan password lama yang salah (harus error)
- [ ] Ganti password dengan benar
- [ ] Logout dan login dengan password baru
- [ ] Test di mobile browser
- [ ] Test dengan data guru dan tamu yang berbeda

---

## 🔮 Future Improvements

### Notifikasi
- [ ] Real-time notification dengan WebSocket/Pusher
- [ ] Notification persistence di database
- [ ] Mark as read functionality yang real
- [ ] Filter notifikasi by type
- [ ] Push notification ke browser
- [ ] Email notification untuk admin

### Profile
- [ ] Upload foto profile
- [ ] Change theme preference
- [ ] Two-factor authentication
- [ ] Activity log
- [ ] Export data profile
- [ ] Social media integration

---

## 📞 Support

Jika ada pertanyaan atau bug, hubungi IT Team:
- Email: it@smktiairlangga.sch.id
- WhatsApp: 0812-xxxx-xxxx

---

**Version:** 2.0.0  
**Last Updated:** {{ date('d M Y') }}  
**Author:** IT Team SMK TI Airlangga