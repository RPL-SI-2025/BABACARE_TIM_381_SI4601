<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomepageTest extends TestCase
{
    /**
     * Test apakah homepage dapat diakses.
     *
     * @return void
     */
    public function testHomePageLoadsSuccessfully()
    {
        $response = $this->get('/'); // Mengakses landingpage

        // Memastikan status code 200 (OK)
        $response->assertStatus(200);
        
        // Memastikan halaman memiliki teks tertentu
        $response->assertSee('Selamat Datang di BabaCare'); 
    }

    /**
     * Test apakah navbar links berfungsi.
     *
     * @return void
     */
    public function testNavbarLinks()
    {
        // Mengakses homepage dan menguji link pada navbar
        $response = $this->get('/'); // Mengakses landingpage

        // Memastikan teks yang ada pada navbar terlihat
        $response->assertSeeText('Dashboard');
        $response->assertSeeText('Management Pasien');
        $response->assertSeeText('Laporan Data Pasien');
    }

    /**
     * Test apakah gambar di homepage berhasil dimuat.
     *
     * @return void
     */
    public function testHomepageImages()
    {
        $response = $this->get('/'); // Mengakses landingpage

        // Memastikan gambar ada di halaman
        $response->assertSee('<img', false); // Menggunakan assertSee untuk memastikan tag <img> ada
    }
}
?>