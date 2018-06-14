<?php

use Faker\Generator as Faker;

$factory->define(App\Round::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'starts_at' => $faker->dateTime,
        'ends_at' => $faker->dateTime,
        'number' => $faker->numberBetween(0, 10),
        'tournament_id' => factory(\App\Tournament::class)->create()->id
    ];
});
