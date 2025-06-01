<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VaccinationRegistration extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pengguna_id',
        'vaccine_id',
        'type',
        'vaccination_date',
        'vaccination_time',
        'allergies',
        'reminder_sent',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'vaccination_date' => 'date',
        'vaccination_time' => 'datetime:H:i',
        'reminder_sent' => 'boolean',
    ];

    /**
     * Get the user that owns the vaccination registration.
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(pengguna::class, 'pengguna_id');
    }

    /**
     * Get the vaccine that is associated with the vaccination registration.
     */
    public function vaccine(): BelongsTo
    {
        return $this->belongsTo(Vaccine::class);
    }
}