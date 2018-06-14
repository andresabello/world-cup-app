<?php

use Faker\Generator as Faker;

$factory->define(App\Match::class, function (Faker $faker) {
    return [
        'number' => $faker->numberBetween(0, 10),
        'play_at' => $faker->dateTime,
        'knockout' => $faker->boolean,
        'home_id' => factory(\App\Team::class)->create()->id,
        'away_id' => factory(\App\Team::class)->create()->id,
        'winner_id' => function ($match) {
            return array_random([
                $match['home_id'],
                $match['away_id']
            ]);
        },
        'score_pt' => '0-0',
        'score_et' => '0-0'
    ];
});
