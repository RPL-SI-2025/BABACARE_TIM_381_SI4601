<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pasien',
        'nik',
        'gender',
        'tanggal_lahir',
        'jenis_perawatan',
        'waktu_periksa',
        'penyakit',
        'obat',
        'hasil_pemeriksaan'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'waktu_periksa' => 'datetime'
    ];
}
