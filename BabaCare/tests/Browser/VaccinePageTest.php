<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Pengguna;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Faker\Factory as Faker;

class VaccinePageTest extends DuskTestCase
{
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create('id_ID');
    }

    protected function createUserAndLogin(Browser $browser)
    {
        $user = Pengguna::factory()->user()->create([
            'password' => bcrypt('password'),
        ]);

        $browser->visit('/login')
            ->type('email', $user->email)
            ->type('password', 'password')
            ->press('Login')
            ->waitForLocation('/user')
            ->assertPathIs('/user');
    }

    /**
     * @group vaccination
     */
    public function test_create_vaccination_success()
    {
        $this->browse(function (Browser $browser) {
            $this->createUserAndLogin($browser);
            
            $browser->clickLink('Vaksin dan Imunisasi')
                ->waitForLocation('/vaccination/create')
                ->assertPathIs('/vaccination/create');
            
            $today = now()->format('m/d/Y');
            $vaccinationData = [
                'type' => 'vaccine',
                'vaccine_id' => '1',
                'vaccination_date' => now()->format('Y-m-d'),
                'vaccination_time' => '11:30:00',
                'allergies' => 'Tidak ada alergi',
            ];
            
            $browser->select('type', $vaccinationData['type'])
                ->pause(1000);
            
            
            $browser->select('vaccine_id', $vaccinationData['vaccine_id'])
                ->assertSelected('vaccine_id', $vaccinationData['vaccine_id']);
            
            $browser->script("document.querySelector('input[name=\"vaccination_date\"]').value = '{$vaccinationData['vaccination_date']}';");
            $browser->script("document.querySelector('input[name=\"vaccination_time\"]').value = '{$vaccinationData['vaccination_time']}';");
            $browser->type('allergies', $vaccinationData['allergies']);
            
            
            
            // $browser->pause(2000)
            //     ->waitFor('.swal2-confirm', 5);

            // $browser->select('type', $vaccinationData['type']);
            // $browser->pause(1000);
            // $browser->select('vaccine_id', $vaccinationData['vaccine_id']);
            // $browser->type('vaccination_date', $vaccinationData['vaccination_date']);
            // $browser->script("document.querySelector('input[name=\"vaccination_time\"]').value = '11:30';");
            // $browser->type('allergies', $vaccinationData['allergies']);
            
            $browser->script('confirmSubmit();');
            $browser->pause(2000);
            $browser->waitFor('.swal2-confirm', 5);
            $browser->script("document.querySelector('.swal2-confirm').click();");
            $browser->pause(5000);
            
            $browser->waitFor('.swal2-container')
                ->assertSee('Berhasil');
            
            $this->assertDatabaseHas('vaccination_registrations', [
                'type' => $vaccinationData['type'],
                'vaccine_id' => $vaccinationData['vaccine_id'],
                'vaccination_date' => $vaccinationData['vaccination_date'],
                'vaccination_time' => $vaccinationData['vaccination_time'],
                'allergies' => $vaccinationData['allergies'],
            ]);
        });
    }

    /**
     * @group vaccination
     */
    public function test_create_vaccination_validation_error()
    {
        $this->browse(function (Browser $browser) {
            $this->createUserAndLogin($browser);
            
            // Navigate to vaccination create page
            $browser->clickLink('Vaksin dan Imunisasi')
                ->waitForLocation('/vaccination/create')
                ->assertPathIs('/vaccination/create');
            
            $browser->script('confirmSubmit();');
            $browser->pause(2000);
            $browser->waitFor('.swal2-confirm', 5);
            $browser->script("document.querySelector('.swal2-confirm').click();");
            $browser->pause(3000);
            
            $browser->waitFor('.swal2-container')
                ->assertSee('Terjadi kesalahan validasi data.')
                ->assertSee('Jenis Vaksin wajib diisi.')
                ->assertSee('Kategori wajib diisi.')
                ->assertSee('Waktu Vaksin wajib diisi.');
        });
    }

    /**
     * @group vaccination
     */
    public function test_vaccination_category_filters_vaccine_options()
    {
        $this->browse(function (Browser $browser) {
            $this->createUserAndLogin($browser);
            
            $browser->clickLink('Vaksin dan Imunisasi')
                ->waitForLocation('/vaccination/create')
                ->assertPathIs('/vaccination/create');
            
            $browser->select('type', 'immunization');
            $browser->pause(1000);
            
            $browser->script(
                "return Array.from(document.querySelectorAll('#vaccine_id option'))
                    .filter(option => option.style.display !== 'none' && option.value !== '')
                    .every(option => option.dataset.type === 'immunization');"
            );
            
            $browser->select('type', 'vaccine');
            $browser->pause(1000);
            
            $browser->script(
                "return Array.from(document.querySelectorAll('#vaccine_id option'))
                    .filter(option => option.style.display !== 'none' && option.value !== '')
                    .every(option => option.dataset.type === 'vaccine');"
            );
        });
    }
}