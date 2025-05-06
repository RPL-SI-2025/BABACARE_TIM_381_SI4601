<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\pengguna;

class HomepageTest extends DuskTestCase
{
    /**
     * A Dusk test homepage.
     * @group admin
     * Test apakah admin bisa mengakses homepage admin.
     */
    public function testAdminCanAccessAdminHomepage()
    {
        $admin = pengguna::factory()->admin()->create();

        $this->browse(function (Browser $browser) use ($admin) {
            $browser->loginAs($admin)
                    ->visit('/admin')
                    ->assertPathIs('/admin')
                    ->assertSee('Dashboard')
                    ->assertSee('Tenaga Medis')
                    ->assertSee('Data Obat')
                    ->assertSee('Manajemen Data Obat');
        });
    }

    /**
     * @group petugas
     * Test apakah petugas bisa mengakses homepage petugas.
     */
    public function testPetugasCanAccessPetugasHomepage()
    {
        $petugas = pengguna::factory()->petugas()->create();

        $this->browse(function (Browser $browser) use ($petugas) {
            $browser->loginAs($petugas)
                    ->visit('/petugas')
                    ->assertSee('Selamat Datang di BabaCare')
                    ->assertSee('Dashboard')
                    ->assertSee('Management Pasien')
                    ->assertSee('Laporan Data Pasien');
        });
    }

    /**
     * @group user
     * Test apakah user biasa bisa mengakses homepage user.
     */
    public function testUserCanAccessUserHomepage()
    {
        $user = pengguna::factory()->user()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/user')
                    ->assertSee('Puskesmas')
                    ->assertSee('Pendaftaran')
                    ->assertSee('Feedback');
        });
    }

    /**
     * @group homepage
     * Test apakah gambar di landing page berhasil dimuat.
     */
    public function testHomepageImages()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertPresent('img');
        });
    }
}
