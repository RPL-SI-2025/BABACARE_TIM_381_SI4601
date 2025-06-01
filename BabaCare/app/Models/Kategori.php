<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori']; // kolom yang bisa diisi

    public function obats()
    {
        return $this->hasMany(Obat::class, 'kategori_id'); // Sesuaikan nama kolom jika perlu
    }
}
