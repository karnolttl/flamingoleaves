<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */

    function a_user_may_register_for_an_account_but_must_confirm_their_email_address()
    {
        $this->visit('register')
            ->type('JohnDoe', 'name')
            ->type('john@example.com', 'email')
            ->type('password', 'password')
            ->press('Register');

        $this->see('Please confirm your email address')
            ->seeInDatabase('users', ['name' => 'JohnDoe', 'verified' => 0]);
    }

}
