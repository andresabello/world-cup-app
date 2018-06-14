<?php

use Faker\Generator as Faker;

$factory->define(App\Venue::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'latitude'=> $faker->latitude,
        'longitude'=> $faker->longitude,
        'city'=> $faker->city,
        'country'=> $faker->country,
        'capacity'=> $faker->numberBetween(30000,100000),
    ];
});
