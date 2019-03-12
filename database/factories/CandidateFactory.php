<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Candidate::class, function (Faker $faker) {
    $nationality = new App\Models\Nationality();
    $workType = new App\Models\WorkType();
    $industry = new App\Models\Industry();
    $location = new App\Models\Location();
    $dob = date('Y-m-d', mt_rand('315518400', '978120000')); // generates from Jan 01, 1970 - Dec 30, 2000 (GMT + 4)

    return [
        'user_id' => function () {
            return factory(App\Models\PmUser::class)->create()->id;
        },
        'nickname' => $faker->firstName,
        'nationality_id' => $nationality->inRandomOrder()->limit(1)->first(['id'])['id'],
        'phone_number' => $faker->tollFreePhoneNumber,
        'mobile_number' => $faker->phoneNumber,
        'work_type_id' => $workType->inRandomOrder()->limit(1)->first(['id'])['id'],
        'dob' => $dob,
        'industry_id' => $industry->inRandomOrder()->limit(1)->first(['id'])['id'],
        'min_salary' => rand(20000, 50000),
        'max_salary' => rand(60000, 100000),
        'long_description' => $faker->text,
        'preferred_location_id' => $location->inRandomOrder()->limit(1)->first(['id'])['id'],
        'willing_to_relocate' => rand(0, 1),
        'new_to_workforce' => rand(0, 1)
    ];
});

/**
 * Create candidate's: job watchlist, candidate job application
 */
$factory->afterCreating(App\Models\Candidate::class, function ($candidate, $faker) {
    $candidateId = $candidate->id;

    factory(App\Models\CandidateJobWatchlist::class, 6)->create(['candidate_id' => $candidateId]);
    factory(App\Models\CandidateJobApplication::class)->create(['candidate_id' => $candidateId]);
    factory(App\Models\CandidateJobApplication::class)->states('closed_jobs')->create(['candidate_id' => $candidateId]);
    factory(App\Models\WhitelistedCompany::class, 6)->create(['candidate_id' => $candidateId]);
    factory(App\Models\CompanyFollower::class, 12)->create(['candidate_id' => $candidateId]);
    factory(App\Models\Privacy::class)->create(['candidate_id' => $candidateId]);
});
