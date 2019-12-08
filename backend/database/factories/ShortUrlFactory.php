<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\ShortUrl;
use Faker\Generator as Faker;

$factory->define(ShortUrl::class, function (Faker $faker) {
    return [
        'long' => $faker->imageUrl,
    ];
});
