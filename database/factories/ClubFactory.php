<?php

use Faker\Generator as Faker;

$factory->define(App\Club::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'followers' => $faker->numberBetween(1, 12),
        'president' => $faker->numberBetween(),
        'rank' => $faker->numberBetween(0, 200),
        'stadium' => $faker->name,
        'uniform' => $faker->sentence
    ];
});
