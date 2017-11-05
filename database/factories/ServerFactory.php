<?php

use Acacha\Forge\Models\Server;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Server::class, function (Faker $faker) {
    $forge_server = random_forge_server();
    return [
        'forge_id' => $forge_server->id,
        'name' => $forge_server->name,
        'user_id' => factory(User::class)->create()->id,
        'token' => Str::random(60),
        'state' => 'pending'
    ];
});
