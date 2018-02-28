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
        'secret' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'redirect' => function($client){
            $user = User::find($client['user_id']);
            return $user->id;
        },
        'personal_access_client' => $faker->boolean(50),
        'password_client' => function($client){
            return !$client['personal_access_client'];
        },
        'revoked' => $faker->boolean(90),
    ];
});
