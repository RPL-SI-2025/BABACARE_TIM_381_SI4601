<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vaccine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'is_active',
    ];

    /**
     * Get the vaccination registrations for the vaccine.
     */
    public function vaccinationRegistrations(): HasMany
    {
        return $this->hasMany(VaccinationRegistration::class);
    }
}