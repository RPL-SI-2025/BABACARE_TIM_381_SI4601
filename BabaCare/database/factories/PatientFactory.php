<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    protected $model = Patient::class;

    public function definition(): array
    {
        return [
            'nama_pasien' => $this->faker->name,
            'nik' => $this->faker->unique()->numerify('################'), // 16 digit
            'gender' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'tanggal_lahir' => $this->faker->date(),
            'jenis_perawatan' => $this->faker->randomElement(['Rawat Inap', 'Rawat Jalan']),
            'waktu_periksa' => $this->faker->dateTime(),
            'penyakit' => $this->faker->word,
            'obat' => $this->faker->word,
            'hasil_pemeriksaan' => $this->faker->sentence
        ];
    }
}
