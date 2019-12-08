<?php

namespace Tests\Feature\SearchHistories;

use App\Models\SearchHistory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use DatabaseTransactions;

    public function listSearchHistories(): TestResponse
    {
        return $this->getJson(route('searches.index'));
    }

    /** @test */
    public function it_should_return_a_list_of_search_histories_paginated()
    {
        create_list(SearchHistory::class, 3, ['user_id' => $this->user()]);

        $this->actingAs($this->user(), 'api')
            ->listSearchHistories()
            ->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'text',
                        'user_id',
                        'hits',
                        'created_at',
                        'updated_at',
                    ],
                ],
                'links',
                'meta',
            ]);
    }
}
