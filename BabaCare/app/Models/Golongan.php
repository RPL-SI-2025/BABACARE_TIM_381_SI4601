<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    use HasFactory;

    protected $fillable = ['nama_golongan']; // kolom yang bisa diisi secara massal

    public function obats()
    {
        return $this->hasMany(Obat::class, 'golongan_id'); // Sesuaikan nama kolom jika perlu
    }
}
