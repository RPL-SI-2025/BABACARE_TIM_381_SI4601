<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_rumah_sakit',
        'kode_rumah_sakit',
        'nama_staff',
        'alamat',
        'no_telepon',
        'email',
        'tipe',
        'deskripsi',
        'is_rujukan'
    ];

    public function originReferrals()
    {
        return $this->hasMany(Referral::class, 'origin_hospital_id');
    }

    public function destinationReferrals()
    {
        return $this->hasMany(Referral::class, 'destination_hospital_id');
    }

    public function scopeRujukan($query)
    {
        return $query->where('is_rujukan', true);
    }

    public function getTipeAttribute($value)
    {
        return ucfirst($value);
    }

    public static function getDropdownOptions()
    {
        return self::rujukan()->pluck('nama_rumah_sakit', 'id');
    }
}