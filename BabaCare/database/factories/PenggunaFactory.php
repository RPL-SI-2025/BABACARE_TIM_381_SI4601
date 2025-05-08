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
            'updated_at' => now()
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


