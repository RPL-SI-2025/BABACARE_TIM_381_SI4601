<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Login3Test extends DuskTestCase
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
    public static function RegisteredEmailWrongPassword(Browser $browser, $email = 'putra@gmail.com', $password = '1234567i',)
    {
        $browser->visit('/login')
                ->type('email', $email)
                ->type('password', $password)
                ->press('Sign In')
                ->assertPathIs('/login');
    }
}
