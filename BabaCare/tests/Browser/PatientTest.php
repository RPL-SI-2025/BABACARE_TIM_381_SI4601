<?php

namespace Tests\Browser;

use App\Models\Patient;
use App\Models\pengguna;
use Laravel\Dusk\Browser;
use App\Models\Obat;
use Tests\DuskTestCase;
use Faker\Factory as Faker;

class PatientTest extends DuskTestCase
{
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create('id_ID'); // Using Indonesian locale for more realistic data
    }

    /**
     * A Dusk test patien.
     * @group petugas
     * Test apakah petugas bisa mengakses homepage dan crud petugas
     */

    protected function createUserAndLogin(Browser $browser)
    {
        $user = pengguna::factory()->petugas()->create([
            'password' => bcrypt('password')
        ]);

        $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->waitForLocation('/petugas')
                ->assertPathIs('/petugas');
    }

    /**
     * @group create
     */
    public function test_create_patient_success()
    {
        $this->browse(function (Browser $browser) {
            // Generate random patient data
            $obat = Obat::create([
                'nama_obat' => 'Test Medicine',
                'jenis_obat' => 'Test Type'
            ]);

            $patientData = [
                'nama_pasien' => $this->faker->name,
                'nik' => $this->faker->numerify('################'),
                'gender' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
                'address' => $this->faker->address,
                'tanggal_lahir' => $this->faker->date('Y-m-d', '-18 years'),
                'jenis_perawatan' => $this->faker->randomElement(['Rawat Inap', 'Rawat Jalan', 'UGD']),
                'waktu_periksa' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d\TH:i'),
                'penyakit' => $this->faker->randomElement(['Demam', 'Flu', 'Batuk', 'Diare', 'Lainnya']),
                'obat' => $this->faker->randomElement(['Paracetamol', 'Amoxicillin', 'Ibuprofen', 'Lainnya']),
                'hasil_pemeriksaan' => $this->faker->sentence(10),
                'allergy' => 'Test Allergy Information',
                'obat_id' => $obat->id,
                'tanggal_reservasi'=> now()->format('Y-m-d'),
                'tanggal_pelaksanaan'=> now()->format('Y-m-d'),
                'keluhan'=> 'sakit hati',
                'pengguna_id' => 3,
                'appointment_id' => 1,
            ];

            $this->createUserAndLogin($browser);

            $browser->visit('/patients/create')
                ->type('@nama_pasien', $patientData['nama_pasien'])
                ->type('@nik', $patientData['nik'])
                ->select('@gender', $patientData['gender'])
                ->type('@tanggal_lahir', $patientData['tanggal_lahir'])
                ->select('@jenis_perawatan', $patientData['jenis_perawatan'])
                ->type('@waktu_periksa', $patientData['waktu_periksa'])
                ->select('@penyakit', $patientData['penyakit'])
                ->select('@obat', $patientData['obat'])
                ->type('@hasil_pemeriksaan', $patientData['hasil_pemeriksaan'])
                ->press('@submit-button')
                ->waitFor('.swal2-confirm', 10)
                ->click('.swal2-confirm')
                ->waitForLocation('/patients', 10)
                ->assertPathIs('/patients')
                ->assertSee($patientData['nama_pasien'])
                ->assertSee('Data pasien berhasil ditambahkan');

            $this->assertDatabaseHas('patients', [
                'nik' => $patientData['nik'],
                'nama_pasien' => $patientData['nama_pasien'],
                'gender' => $patientData['gender'],
                'jenis_perawatan' => $patientData['jenis_perawatan'],
                'penyakit' => $patientData['penyakit'],
                'obat' => $patientData['obat']
            ]);
        });
    }

    /**
     * Test validasi gagal saat form kosong.
     * @group validation
     */
    public function test_create_patient_validation_error()
    {
        $this->browse(function (Browser $browser) {
            $this->createUserAndLogin($browser);

            $browser->visit('/patients/create')
                ->click('@submit-patient')
                ->waitFor('.swal2-confirm', 10)
                ->click('.swal2-confirm')
                ->waitFor('.bg-red-50', 10) // Wait for error alert
                ->assertSee('Nama pasien wajib diisi.')
                ->assertSee('NIK wajib diisi.')
                ->assertSee('Gender wajib diisi.')
                ->assertSee('Tanggal lahir wajib diisi.')
                ->assertSee('Jenis perawatan wajib diisi.')
                ->assertSee('Waktu periksa wajib diisi.')
                ->assertSee('Penyakit wajib diisi.')
                ->assertSee('Obat wajib diisi.')
                ->assertSee('Hasil pemeriksaan wajib diisi.');
        });
    }

    /**
     * Test update data pasien dari UI.
     * @group update
     */
    public function test_update_patient()
    {
        $obat = Obat::create([
            'nama_obat' => 'Test Medicine',
            'jenis_obat' => 'Test Type'
        ]);
        $patient = Patient::factory()->create([
                'nama_pasien' => $this->faker->name,
                'nik' => $this->faker->numerify('################'),
                'gender' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
                'address' => $this->faker->address,
                'tanggal_lahir' => $this->faker->date('Y-m-d', '-18 years'),
                'jenis_perawatan' => $this->faker->randomElement(['Rawat Inap', 'Rawat Jalan', 'UGD']),
                'waktu_periksa' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d\TH:i'),
                'penyakit' => $this->faker->randomElement(['Demam', 'Flu', 'Batuk', 'Diare', 'Lainnya']),
                // 'obat' => $this->faker->randomElement(['Paracetamol', 'Amoxicillin', 'Ibuprofen', 'Lainnya']),
                'hasil_pemeriksaan' => $this->faker->sentence(10),
                'allergy' => 'Test Allergy Information',
                'obat_id' => $obat->id,
                'tanggal_reservasi'=> now()->format('Y-m-d'),
                'tanggal_pelaksanaan'=> now()->format('Y-m-d'),
                'keluhan'=> 'sakit hati',
                'pengguna_id' => 3,
                'appointment_id' => 1,
            ]);

        $this->browse(function (Browser $browser) use ($patient) {
            $this->createUserAndLogin($browser);

            $browser->visit("/patients/{$patient->id}/edit")
                ->type('nama_pasien', 'Update Nama')
                ->select('penyakit', 'Demam')
                ->select('obat', 'Paracetamol')
                ->press('Update')
                ->waitFor('.swal2-confirm', 10)
                ->click('.swal2-confirm')
                ->waitForLocation("/patients/{$patient->id}", 10)
                ->assertPathIs("/patients/{$patient->id}");

            $this->assertDatabaseHas('patients', ['nama_pasien' => 'Update Nama']);

        });
    }

    /**
     * Test hapus pasien dari UI.
     * @group delete
     */
    public function test_delete_patient()
    {
        $obat = Obat::create([
            'nama_obat' => 'Test Medicine',
            'jenis_obat' => 'Test Type'
        ]);
        $patient = Patient::factory()->create([
            'nama_pasien' => $this->faker->name,
            'nik' => $this->faker->numerify('################'),
            'gender' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'address' => $this->faker->address,
            'tanggal_lahir' => $this->faker->date('Y-m-d', '-18 years'),
            'jenis_perawatan' => $this->faker->randomElement(['Rawat Inap', 'Rawat Jalan', 'UGD']),
            'waktu_periksa' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d\TH:i'),
            'penyakit' => $this->faker->randomElement(['Demam', 'Flu', 'Batuk', 'Diare', 'Lainnya']),
            // 'obat' => $this->faker->randomElement(['Paracetamol', 'Amoxicillin', 'Ibuprofen', 'Lainnya']),
            'hasil_pemeriksaan' => $this->faker->sentence(10),
            'allergy' => 'Test Allergy Information',
            'obat_id' => $obat->id,
            'tanggal_reservasi'=> now()->format('Y-m-d'),
            'tanggal_pelaksanaan'=> now()->format('Y-m-d'),
            'keluhan'=> 'sakit hati',
            'pengguna_id' => 3,
            'appointment_id' => 1,
        ]);

        $this->browse(function (Browser $browser) use ($patient) {
            $this->createUserAndLogin($browser);

            $browser->visit('/patients')
                ->press("@delete-button-{$patient->id}")   // Klik tombol delete
                ->pause(500)                               // Tunggu modal muncul
                ->waitFor('.swal2-confirm', 5)              // Tunggu tombol konfirmasi muncul
                ->press('Ya, Hapus!')                  // Klik tombol konfirmasi
                ->pause(2000)                              // Tunggu beberapa detik setelah submit
                ->assertDontSee($patient->nama_pasien);    // Pastikan pasien sudah tidak terlihat

            $this->assertDatabaseMissing('patients', ['id' => $patient->id]); // Pastikan pasien sudah terhapus
        });
    }
}
