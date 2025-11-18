<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    protected $table = "pengguna";
    protected $primaryKey = "id_pengguna";
    public $timestamps = false;

    protected $fillable = [
        "nama",
        "email",
        "password",
        "peran_id",
        "last_login",
    ];

    protected $hidden = ["password"];

    protected $casts = [
        "last_login" => "datetime",
    ];

    public function peran()
    {
        return $this->belongsTo(Peran::class, "peran_id", "id_peran");
    }

    public function tamu()
    {
        return $this->hasMany(Tamu::class, "created_by", "id_pengguna");
    }
}
