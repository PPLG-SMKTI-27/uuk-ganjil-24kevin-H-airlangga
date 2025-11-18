# Fix: Profile Modal Error - "Attempt to read property id_pengguna on null"

## 🐛 Masalah yang Ditemukan

### Error Message
```
Terjadi kesalahan: Attempt to read property "id_pengguna" on null
```

### Penyebab
Aplikasi ini menggunakan **session manual** untuk autentikasi, bukan Laravel Auth default (`Auth::user()`). Ketika `ProfileController` mencoba menggunakan `Auth::user()`, Laravel mengembalikan `null` karena tidak ada user yang ter-autentikasi melalui sistem Auth bawaan Laravel.

### Lokasi Error
- `app/Http/Controllers/ProfileController.php`
- Method: `show()`, `update()`, `changePassword()`

---

## ✅ Solusi yang Diterapkan

### 1. Membuat Helper Functions

**File Baru:** `app/Helpers/helpers.php`

Helper functions untuk mengakses data user dari session:

```php
// Mendapatkan user lengkap dari session
current_user()          // Returns: Pengguna model instance atau null

// Mendapatkan ID user
current_user_id()       // Returns: int (user ID) atau null

// Mendapatkan nama user
current_user_name()     // Returns: string (nama) atau null

// Mendapatkan email user
current_user_email()    // Returns: string (email) atau null

// Cek status login
is_logged_in()          // Returns: boolean

// Cek role user
user_has_role('admin')  // Returns: boolean
```

### 2. Registrasi Helper di Composer

**File:** `composer.json`

```json
{
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        },
        "files": [
            "app/Helpers/helpers.php"
        ]
    }
}
```

Jalankan: `composer dump-autoload`

### 3. Update ProfileController

**Sebelum:**
```php
$user = Auth::user(); // ❌ Mengembalikan null
if (!$user) {
    // error handling
}
```

**Sesudah:**
```php
$user = current_user(); // ✅ Mengambil dari session
if (!$user) {
    return response()->json([
        "success" => false,
        "message" => "User tidak ditemukan dalam session",
    ], 401);
}
```

---

## 📝 Perubahan Detail

### File yang Dibuat
1. ✅ `app/Helpers/helpers.php` - Helper functions untuk session
2. ✅ `FIX_PROFILE_ISSUE.md` - Dokumentasi ini

### File yang Diubah
1. ✅ `app/Http/Controllers/ProfileController.php` - Menggunakan `current_user()` bukan `Auth::user()`
2. ✅ `composer.json` - Menambahkan autoload files

---

## 🔍 Cara Kerja Session Auth di Aplikasi Ini

### Login Process (`AuthController`)
```php
public function login(Request $request)
{
    $pengguna = Pengguna::where("email", $request->email)->first();

    if ($pengguna && Hash::check($request->password, $pengguna->password)) {
        // Simpan ke session (BUKAN Auth facade)
        session([
            "user_id" => $pengguna->id_pengguna,
            "user_name" => $pengguna->nama,
            "user_email" => $pengguna->email,
            "peran_id" => $pengguna->peran_id,
            "logged_in" => true,
        ]);

        return redirect()->route("dashboard");
    }
}
```

### Custom Middleware (`CustomAuth`)
```php
public function handle(Request $request, Closure $next)
{
    if (!session("logged_in")) {
        return redirect()->route("login");
    }
    return $next($request);
}
```

### Helper Function (`current_user()`)
```php
function current_user()
{
    $userId = session('user_id'); // Ambil dari session

    if (!$userId) {
        return null;
    }

    return \App\Models\Pengguna::with('peran')
        ->where('id_pengguna', $userId)
        ->first();
}
```

---

## 🧪 Testing

### 1. Test Helper Functions
```php
// Di Tinker atau Controller
dd(current_user());        // Harus return user object
dd(current_user_id());     // Harus return integer
dd(current_user_name());   // Harus return string
dd(is_logged_in());        // Harus return true jika login
```

### 2. Test Profile API
```bash
# Get Profile
curl -X GET http://localhost:8000/api/profile \
  -H "Cookie: laravel_session=YOUR_SESSION_COOKIE"

# Update Profile
curl -X POST http://localhost:8000/api/profile/update \
  -H "Cookie: laravel_session=YOUR_SESSION_COOKIE" \
  -H "Content-Type: application/json" \
  -d '{"nama":"New Name","email":"new@email.com"}'
```

### 3. Test di Browser
1. Login ke aplikasi
2. Klik profile icon/button
3. Profile modal harus muncul dengan data user
4. Klik "Edit Profile"
5. Ubah nama atau email
6. Klik "Simpan"
7. Data harus terupdate tanpa error

---

## 🎯 Keuntungan Solusi Ini

### ✅ Centralized
- Semua logic akses user ada di satu tempat (helpers.php)
- Mudah dimaintain dan diupdate

### ✅ Konsisten
- Semua controller bisa menggunakan helper yang sama
- Tidak ada duplikasi kode

### ✅ Readable
- Kode lebih mudah dibaca: `current_user()` vs `Auth::user()`
- Jelas bahwa ini menggunakan session

### ✅ Type Safe
- Helper mengembalikan `Pengguna` model instance
- IDE autocomplete berfungsi dengan baik

### ✅ Flexible
- Mudah menambahkan fungsi baru
- Mudah beralih ke Laravel Auth jika diperlukan

---

## 🔄 Migration ke Laravel Auth (Optional)

Jika suatu saat ingin beralih ke Laravel Auth standard:

### 1. Update Model Pengguna
```php
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    // existing code...
}
```

### 2. Update AuthController
```php
public function login(Request $request)
{
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        return redirect()->route("dashboard");
    }
    return back()->withErrors(["email" => "Email atau password salah"]);
}
```

### 3. Update Helper (atau hapus)
```php
function current_user()
{
    return Auth::user(); // Gunakan Auth facade
}
```

### 4. Update Middleware
```php
Route::middleware(['auth'])->group(function () {
    // routes...
});
```

---

## 📚 Referensi

- [Laravel Session Documentation](https://laravel.com/docs/11.x/session)
- [Laravel Authentication](https://laravel.com/docs/11.x/authentication)
- [Composer Autoloading](https://getcomposer.org/doc/04-schema.md#autoload)

---

## ✅ Checklist Testing

Setelah apply fix ini, test semua scenario berikut:

- [ ] Login berhasil
- [ ] Buka profile modal → data muncul dengan benar
- [ ] Edit nama → berhasil tersimpan
- [ ] Edit email → berhasil tersimpan
- [ ] Ganti password dengan password lama salah → error muncul
- [ ] Ganti password dengan benar → berhasil
- [ ] Logout → session terhapus
- [ ] Login lagi dengan password baru → berhasil
- [ ] Session masih aktif setelah refresh halaman
- [ ] Multiple tabs → semua sync dengan session yang sama

---

## 🆘 Jika Masih Error

### Error: "Function current_user not found"
**Solusi:**
```bash
composer dump-autoload
php artisan optimize:clear
php artisan config:clear
```

### Error: "Session not found"
**Solusi:**
- Pastikan sudah login
- Check `.env` untuk `SESSION_DRIVER` (harus `file` atau `database`)
- Pastikan middleware `web` aktif di routes

### Error: "Call to undefined method"
**Solusi:**
- Pastikan model `Pengguna` memiliki relasi `peran()`
- Check apakah tabel `pengguna` dan `peran` ada

---

## 📝 Notes

- Helper functions bersifat global, bisa digunakan di mana saja (Controller, Blade, dll)
- Session driver menggunakan `file` (default Laravel)
- Timeout session: 120 menit (config di `config/session.php`)
- Cookie name: `laravel_session`

---

**Status:** ✅ FIXED  
**Version:** 2.0.1  
**Date:** {{ date('d M Y') }}  
**Fixed By:** IT Team