<?php

use Faker\Generator as Faker;

$factory->define(App\Squad::class, function (Faker $faker) {
    return [
        'number' => $faker->numberBetween(1,11),
        'position' => $faker->name,
        'team_id' => factory(\App\Team::class)->create()->id
    ];
});
