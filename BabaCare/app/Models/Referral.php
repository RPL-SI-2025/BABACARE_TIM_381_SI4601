<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'kode_rujukan',
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
        $lastReferral = self::latest()->first();
        $nextNumber = $lastReferral ? intval(substr($lastReferral->kode_rujukan, -3)) + 1 : 1;
        return 'REF-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}