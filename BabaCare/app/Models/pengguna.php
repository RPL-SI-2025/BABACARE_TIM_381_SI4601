<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class pengguna extends Authenticatable
{
    use Notifiable;

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
        'allergy'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
