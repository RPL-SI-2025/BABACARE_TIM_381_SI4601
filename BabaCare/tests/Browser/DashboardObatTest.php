<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
class DashboardObatTest extends DuskTestCase
{


    // public function test_admin_can_view_dashboard_obat()
    // {
    //     $this->browse(function (Browser $browser) {
    //         $admin = User::factory()->create([
    //             'name' => 'Admin Test',
    //             'email' => 'admin@example.com',
    //             'password' => Hash::make('password'),
    //             'role' => 'admin', // atau sesuaikan kalau kamu pakai enum/tipe lain
    //         ]);

    //         $browser->loginAs($admin)
    //                 ->visit('/dashboarddataobat')
    //                 ->assertSee('Ringkasan Data Obat')
    //                 ->assertSee('Total Obat')
    //                 ->assertSee('Obat per Kategori')
    //                 ->assertSee('Obat per Golongan')
    //                 ->assertSee('Daftar Obat');

    //         $browser->with('table', function ($table) {
    //             $table->assertPresent('tbody tr');
    //         });

    //         if ($browser->element('a#btnTambahObat')) {
    //             $browser->click('a#btnTambahObat')
    //                     ->assertPathIs('/obats/create');
    //         }
    //     });

    public function test_bisa_melihat_halaman_obat()
    {
        $response = $this->get('/dashboarddataobat');

        $response->assertStatus(200);
        $response->assertSee('Ringkasan Data Obat'); // sesuaikan dengan tampilan di view
    }

    public function test_bisa_melihat_daftar_obat()
    {
        $response = $this->get('/dashboarddataobat');

        $response->assertStatus(200);
        $response->assertSee('Daftar Obat Tersedia'); // sesuaikan dengan tampilan di view
    }

    public function test_bisa_melihat_grafik_obat_per_kategori()
    {
        $response = $this->get('/dashboarddataobat');

        $response->assertStatus(200);
        $response->assertSee('Obat per Kategori'); // sesuaikan dengan tampilan di view
    }

    public function test_bisa_melihat_grafik_obat_per_golongan()
    {
        $response = $this->get('/dashboarddataobat');

        $response->assertStatus(200);
        $response->assertSee('Obat per Golongan'); // sesuaikan dengan tampilan di view
    }
    public function test_bisa_melihat_total_obat()
    {
        $response = $this->get('/dashboarddataobat');

        $response->assertStatus(200);
        $response->assertSee('Total Obat'); // sesuaikan dengan tampilan di view
    }

    public function test_bisa_menambah_obat_baru()
    {
        $this->withoutMiddleware(); // lewati middleware seperti CSRF

        

        $response = $this->get('/dashboarddataobat');

        $response->assertStatus(200);
        $response->assertSee('Tambah Data Obat'); // sesuaikan dengan tampilan di view
    }
}

// }
