<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merek extends Model
{
    protected $table = 'merek';

    protected $fillable = [
        'id',
        'nama',
    ];
    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class, 'id_merek');
    }
}