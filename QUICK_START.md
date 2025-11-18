# 🚀 Quick Start - Notifikasi & Profile

## ⚡ Akses Cepat

### 1️⃣ Notifikasi
- **Lokasi:** Header kanan atas (icon bell 🔔)
- **Badge:** Menampilkan jumlah notifikasi baru (24 jam terakhir)
- **Update:** Otomatis refresh setiap 30 detik

### 2️⃣ Profile
- **Lokasi:** Sidebar bawah atau header kanan (icon user 👤)
- **Fitur:** View profile, Edit profile, Ganti password, Logout

---

## 📋 Fitur Notifikasi

### Apa yang Ditampilkan?
- ✅ 20 notifikasi terbaru dari pengunjung/tamu
- ✅ Status kunjungan (menunggu, diproses, selesai, dibatalkan)
- ✅ Info lengkap: nama tamu, guru tujuan, waktu
- ✅ Badge untuk notifikasi belum dibaca

### Cara Menggunakan
1. Klik icon **bell (🔔)** di header
2. Lihat daftar notifikasi terbaru
3. Notifikasi baru akan memiliki background biru muda
4. Klik **"Lihat Semua Tamu"** untuk detail lengkap

### Icon Status
- 🆕 `user-plus` - Pengunjung baru
- ⏰ `clock` - Kunjungan sedang diproses
- ✅ `check-circle` - Kunjungan selesai
- ❌ `times-circle` - Kunjungan dibatalkan

---

## 👤 Fitur Profile

### Mode Tampilan (View)
Informasi yang ditampilkan:
- 📧 **Email:** Email pengguna yang login
- 🛡️ **Role:** Peran/jabatan (Admin, Staff, dll)
- 🕐 **Last Login:** Waktu login terakhir

### Mode Edit
Yang bisa diubah:
- ✏️ **Nama Lengkap**
- ✉️ **Email** (harus unique)
- 🔒 **Password** (opsional)

---

## 🔐 Ganti Password

### Langkah-langkah:
1. Klik **nama/foto profile** di sidebar
2. Klik tombol **"Edit Profile"**
3. Scroll ke bagian **"Ganti Password"**
4. Isi formulir:
   ```
   Password Lama: [password saat ini]
   Password Baru: [min 6 karakter]
   Konfirmasi: [ketik ulang password baru]
   ```
5. Klik **"Simpan"**
6. Logout dan login dengan password baru

### ⚠️ Catatan Penting:
- Password lama HARUS benar
- Password baru minimal 6 karakter
- Konfirmasi password harus sama
- Jika hanya ubah nama/email, kosongkan field password

---

## 🎯 Tips & Trik

### Notifikasi
- Badge otomatis update, tidak perlu refresh manual
- Notifikasi disortir dari terbaru ke terlama
- Data diambil langsung dari tabel tamu (real-time)

### Profile
- Email harus unik, tidak boleh duplikat dengan user lain
- Jika tidak ingin ganti password, kosongkan semua field password
- Data otomatis terupdate setelah klik simpan
- Alert akan muncul jika ada error validasi

---

## 🐛 Troubleshooting

### Notifikasi Tidak Muncul?
1. Pastikan ada data tamu di database
2. Cek koneksi internet
3. Refresh halaman (F5)
4. Cek console browser untuk error (F12)

### Profile Tidak Bisa Disimpan?
- ✅ Cek format email (harus valid: user@domain.com)
- ✅ Pastikan email belum digunakan user lain
- ✅ Jika ganti password, pastikan password lama benar
- ✅ Password baru minimal 6 karakter
- ✅ Konfirmasi password harus sama persis

### Badge Notifikasi Tidak Update?
- Badge update otomatis setiap 30 detik
- Tunggu beberapa saat atau refresh halaman
- Pastikan JavaScript tidak diblock browser

---

## 🔗 API Endpoints

### Notifikasi
```
GET  /api/notifications         → Ambil daftar notifikasi
GET  /api/notifications/count   → Hitung notifikasi baru
POST /api/notifications/{id}/read → Tandai dibaca
POST /api/notifications/read-all  → Tandai semua dibaca
```

### Profile
```
GET  /api/profile                  → Ambil data profile
POST /api/profile/update           → Update profile
POST /api/profile/change-password  → Ganti password
```

---

## 📱 Mobile Support

Semua fitur **fully responsive**:
- ✅ Modal menyesuaikan ukuran layar
- ✅ Form mudah diisi di mobile
- ✅ Button cukup besar untuk di-tap
- ✅ Scroll otomatis jika konten panjang

---

## ⌨️ Keyboard Shortcuts

| Key | Action |
|-----|--------|
| `Esc` | Tutup modal yang terbuka |
| Click outside | Tutup modal |

---

## 📊 Status Code Response

| Code | Meaning |
|------|---------|
| 200 | Success ✅ |
| 422 | Validation Error ⚠️ |
| 500 | Server Error ❌ |

---

## 💡 Best Practices

### Keamanan
- 🔒 Selalu logout setelah selesai
- 🔒 Ganti password secara berkala
- 🔒 Jangan share password dengan siapapun
- 🔒 Gunakan password yang kuat (kombinasi huruf, angka, simbol)

### Notifikasi
- 👀 Cek notifikasi secara berkala
- 📝 Follow up tamu yang baru masuk
- ✔️ Update status kunjungan tepat waktu

### Profile
- ✏️ Update email jika ada perubahan
- 📧 Gunakan email aktif yang sering dicek
- 🔄 Update data profile jika ada perubahan

---

## 🎓 Tutorial Video (Coming Soon)
- [ ] Cara menggunakan notifikasi
- [ ] Cara edit profile
- [ ] Cara ganti password
- [ ] Tips keamanan akun

---

## ❓ FAQ

**Q: Notifikasi hilang setelah refresh?**  
A: Notifikasi tidak hilang, hanya yang > 24 jam tidak ditampilkan di badge.

**Q: Lupa password, bagaimana?**  
A: Hubungi administrator untuk reset password.

**Q: Bisa ganti email ke email yang sama dengan user lain?**  
A: Tidak bisa, email harus unique.

**Q: Password lama yang benar tapi error?**  
A: Pastikan tidak ada spasi di awal/akhir password.

**Q: Notifikasi bisa dihapus?**  
A: Saat ini belum ada fitur hapus, akan ditambahkan di versi mendatang.

---

## 📞 Butuh Bantuan?

**IT Support:**
- 📧 Email: it@smktiairlangga.sch.id
- 💬 WhatsApp: 0812-xxxx-xxxx
- 🕐 Available: Senin-Jumat, 08:00-16:00 WIB

---

**Happy Using! 🎉**

*Last Updated: 2024*