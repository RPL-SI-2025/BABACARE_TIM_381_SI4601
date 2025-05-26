<?php

namespace Database\Factories;

use App\Models\pengguna;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PenggunaFactory extends Factory
{
    protected $model = pengguna::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'created_at' => now(),
            'role' => 'admin',
            'updated_at' => now(),
            'email' => $this->faker->unique()->safeEmail(),
            'nik' => Str::random(10),
            'gender' => $this->faker->randomElement(['Perempuan','Laki-laki']),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'age' => $this->faker->numberBetween(1, 100),
            'birth_date' => now(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'visit_history' => $this->faker->postcode(),
            'disease_history' => Str::random(10),
            'allergy' => Str::random(10),
        ];
    }
    /**
     * State untuk admin.
     */
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return ['role' => 'admin'];
        });
    }

    /**
     * State untuk petugas.
     */
    public function petugas()
    {
        return $this->state(function (array $attributes) {
            return ['role' => 'petugas'];
        });
    }

    /**
     * State untuk user.
     */
    public function user()
    {
        return $this->state(function (array $attributes) {
            return ['role' => 'user'];
        });
    }
}


