<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\NeptuneRole;
use Faker\Generator as Faker;

$factory->define(NeptuneRole::class, function (Faker $faker) {
    return [
        'name' => $faker->name
    ];
});
