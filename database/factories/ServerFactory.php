<?php

use Acacha\Forge\Models\Server;
use App\User;
use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Server::class, function (Faker $faker) {
    return [
        'forge_id' => 567,
        'user_id' => factory(User::class)->create()->id
    ];
});
