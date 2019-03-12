<?php

use Faker\Generator as Faker;
use App\Models\Company;

$factory->define(App\Models\Company::class, function (Faker $faker) {
    $industry = new App\Models\Industry();
    $location = new App\Models\Location();
    $numOfEmployees = rand(1, 100) . ' - ' . rand(200, 500);
    return [
        'industry_id' => $industry->inRandomOrder()->limit(1)->first(['id'])['id'],
        'company_name' => $faker->company,
        'num_of_employees' => $numOfEmployees,
        'website_url' => $faker->url,
        'company_phone' => $faker->tollFreePhoneNumber,
        'company_fax' => $faker->tollFreePhoneNumber,
        'ob_key' => str_random(7),
        'street_address' => $faker->streetName,
        'street_address_2' => $faker->streetAddress,
        'location_id' => $location->inRandomOrder()->limit(1)->first(['id'])['id'],
        'company_description' => $faker->text,
        'status' => Company::ACTIVE
    ];
});

/**
 * Create jobs
 */
$factory->afterCreating(App\Models\Company::class, function ($company, $faker) {
    factory(App\Models\Job::class, 12)->create(['company_id' => $company->id]);
});
