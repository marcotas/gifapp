<?php

namespace Tests\Feature\Users;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AddFavoriteGifTest extends TestCase
{
    use DatabaseTransactions;

    public function toggleFavoriteGif($tenor_id): TestResponse
    {
        return $this->postJson(route('favorites.toggle'), compact('tenor_id'));
    }

    public function castToJson($json)
    {
        // Convert from array to json and add slashes, if necessary.
        if (is_array($json)) {
            $json = addslashes(json_encode($json));
        }
        // Or check if the value is malformed.
        elseif (is_null($json) || is_null(json_decode($json))) {
            throw new \Exception('A valid JSON string was not provided.');
        }

        return DB::raw("CAST('{$json}' AS JSON)");
    }

    /** @test */
    public function it_adds_the_id_in_users_favorite_list_if_doesnt_exist()
    {
        $this->user()->update(['favorite_gifs' => [321]]);

        $this->actingAs($this->user(), 'api')
            ->toggleFavoriteGif('123')
            ->assertOk()
            ->assertJsonStructure([
                'favorite_gifs',
            ])
            ->assertJsonFragment([
                'favorite_gifs' => [321, 123],
            ]);
        $this->assertEquals([321, 123], $this->user()->fresh()->favorite_gifs->toArray());
    }

    /** @test */
    public function it_removes_the_id_if_exists()
    {
        $this->user()->update(['favorite_gifs' => [123, 321]]);

        $this->actingAs($this->user(), 'api')
            ->toggleFavoriteGif('123')
            ->assertOk()
            ->assertJsonFragment([
                'favorite_gifs' => [321],
            ]);

        $this->assertEquals([321], $this->user()->fresh()->favorite_gifs->toArray());
    }
}
