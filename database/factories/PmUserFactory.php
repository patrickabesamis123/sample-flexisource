<?php

use Faker\Generator as Faker;

$factory->define(App\Models\PmUser::class, function (Faker $faker) {
    $email = $faker->unique()->email;

    return [
        'username' => $email,
        'username_canonical' => $email,
        'email' => $email,
        'email_canonical' => $email,
        'enabled' => 1,
        'password' => bcrypt('secret'),
        'roles' => 'candidate',
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'user_type' => 'candidate',
        'ob_key' => str_random(8),
        'aa_token' => str_random(32)
    ];
});
