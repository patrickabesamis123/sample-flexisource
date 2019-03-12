<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('salutations', 'Api\SalutationController');
Route::get('industries', 'Api\IndustryController');
Route::get('industries/list-parent', 'Api\IndustryController@listParent');
Route::get('industries/list-parent-and-sub', 'Api\IndustryController@listParentAndSub');
Route::get('locations', 'Api\LocationController@fetchData');
Route::get('work-types', 'Api\WorkTypeController');
Route::get('work-types/list', 'Api\WorkTypeController@list');
Route::get('country/list', 'Api\CountryController@list');
Route::get('location/auto-complete/{data}/{country_id}', 'Api\LocationController@autoComplete');
Route::get('location/auto-complete-search/{data}', 'Api\LocationController@autoCompleteSearch');
Route::get('location/search-by-country/{slug_code}', 'Api\LocationController@searchForLocationByCountry');
Route::get('qualification/auto-complete/{display_name}/{limit}', 'Api\QualificationController@autoComplete');
Route::get('qualification/list', 'Api\QualificationController@list');
Route::get('qualification-provider/auto-complete/{display_name}/{limit}', 'Api\QualificationProviderController@autoComplete');
Route::get('qualification-provider/list', 'Api\QualificationProviderController@list');
Route::post('contact-us', 'Api\CustomerFormController@storeContactUs');
Route::post('harmful-complaint', 'Api\CustomerFormController@storeHarmfulComplaint');
Route::get('blog-posts', 'Api\BlogPostController@index');
Route::get('blog-post/{slug_name}', 'Api\BlogPostController@getDetails');


/************ 
* CANDIDATE * 
*************/

Route::prefix('candidate')->group(function() {
    
    Route::get('profile/completion', 'CandidateProfileCompletionController');
    Route::get('profile/request', 'CandidateProfileRequestController@index');
    Route::put('profile/request/{id}', 'CandidateProfileRequestController@update');
    Route::get('job/watchlist', 'CandidateJobWatchlistController@index');
    Route::post('job/watchlist', 'CandidateJobWatchlistController@store');
    Route::delete('job/watchlist/{job_id}', 'CandidateJobWatchlistController@destroy');
    Route::get('job/featured', 'CandidateJobFeaturedController');
    Route::get('job/application/{type}', 'Api\CandidateJobApplicationController@getByType');
    Route::get('company/follow', 'CandidateCompanyFollowController');
    Route::get('company/log', 'CandidateJobLogController');
    Route::get('company/suggestion', 'CandidateCompanySuggestionController');

    Route::get('pre-apply-questions/{jobObjId}', 'Api\JobPreApplyQuestionsController@getPreApplyQuestions');
    Route::post('pre-apply-questions/{job_objId}', 'Api\CandidateJobApplicationController@postPreApplyQuestions');

    Route::get('requirements-check/{jobId}/{candidateId}', 'Api\JobMetaController@getRequirementsCheck');
    Route::get('info/{candidate_id}', 'Api\CandidateController@show');

    Route::post('requirements-check/{job_objId}/{application_objId}', 'Api\CandidateJobApplicationController@postRequirementsCheck');

    Route::get('questions/{jobObjId}', 'Api\JobApplicationQuestionsController@getQuestions');
    Route::post('questions/{jobObjId}/{application_objId}', 'Api\CandidateJobApplicationController@postQuestions');
});


/**********************
*  EMPLOYER / COMPANY * 
***********************/

Route::get('public/company-search', 'SearchController@getCompanySearchList');

Route::prefix('company')->group(function() {
    Route::get('{company_url}', 'Api\CompanyController@index');
    Route::get('edit/{company_id}', 'Api\CompanyController@edit');
    Route::post('update/{company_id}', 'Api\CompanyController@update');
    Route::get('employers/{company_id}', 'Api\CompanyController@getEmployers');
    Route::get('teams/{company_id}/{employer_id}', 'Api\CompanyController@getTeams');
    Route::post('team/create', 'Api\CompanyController@storeTeam');
    Route::put('team/update/{team_id}', 'Api\CompanyController@updateTeam');
    Route::delete('team/delete/{team_id}', 'Api\CompanyController@destroyTeam');
    Route::get('team-members/{company_id}', 'Api\CompanyController@getTeamMembers');
    Route::delete('team-member/delete/{team_id}/{employer_id}', 'Api\CompanyController@destroyTeamMember');
    Route::post('team-member/invite/{company_id}', 'Api\CompanyController@storeInvitedTeamMember');
    Route::get('all/active', 'Api\CompanyController@getActiveCompanies');
});

Route::prefix('employer')->group(function() {
    Route::get('profile/open-roles', 'Api\EmployerController@open_roles');
    Route::get('profile/closed-jobs', 'Api\EmployerController@closed_jobs');
    Route::get('profile/draft-jobs', 'Api\EmployerController@draft_jobs');
    Route::get('profile/watchlist', 'Api\EmployerController@watchlist');
    Route::get('settings/{employer_id}', 'Api\EmployerController@index');
    Route::post('change-email-address/{employer_id}', 'Api\EmployerController@updateEmail');
    Route::post('change-password/{employer_id}', 'Api\EmployerController@updatePassword');
    Route::post('change-basic-info/{employer_id}', 'Api\EmployerController@updateBasicInfo');
    Route::put('change-account-type/{employer_id}', 'Api\EmployerController@updateAccountType');
    Route::put('change-account-status/{employer_id}', 'Api\EmployerController@updateAccountStatus');
    Route::get('js-config/{company_id}', 'Api\IntegrationController@getJsIntegrationConfig');
    Route::get('permissions/{employer_id}', 'Api\EmployerController@getPermissions');
});

Route::get('employer/profile/open-roles', 'Api\EmployerController@open_roles');
Route::get('employer/profile/closed-jobs', 'Api\EmployerController@closed_jobs');
Route::get('employer/profile/draft-jobs', 'Api\EmployerController@draft_jobs');
Route::get('employer/profile/watchlist', 'Api\EmployerController@watchlist');
Route::get('employer/role-creation/drafts', 'Api\EmployerRoleCreationController@drafts');
Route::get('employer/role-creation/classifications', 'Api\EmployerRoleCreationController@classifications');
Route::get('employer/role-creation/search', 'Api\EmployerRoleCreationController@search');
Route::get('employer/role-creation/preview/{template_id}', 'Api\EmployerRoleCreationController@preview');


/*******
* JOBS * 
********/

Route::get('public/job-search', 'SearchController@getJobSearchList');
Route::prefix('job')->group(function() {
    Route::get('details/{object_id}', 'Api\JobController@getDetailsByObjectId');
    Route::get('search-widget', 'Api\JobController@getJobSearchWidget');
    Route::get('{object_id}', 'Api\JobController@getDetailsByObjectId');
    Route::get('tally/{company_id}', 'Api\JobController@getJobTally');
    Route::get('{status}/{company_id}', 'Api\JobController@getCompanyRoles');
});


/***********************
* LOGIN / LOGOUT /AUTH * 
************************/

Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::get('recover', 'AuthController@recover');
Route::post('forgot', 'AuthController@forgot');
Route::get('reset', 'AuthController@reset');
Route::group(['middleware' => ['jwt.auth']], function() {
    Route::get('logout', 'AuthController@logout');
    Route::get('user-auth-data', 'AuthController@getAuthenticatedUser');
    
    Route::prefix('employer')->group(function() {
        Route::post('js-request/{employer_id}', 'Api\EmployerController@storeJsIntegrationRequest');
        Route::get('js-status/{employer_id}', 'Api\EmployerController@getJsIntegrationStatus');
        Route::post('js-config/{company_id}', 'Api\IntegrationController@storeJsIntegrationConfig');
    });


    //Candidate
    Route::prefix('candidate')->group(function() {
        Route::get('profile', 'Candidate\CandidateProfileController@index');
        Route::get('profile/details', 'Api\PMUserController@show');
        Route::put('profile/update-name/{pm_user_id}', 'Api\PMUserController@updateName');
        Route::put('profile/update-details/{pm_user_id}', 'Api\PMUserController@updateByPMUserId');
        Route::put('profile/update-location/{pm_user_id}', 'Api\CandidateController@updateLocation');
        Route::put('profile/update-candidate-only/{pm_user_id}', 'Api\CandidateController@update');
        Route::post('work-history/create/', 'Api\CandidateWorkHistoryController@store');
        Route::put('work-history/update/{work_history_id}', 'Api\CandidateWorkHistoryController@update');
        Route::delete('work-history/delete/{work_history_id}', 'Api\CandidateWorkHistoryController@destroy');
        Route::post('qualification/create/', 'Api\CandidateQualificationController@store');
        Route::put('qualification/update/{qualification_id}', 'Api\CandidateQualificationController@update');
        Route::delete('qualification/delete/{qualification_id}', 'Api\CandidateQualificationController@destroy');
        Route::post('reference/create/', 'Api\CandidateReferenceController@store');
        Route::put('reference/update/{reference_id}', 'Api\CandidateReferenceController@update');
        Route::delete('reference/delete/{reference_id}', 'Api\CandidateReferenceController@destroy');
        Route::get('application/{candidate_id}/{status}/', 'Api\CandidateApplicationController@show');
        Route::get('job-application-details/{candidate_id}/{job_object_id}/', 'Api\JobController@getApplicationDetails');
        Route::get('job-application-steps/{job_ObjId}/{application_ObjId}', 'Api\CandidateJobApplicationController@getSteps');
        
        Route::prefix('account-settings')->group(function() {
            Route::put('update-email', 'Api\CandidateController@updateEmailAddress');
            Route::put('update-password', 'Api\CandidateController@updatePassword');
            Route::put('update-profile-url', 'Api\CandidateController@updateProfileUrl');
            Route::get('update-status/{candidate_id}', 'Api\CandidateController@updateStatus');
        });
        Route::prefix('communication-settings')->group(function() {
            Route::prefix('email')->group(function() {
                Route::get('{candidate_id}', 'Api\CandidateEmailSettingsController@index');
                Route::put('update', 'Api\CandidateEmailSettingsController@update');
            });
            Route::prefix('notification')->group(function() {
                Route::get('{candidate_id}', 'Api\CandidateNotificationSettingsController@index');
                Route::put('update', 'Api\CandidateNotificationSettingsController@update');
            });
        });
        Route::prefix('privacy-settings')->group(function() {
            Route::get('{candidate_id}', 'Api\CandidatePrivacySettingsController@index');
            Route::put('update', 'Api\CandidatePrivacySettingsController@update');
        });
        Route::prefix('whitelisted-companies')->group(function() {
            Route::get('{candidate_id}', 'Api\CandidateWhitelistedCompaniesController@index');
            Route::get('request/{candidate_id}', 'Api\CandidateWhitelistedCompaniesController@getRequestedWhitelistCompanies');
            Route::put('store', 'Api\CandidateWhitelistedCompaniesController@storeWhitelistedCompanies');
            Route::put('allow', 'Api\CandidateWhitelistedCompaniesController@allowWhitelistCompany');
            Route::put('decline', 'Api\CandidateWhitelistedCompaniesController@declineWhitelistCompany');
        });
        Route::prefix('blacklisted-companies')->group(function() {
            Route::get('{candidate_id}', 'Api\CandidateBlacklistedCompaniesController@index');
            Route::put('store', 'Api\CandidateBlacklistedCompaniesController@storeBlacklistedCompanies');
        });        
    });

});

/*Route::get('password/email', 'Auth\ForgotPasswordController@getResetToken');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');*/