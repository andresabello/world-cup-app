<?php

use Faker\Generator as Faker;

$factory->define(App\Season::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'prize' => $faker->numberBetween(999999,999999999)
    ];
});
