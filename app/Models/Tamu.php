<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    protected $table = "tamu";
    protected $primaryKey = "id_tamu";
    public $timestamps = true;

    protected $fillable = [
        "nama",
        "telepon",
        "status",
        "id_jenis",
        "tujuan",
        "guru_tujuan",
        "alamat",
        "keterangan",
        "tanggal_kunjungan",
        "waktu_masuk",
        "waktu_keluar",
        "status_kunjungan",
        "created_by",
        "deleted_at",
        "created_at",
        "updated_at",
    ];

    protected $casts = [
        "tanggal_kunjungan" => "date",
        "waktu_masuk" => "datetime",
        "waktu_keluar" => "datetime",
        "deleted_at" => "datetime",
        "created_at" => "datetime",
        "updated_at" => "datetime",
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, "guru_tujuan");
    }

    public function jenisKunjungan()
    {
        return $this->belongsTo(JenisKunjungan::class, "id_jenis");
    }

    public function createdBy()
    {
        return $this->belongsTo(Pengguna::class, "created_by");
    }
}
