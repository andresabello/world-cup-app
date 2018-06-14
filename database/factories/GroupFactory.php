<?php

use Faker\Generator as Faker;

$factory->define(App\Group::class, function (Faker $faker) {
    return [
        'name' => $faker,
        'tournament_id' => factory(\App\Tournament::class)->create()->id
    ];
});
