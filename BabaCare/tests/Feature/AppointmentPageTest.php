<?php

namespace Tests\Feature;

use App\Models\pengguna;
use App\Models\Appointment;
use Tests\TestCase;

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
}
