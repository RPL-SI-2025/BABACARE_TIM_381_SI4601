<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class pengguna extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $table = 'penggunas';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'first_name',
        'last_name',
        'age',
        'birth_date',
        'phone',
        'address',
        'visit_history',
        'disease_history',
        'allergy',
        'nik',
        'gender'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

        public function hasRole($role)
    {
        return $this->role === $role;
    }

    /**
     * Get the vaccination registrations for the user.
     */
    public function vaccinationRegistrations(): HasMany
    {
        return $this->hasMany(VaccinationRegistration::class, 'pengguna_id');
    }

    /**
     * Get the referral for the user.
     */
    public function referral(): HasMany
    {
        return $this->hasMany(Referral::class, 'staff_id');
    }
}

