<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Login6Test extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login');
        });
    }
    public static function LoginSuccessPetugas(Browser $browser, $email = 'gibran@gmail.com', $password = '1234567h',)
    {
        $browser->visit('/login')
                ->type('email', $email)
                ->type('password', $password)
                ->press('Sign In')
                ->assertPathIs('/petugas');
    }
}
