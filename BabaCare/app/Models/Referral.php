<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'referral_code',
        'origin_hospital_id',
        'destination_hospital_id',
        'hasil_pemeriksaan',
        'pengobatan_sementara',
        'keadaan_saat_rujuk',
        'staff_id',
        'gender',
        'address'
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function staff()
    {
        return $this->belongsTo(pengguna::class, 'staff_id');
    }

    public function originHospital()
    {
        return $this->belongsTo(Hospital::class, 'origin_hospital_id');
    }

    public function destinationHospital()
    {
        return $this->belongsTo(Hospital::class, 'destination_hospital_id');
    }

    public static function generateReferralCode()
    {
        do {
            $timestamp = base_convert(time(), 10, 36); 
            $random = Str::upper(Str::random(5));      

            $suffix = substr($timestamp . $random, 0, 10);
            $code = 'REF-' . $suffix;
        } while (self::where('referral_code', $code)->exists());

        return $code;
    }
}