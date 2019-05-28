<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\NeptuneContract;
use Faker\Generator as Faker;

$factory->define(NeptuneContract::class, function (Faker $faker) {
    return [
        'role_id' => 1,
        'number' => $faker->randomDigit,
        'name' => $faker->name,
    ];
});
