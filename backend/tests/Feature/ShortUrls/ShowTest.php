<?php

namespace Tests\Feature\ShortUrls;

use App\Models\ShortUrl;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowTest extends TestCase
{
    use DatabaseTransactions, WithFaker;

    public function showShortUrl($url)
    {
        return $this->postJson(route('short-url.show'), compact('url'));
    }

    /** @test */
    public function it_should_generate_a_short_url_if_doesnt_exist()
    {
        $url = $this->faker->url;
        $this->actingAs($this->user(), 'api')
            ->showShortUrl($url)
            ->assertOk()
            ->assertJsonStructure(['short_url']);

        $this->assertDatabaseHas('short_urls', [
            'long' => $url,
        ]);
    }

    /** @test */
    public function it_doesnt_duplicate_the_url()
    {
        /** @var ShortUrl $url */
        $url = create(ShortUrl::class);

        $this->assertDatabaseHas($url->getTable(), [
            'id'   => $url->id,
            'long' => $url->long,
        ]);
        $this->assertEquals(1, ShortUrl::count());

        $response = $this->actingAs($this->user(), 'api')
            ->showShortUrl($url->long)
            ->assertOk()
            ->assertJsonStructure(['short_url']);

        $this->assertEquals($response->original['short_url'], $url->short);
        $this->assertEquals(1, ShortUrl::count());
        $this->assertDatabaseHas($url->getTable(), [
            'id'   => $url->id,
            'long' => $url->long,
        ]);
    }
}
