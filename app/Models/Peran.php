<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peran extends Model
{
    protected $table = "peran";
    protected $primaryKey = "id_peran";
    public $timestamps = false;

    protected $fillable = ["nama_peran"];

    public function pengguna()
    {
        return $this->hasMany(Pengguna::class, "peran_id");
    }
}
