<?php

use Faker\Generator as Faker;

$factory->define(App\Models\WhitelistedCompany::class, function (Faker $faker) {
    return [
        'candidate_id' => function () {
            return factory(App\Models\Candidate::class)->create()->id;
        },
        'company_id' => function () {
            return factory(App\Models\Company::class)->create()->id;
        },
        'enabled' => 0,
        'requested' => 1
    ];
});
