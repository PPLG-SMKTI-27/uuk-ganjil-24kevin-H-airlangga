# Fitur Delete Tamu - Dokumentasi

## 📋 Overview

Fitur delete tamu memungkinkan admin untuk menghapus data tamu baik secara individual maupun massal (bulk delete). Semua penghapusan bersifat **hard delete** (permanen).

---

## 🔥 Hard Delete

### Apa itu Hard Delete?
Hard delete berarti data dihapus **secara permanen** dari database dan **tidak dapat dikembalikan**.

⚠️ **PERINGATAN:** 
- Data yang dihapus tidak bisa di-restore
- Pastikan data benar-benar tidak diperlukan lagi
- Backup database secara berkala

---

## 🎯 Fitur yang Tersedia

### 1. **Single Delete** - Hapus Satu Data
Menghapus satu data tamu secara individual.

**Lokasi:** Kolom "Aksi" di tabel tamu
**Button:** Tombol merah dengan icon trash 🗑️

**Cara Penggunaan:**
1. Di halaman Data Tamu, cari tamu yang ingin dihapus
2. Klik tombol **merah (trash icon)** di kolom Aksi
3. Konfirmasi popup akan muncul
4. Klik **OK** untuk menghapus, **Cancel** untuk membatalkan
5. Data terhapus dan halaman akan refresh

### 2. **Bulk Delete** - Hapus Multiple Data
Menghapus beberapa data tamu sekaligus.

**Lokasi:** Checkbox di sebelah kiri tabel
**Button:** Tombol "Hapus (n)" muncul di header

**Cara Penggunaan:**
1. Centang checkbox data tamu yang ingin dihapus
2. Tombol **"Hapus (n)"** akan muncul di header (n = jumlah data terpilih)
3. Klik tombol tersebut
4. Konfirmasi popup akan muncul
5. Klik **OK** untuk menghapus, **Cancel** untuk membatalkan
6. Data terhapus dan halaman akan refresh

**Fitur Tambahan:**
- ✅ **Select All:** Centang checkbox di header untuk pilih semua data
- ✅ **Counter:** Badge menunjukkan jumlah data yang dipilih
- ✅ **Auto Hide:** Tombol bulk delete otomatis hilang jika tidak ada data terpilih

---

## 🛠️ Implementasi Teknis

### Backend

#### 1. TamuController - destroy() Method
```php
/**
 * Hard delete - Menghapus data tamu secara permanen
 */
public function destroy($id)
{
    try {
        $tamu = Tamu::where("id_tamu", $id)->firstOrFail();
        $namaTamu = $tamu->nama;
        
        // Hard delete - hapus permanen
        $tamu->delete();
        
        return redirect()
            ->route("tamu.index")
            ->with("success", "Data tamu {$namaTamu} berhasil dihapus secara permanen");
    } catch (\Exception $e) {
        return redirect()
            ->route("tamu.index")
            ->with("error", "Gagal menghapus data tamu: " . $e->getMessage());
    }
}
```

#### 2. TamuController - bulkDelete() Method
```php
/**
 * Bulk delete - Hapus multiple tamu sekaligus
 */
public function bulkDelete(Request $request)
{
    try {
        $ids = $request->input("ids", []);
        
        if (empty($ids)) {
            return response()->json([
                "success" => false,
                "message" => "Tidak ada data yang dipilih",
            ], 400);
        }
        
        $count = Tamu::whereIn("id_tamu", $ids)->delete();
        
        return response()->json([
            "success" => true,
            "message" => "{$count} data tamu berhasil dihapus",
        ]);
    } catch (\Exception $e) {
        return response()->json([
            "success" => false,
            "message" => "Gagal menghapus data: " . $e->getMessage(),
        ], 500);
    }
}
```

### Routes

#### Single Delete (sudah ada di resource)
```php
Route::resource("tamu", TamuController::class);
// DELETE /tamu/{id} → TamuController@destroy
```

#### Bulk Delete (route baru)
```php
Route::post("/tamu/bulk-delete", [
    TamuController::class,
    "bulkDelete",
])->name("tamu.bulkDelete");
```

### Frontend

#### 1. Checkbox di Tabel
```blade
<!-- Checkbox Select All -->
<th class="px-6 py-4 text-center">
    <input type="checkbox" id="selectAll" 
           class="w-4 h-4 text-primary-600 border-gray-300 rounded" 
           onchange="toggleSelectAll(this)">
</th>

<!-- Checkbox per Row -->
<td class="px-6 py-4 text-center">
    <input type="checkbox" 
           class="row-checkbox w-4 h-4" 
           value="{{ $item->id_tamu }}" 
           onchange="updateBulkDeleteBtn()">
</td>
```

#### 2. Tombol Bulk Delete
```blade
<button id="bulkDeleteBtn" 
        class="hidden bg-red-600 text-white px-4 py-2 rounded-xl" 
        onclick="confirmBulkDelete()">
    <i class="fas fa-trash mr-2"></i>Hapus 
    <span id="selectedCount">(0)</span>
</button>
```

#### 3. JavaScript Functions
```javascript
// Toggle select all checkbox
function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = checkbox.checked;
    });
    updateBulkDeleteBtn();
}

// Update bulk delete button visibility
function updateBulkDeleteBtn() {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    const count = checkboxes.length;
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    
    if (count > 0) {
        bulkDeleteBtn.classList.remove('hidden');
        document.getElementById('selectedCount').textContent = `(${count})`;
    } else {
        bulkDeleteBtn.classList.add('hidden');
    }
}

// Confirm bulk delete
function confirmBulkDelete() {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    const ids = Array.from(checkboxes).map(cb => cb.value);
    
    if (!confirm(`Hapus ${ids.length} data tamu?`)) return;
    
    fetch('/tamu/bulk-delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ ids: ids })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    });
}
```

---

## 🔒 Security & Validation

### 1. CSRF Protection
- Semua request menggunakan CSRF token
- Token di-inject via meta tag atau form

### 2. Authorization
- Hanya user yang login bisa akses
- Menggunakan middleware `auth.custom`

### 3. Validation
- ID harus valid dan exist di database
- Menggunakan `firstOrFail()` untuk handle not found

### 4. Error Handling
- Try-catch untuk semua operasi delete
- Return error message yang informatif

---

## 📊 Response Format

### Single Delete (Success)
```
Redirect ke: /tamu
Flash Message: "Data tamu {nama} berhasil dihapus secara permanen"
Type: success
```

### Single Delete (Error)
```
Redirect ke: /tamu
Flash Message: "Gagal menghapus data tamu: {error}"
Type: error
```

### Bulk Delete (Success)
```json
{
    "success": true,
    "message": "5 data tamu berhasil dihapus"
}
```

### Bulk Delete (Error)
```json
{
    "success": false,
    "message": "Tidak ada data yang dipilih"
}
```

---

## 🧪 Testing

### Test Single Delete
1. ✅ Login sebagai admin
2. ✅ Buka halaman Data Tamu
3. ✅ Klik tombol delete pada satu data
4. ✅ Konfirmasi popup muncul dengan nama tamu
5. ✅ Klik OK, data terhapus
6. ✅ Flash message sukses muncul
7. ✅ Tabel terupdate tanpa data tersebut
8. ✅ Check database, data benar-benar terhapus

### Test Bulk Delete
1. ✅ Login sebagai admin
2. ✅ Buka halaman Data Tamu
3. ✅ Centang beberapa checkbox (misal 3 data)
4. ✅ Tombol "Hapus (3)" muncul
5. ✅ Klik tombol tersebut
6. ✅ Konfirmasi popup muncul dengan jumlah data
7. ✅ Klik OK, semua data terpilih terhapus
8. ✅ Alert sukses muncul
9. ✅ Halaman refresh otomatis
10. ✅ Checkbox ter-reset
11. ✅ Tombol bulk delete hilang
12. ✅ Check database, semua data terpilih benar-benar terhapus

### Test Select All
1. ✅ Centang checkbox "Select All" di header
2. ✅ Semua checkbox data tercentang
3. ✅ Tombol bulk delete muncul dengan counter total data
4. ✅ Uncheck satu data
5. ✅ Checkbox "Select All" otomatis uncheck
6. ✅ Counter berkurang

### Test Error Handling
1. ✅ Hapus data dengan ID yang tidak exist → error message muncul
2. ✅ Bulk delete tanpa pilih data → error "tidak ada data yang dipilih"
3. ✅ Klik cancel pada konfirmasi → operasi dibatalkan

---

## 🎨 UI/UX

### Visual Feedback
- ✅ Tombol delete berwarna **merah** (danger)
- ✅ Icon trash yang jelas
- ✅ Hover effect pada button
- ✅ Badge counter untuk bulk delete
- ✅ Checkbox dengan styling Tailwind modern

### Konfirmasi
- ✅ Popup confirm dengan pesan jelas
- ✅ Nama tamu ditampilkan (single delete)
- ✅ Jumlah data ditampilkan (bulk delete)
- ✅ Peringatan "tidak dapat dikembalikan"

### Flash Messages
- ✅ Success: hijau dengan icon check
- ✅ Error: merah dengan icon warning
- ✅ Auto dismiss atau manual close

---

## 📝 Best Practices

### For Developers
1. ✅ Selalu gunakan try-catch
2. ✅ Validasi input dengan baik
3. ✅ Return informative error messages
4. ✅ Log operasi delete (optional)
5. ✅ Test di development dulu
6. ✅ Backup database sebelum deploy

### For Users
1. ⚠️ Pastikan data benar-benar tidak diperlukan
2. ⚠️ Double check sebelum confirm delete
3. ⚠️ Backup data penting secara berkala
4. ⚠️ Gunakan filter/search untuk memastikan data yang benar
5. ⚠️ Jangan bulk delete semua data sekaligus tanpa review

---

## 🔮 Future Enhancements

### Soft Delete (Optional)
Jika ingin menambahkan soft delete:
```php
// Model Tamu
use Illuminate\Database\Eloquent\SoftDeletes;

class Tamu extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
}

// Controller
public function destroy($id)
{
    $tamu = Tamu::findOrFail($id);
    $tamu->delete(); // Soft delete
}

// Restore
public function restore($id)
{
    $tamu = Tamu::withTrashed()->findOrFail($id);
    $tamu->restore();
}
```

### Audit Log
Track siapa yang menghapus data:
```php
// Log delete activity
LogAktivitas::create([
    'user_id' => current_user_id(),
    'activity' => "Menghapus tamu: {$tamu->nama}",
    'ip_address' => request()->ip(),
    'timestamp' => now()
]);
```

### Export Before Delete
Export data sebelum dihapus:
```php
// Export to CSV/Excel before delete
$this->exportToCSV($tamu);
$tamu->delete();
```

---

## 🆘 Troubleshooting

### Error: "Method [destroy] does not exist"
**Solusi:** Pastikan route resource sudah di-define dengan benar.

### Error: "CSRF token mismatch"
**Solusi:** 
- Pastikan meta tag CSRF ada di layout
- Include `@csrf` di form
- Gunakan header `X-CSRF-TOKEN` di AJAX

### Tombol bulk delete tidak muncul
**Solusi:**
- Check JavaScript console untuk error
- Pastikan ID element sesuai
- Pastikan checkbox punya class `row-checkbox`

### Data tidak terhapus dari database
**Solusi:**
- Check apakah menggunakan soft delete
- Pastikan method `delete()` dipanggil
- Check migration: pastikan tabel tidak punya constraint

---

## 📞 Support

**Butuh bantuan?**
- 📧 Email: it@smktiairlangga.sch.id
- 💬 WhatsApp: 0812-xxxx-xxxx

---

**Version:** 2.0.2  
**Last Updated:** 2024-01-15  
**Author:** IT Team SMK TI Airlangga  
**Status:** ✅ Production Ready