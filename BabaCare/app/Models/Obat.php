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
        'kategori_id',
        'golongan_id',
    ];

    public function patients()
    {
        return $this->hasMany(Patient::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id'); // Sesuaikan nama kolom jika perlu
    }

    // Relasi ke tabel Golongan
    public function golongan()
    {
        return $this->belongsTo(Golongan::class, 'golongan_id'); // Sesuaikan nama kolom jika perlu
    }
}
