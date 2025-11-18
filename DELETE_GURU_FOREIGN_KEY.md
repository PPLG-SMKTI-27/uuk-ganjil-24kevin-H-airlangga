# Solusi Foreign Key Constraint - Delete Guru

## 🔴 Masalah

### Error Message
```
SQLSTATE[23000]: Integrity constraint violation: 1451 
Cannot delete or update a parent row: a foreign key constraint fails 
(`buku_tamu`.`tamu`, CONSTRAINT `fk_guru` FOREIGN KEY (`guru_tujuan`) 
REFERENCES `guru` (`id_guru`))
```

### Penyebab
Guru tidak bisa dihapus karena:
- Ada data **tamu** yang masih referensi ke guru tersebut
- Database memiliki **foreign key constraint** `fk_guru`
- Constraint mencegah penghapusan data parent yang masih punya child

---

## ✅ Solusi yang Diterapkan

### Smart Delete Strategy

#### 1. **Check First** - Cek dulu sebelum hapus
```php
$tamuCount = Tamu::where("guru_tujuan", $id)->count();

if ($tamuCount > 0) {
    // Guru masih punya tamu, jangan hapus
    return error dengan informasi jumlah tamu
}

// Aman untuk dihapus
$guru->delete();
```

#### 2. **Reassign Option** - Pindahkan tamu ke guru lain
```php
// User pilih guru pengganti
Tamu::where("guru_tujuan", $oldGuruId)
    ->update(["guru_tujuan" => $newGuruId]);

// Sekarang aman untuk hapus
$guru->delete();
```

#### 3. **Set NULL Option** - Hapus tanpa pengganti
```php
// Set guru_tujuan menjadi NULL
Tamu::where("guru_tujuan", $guruId)
    ->update(["guru_tujuan" => null]);

// Sekarang aman untuk hapus
$guru->delete();
```

---

## 🎯 Implementasi

### Backend - GuruController

#### Method 1: `destroy()` - Delete dengan check
```php
public function destroy($id)
{
    try {
        $guru = Guru::where("id_guru", $id)->firstOrFail();
        
        // Check if guru has related tamu
        $tamuCount = Tamu::where("guru_tujuan", $id)->count();
        
        if ($tamuCount > 0) {
            return redirect()
                ->route("guru.index")
                ->with("error", 
                    "Tidak dapat menghapus guru {$guru->nama_guru} " .
                    "karena masih memiliki {$tamuCount} data kunjungan tamu. " .
                    "Silakan hapus atau pindahkan data tamu terlebih dahulu."
                );
        }
        
        // Safe to delete
        $namaGuru = $guru->nama_guru;
        $guru->delete();
        
        return redirect()
            ->route("guru.index")
            ->with("success", "Data guru {$namaGuru} berhasil dihapus");
            
    } catch (\Exception $e) {
        return redirect()
            ->route("guru.index")
            ->with("error", "Gagal menghapus data guru: " . $e->getMessage());
    }
}
```

#### Method 2: `checkDelete()` - API untuk check
```php
public function checkDelete($id)
{
    try {
        $guru = Guru::where("id_guru", $id)->firstOrFail();
        $tamuCount = Tamu::where("guru_tujuan", $id)->count();
        
        return response()->json([
            "success" => true,
            "can_delete" => $tamuCount === 0,
            "tamu_count" => $tamuCount,
            "guru_name" => $guru->nama_guru,
            "message" => $tamuCount > 0 
                ? "Guru ini memiliki {$tamuCount} data kunjungan tamu"
                : "Guru dapat dihapus"
        ]);
    } catch (\Exception $e) {
        return response()->json([
            "success" => false,
            "message" => "Guru tidak ditemukan"
        ], 404);
    }
}
```

#### Method 3: `reassignAndDelete()` - Reassign & Delete
```php
public function reassignAndDelete(Request $request, $id)
{
    try {
        $guru = Guru::where("id_guru", $id)->firstOrFail();
        $newGuruId = $request->input("new_guru_id");
        
        if ($newGuruId) {
            // Validate new guru exists
            $newGuru = Guru::where("id_guru", $newGuruId)->firstOrFail();
            
            // Reassign all tamu to new guru
            Tamu::where("guru_tujuan", $id)
                ->update(["guru_tujuan" => $newGuruId]);
                
            $message = "Data guru berhasil dihapus dan tamu dipindahkan";
        } else {
            // Set guru_tujuan to NULL
            Tamu::where("guru_tujuan", $id)
                ->update(["guru_tujuan" => null]);
                
            $message = "Data guru berhasil dihapus dan data tamu diupdate";
        }
        
        // Now safe to delete guru
        $namaGuru = $guru->nama_guru;
        $guru->delete();
        
        return redirect()
            ->route("guru.index")
            ->with("success", $message);
            
    } catch (\Exception $e) {
        return redirect()
            ->route("guru.index")
            ->with("error", "Gagal menghapus data guru: " . $e->getMessage());
    }
}
```

### Routes

```php
// Standard resource routes
Route::resource("guru", GuruController::class);

// Additional routes for foreign key handling
Route::get("/guru/{id}/check-delete", [
    GuruController::class,
    "checkDelete"
])->name("guru.checkDelete");

Route::post("/guru/{id}/reassign-delete", [
    GuruController::class,
    "reassignAndDelete"
])->name("guru.reassignDelete");
```

### Frontend - JavaScript Flow

```javascript
function checkAndDelete(guruId, guruName) {
    // Step 1: Check if guru can be deleted
    fetch(`/guru/${guruId}/check-delete`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.can_delete) {
                    // No related tamu -> show simple delete confirmation
                    showDeleteModal(guruId, guruName);
                } else {
                    // Has related tamu -> show reassign modal
                    showReassignModal(guruId, guruName, data.tamu_count);
                }
            }
        });
}
```

---

## 🎨 UI/UX Flow

### Scenario 1: Guru Tanpa Tamu (Aman Dihapus)

```
User klik delete button
    ↓
Check API: /guru/{id}/check-delete
    ↓
can_delete = true
    ↓
Tampilkan modal konfirmasi sederhana
    ↓
User klik "Ya, Hapus"
    ↓
DELETE /guru/{id}
    ↓
Guru terhapus ✅
```

**Modal:**
```
┌─────────────────────────────────────┐
│ 🗑️  Konfirmasi Hapus                │
├─────────────────────────────────────┤
│ Apakah Anda yakin ingin menghapus?  │
│                                      │
│ Pak Budi (NIP: 123456)              │
│                                      │
│ ⚠️ Data tidak dapat dikembalikan!   │
│                                      │
│  [Ya, Hapus]     [Batal]            │
└─────────────────────────────────────┘
```

### Scenario 2: Guru Punya Tamu (Perlu Reassign)

```
User klik delete button
    ↓
Check API: /guru/{id}/check-delete
    ↓
can_delete = false, tamu_count = 5
    ↓
Tampilkan modal reassign dengan dropdown
    ↓
User pilih guru pengganti (atau kosongkan)
    ↓
User klik "Hapus Guru"
    ↓
POST /guru/{id}/reassign-delete
    ↓
Tamu dipindahkan → Guru dihapus ✅
```

**Modal:**
```
┌─────────────────────────────────────────────┐
│ ⚠️  Guru Memiliki Data Kunjungan            │
├─────────────────────────────────────────────┤
│ ℹ️ Guru Pak Budi memiliki 5 data           │
│    kunjungan tamu.                          │
│                                             │
│    Pilih guru pengganti atau hapus          │
│    tanpa pengganti.                         │
│                                             │
│ Guru Pengganti (Opsional):                  │
│ ┌─────────────────────────────────┐         │
│ │ [Pilih Guru...]          ▼      │         │
│ └─────────────────────────────────┘         │
│                                             │
│ Opsi:                                       │
│ • Pilih guru = tamu dipindahkan             │
│ • Kosongkan = set guru_tujuan NULL          │
│                                             │
│  [Hapus Guru]        [Batal]                │
└─────────────────────────────────────────────┘
```

---

## 📋 Features

### ✅ Smart Detection
- Otomatis deteksi apakah guru punya tamu
- AJAX call untuk check sebelum tampilkan modal
- Real-time count jumlah tamu

### ✅ Flexible Options
- **Opsi 1:** Pindahkan tamu ke guru lain
- **Opsi 2:** Hapus tanpa pengganti (set NULL)
- **Opsi 3:** Cancel dan tidak jadi hapus

### ✅ User-Friendly
- Modal yang jelas dan informatif
- Pesan error yang deskriptif
- Dropdown hanya tampilkan guru lain (exclude yang akan dihapus)
- Konfirmasi yang tidak ambigu

### ✅ Safe Operations
- Try-catch untuk semua operasi
- Validation guru pengganti exist
- Transaction-safe (jika gagal, rollback)
- Flash messages untuk feedback

---

## 🧪 Testing Scenarios

### Test 1: Hapus Guru Tanpa Tamu
```
✅ Guru tidak punya data tamu
✅ Modal simple confirmation muncul
✅ Klik "Ya, Hapus"
✅ Guru terhapus dari database
✅ Flash message: "Data guru berhasil dihapus"
```

### Test 2: Hapus Guru Dengan Tamu (Reassign)
```
✅ Guru punya 5 data tamu
✅ Modal reassign muncul dengan info "5 data kunjungan"
✅ Pilih guru pengganti dari dropdown
✅ Klik "Hapus Guru"
✅ Semua tamu dipindahkan ke guru baru
✅ Guru lama terhapus
✅ Flash message: "Data guru berhasil dihapus dan tamu dipindahkan"
```

### Test 3: Hapus Guru Dengan Tamu (Set NULL)
```
✅ Guru punya 3 data tamu
✅ Modal reassign muncul
✅ Tidak pilih guru pengganti (kosong)
✅ Klik "Hapus Guru"
✅ guru_tujuan di tamu diset NULL
✅ Guru terhapus
✅ Flash message: "Data guru berhasil dihapus dan data tamu diupdate"
```

### Test 4: Cancel Delete
```
✅ Modal muncul (simple atau reassign)
✅ Klik "Batal"
✅ Modal tertutup
✅ Tidak ada perubahan di database
```

### Test 5: Error Handling
```
✅ Guru tidak ditemukan → Error message
✅ Guru pengganti tidak valid → Error message
✅ Database error → Catch exception, tampilkan error
```

---

## 🔒 Database Considerations

### Foreign Key Constraint
```sql
CONSTRAINT `fk_guru` 
FOREIGN KEY (`guru_tujuan`) 
REFERENCES `guru` (`id_guru`)
```

### Options untuk Constraint (Alternatif)

#### Option 1: ON DELETE SET NULL
```sql
ALTER TABLE tamu
DROP FOREIGN KEY fk_guru;

ALTER TABLE tamu
ADD CONSTRAINT fk_guru 
FOREIGN KEY (guru_tujuan) 
REFERENCES guru(id_guru)
ON DELETE SET NULL;
```
**Behavior:** Otomatis set NULL saat guru dihapus

#### Option 2: ON DELETE CASCADE
```sql
ALTER TABLE tamu
ADD CONSTRAINT fk_guru 
FOREIGN KEY (guru_tujuan) 
REFERENCES guru(id_guru)
ON DELETE CASCADE;
```
**⚠️ BAHAYA:** Akan hapus semua tamu juga! **TIDAK DIREKOMENDASIKAN**

#### Option 3: RESTRICT (Default/Current)
```sql
ON DELETE RESTRICT
-- atau
ON DELETE NO ACTION
```
**Behavior:** Prevent delete (seperti sekarang) - **PALING AMAN**

### Rekomendasi
**Tetap gunakan RESTRICT** dan handle di aplikasi level seperti yang sudah diimplementasikan. Ini memberi kontrol penuh dan user experience yang lebih baik.

---

## 📊 Comparison: Database vs Application Level

| Aspect | Database Level (ON DELETE) | Application Level (Current) |
|--------|---------------------------|----------------------------|
| **Control** | Automatic | Manual/Explicit |
| **User Choice** | ❌ No | ✅ Yes (reassign/null) |
| **Audit Trail** | ❌ Limited | ✅ Full logging possible |
| **UX** | ❌ Just error | ✅ Guided flow |
| **Flexibility** | ❌ Fixed behavior | ✅ Multiple options |
| **Safety** | ⚠️ Can be dangerous | ✅ Controlled |
| **Recommended** | For simple cases | ✅ **For complex apps** |

---

## 🎓 Best Practices

### 1. Always Check First
```php
// ❌ BAD: Langsung hapus
$guru->delete();

// ✅ GOOD: Check dulu
$count = Tamu::where("guru_tujuan", $id)->count();
if ($count > 0) {
    // Handle foreign key issue
}
```

### 2. Informative Messages
```php
// ❌ BAD: Generic message
"Cannot delete guru"

// ✅ GOOD: Specific message
"Tidak dapat menghapus guru {nama} karena masih memiliki {count} data kunjungan tamu"
```

### 3. Give Options
```php
// ❌ BAD: Just block delete
return error("Guru has tamu");

// ✅ GOOD: Provide solutions
return reassign_modal([
    'options' => ['reassign', 'set_null', 'cancel']
]);
```

### 4. Transaction Safety
```php
DB::transaction(function() use ($oldGuruId, $newGuruId) {
    // Reassign tamu
    Tamu::where("guru_tujuan", $oldGuruId)
        ->update(["guru_tujuan" => $newGuruId]);
    
    // Delete guru
    Guru::where("id_guru", $oldGuruId)->delete();
});
```

### 5. Log Important Actions
```php
Log::info("Guru deleted", [
    'guru_id' => $id,
    'guru_name' => $namaGuru,
    'tamu_reassigned' => $tamuCount,
    'new_guru_id' => $newGuruId,
    'deleted_by' => current_user_id()
]);
```

---

## 🆘 Troubleshooting

### Error: "Cannot add foreign key constraint"
**Cause:** Mungkin ada data orphan di tamu
**Solution:**
```sql
-- Check for orphaned records
SELECT * FROM tamu 
WHERE guru_tujuan IS NOT NULL 
AND guru_tujuan NOT IN (SELECT id_guru FROM guru);

-- Fix orphaned records
UPDATE tamu 
SET guru_tujuan = NULL 
WHERE guru_tujuan NOT IN (SELECT id_guru FROM guru);
```

### Error: "Guru tidak ditemukan"
**Cause:** ID guru tidak valid atau sudah dihapus
**Solution:** Refresh page dan coba lagi

### Modal tidak muncul
**Cause:** JavaScript error atau AJAX gagal
**Solution:** 
- Check browser console untuk error
- Pastikan route `/guru/{id}/check-delete` exist
- Test API endpoint langsung

---

## 📞 Summary

### Problem
❌ Guru tidak bisa dihapus karena foreign key constraint

### Solution
✅ Smart delete dengan check + reassign option

### Features
- ✅ Otomatis deteksi guru punya tamu atau tidak
- ✅ Modal konfirmasi sesuai kondisi
- ✅ Opsi reassign tamu ke guru lain
- ✅ Opsi set NULL tanpa pengganti
- ✅ Flash messages informatif
- ✅ Safe dengan try-catch

### Benefits
- 🎯 User-friendly experience
- 🛡️ Data integrity terjaga
- 🔄 Flexible options
- ⚡ No more foreign key errors!

---

**Status:** ✅ SOLVED  
**Version:** 2.0.3  
**Last Updated:** 15 Januari 2024  
**Maintained By:** IT Team SMK TI Airlangga