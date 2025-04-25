<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    
    protected $table = 'jurusan';

    protected $fillable = [
        'id_jurusan', 
        'nama_jurusan'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_jurusan', 'id_jurusan');
    }
}
