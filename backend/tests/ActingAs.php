<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

class ActingAs
{
    use RefreshDatabase;

    public static function user($data = [])
    {
        $user = factory(User::class)->create($data);
        Sanctum::actingAs($user, ['*']);
        
        return $user;
    }
}
