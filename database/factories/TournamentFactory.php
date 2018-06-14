<?php

use Faker\Generator as Faker;

$factory->define(App\Tournament::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'prize' => $faker->numberBetween(800000, 180000000),
        'season_id' => factory(\App\Season::class)->create()->id,
        'league_id' => factory(\App\League::class)->create()->id
    ];
});
