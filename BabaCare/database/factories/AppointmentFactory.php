<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        return [
            'tanggal_reservasi' => now()->format('Y-m-d'),
            'tanggal_pelaksanaan' => now()->addDays(2)->format('Y-m-d'),
            'waktu_pelaksanaan' => now()->addDays(2)->format('Y-m-d').' 10:30:00',
            'keluhan_utama' => $this->faker->randomElement(['sakit keras', 'sakit jiwa']),
            'keluhan' => $this->faker->sentence,
            'status' => 'confirmed',
        ];
    }
}

