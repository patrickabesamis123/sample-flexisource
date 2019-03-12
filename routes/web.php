<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/****************
* PUBLIC ROUTES * 
*****************/

/** demo-frontend **/

Route::get('/', function () {
    return view('home/index');
});

Route::get('/login', function () {
    return view('home/login');
});

Route::get('/candidate/settings/index', function () {
    return view('candidate/settings/index');
});

Route::get('/register/forgot_password', function () {
    return view('home/forgot_password');
});

Route::get('/features', function () {
    return view('home/features');
});

Route::get('/features/candidates', function () {
    return view('home/feature_candidate');
});

Route::get('/features/employers', function () {
    return view('home/feature_employer');
});

Route::get('/features', function () {
    return view('home/features');
});

Route::get('/about-us', function () {
    return view('home/about-us');
});

Route::get('/resources', function () {
    return view('home/resources');
});

Route::get('/resources/{id}', function () {
    return view('home/resources');
});

Route::get('/resource/{blog_url_segment}', function () {
    return view('home/resource');
});

Route::get('/contact-us', function () {
    return view('home/contact-us');
});

Route::get('/faq', function () {
    return view('home/faq');
});

Route::get('/pricing', function () {
    return view('home/pricing');
});

Route::get('/help', function () {
    return view('home/help');
});

Route::get('/harmful-communications', function () {
    return view('home/harmful-communications');
});

Route::get('/our-partners', function () {
    return view('home/our-partners');
});

Route::get('/job-search', function () {
    return view('home/job_search');
});

Route::get('/reset-password', function () {
    return view('home/reset_password');
});

//change "previewme" to a variable for the company id
Route::get('/company/{company_url}', function () {
    return view('employer/company');
});

Route::get('/job-template', function () {
    return view('employer/job_template_search');
});

Route::get('/terms-and-conditions', function () {
    return view('home/terms_conditions');
});

Route::get('/privacy-policy', function () {
    return view('home/privacy_policy');
});

Route::get('/register', function () {
    return view('home/register');
});

Route::get('/register/location', function () {
    return view('home/register-location');
});

Route::get('/register/confirm', function () {
    return view('home/register-confirm');
});

Route::get('/register/employer', function () {
    return view('home/register-employer');
});

Route::get('/register/confirm-employer', function () {
    return view('home/register-confirm-employer');
});

Route::get('/help', function () {
    return view('home/help');
});

/** with API **/

Route::get('job/listing/{object_id}', 'Job\ListingController@show');



/*******************
* CANDIDATE ROUTES * 
********************/

/** demo-frontend **/

/*Route::get('/my-profile', function () {
    return view('candidate/my-profile');
});

Route::get('/my-profile-edit', function () {
    return view('candidate/my-profile-edit');
});

Route::get('/my-job-applications', function () {
    return view('candidate/applications/index');
});

Route::get('/candidate/messages', function () {
    return view('candidate/messages');
});

Route::get('/candidate/analytics', function () {
    return view('candidate/analytics/job-applications');
});*/

/** with API **/

Route::get('/candidate/profile', 'Candidate\CandidateProfileController@show');
Route::get('/candidate/profile/edit', 'Candidate\CandidateProfileController@edit');
Route::get('/candidate/job-applications', 'Candidate\JobApplicationController@show');
Route::get('/job/application/{c_obj_app_object_id}', 'Candidate\JobApplicationController@apply');


/****************************
* EMPLOYER / COMPANY ROUTES * 
*****************************/

/** demo-frontend **/
Route::get('candidate/roleapplication', function () {
    return view('candidate/roleapplication/index');
});

Route::get('candidate/roleapplication/candidate-declaration', function () {
    return view('candidate/roleapplication/candidate-declaration');
});

/* Employer routes */
Route::prefix('employer')->group(function () {
    Route::get('dashboard', function () {
        return view('employer/dashboard');
    });
    Route::get('teams', function () {
        return view('employer/teams');
    });
    Route::get('settings', function () {
        return view('employer/employer_settings');
    });
    Route::get('company-roles', function () {
        return view('employer/company_roles');
    });
    Route::get('role-creation/add', function () {
        return view('employer/role_creation/add');
    });
    Route::get('role-creation/add/employee', function () {
        return view('employer/role_creation/add_job_employees');
    });
});

Route::get('/employer/edit/company-profile', function () {
    return view('employer/edit_company_profile');
});

Route::get('user/verify/{verification_code}', 'AuthController@verifyUser');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@postReset')->name('password.reset');

Route::get('user/verify/{verification_code}', 'AuthController@verifyUser');
/*Route::get('reset-password/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.request');*/
Route::post('reset-password?token={token}', 'Auth\ResetPasswordController@postReset')->name('password.reset');

Route::get('/employer/manage-talent', function () {
    return view('employer/role_creation/tms/manage_talent');
});


/****************
* VUE JS ROUTES * 
*****************/

Route::get('{path}', function () {
    return view('index');
})->where('path', '(.*)');
