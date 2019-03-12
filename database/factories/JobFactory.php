<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Job::class, function (Faker $faker) {
    return [
        'company_id' => function () {
            return factory(App\Models\Company::class)->create()->id;
        },
        'role_type_id' => App\Models\WorkType::inRandomOrder()->limit(1)->first(['id'])->id,
        'job_title' => $faker->jobTitle,
        'min_salary' => rand(20000, 50000),
        'max_salary' => rand(70000, 100000),
        'working_days' => "['0.1.2.3.4']",
        'start_time' => "08:00:00",
        "finish_time" => "18:00:00",
        "created_by_id" => function (array $post) {
            return factory(App\Models\Employer::class)->create(['company_id' => $post['company_id']])->id;
        },
        "job_description" => $faker->sentence(30),
        "job_status" => App\Models\Job::ACTIVE,
        "visibility" => '{"teams":[],"members":[2],"compiled_members":[2]}',
        'location_id' => App\Models\Location::inRandomOrder()->limit(1)->first(['id'])->id,
        'object_id' => 'J' . strtoupper(str_random(8)),
        'expiry_date' => date('Y-m-d H:i:s', strtotime("+30 day")),
        'industry_id' => App\Models\Industry::inRandomOrder()->limit(1)->first(['id'])->id,
        'min_experience' => rand(0, 5),
        'max_experience' => rand(6, 10),
        'is_salary_public' => rand(0, 1),
        'salary_notes' => function (array $post) {
            if ($post['is_salary_public']) {
                return '$10k to $15k';
            }
            return '';
        },
        'salary_type' => 'Annual salary package',
        'flexible_hours' => rand(0, 1),
        'published_date' => date('Y-m-d H:i:s'),
        'role_duration' => 30,
        'closing_date' => date('Y-m-d H:i:s', strtotime("+60 day")),
     ];
});

$factory->afterCreating(App\Models\Job::class, function ($job, $faker) {
    factory(App\Models\JobLog::class)->create(['job_id' => $job->id]);
});
