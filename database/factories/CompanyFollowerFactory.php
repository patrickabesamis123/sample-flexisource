<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CompanyFollower::class, function (Faker $faker) {
    return [
        'company_id' => function () {
            return factory(App\Models\Company::class)->create()->id;
        },
        'candidate_id' => function () {
            return factory(App\Models\Candidate::class)->create()->id;
        }
    ];
});
