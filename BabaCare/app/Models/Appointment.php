<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pengguna_id',
        'tanggal_reservasi',
        'tanggal_pelaksanaan',
        'waktu_pelaksanaan',
        'specialist',
        'keluhan_utama',
        'keluhan',
        'status'
    ];

    protected $casts = [
        'tanggal_reservasi' => 'date',
        'tanggal_pelaksanaan' => 'date',
        'waktu_pelaksanaan' => 'datetime'
    ];

    /**
     * Get the user that owns the appointment.
     */
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }
}