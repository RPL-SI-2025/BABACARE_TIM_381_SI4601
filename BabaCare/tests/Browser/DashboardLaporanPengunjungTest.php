<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\pengguna;
use App\Models\Appointment;

class DashboardLaporanPengunjungTest extends DuskTestCase
{
    /**
     * Test akses dashboard.
     * @group akses_dash
     */
    public function test_dashboard_displayed_correctly()
    {
        $petugas = pengguna::factory()->petugas()->create();

        $this->browse(function (Browser $browser) use ($petugas) {
            $startTime = microtime(true);
            $browser->loginAs($petugas)
                ->visit('/petugas')
                ->assertSee('Total Pasien') 
                ->assertSee('Pasien Hari Ini')
                ->visit('/reports') 
                ->assertSee('Tren Penyakit') 
                ->assertSee('Distribusi Jenis Perawatan')
                ->assertSee('Distribusi Gender Pasien')
                ->assertDontSee('500') 
                ->assertDontSee('Server Error');

            $elapsedTime = microtime(true) - $startTime;
            $this->assertLessThan(2, $elapsedTime, 'Halaman dashboard terlalu lama dimuat');
        });
    }

    /**
     * Test akses filter waktu.
     * @group akses_filter
     */
    public function test_filter_waktu_updates_dashboard()
    {
        $petugas = pengguna::factory()->petugas()->create();

        $this->browse(function (Browser $browser) use ($petugas) {
            $browser->loginAs($petugas)
                ->visit('/reports')
                ->assertSee('Laporan Data Pasien')
                ->select('year', '2025') 
                ->press('Terapkan')      
                ->pause(2000)
                ->assertSee('Tren Penyakit')
                ->assertSee('Distribusi Jenis Perawatan');
        });
    }
}