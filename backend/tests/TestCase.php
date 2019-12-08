<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var User
     */
    protected $user;

    public function user($attributes = []): User
    {
        return $this->user = $this->user ?? create(User::class, $attributes);
    }

    public function passportGrantClient(): Client
    {
        return (new ClientRepository)->createPasswordGrantClient(null, 'Password Grant Client', '');
    }

    public function personalAccessClient(): Client
    {
        return (new ClientRepository)->createPersonalAccessClient(null, 'Personal Access Client', '');
    }
}
