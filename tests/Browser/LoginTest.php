<?php

namespace Tests\Browser;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_cannot_login_with_invalid_credentials()
    {
        $user = factory(User::class)->create([
            'email' => 'user@user.com',
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->visit('/login')
                    ->assertSee('Returning Customer')
                    ->type('email', 'user@user.com')
                    ->type('password', 'wrong-password')
                    ->press('Login')
                    ->assertPathIs('/login')
                    ->assertSee('credentials do not match');
        });
    }

    /** @test */
    public function a_user_can_login()
    {
        $user = factory(User::class)->create([
            'email' => 'user@user.com',
        ]);

        // $this->browse(function (Browser $browser) {
        //     $browser->visit('/')
        //             ->visit('/login')
        //             ->assertSee('Returning Customer')
        //             ->type('email', 'user@user.com')
        //             ->type('password', 'secret')
        //             ->press('Login')
        //             ->assertPathIs('/');
        // });
        $this->browse(function (Browser $browser) use($user){
            $browser->loginAs($user)
                    ->visit('/')
                    ->assertSee('Larashop');
        });
    }
}
