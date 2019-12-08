<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\SearchHistory;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(SearchHistory::class, function (Faker $faker) {
    return [
        'text'    => $faker->words(rand(1, 5), true),
        'hits'    => rand(1, 20),
        'user_id' => factory(User::class),
    ];
});
