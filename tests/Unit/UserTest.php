<?php

namespace Tests\Unit;

use App\Models\User;
use Database\Seeders\UsersTableSeeder;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    //Check if login page exists
    public function test_login_form()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

}