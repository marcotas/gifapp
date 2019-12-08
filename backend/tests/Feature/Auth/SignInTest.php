<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

class SignInTest extends TestCase
{
    use DatabaseTransactions;

    public function signin($params = []): TestResponse
    {
        return $this->postJson(route('passport.token'), $params);
    }

    /** @test */
    public function it_should_use_passport_password_grant_client()
    {
        $client = $this->passportGrantClient();
        $user   = $this->user();

        $this->signin([
            'grant_type'    => 'password',
            'client_id'     => $client->id,
            'client_secret' => $client->secret,
            'username'      => $user->email,
            'password'      => 'password',
            'scope'         => '',
        ])
            ->assertOk()
            ->assertJsonStructure([
                'token_type',
                'expires_in',
                'access_token',
                'refresh_token',
            ]);
    }
}
