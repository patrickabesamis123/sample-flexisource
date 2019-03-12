<?php

use Faker\Generator as Faker;

$factory->define(App\Models\JobLog::class, function (Faker $faker) {
    return [
        'job_id' => function () {
            return factory(App\Models\Job::class)->create()->id;
        },
        'status' => App\Models\JobLog::POSTED
    ];
});
