<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function login()
    {
        $this->withExceptionHandling();
        $response = $this->get('/api/user');
        $response->assertStatus(401);
    }
}
