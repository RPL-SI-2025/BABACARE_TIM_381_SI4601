<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use HasFactory;

    protected $table = 'prescription';

    protected $fillable = [
        'patient_id',
        'prescription_code',
        'drugs_allergies',
        'obat_id',
        'staff_id',
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
    
    public function obats()
    {
        return $this->hasMany(Obat::class,'obat_id');
    }

    public static function generatePrescriptionCode()
    {
        $lastPrescription = self::latest()->first();
        $nextNumber = $lastPrescription ? intval(substr($lastPrescription->prescription_code, -3)) + 1 : 1;
        return 'PRESC-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}