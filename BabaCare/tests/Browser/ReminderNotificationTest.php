<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use App\Models\pengguna;

class ReminderNotificationTest extends DuskTestCase
{

    public function testReminderNotificationAndSweetAlert()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'tes@gmail.com')
                ->type('password', 'dimas123')
                ->press('Login')
                ->visit('/appointments/create')
                ->type('tanggal_pelaksanaan', now()->format('d-m-Y'))
                ->type('waktu_pelaksanaan', now()->addHour()->addMinute()->format('H:i'))
                ->type('keluhan_utama', 'Tes notifikasi otomatis')
                ->pause(1000)
                ->press('@confirm-appointment') // klik tombol "Daftar"
                ->pause(1000) // tunggu SweetAlert muncul
                ->script("Swal.clickConfirm()"); // klik tombol "Ya, Daftar Sekarang"

            // Simulasi waktu berjalan agar notifikasi muncul
            $browser->pause(62000); // 60 detik

            $userId = pengguna::where('email', 'tes@gmail.com')->first()->id;
            $notif = DB::table('notifications')
                ->where('notifiable_id', $userId)
                ->latest()
                ->first();

            $this->assertNotNull($notif, 'Notifikasi tidak ditemukan setelah 60 detik');

            // Refresh dan cek apakah sweetalert muncul
            $browser->refresh()
                ->pause(1500)
                ->assertPresent('.swal2-toast');
        });
    }

    public function testNotificationAppearsInCenter()
    {

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'tes@gmail.com')
                ->type('password', 'dimas123')
                ->press('Login')
                
                ->visit('/notifications')
                ->pause(1000)
                ->assertSeeIn('.list-group-item', 'Reminder Janji Temu')
                ->clickLink('Reminder Janji Temu')
                ->pause(1000)
                ->assertSee('Janji temu Anda akan dimulai');
        });
    }
}
