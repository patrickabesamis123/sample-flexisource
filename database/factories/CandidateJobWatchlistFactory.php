<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CandidateJobWatchlist::class, function (Faker $faker) {
    return [
        'candidate_id' => function () {
            return factory(App\Models\Candidate::class)->create()->id;
        },
        'job_id' => function () {
            return factory(App\Models\Job::class)->create()->id;
        }
    ];
});
