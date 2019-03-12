<?php

use Faker\Generator as Faker;
use App\Models\Job;

// generate jobs that are closed for candidate to apply.
$factory->state(App\Models\CandidateJobApplication::class, 'closed_jobs', function ($faker) {
    return [
        'job_id' => function () {
            return factory(App\Models\Job::class)->create(['job_status' => JOB::CLOSED])->first()->id;
        }
            
    ];
});

$factory->define(App\Models\CandidateJobApplication::class, function (Faker $faker) {
    /**
     * you might be wondering why i am saving json data,
     * i did it because i wanted to replicate the old database structure.
     */
    return [
        'candidate_id' => function () {
            return factory(App\Models\Candidate)->create()->id;
        },
        'job_id' => function () {
            return factory(App\Models\Job::class)->create(['job_status' => Job::ACTIVE])->first()->id;
        },
        'app_status' => App\Models\CandidateJobApplication::APPLIED,
        'app_steps' => '{"pre_apply_questions":"passed","requirements_check":"passed"}',
        'object_id' => str_random(24),
        'extra_info' => 'O:8:"stdClass":3:{s:14:"location_color";i:0;s:17:"experience_string";s:39:"0 years in Banking & Financial Services";s:16:"experience_color";i:0;}'
    ];
});
