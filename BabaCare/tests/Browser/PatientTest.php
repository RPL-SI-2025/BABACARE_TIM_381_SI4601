<?php

namespace Tests\Browser;

use App\Models\Patient;
use App\Models\pengguna;
use Laravel\Dusk\Browser;
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
            $patientData = [
                'nama_pasien' => $this->faker->name,
                'nik' => $this->faker->numerify('################'), // 16 digit NIK
                'gender' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
                'tanggal_lahir' => $this->faker->date('Y-m-d', '-18 years'),
                'jenis_perawatan' => $this->faker->randomElement(['Rawat Inap', 'Rawat Jalan', 'UGD']),
                'waktu_periksa' => $this->faker->dateTimeBetween('now', '+1 month')->format('Y-m-d\TH:i'),
                'penyakit' => $this->faker->randomElement(['Demam', 'Flu', 'Batuk', 'Diare', 'Lainnya']),
                'obat' => $this->faker->randomElement(['Paracetamol', 'Amoxicillin', 'Ibuprofen', 'Lainnya']),
                'hasil_pemeriksaan' => $this->faker->sentence(10)
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
                ->click('@submit-button')
                ->waitFor('.swal2-confirm')
                ->click('.swal2-confirm')
                ->pause(2000)
                ->waitForLocation('/patients', 15)
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
                ->type('nik', '1234567890123456') // Kosongkan nama_pasien
                ->press('Simpan')
                ->assertSee('nama_pasien');
        });
    }

    /**
     * Test update data pasien dari UI.
     * @group update
     */
    public function test_update_patient()
    {
        $patient = Patient::factory()->create();

        $this->browse(function (Browser $browser) use ($patient) {
            $this->createUserAndLogin($browser);

            $browser->visit("/patients/{$patient->id}/edit")
                ->type('nama_pasien', 'Update Nama')
                ->type('obat', 'Antibiotik')
                ->press('Update') // Sesuaikan nama tombol submit
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
        $patient = Patient::factory()->create();

        $this->browse(function (Browser $browser) use ($patient) {
            $this->createUserAndLogin($browser);

            $browser->visit('/patients')
                ->press("@delete-button-{$patient->id}") // Gunakan dusk selector atau tombol sesuai ID
                ->whenAvailable('.swal2-confirm', function ($modal) {
                    $modal->click();
                })
                ->assertDontSee($patient->nama_pasien);

            $this->assertDatabaseMissing('patients', ['id' => $patient->id]);
        });
    }
}
