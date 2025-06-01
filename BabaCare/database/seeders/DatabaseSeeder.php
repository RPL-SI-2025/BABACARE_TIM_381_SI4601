<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use App\Models\Obat;
use App\Models\Vaccine;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // // Create admin user
        // Pengguna::create([
        //     'name' => 'Admin',
        //     'email' => 'admin@example.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'admin',
        // ]);

        // // Create petugas user
        // Pengguna::create([
        //     'name' => 'Petugas',
        //     'email' => 'petugas@example.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'petugas'
        // ]);

        // // Create test patient
        // Pengguna::create([
        //     'name' => 'Test Patient',
        //     'email' => 'patient@example.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'user'
        // ]);

        $vaccines = [
            [
                'name' => 'COVID-19',
                'description' => 'Vaksin untuk pencegahan COVID-19',
                'type' => 'vaccine',
                'is_active' => true,
            ],
            [
                'name' => 'BCG',
                'description' => 'Bacillus Calmette-Guérin vaccine',
                'type' => 'vaccine',
                'is_active' => true,
            ],
            [
                'name' => 'DPT',
                'description' => 'Difteri, Pertussis, Tetanus vaccine',
                'type' => 'vaccine',
                'is_active' => true,
            ],
            [
                'name' => 'Polio',
                'description' => 'Vaksin untuk pencegahan polio',
                'type' => 'vaccine',
                'is_active' => true,
            ],
            [
                'name' => 'Campak',
                'description' => 'Vaksin untuk pencegahan campak',
                'type' => 'vaccine',
                'is_active' => true,
            ],
            [
                'name' => 'Imunisasi Dasar',
                'description' => 'Imunisasi dasar untuk bayi 0-12 bulan',
                'type' => 'immunization',
                'is_active' => true,
            ],
            [
                'name' => 'Imunisasi Lanjutan',
                'description' => 'Imunisasi lanjutan untuk anak 18 bulan - 5 tahun',
                'type' => 'immunization',
                'is_active' => true,
            ],
            [
                'name' => 'Imunisasi Dewasa',
                'description' => 'Imunisasi untuk usia dewasa',
                'type' => 'immunization',
                'is_active' => true,
            ],
            [
                'name' => 'Imunisasi Khusus',
                'description' => 'Imunisasi khusus sesuai kebutuhan',
                'type' => 'immunization',
                'is_active' => true,
            ],
        ];

        foreach ($vaccines as $vaccine) {
            Vaccine::create($vaccine);
        }

        $hospitals = [
            [
                'nama_rumah_sakit' => 'RS Sentosa Utama',
                'kode_rumah_sakit' => 'RSU-001',
                'nama_staff' => 'mahmud',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta Pusat',
                'no_telepon' => '(021) 1234-5678',
                'email' => 'info@rssentosautama.com',
                'tipe' => 'Swasta',
                'deskripsi' => 'Rumah sakit umum dengan fasilitas lengkap dan pelayanan terbaik',
                'is_rujukan' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_rumah_sakit' => 'RSUD Dr. Soetomo',
                'kode_rumah_sakit' => 'RSUD-002',
                'nama_staff' => 'mahmud',
                'alamat' => 'Jl. Mayjen Prof. Dr. Moestopo No. 6-8, Surabaya',
                'no_telepon' => '(031) 5501-5501',
                'email' => 'info@rsudsoetomo.go.id',
                'tipe' => 'Pemerintah',
                'deskripsi' => 'Rumah sakit pemerintah terkemuka dengan layanan kesehatan komprehensif',
                'is_rujukan' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_rumah_sakit' => 'RS Siloam Hospitals',
                'kode_rumah_sakit' => 'RSH-003',
                'nama_staff' => 'mahmud',
                'alamat' => 'Jl. Let. Jend. MT. Haryono Kav. 10, Jakarta Selatan',
                'no_telepon' => '(021) 2996-9999',
                'email' => 'info@siloamhospitals.com',
                'tipe' => 'Swasta',
                'deskripsi' => 'Jaringan rumah sakit swasta dengan standar internasional',
                'is_rujukan' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_rumah_sakit' => 'RS Akademik Universitas Indonesia',
                'kode_rumah_sakit' => 'RSA-004',
                'nama_staff' => 'mahmud',
                'alamat' => 'Kampus UI, Depok, Jawa Barat',
                'no_telepon' => '(021) 7863-4567',
                'email' => 'rsui@ui.ac.id',
                'tipe' => 'Akademik',
                'deskripsi' => 'Rumah sakit pendidikan dengan focus pada penelitian dan pengembangan medis',
                'is_rujukan' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama_rumah_sakit' => 'RS Khusus Mata Dr. Yap',
                'kode_rumah_sakit' => 'RSK-005',
                'nama_staff' => 'mahmud',
                'alamat' => 'Jl. Cihampelas No. 70, Bandung',
                'no_telepon' => '(022) 2532-7070',
                'email' => 'info@rsmatadr.yap.com',
                'tipe' => 'Khusus',
                'deskripsi' => 'Rumah sakit spesialis mata dengan teknologi tercanggih',
                'is_rujukan' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        // pakai array chunk make sure data keinput
        foreach (array_chunk($hospitals, 50) as $chunk) {
            DB::table('hospitals')->insert($chunk);
        }

    }
}
