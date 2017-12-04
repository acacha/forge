<?php

use Acacha\Forge\Models\Group;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(Group::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name
    ];
});
