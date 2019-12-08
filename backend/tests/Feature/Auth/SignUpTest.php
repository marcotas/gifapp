<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Str;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        $this->personalAccessClient();
    }

    public function signUp($params = []): TestResponse
    {
        return $this->postJson(route('signup'), $params);
    }

    /** @test */
    public function it_creates_a_user_in_database()
    {
        $user = raw(User::class, [
            'password'              => '123456',
            'password_confirmation' => '123456',
        ]);

        $this
            ->signUp($user)
            ->assertCreated()
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
                'token' => [
                    'access_token',
                    'expires_in',
                ],
            ]);
    }

    /** @test */
    public function name_is_required()
    {
        $user = make(User::class, ['name' => null]);

        $this
            ->signUp($user->toArray())
            ->assertStatus(422)
            ->assertSeeText(trans('validation.required', ['attribute' => 'name']));
    }

    /** @test */
    public function name_has_max_of_255()
    {
        $user = raw(User::class, [
            'name'                  => Str::random(255),
            'password'              => '123456',
            'password_confirmation' => '123456',
        ]);

        $this
            ->signUp($user)
            ->assertCreated();

        $user['name'] = Str::random(256);

        $this
            ->signUp($user)
            ->assertStatus(422)
            ->assertSeeText(trans('validation.max.string', ['attribute' => 'name', 'max' => 255]));
    }

    /** @test */
    public function email_is_required()
    {
        $user = make(User::class, ['email' => null]);

        $this
            ->signUp($user->toArray())
            ->assertStatus(422)
            ->assertSeeText(trans('validation.required', ['attribute' => 'email']));
    }

    /** @test */
    public function email_should_be_valid()
    {
        $user = make(User::class, ['email' => 'some email']);

        $this
            ->signUp($user->toArray())
            ->assertStatus(422)
            ->assertSeeText(trans('validation.email', ['attribute' => 'email']));
    }

    /** @test */
    public function email_is_unique()
    {
        $existing = create(User::class);

        $user = raw(User::class, ['email' => $existing->email]);

        $this
            ->signUp($user)
            ->assertStatus(422)
            ->assertSeeText(trans('validation.unique', ['attribute' => 'email']));
    }

    /** @test */
    public function password_is_required()
    {
        $user = raw(User::class, ['password' => null]);

        $this
            ->signUp($user)
            ->assertStatus(422)
            ->assertSeeText(trans('validation.required', ['attribute' => 'password']));
    }

    /** @test */
    public function password_has_a_min_of_6_caracters()
    {
        $user = raw(User::class, ['password' => null]);

        $this
            ->signUp($user)
            ->assertStatus(422)
            ->assertSeeText(trans('validation.required', ['attribute' => 'password']));
    }

    /** @test */
    public function password_should_be_confirmed()
    {
        $user = raw(User::class, ['password' => '123456', 'password_confirmation' => '1234567']);

        $this
            ->signUp($user)
            ->assertStatus(422)
            ->assertSeeText(trans('validation.confirmed', ['attribute' => 'password']));
    }
}
