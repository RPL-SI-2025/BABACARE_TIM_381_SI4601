<?php

namespace App\Models;

use Illuminate\Support\Str;
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
        do {
            $timestamp = base_convert(time(), 10, 36); 
            $random = Str::upper(Str::random(5));      

            $suffix = substr($timestamp . $random, 0, 10);
            $code = 'PRESC-' . $suffix;
        } while (self::where('prescription_code', $code)->exists());

        return $code;
    }
}