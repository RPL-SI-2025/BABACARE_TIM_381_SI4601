<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TenagaMedisManagementTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function mengakses_halaman_utama_fitur()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser())
                ->visit(route('tenaga_medis.index'))
                ->assertSee('Tenaga Medis');
        });
    }

    /** @test */
    public function membuka_form_tambah_data_baru()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser())
                ->visit(route('tenaga_medis.index'))
                ->press('@add-tenaga-medis')
                ->assertSee('Tambah Tenaga Medis');
        });
    }

    /** @test */
    public function input_data_pada_form_tambah_data()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs($this->adminUser())
                ->visit(route('tenaga_medis.create'))
                ->type('nama', 'Dusk Medis')
                ->type('email', 'duskmedis@email.com')
                ->type('password', 'password123')
                ->press('Simpan')
                ->assertPathIs(route('tenaga_medis.index', [], false))
                ->assertSee('Dusk Medis');
        });
    }

    /** @test */
    public function membuka_form_edit_data()
    {
        $this->browse(function (Browser $browser) {
            $this->createTenagaMedis();
            $browser->loginAs($this->adminUser())
                ->visit(route('tenaga_medis.index'))
                ->press('@edit-tenaga-medis-1')
                ->assertSee('Edit Tenaga Medis');
        });
    }

    /** @test */
    public function input_data_yang_sudah_diubah()
    {
        $this->browse(function (Browser $browser) {
            $this->createTenagaMedis();
            $browser->loginAs($this->adminUser())
                ->visit(route('tenaga_medis.edit', 1))
                ->type('nama', 'Dusk Medis Updated')
                ->press('Update')
                ->assertPathIs(route('tenaga_medis.index', [], false))
                ->assertSee('Dusk Medis Updated');
        });
    }

    /** @test */
    public function menghapus_data_yang_ada()
    {
        $this->browse(function (Browser $browser) {
            $this->createTenagaMedis();
            $browser->loginAs($this->adminUser())
                ->visit(route('tenaga_medis.index'))
                ->press('@delete-tenaga-medis-1')
                ->waitForText('Yakin ingin menghapus?')
                ->press('Ya, hapus!')
                ->pause(1000)
                ->assertDontSee('Dusk Medis');
        });
    }

    private function adminUser()
    {
        return \App\Models\pengguna::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@dusk.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);
    }

    private function createTenagaMedis()
    {
        return \App\Models\TenagaMedis::factory()->create([
            'nama' => 'Dusk Medis',
            'email' => 'duskmedis@email.com',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
        ]);
    }
}
