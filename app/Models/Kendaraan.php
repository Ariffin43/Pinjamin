<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $table = 'kendaraan';

    protected $fillable = [
        'id_merek',
        'atas_nama',
        'seri',
        'no_plat',
        'jenis_kendaraan',
        'detail_kendaraan',
        'status_kendaraan',
        'lokasi_awal',
        'image',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    // Model Kendaraan
    public function merek()
    {
        return $this->belongsTo(Merek::class, 'id_merek');
    }

    public function peminjamanAktif()
    {
        return $this->hasOne(Peminjaman::class)->where('status_peminjaman', 'Di Terima');
    }

}
