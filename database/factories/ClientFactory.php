<?php

use App\User;
use Faker\Generator as Faker;
use Laravel\Passport\Client;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return factory(User::class)->create()->id;
        },
        'name' => $faker->name,
        'secret' => 'secret', // secret
        'redirect' => $faker->word,
        'personal_access_client' => $faker->boolean(50),
        'password_client' => function($client){
            return !$client['personal_access_client'];
        },
        'revoked' => $faker->boolean(90),
    ];
});
