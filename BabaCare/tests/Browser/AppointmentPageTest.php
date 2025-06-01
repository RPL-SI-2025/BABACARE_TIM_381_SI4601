<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\pengguna;
use App\Models\Appointment;
use Faker\Factory as Faker;

class AppointmentPageTest extends DuskTestCase
{
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create('id_ID');
    }

    protected function createUserAndLogin(Browser $browser)
    {
        $user = pengguna::factory()->user()->create([
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
     * @group appointment
     */
    public function test_create_appointment_success()
    {
        $this->browse(function (Browser $browser) {
            $this->createUserAndLogin($browser);

            $browser->clickLink('Pemeriksaan')
                ->waitForLocation('/appointments/create')
                ->assertPathIs('/appointments/create');

            $today = now()->format('m/d/Y');
            $futureDate = now()->addDays(2)->format('m/d/Y');

            $appointmentData = [
                'tanggal_reservasi' => now()->format('Y-m-d'),
                'tanggal_pelaksanaan' => now()->addDays(2)->format('Y-m-d'),
                'waktu_pelaksanaan' => now()->addDays(2)->format('Y-m-d').' 10:30:00',
                // 'specialist' => 'Umum',
                'keluhan_utama' => 'keras kepala',
            ];

            $browser->type('tanggal_reservasi', $today);

            $browser->type('tanggal_pelaksanaan', $futureDate);

            $browser->script("document.querySelector('input[name=\"waktu_pelaksanaan\"]').value = '10:30';");

            // $browser->select('specialist', $appointmentData['specialist']);

            $browser->type('keluhan_utama', $appointmentData['keluhan_utama']);

            $browser->script('confirmSubmit();');
            $browser->pause(2000);
            $browser->waitFor('.swal2-confirm', 5);
            $browser->script("document.querySelector('.swal2-confirm').click();");

            $browser->pause(5000); 

            $browser->waitFor('.swal2-container')
                    ->assertSee('Janji temu berhasil dibuat.');

            $this->assertDatabaseHas('appointments', [
                'tanggal_reservasi' => $appointmentData['tanggal_reservasi'],
                'tanggal_pelaksanaan' => $appointmentData['tanggal_pelaksanaan'],
                'waktu_pelaksanaan' => $appointmentData['waktu_pelaksanaan'],
                // 'specialist' => $appointmentData['specialist'],
                'keluhan_utama' => $appointmentData['keluhan_utama'],
            ]);
        });
    }

    /**
     * @group appointment
     */
    public function test_create_appointment_validation_error()
    {
        $this->browse(function (Browser $browser) {
            $this->createUserAndLogin($browser);

            $browser->clickLink('Pemeriksaan')
                ->waitForLocation('/appointments/create')
                ->assertPathIs('/appointments/create');

            $browser->script('confirmSubmit();');
            $browser->pause(2000);
            $browser->waitFor('.swal2-confirm', 5);
            $browser->script("document.querySelector('.swal2-confirm').click();");
            $browser->pause(3000);

            $browser->waitFor('.swal2-container')
                ->assertSee('Terjadi kesalahan validasi data.')
                ->assertSee('Tanggal Pelaksanaan wajib diisi.')
                ->assertSee('Waktu Pelaksanaan wajib diisi.')
                // ->assertSee('Specialist wajib diisi.')
                ->assertSee('Keluhan Utama wajib diisi.');
        });
    }


}
