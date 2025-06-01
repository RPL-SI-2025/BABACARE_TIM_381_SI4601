<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class Login4Test extends DuskTestCase
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
    public static function UnregisteredEmailIncorrectPassword(Browser $browser, $email = 'adam@gmail.com', $password = '1234567i',)
    {
        $browser->visit('/login')
                ->type('email', $email)
                ->type('password', $password)
                ->press('Sign In')
                ->assertPathIs('/login');
    }
}
