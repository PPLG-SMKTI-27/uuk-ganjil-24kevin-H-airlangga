<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisKunjungan extends Model
{
    protected $table = "jenis_kunjungan";
    protected $primaryKey = "id_jenis";
    public $timestamps = false;

    protected $fillable = ["nama_jenis", "deskripsi"];

    public function tamu()
    {
        return $this->hasMany(Tamu::class, "id_jenis");
    }
}
