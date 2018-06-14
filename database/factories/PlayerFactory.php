<?php

use Faker\Generator as Faker;

$factory->define(App\Player::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'position' => $faker->numberBetween(0,11),
        'height' => $faker->numberBetween(160, 199),
        'weight' => $faker->numberBetween(68, 100),
        'age' => $faker->numberBetween(17, 34),
        'photo' => $faker->imageUrl(),
        'team_id' => factory(\App\Team::class)->create()->id,
        'club_id' => factory(\App\Club::class)->create()->id
    ];
});
