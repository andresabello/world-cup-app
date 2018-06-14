<?php

use Faker\Generator as Faker;

$factory->define(App\League::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'prize' => $faker->numberBetween(999999,999999999)
    ];
});
