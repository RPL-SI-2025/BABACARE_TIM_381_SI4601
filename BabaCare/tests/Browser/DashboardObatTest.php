<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class DashboardObatTest extends DuskTestCase
{
    public function test_bisa_melihat_halaman_dashboard_obat()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/dashboarddataobat')
                    ->assertSee('Ringkasan Data Obat')
                    ->assertSee('Total Obat')
                    ->assertSee('Obat per Kategori')
                    ->assertSee('Obat per Golongan')
                    ->assertSee('Daftar Obat Tersedia'); // Sesuaikan teksnya jika beda
        });
    }

    public function test_bisa_melihat_grafik_obat_per_kategori()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/dashboarddataobat')
                    ->assertSee('Obat per Kategori');
        });
    }

    public function test_bisa_melihat_grafik_obat_per_golongan()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/dashboarddataobat')
                    ->assertSee('Obat per Golongan');
        });
    }

    public function test_bisa_melihat_total_obat()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/dashboarddataobat')
                    ->assertSee('Total Obat');
        });
    }

    public function test_tombol_tambah_data_obat_berfungsi()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/dashboarddataobat')
                    ->assertSee('+ Tambah Data Obat')
                    ->clickLink('+ Tambah Data Obat')
                    ->assertPathIs('/obats/create');
        });
    }
}
