<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Privacy::class, function (Faker $faker) {
    return [
        'candidate_id' => function () {
            return factory(App\Models\Candidate::class)->create()->id;
        },
        'settings' => '{"seo_enabled":false,"first_name":true,"last_name":true,"contact_number":true,
                        "email":false,"location":true,"about_me":true,"industry":false,"sub_industry":true,
                        "profile_photo":true,"generic_video":false,"experience":true,"education":true,"references":true,
                        "resume":true,"supporting_docs":true}',
        'type' => App\Models\Privacy::PUBLIC_TYPE
    ];
});
