<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Salutation::class, function (Faker $faker) {
    return [
        'author' => $faker->name,
        'message' => $faker->sentence
    ];
});
