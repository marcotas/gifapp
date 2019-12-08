<?php

namespace Tests\Feature\SearchHistories;

use App\Models\SearchHistory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use DatabaseTransactions;

    public function storeSearch($text = null): TestResponse
    {
        return $this->postJson(route('searches.store'), compact('text'));
    }

    /** @test */
    public function it_should_store_a_search_history_in_database()
    {
        $this->actingAs($this->user(), 'api')
            ->storeSearch('bleach')
            ->assertCreated()
            ->assertJsonStructure([
                'id',
                'text',
                'user_id',
                'hits',
                'created_at',
                'updated_at',
            ])
            ->assertJsonFragment([
                'text'    => 'bleach',
                'hits'    => 1,
                'user_id' => $this->user()->id,
            ]);

        $this->assertDatabaseHas('search_histories', [
            'text'    => 'bleach',
            'hits'    => 1,
            'user_id' => $this->user()->id,
        ]);
    }

    /** @test */
    public function it_increments_the_hits_if_exists_and_dont_duplicate()
    {
        create(SearchHistory::class, ['text' => 'bleach', 'hits' => 1, 'user_id' => $this->user()]);

        $this->actingAs($this->user(), 'api')
            ->storeSearch('bleach')
            ->assertOk()
            ->assertJsonStructure([
                'id',
                'text',
                'user_id',
                'hits',
                'created_at',
                'updated_at',
            ])
            ->assertJsonFragment([
                'text'    => 'bleach',
                'hits'    => 2,
                'user_id' => $this->user()->id,
            ]);

        $this->assertDatabaseHas('search_histories', [
            'text'    => 'bleach',
            'hits'    => 2,
            'user_id' => $this->user()->id,
        ]);
        $this->assertEquals(1, $this->user()->searchHistories()->count());
    }

    /** @test */
    public function it_can_duplicate_the_search_with_different_user()
    {
        create(SearchHistory::class, ['text' => 'bleach', 'hits' => 1]);

        $this->actingAs($this->user(), 'api')
            ->storeSearch('bleach')
            ->assertSuccessful()
            ->assertJsonFragment([
                'text'    => 'bleach',
                'hits'    => 1,
                'user_id' => $this->user()->id,
            ]);

        $this->assertDatabaseHas('search_histories', [
            'text'    => 'bleach',
            'hits'    => 1,
            'user_id' => $this->user()->id,
        ]);
        $this->assertEquals(2, SearchHistory::whereText('bleach')->count());
    }

    /** @test */
    public function text_is_required()
    {
        $this->actingAs($this->user(), 'api')
            ->storeSearch('')
            ->assertStatus(422)
            ->assertSee(trans('validation.required', ['attribute' => 'text']));
    }
}
