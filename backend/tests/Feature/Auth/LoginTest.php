<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function UserCanLogin()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->make();        
        $response = $this->post('/api/login', ['email' => $user->email, 'password' => 'password']);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    // public function UserCantLoginWithWrongUsername()
    // {
    //     $user = User::factory()->make();        
    //     $response = $this->post('/api/login', ['email' => 'user', 'password' => 'password']);

    //     $response->assertStatus(401);
    // }

    /**
     * @test
     */
    // public function UserCantLoginWithWrongPassword()
    // {
    //     $user = User::factory()->make();        
    //     $response = $this->post('/api/login', ['email' => $user->email, 'password' => 'password2']);

    //     $response->assertStatus(401);
    // }
}
