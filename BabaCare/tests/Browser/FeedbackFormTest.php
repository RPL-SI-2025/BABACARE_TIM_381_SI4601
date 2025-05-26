<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\pengguna;

class FeedbackFormTest extends DuskTestCase
{

    /**
     * Test akses form feedback.
     * @group akses_form
     */
    public function test_access_feedback_form()
    {
        $user = pengguna::factory()->user()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/user')
                    ->assertSee('Puskesmas')
                    ->assertSee('Pemeriksaan')
                    ->assertSee('Vaksin dan Imunisasi')
                    ->assertSee('Feedback')
                    ->visit('/feedback') 
                    ->assertSee('Feedback')
                    ->pause(1000);
        });
    }

    /**
     * Test submit form feedback lengkap.
     * @group submit_form
     */
    public function test_submit_complete_feedback()
    {
        $user = pengguna::factory()->user()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/feedback') 
                    ->type('name', 'John Doe')
                    ->radio('satisfaction', 'puas')
                    ->type('comment', 'Pelayanan sangat baik!')
                    ->press('Submit')
                    ->waitForText('Terima kasih atas feedback Anda!')
                    ->assertSee('Terima kasih atas feedback Anda!');
    
            $this->assertDatabaseHas('feedback', [ 
                'name' => 'John Doe',
                'satisfaction' => 'puas',
                'comment' => 'Pelayanan sangat baik!',
            ]);
        });
    }

    /**
     * Test submit form tanpa input.
     * @group submit_form_without_input
     */
    public function test_submit_without_input()
    {
        $user = pengguna::factory()->user()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                    ->visit('/feedback')
                    ->press('Submit')
                    ->assertSee('Nama Pasien tidak boleh kosong.')
                    ->assertSee('Silakan pilih tingkat kepuasan.')
                    ->assertSee('Komentar tidak boleh kosong.');

            // Cek apakah data tidak masuk ke database
            $this->assertDatabaseMissing('feedback', [
                'comment' => 'This is a feedback comment.'
            ]);
        });
    }
}
