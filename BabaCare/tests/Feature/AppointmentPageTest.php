<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\pengguna;
use Illuminate\Support\Carbon;

class AppointmentPageTest extends TestCase
{
    /** @test */
    public function authenticated_user_can_view_create_appointment_page()
    {
        $user = pengguna::first(); 

        $response = $this->actingAs($user)
                         ->get(route('appointments.create'));

        $response->assertStatus(200);
        $response->assertSee('Dokter Umum');
    }

    /** @test */
    public function authenticated_user_can_create_an_appointment()
    {
        $user = pengguna::first();

        $formData = [
            'tanggal_reservasi' => now()->addDay()->toDateString(),
            'tanggal_pelaksanaan' => now()->addDays(2)->toDateString(),
            'waktu_pelaksanaan' => '10:00',
            'specialist' => 'Umum',
            'keluhan_utama' => 'Demam dan sakit kepala',
        ];

        $response = $this->actingAs($user)
                         ->post(route('appointments.store'), $formData);

        $response->assertRedirect(route('appointments.create'));
        $response->assertSessionHas('success', 'Janji temu berhasil dibuat.');

        $this->assertDatabaseHas('appointments', [
            'user_id' => $user->id,
            'tanggal_reservasi' => $formData['tanggal_reservasi'],
            'specialist' => $formData['specialist'],
            'keluhan_utama' => $formData['keluhan_utama'],
        ]);
    }

    /** @test */
    public function it_shows_validation_errors_when_required_fields_are_missing()
    {
        $user = pengguna::first();

        $response = $this->actingAs($user)
                         ->post(route('appointments.store'), []);

        $response->assertSessionHasErrors([
            'tanggal_reservasi',
            'tanggal_pelaksanaan',
            'waktu_pelaksanaan',
            'specialist',
            'keluhan_utama',
        ]);
    }

    /** @test */
    public function it_shows_error_when_invalid_date_format_is_used()
    {
        $user = pengguna::first();

        $formData = [
            'tanggal_reservasi' => 'invalid-date',
            'tanggal_pelaksanaan' => now()->addDays(1)->toDateString(),
            'waktu_pelaksanaan' => '10:00',
            'specialist' => 'Umum',
            'keluhan_utama' => 'Sakit kepala',
        ];

        $response = $this->actingAs($user)
                         ->post(route('appointments.store'), $formData);

        $response->assertSessionHasErrors(['tanggal_reservasi']);
    }

    /** @test */
    public function it_shows_error_when_tanggal_pelaksanaan_is_before_reservasi()
    {
        $user = pengguna::first();

        $formData = [
            'tanggal_reservasi' => now()->addDays(3)->toDateString(),
            'tanggal_pelaksanaan' => now()->addDay()->toDateString(),
            'waktu_pelaksanaan' => '10:00',
            'specialist' => 'Umum',
            'keluhan_utama' => 'Batuk',
        ];

        $response = $this->actingAs($user)
                         ->post(route('appointments.store'), $formData);

        $response->assertSessionHasErrors(['tanggal_pelaksanaan']);
    }

    /** @test */
    public function it_allows_pelaksanaan_date_same_or_after_reservasi_date()
    {
        $user = pengguna::first();

        // tanggal_pelaksanaan == tanggal_reservasi
        $formData = [
            'tanggal_reservasi' => now()->toDateString(),
            'tanggal_pelaksanaan' => now()->toDateString(),
            'waktu_pelaksanaan' => '13:00',
            'specialist' => 'Umum',
            'keluhan_utama' => 'Pemeriksaan rutin',
        ];

        $response = $this->actingAs($user)
                        ->post(route('appointments.store'), $formData);

        $response->assertRedirect(route('appointments.create'));
        $response->assertSessionHas('success', 'Janji temu berhasil dibuat.');

        $this->assertDatabaseHas('appointments', [
            'user_id' => $user->id,
            'tanggal_reservasi' => $formData['tanggal_reservasi'],
            'tanggal_pelaksanaan' => $formData['tanggal_pelaksanaan'],
            'waktu_pelaksanaan' => $formData['waktu_pelaksanaan'],
        ]);

        // jika pelaksanaan > reservasi
        $formData['tanggal_pelaksanaan'] = now()->addDay()->toDateString();
        $response = $this->actingAs($user)
                        ->post(route('appointments.store'), $formData);

        $response->assertRedirect(route('appointments.create'));
        $response->assertSessionHas('success', 'Janji temu berhasil dibuat.');

        $this->assertDatabaseHas('appointments', [
            'user_id' => $user->id,
            'tanggal_pelaksanaan' => $formData['tanggal_pelaksanaan'],
        ]);
    }

}
