<?php

use Faker\Generator as Faker;

$factory->define(App\News::class, function (Faker $faker) {
    return [
        'source' => $faker->url,
        'excerpt' => $faker->sentence,
        'image' => $faker->imageUrl()
    ];
});
