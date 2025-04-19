<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;

class AppointmentPageTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_shows_the_appointment_form()
    {
        $response = $this->get(route('appointments.create'));

        $response->assertStatus(200);
        $response->assertViewIs('appointments.create');
        $response->assertSee('Dokter Umum');
        $response->assertSee('Dokter Bidan');
    }

    #[Test]
    public function it_stores_an_appointment_successfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $formData = [
            'tanggal_reservasi' => now()->toDateString(),
            'tanggal_pelaksanaan' => now()->addDay()->toDateString(),
            'waktu_pelaksanaan' => '10:00',
            'specialist' => 'Umum',
            'keluhan_utama' => 'Sakit kepala hebat',
        ];

        $response = $this->post(route('appointments.store'), $formData);

        $response->assertRedirect(route('appointments.create'));
        $response->assertSessionHas('success', 'Janji temu berhasil dibuat.');

        $this->assertDatabaseHas('appointments', [
            'user_id' => $user->id,
            'keluhan_utama' => 'Sakit kepala hebat',
            'specialist' => 'Umum'
        ]);
    }

    #[Test]
    public function it_fails_validation_when_required_fields_are_missing()
    {
        $response = $this->post(route('appointments.store'), []); // kosong

        $response->assertSessionHasErrors([
            'tanggal_reservasi',
            'tanggal_pelaksanaan',
            'waktu_pelaksanaan',
            'specialist',
            'keluhan_utama',
        ]);
    }

    #[Test]
    public function it_fails_validation_when_tanggal_pelaksanaan_is_before_tanggal_reservasi()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $formData = [
            'tanggal_reservasi' => now()->toDateString(),
            'tanggal_pelaksanaan' => now()->subDay()->toDateString(),
            'waktu_pelaksanaan' => '09:00',
            'specialist' => 'Umum',
            'keluhan_utama' => 'Demam',
        ];

        $response = $this->post(route('appointments.store'), $formData);

        $response->assertSessionHasErrors([
            'tanggal_pelaksanaan',
        ]);
    }
}
