<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = "log_aktivitas";
    protected $primaryKey = "id_log";
    public $timestamps = true;

    protected $fillable = [
        "id_pengguna",
        "aktivitas",
        "tabel_terkait",
        "id_record",
        "ip_address",
        "user_agent",
        "created_at",
        "updated_at",
    ];

    protected $casts = [
        "created_at" => "datetime",
        "updated_at" => "datetime",
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, "id_pengguna");
    }
}
