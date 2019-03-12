<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Employer::class, function (Faker $faker) {
    $accountType = new App\Models\AccountType();
    $workDept = ['Accounting', 'Information Technology', 'Human Resources', 'Finance', 'Requisition', 'Budget',
                 'Purchasing', 'Quality Monitoring', 'QA Dept.', 'Marketing', 'Production', 'Research and Development'];
    $randWorkDept = $workDept[rand(1, (count($workDept) - 1))];

    return [
        'user_id' => function () {
            return factory(App\Models\PmUser::class)->create()->id;
        },
        'company_id' => function () {
            return factory(App\Models\Company::class)->create()->id;
        },
        'nickname' => $faker->firstName,
        'phone_number' => $faker->tollFreePhoneNumber,
        'mobile_number' => $faker->phoneNumber,
        'work_title' => $faker->jobTitle,
        'work_dept' => $randWorkDept,
        'account_type_id' => $accountType->inRandomOrder()->limit(1)->first(['id'])['id']
    ];
});
