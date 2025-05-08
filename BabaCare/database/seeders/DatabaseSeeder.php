<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use App\Models\Obat;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        Pengguna::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        // Create test patient
        Pengguna::create([
            'name' => 'Test Patient',
            'email' => 'patient@example.com',
            'password' => Hash::make('password'),
            'role' => 'user'
        ]);

        // Create some test medications
        $obats = [
            [
                'nama_obat' => 'Paracetamol',
                'deskripsi' => 'Obat untuk menurunkan demam dan meredakan nyeri',
                'stok' => 100
            ],
            [
                'nama_obat' => 'Amoxicillin',
                'deskripsi' => 'Antibiotik untuk infeksi bakteri',
                'stok' => 50
            ],
            [
                'nama_obat' => 'Ibuprofen',
                'deskripsi' => 'Anti inflamasi non steroid',
                'stok' => 75
            ]
        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }
    }
}
