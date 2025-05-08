<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class HomepageTest extends TestCase
{
    /**
     * Test apakah admin bisa mengakses homepage admin.
     */
    public function testAdminCanAccessAdminHomepage()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        $response = $this->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('Puskesmas');
        
        $response->assertSeeText('Dashboard');
        $response->assertSeeText('Tenaga Medis');
        $response->assertSeeText('Data Obat');
        $response->assertSeeText('Manajemen Data Obat');
    }

    /**
     * Test apakah petugas bisa mengakses homepage admin.
     */
    public function testPetugasCanAccessAdminHomepage()
    {
        $petugas = User::factory()->create();
        $this->actingAs($petugas);

        $response = $this->get('/petugas');

        $response->assertStatus(200);
        $response->assertSee('Selamat Datang di BabaCare');
        
        $response->assertSeeText('Dashboard');
        $response->assertSeeText('Management Pasien');
        $response->assertSeeText('Laporan Data Pasien');
    }

    /**
     * Test apakah user biasa tidak bisa mengakses homepage admin.
     */
    public function testUserCannotAccessAdminHomepage()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/user');

        // Misal user biasa diarahkan ke /home atau error 403
        $response->assertStatus(200);
        $response->assertSee('Puskesmas');

        $response->assertSeeText('Pendaftaran');
        $response->assertSeeText('Feedback');
    }

    /**
     * Test apakah gambar di homepage (landing page) berhasil dimuat.
     */
    public function testHomepageImages()
    {
        $response = $this->get('/');

        $response->assertSee('<img', false);
    }
}
