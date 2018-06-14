<?php

use Faker\Generator as Faker;

$factory->define(App\Team::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'flag' => $faker->imageUrl(),
        'main_color' => $faker->colorName,
        'second_color' => $faker->colorName,
        'third_color' => $faker->colorName
    ];
});
