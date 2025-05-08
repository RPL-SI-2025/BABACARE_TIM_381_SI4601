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
        'address',
        'allergy',
        'tanggal_reservasi',
        'tanggal_pelaksanaan',
        'keluhan',
        'jenis_perawatan',
        'waktu_periksa',
        'penyakit',
        'obat_id',
        'hasil_pemeriksaan',
        'pengguna_id',
        'appointment_id'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_reservasi' => 'date',
        'tanggal_pelaksanaan' => 'date',
        'waktu_periksa' => 'datetime'
    ];

    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
