<?php

namespace Tests\Browser;

use App\Models\Obat;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DataobatTest extends DuskTestCase
{
    
    /** @test @group obat */
    public function test_bisa_melihat_halaman_obat()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/obats')
                    ->assertSee('Data Obat');
        });
    }

    /** @test @group obat */
    public function test_bisa_menambah_obat_baru()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/obats/create')
                    ->type('nama_obat', 'Paracetamol')
                    ->type('kategori', 'Ringan')
                    ->type('golongan', 'tablet')
                    ->press('Simpan') // pastikan tombol submit bernama 'Simpan'
                    ->assertPathIs('/obats')
                    ->assertSee('Paracetamol');
        });
    }

    /** @test @group obat */
    public function test_bisa_edit_data_obat()
    {
        $obat = Obat::create([
            'nama_obat' => 'Paracetamol',
            'kategori' => 'Ringan',
            'golongan' => 'tablet',
        ]);

        $this->browse(function (Browser $browser) use ($obat) {
            $browser->visit("/obats/{$obat->id}/edit")
                    ->type('nama_obat', 'Paracetamol')
                    ->type('kategori', 'Ringan')
                    ->type('golongan', 'tablet')
                    ->press('Update') // pastikan tombol update bernama 'Update'
                    ->assertPathIs('/obats')
                    ->assertSee('Paracetamol');
        });
    }

    /** @test @group obat */
    public function test_bisa_hapus_obat()
    {
        $obat = Obat::create([
            'nama_obat' => 'Paracetamol',
            'kategori' => 'Ringan',
            'golongan' => 'tablet',
        ]);

        $this->browse(function (Browser $browser) use ($obat) {
            $browser->visit('/obats')
                    ->press("@delete-obat-{$obat->id}")
                    ->pause(1000)
                    ->waitFor('.swal2-confirm', 5)
                    ->script("document.querySelector('.swal2-confirm').click();");

            $browser->pause(2000)
                    ->assertDontSee('Paracetamol');
        });
    }


}
