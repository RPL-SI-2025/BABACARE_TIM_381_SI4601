<?php

namespace Database\Factories;

use App\Models\TenagaMedis;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TenagaMedisFactory extends Factory
{
    protected $model = TenagaMedis::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password123'),
            'role' => 'petugas',
        ];
    }
}