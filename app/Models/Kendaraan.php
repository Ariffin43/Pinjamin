<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraan';

    protected $fillable = [
        'merk',
        'seri',
        'no_plat',
        'jenis_kendaraan',
        'detail_kendaraan',
        'status_kendaraan',
        'image',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
    public function peminjamanAktif()
    {
        return $this->hasOne(Peminjaman::class)->where('status_peminjaman', 'Di Terima');
    }

}
