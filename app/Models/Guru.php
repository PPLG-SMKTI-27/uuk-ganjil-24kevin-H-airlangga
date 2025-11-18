<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = "guru";
    protected $primaryKey = "id_guru";
    public $timestamps = false;

    protected $fillable = ["nama_guru", "nip"];

    public function tamu()
    {
        return $this->hasMany(Tamu::class, "guru_tujuan", "id_guru");
    }
}
