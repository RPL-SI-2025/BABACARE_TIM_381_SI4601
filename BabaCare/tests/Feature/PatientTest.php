<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_create_patient_success()
    {
        $this->authenticate();

        $response = $this->post(route('patients.store'), [
            'nama_pasien' => 'Budi Santoso',
            'nik' => '1234567890123456',
            'gender' => 'Laki-laki',
            'tanggal_lahir' => '2000-01-01',
            'jenis_perawatan' => 'Rawat Jalan',
            'waktu_periksa' => '2025-04-19',
            'penyakit' => 'Demam',
            'obat' => 'Paracetamol',
            'hasil_pemeriksaan' => 'Suhu tubuh tinggi',
        ]);

        $response->assertRedirect(route('patients.index'));
        $this->assertDatabaseHas('patients', ['nik' => '1234567890123456']);
    }

    public function test_create_patient_validation_error()
    {
        $this->authenticate();

        $response = $this->post(route('patients.store'), [
            // nama_pasien is missing
            'nik' => '1234567890123456',
            'gender' => 'Laki-laki',
            'tanggal_lahir' => '2000-01-01',
            'jenis_perawatan' => 'Rawat Jalan',
            'waktu_periksa' => '2025-04-19',
            'penyakit' => 'Demam',
            'obat' => 'Paracetamol',
            'hasil_pemeriksaan' => 'Suhu tubuh tinggi',
        ]);

        $response->assertSessionHasErrors(['nama_pasien']);
    }

    public function test_duplicate_nik()
    {
        $this->authenticate();

        Patient::factory()->create([
            'nik' => '1234567890123456'
        ]);

        $response = $this->post(route('patients.store'), [
            'nama_pasien' => 'Andi',
            'nik' => '1234567890123456',
            'gender' => 'Laki-laki',
            'tanggal_lahir' => '1990-02-02',
            'jenis_perawatan' => 'Rawat Inap',
            'waktu_periksa' => '2025-04-19',
            'penyakit' => 'Batuk',
            'obat' => 'OBH',
            'hasil_pemeriksaan' => 'Batuk kering',
        ]);

        $response->assertSessionHasErrors(['nik']);
    }

    public function test_update_patient()
    {
        $this->authenticate();

        $patient = Patient::factory()->create();

        $response = $this->put(route('patients.update', $patient), [
            'nama_pasien' => 'Update Nama',
            'nik' => $patient->nik,
            'gender' => 'Laki-laki',
            'tanggal_lahir' => '1999-01-01',
            'jenis_perawatan' => 'Rawat Jalan',
            'waktu_periksa' => '2025-04-19',
            'penyakit' => 'Flu',
            'obat' => 'Antibiotik',
            'hasil_pemeriksaan' => 'Panas turun',
        ]);

        $response->assertRedirect(route('patients.show', $patient));
        $this->assertDatabaseHas('patients', ['nama_pasien' => 'Update Nama']);
    }

    public function test_delete_patient()
    {
        $this->authenticate();

        $patient = Patient::factory()->create();

        $response = $this->delete(route('patients.destroy', $patient));

        $response->assertRedirect(route('patients.index'));
        $this->assertDatabaseMissing('patients', ['id' => $patient->id]);
    }
}
