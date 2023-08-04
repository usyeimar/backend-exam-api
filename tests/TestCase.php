<?php

namespace Tests;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Password;
use Laravel\Passport\HasApiTokens;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    public function signIn($user = null): Authenticatable
    {
        $user = $user ?: User::factory()->create();

        return Passport::actingAs($user);
    }
}
