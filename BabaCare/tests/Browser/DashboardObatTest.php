<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class DashboardObatTest extends DuskTestCase
{
    public function test_admin_can_view_dashboard_obat()
    {
        $this->browse(function (Browser $browser) {
            // Asumsikan sudah ada user admin dengan id 1
            $admin = User::find(1);

            $browser->loginAs($admin)
                    ->visit('/dashboarddataobat') // sesuaikan route-nya
                    ->assertSee('Ringkasan Data Obat')
                    ->assertSee('Total Obat')
                    ->assertSee('Obat per Kategori')
                    ->assertSee('Obat per Golongan')
                    ->assertSee('Daftar Obat');

            // Pastikan tabel obat muncul dengan baris obat
            $browser->with('table', function ($table) {
                $table->assertPresent('tbody tr');
            });

            // Jika ada tombol tambah obat, cek tombol dan klik lalu cek url create
            if ($browser->element('a#btnTambahObat')) {
                $browser->click('a#btnTambahObat')
                        ->assertPathIs('/obats/create');
            }
        });
    }
}
