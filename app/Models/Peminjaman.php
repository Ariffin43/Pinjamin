<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'id_user',
        'id_kendaraan',
        'status_peminjaman',
        'tujuan_peminjaman',
        'tanggal_awal_peminjaman',
        'tanggal_akhir_peminjaman',
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
