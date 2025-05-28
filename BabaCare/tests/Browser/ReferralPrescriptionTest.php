<?php

namespace Tests\Browser;

use App\Models\Patient;
use App\Models\Hospital;
use App\Models\Referral;
use App\Models\Prescription;
use App\Models\Obat;
use App\Models\pengguna;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Faker\Factory as Faker;

class ReferralPrescriptionTest extends DuskTestCase
{
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create('id_ID');
    }

    /**
     * Create user and login - consistent with PatientTest
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
     * Test referral index page loads successfully
     * @group referral-index
     */
    public function test_referral_index_page_loads_successfully()
    {
        $this->browse(function (Browser $browser) {
            $this->createUserAndLogin($browser);

            $browser->visit('/referrals')
                    ->assertSee('Surat Dokter')
                    ->assertSee('Rujukan')
                    ->assertSee('Tambah Rujukan')
                    ->waitFor('th[data-sort="patient_id"]', 10)
                    ->assertPresent('th[data-sort="patient_id"]')
                    ->assertPresent('th[data-sort="referral_code"]')
                    ->assertPresent('th[data-sort="nama_pasien"]');
        });
    }

    /**
     * Test prescription index page loads successfully
     * @group prescription-index
     */
    public function test_prescription_index_page_loads_successfully()
    {
        $this->browse(function (Browser $browser) {
            $this->createUserAndLogin($browser);

            $browser->visit('/referrals?category=resep')
                    ->pause(2000)
                    ->waitFor('table', 10)
                    ->assertSee('Surat Dokter')
                    ->assertSee('Resep Obat')
                    ->assertSee('Tambah Resep')
                    ->waitFor('th[data-sort="patient_id"]', 10)
                    ->assertPresent('th[data-sort="patient_id"]')
                    ->assertPresent('th[data-sort="prescription_code"]')
                    ->assertPresent('th[data-sort="nama_pasien"]');
        });
    }

    /**
     * Test successful referral creation
     * @group create-referral
     */
    public function test_create_referral_successfully()
    {
        $this->browse(function (Browser $browser) {
            $this->createUserAndLogin($browser);

            $browser->visit('/referrals')
                    ->clickLink('Tambah Rujukan')
                    ->waitForLocation('/referrals/create')
                    ->assertPathIs('/referrals/create')
                    ->assertSee('Tambah Surat Dokter');

            $referralData = [
                'patient_id' => '1',
                'destination_hospital_id' => '1',
                'keadaan_saat_rujuk' => 'Pasien dalam kondisi stabil namun memerlukan pemeriksaan lanjutan di rumah sakit tujuan untuk penanganan yang lebih spesifik'
            ];

            $browser->select('@patient_id', $referralData['patient_id'])
                ->pause(1000)
                ->select('@destination_hospital_id', $referralData['destination_hospital_id'])
                ->type('@keadaan_saat_rujuk', $referralData['keadaan_saat_rujuk'])
                ->pause(2000)
                ->scrollIntoView('@submit-referral')
                ->pause(500)
                ->click('@submit-referral')
                ->waitForLocation('/referrals', 10)
                ->assertPathIs('/referrals')
                ->waitFor('.swal2-container', 10)
                ->assertSee('Berhasil');


            // Verify we're redirected to referrals index

            // Verify referral was created in database
            $this->assertDatabaseHas('referrals', [
                'patient_id' => $referralData['patient_id'],
                'destination_hospital_id' => $referralData['destination_hospital_id'],
                'keadaan_saat_rujuk' => $referralData['keadaan_saat_rujuk']
            ]);
        });
    }

    /**
     * Test referral creation validation errors
     * @group validation-referral
     */
    public function test_create_referral_validation_errors()
    {
        $this->browse(function (Browser $browser) {
            $this->createUserAndLogin($browser);

            $browser->visit('/referrals/create')
                    ->scrollIntoView('@submit-referral')
                    ->pause(500)
                    ->click('@submit-referral')
                    ->waitFor('.text-red-500', 10)
                    ->assertSee('The patient id field is required.')
                    ->assertSee('The destination hospital id field is required.');
        });
    }

    /**
     * Test successful referral update
     * @group update-referral
     */
    public function test_update_referral_successfully()
    {
        $referral = Referral::create([
            'patient_id' => 1,
            'destination_hospital_id' => 1,
            'keadaan_saat_rujuk' => 'Pasien dalam keadaan kritis dan butuh penanganan segera',
            'referral_code' => 'REF-' . uniqid(),
            'origin_hospital_id' => 1,
            'staff_id' => 1,
        ]);


        $updatedCondition = 'Pasien membaik, tapi masih perlu perawatan lanjutan';

        $this->browse(function (Browser $browser) use ($referral, $updatedCondition) {
            $this->createUserAndLogin($browser);

            $browser->visit("/referrals/{$referral->id}/edit")
                    ->assertSee('Edit Surat Dokter')
                    ->type('@keadaan_saat_rujuk', $updatedCondition)
                    ->pause(1000)
                    ->scrollIntoView('@submit-referral')
                    ->pause(500)
                    ->click('@submit-referral')
                    ->waitForLocation('/referrals', 10)
                    ->assertPathIs('/referrals')
                    ->waitFor('.swal2-container', 10)
                    ->assertSee('Berhasil');
        });

        $this->assertDatabaseHas('referrals', [
            'id' => $referral->id,
            'keadaan_saat_rujuk' => $updatedCondition
        ]);
    }



    /**
     * Test referral deletion
     * @group delete-referral
     */
    public function test_delete_referral_successfully()
    {
        $referral = Referral::create([
            'patient_id' => 1,
            'destination_hospital_id' => 1,
            'keadaan_saat_rujuk' => 'Pasien dalam keadaan kritis dan butuh penanganan segera',
            'referral_code' => 'REF-' . uniqid(),
            'origin_hospital_id' => 1,
            'staff_id' => 1,
        ]);

        $this->browse(function (Browser $browser) use ($referral) {
            $this->createUserAndLogin($browser);

            $browser->visit('/referrals')
                    ->press("@delete-button-{$referral->id}")
                    ->pause(500)
                    ->waitFor('.swal2-confirm', 5)
                    ->press('Ya, Hapus!')
                    ->pause(2000)
                    ->assertSee('Rujukan berhasil dihapus');
        });

        // Verify referral was deleted
        $this->assertDatabaseMissing('referrals', [
            'id' => $referral->id
        ]);
    }

    /**
     * Test successful prescription creation
     * @group create-prescription
     */
    public function test_create_prescription_successfully()
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
            'allergy' => 'Test Allergy Information',
            'obat_id' => $obat->id,
            'tanggal_reservasi'=> now()->format('Y-m-d'),
            'tanggal_pelaksanaan'=> now()->format('Y-m-d'),
            'keluhan'=> 'sakit hati',
            'pengguna_id' => 3,
            'appointment_id' => 1,
        ]);

        $prescriptionData = [
            'drugs_allergies' => 'banyak pokoknya'
        ];

        $this->browse(function (Browser $browser) use ($patient, $prescriptionData) {
            $this->createUserAndLogin($browser);

            $browser->visit('/prescriptions/create')
                    ->assertSee('Tambah Resep Obat')
                    ->select('@patient_id', $patient->id)
                    ->pause(1000) // Wait for patient info to load
                    ->assertSee($patient->nama_pasien)
                    ->assertSee('Test Allergy Information')
                    ->type('@drugs_allergies', $prescriptionData['drugs_allergies'])
                    ->click('@submit-prescriptions')
                    ->waitForLocation('/referrals', 10)
                    ->assertQueryStringHas('category', 'resep')
                    ->assertSee('Berhasil');
        });

        // Verify prescription was created
        $this->assertDatabaseHas('prescription', [
            'patient_id' => $patient->id,
            'drugs_allergies' => $prescriptionData['drugs_allergies']
        ]);
    }

    /**
     * Test prescription creation validation errors
     * @group validation-prescription
     */
    public function test_create_prescription_validation_errors()
    {
        $this->browse(function (Browser $browser) {
            $this->createUserAndLogin($browser);

            $browser->visit('/prescriptions/create')
                    ->click('@submit-prescriptions')
                    ->waitFor('.text-red-500', 10)
                    ->assertSee('The patient id field is required.');
        });
    }

    /**
     * Test successful prescription update
     * @group update-prescription
     */
    public function test_update_prescription_successfully()
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
            'allergy' => 'Test Allergy Information',
            'obat_id' => $obat->id,
            'tanggal_reservasi'=> now()->format('Y-m-d'),
            'tanggal_pelaksanaan'=> now()->format('Y-m-d'),
            'keluhan'=> 'sakit hati',
            'pengguna_id' => 3,
            'appointment_id' => 1,
        ]);

        $prescription = Prescription::create([
            'patient_id' => $patient->id,
            'obat_id' => $obat->id,
            'prescription_code' => 'PRESC-' . uniqid(),
            'staff_id'=> 2,
        ]);

        $updatedAllergy = 'Updated allergy information from test';

        $this->browse(function (Browser $browser) use ($prescription, $updatedAllergy) {
            $this->createUserAndLogin($browser);

            $browser->visit("/prescriptions/{$prescription->id}/edit")
                    ->assertSee('Edit Resep Obat')
                    ->type('@drugs-allergies', $updatedAllergy)
                    ->scrollIntoView('@submit-prescriptions')
                    ->pause(500)
                    ->click('@submit-prescriptions')
                    ->waitForLocation('/referrals', 10)
                    ->assertQueryStringHas('category', 'resep')
                    ->assertSee('Resep obat berhasil diperbarui');
        });

        $this->assertDatabaseHas('prescription', [
            'id' => $prescription->id,
            'drugs_allergies' => $updatedAllergy
        ]);
    }

    /**
     * Test prescription deletion
     * @group delete-prescription
     */
    public function test_delete_prescription_successfully()
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
            'allergy' => 'Test Allergy Information',
            'obat_id' => $obat->id,
            'tanggal_reservasi'=> now()->format('Y-m-d'),
            'tanggal_pelaksanaan'=> now()->format('Y-m-d'),
            'keluhan'=> 'sakit hati',
            'pengguna_id' => 3,
            'appointment_id' => 1,
        ]);

        $prescription = Prescription::create([
            'patient_id' => $patient->id,
            'obat_id' => $obat->id,
            'prescription_code' => 'PRESC-' . uniqid(),
            'staff_id'=> 2,
        ]);

        $this->browse(function (Browser $browser) use ($prescription) {
            $this->createUserAndLogin($browser);

            $browser->visit('/referrals?category=resep')
                    ->press("@delete-button-{$prescription->id}")
                    ->pause(500)
                    ->waitFor('.swal2-confirm', 5)
                    ->press('Ya, Hapus!')
                    ->pause(2000)
                    ->assertSee('Resep obat berhasil dihapus');
        });

        // Verify prescription was deleted
        $this->assertDatabaseMissing('prescription', [
            'id' => $prescription->id
        ]);
    }

    /**
     * Test referral PDF download
     * @group download-referral
     */
    public function test_download_referral_pdf()
    {
        $hospital = Hospital::create([
            'nama_rumah_sakit' => 'ga sehat',
            'kode_rumah_sakit'=> 'RSU-'.uniqid(),
            'nama_staff'=> now()->format('Y-m-d'),
            'alamat'=> 'deket ko ga jauh',
            'no_telepon' => '08888888888',
            'email'=> 'test@gmail.co.id',
            'tipe' => 'swasta',
            'deskripsi' => 'rumah sakit gaul',
            'is_rujukan' => 1,
        ]);
        $patient = Patient::factory()->create([
            'nama_pasien' => $this->faker->name,
            'nik' => $this->faker->numerify('################'),
            'gender' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'address' => $this->faker->address,
            'allergy' => 'Test Allergy Information',
            'obat_id' => 1,
            'tanggal_reservasi'=> now()->format('Y-m-d'),
            'tanggal_pelaksanaan'=> now()->format('Y-m-d'),
            'keluhan'=> 'sakit hati',
            'pengguna_id' => 3,
            'appointment_id' => 1,
        ]);
        $referral = Referral::create([
            'patient_id' => $patient->id,
            'destination_hospital_id' => $hospital->id,
            'referral_code' => 'REF-'.uniqid(),
            'origin_hospital_id'=> 1,
            'staff_id' => 1,
        ]);

        $this->browse(function (Browser $browser) use ($referral) {
            $this->createUserAndLogin($browser);

            $browser->visit('/referrals')
                    ->click("@download-button-{$referral->id}")
                    ->pause(2000);
        });
    }

    /**
     * Test prescription PDF download
     * @group download-prescription
     */
    public function test_download_prescription_pdf()
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
            'allergy' => 'Test Allergy Information',
            'obat_id' => $obat->id,
            'tanggal_reservasi'=> now()->format('Y-m-d'),
            'tanggal_pelaksanaan'=> now()->format('Y-m-d'),
            'keluhan'=> 'sakit hati',
            'pengguna_id' => 3,
            'appointment_id' => 1,
        ]);

        $prescription = Prescription::create([
            'patient_id' => $patient->id,
            'obat_id' => $obat->id,
            'prescription_code' => 'PRESC-' . uniqid(),
            'staff_id'=> 2,
        ]);

        $this->browse(function (Browser $browser) use ($prescription) {
            $this->createUserAndLogin($browser);

            $browser->visit('/referrals?category=resep')
                    ->click("@download-button-{$prescription->id}")
                    ->pause(2000);
        });
    }

    /**
     * Test category switching between referral and prescription
     * @group category-switch
     */
    public function test_switch_between_referral_and_prescription_categories()
    {
        $this->browse(function (Browser $browser) {
            $this->createUserAndLogin($browser);

            $browser->visit('/referrals')
                    ->assertSee('Rujukan')
                    ->select('#category', 'resep')
                    ->pause(1000)
                    ->assertPathIs('/referrals')
                    ->assertQueryStringHas('category', 'resep')
                    ->assertSee('Resep Obat')
                    ->select('#category', 'rujukan')
                    ->pause(1000)
                    ->assertSee('Rujukan');
        });
    }

    /**
     * Test clear search functionality
     * @group clear-search
     */
    public function test_clear_search_functionality()
    {
        $this->browse(function (Browser $browser) {
            $this->createUserAndLogin($browser);

            $browser->visit('/referrals')
                    ->type('#searchInput', 'test search')
                    ->pause(500)
                    ->click('#clearSearch')
                    ->pause(500)
                    ->assertInputValue('#searchInput', '');
        });
    }
}