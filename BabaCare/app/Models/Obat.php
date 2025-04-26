<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan penamaan konvensional
    protected $table = 'obats';

    // Tentukan kolom yang bisa diisi (fillable)
    protected $fillable = [
        'nama_obat',
        'kategori',
        'golongan',   
    ];

}
