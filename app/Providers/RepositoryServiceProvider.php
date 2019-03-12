<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        //'App\Repositories\JobRepository' => 'App\Repositories\JobRepositoryEloquent',
        //'App\Repositories\CandidateRepository' => 'App\Repositories\CandidateRepositoryEloquent',
        //'App\Repositories\CompanyRepository' => 'App\Repositories\CompanyRepositoryEloquent',
        //'App\Repositories\CandidateJobApplicationRepository' => 'App\Repositories\CandidateJobApplicationRepositoryEloquent',
        //'App\Repositories\WhitelistedCompanyRepository' => 'App\Repositories\WhitelistedCompanyRepositoryEloquent',
        //'App\Repositories\IndustryRepository' => 'App\Repositories\IndustryRepositoryEloquent',
        //'App\Repositories\LocationRepository' => 'App\Repositories\LocationRepositoryEloquent',
        //'App\Repositories\WorkTypeRepository' => 'App\Repositories\WorkTypeRepositoryEloquent',
        //'App\Repositories\CandidateJobWatchlistRepository' => 'App\Repositories\CandidateJobWatchlistRepositoryEloquent',
        //'App\Repositories\PrivacyRepository' => 'App\Repositories\PrivacyRepositoryEloquent',
        //'App\Repositories\CandidateDocsRepository' => 'App\Repositories\CandidateDocsRepositoryEloquent',

        'App\Repositories\Contracts\JobInterface' => 'App\Repositories\JobRepository',
        'App\Repositories\Contracts\JobMetaInterface' => 'App\Repositories\JobMetaRepository',
        'App\Repositories\Contracts\CompanyFollowerInterface' => 'App\Repositories\CompanyFollowerRepository',
        'App\Repositories\Contracts\CompanyInterface' => 'App\Repositories\CompanyRepository',
        'App\Repositories\Contracts\CandidateInterface' => 'App\Repositories\CandidateRepository',
        'App\Repositories\Contracts\CandidateJobApplicationInterface' => 'App\Repositories\CandidateJobApplicationRepository',
        'App\Repositories\Contracts\EmployerInterface' => 'App\Repositories\EmployerRepository',
        'App\Repositories\Contracts\IntegrationInterface' => 'App\Repositories\IntegrationRepository',
        'App\Repositories\Contracts\PMUserInterface' => 'App\Repositories\PMUserRepository',
        'App\Repositories\Contracts\CountryInterface' => 'App\Repositories\CountryRepository',
        'App\Repositories\Contracts\LocationInterface' => 'App\Repositories\LocationRepository',
        'App\Repositories\Contracts\CandidateWorkHistoryInterface' => 'App\Repositories\CandidateWorkHistoryRepository',
        'App\Repositories\Contracts\CandidateQualificationInterface' => 'App\Repositories\CandidateQualificationRepository',
        'App\Repositories\Contracts\QualificationInterface' => 'App\Repositories\QualificationRepository',
        'App\Repositories\Contracts\QualificationProviderInterface' => 'App\Repositories\QualificationProviderRepository',
        'App\Repositories\Contracts\WorkTypeInterface' => 'App\Repositories\WorkTypeRepository',
        'App\Repositories\Contracts\IndustryInterface' => 'App\Repositories\IndustryRepository',
        'App\Repositories\Contracts\CandidateReferenceInterface' => 'App\Repositories\CandidateReferenceRepository',
        'App\Repositories\Contracts\EmployerInterface' => 'App\Repositories\EmployerRepository',
        'App\Repositories\Contracts\EmployerRoleCreationInterface' => 'App\Repositories\EmployerRoleCreationRepository',
        'App\Repositories\Contracts\CustomerFormInterface' => 'App\Repositories\CustomerFormRepository',
        'App\Repositories\Contracts\TeamsMembersInterface' => 'App\Repositories\TeamsMembersRepository',
        'App\Repositories\Contracts\BlogPostInterface' => 'App\Repositories\BlogPostRepository',
        'App\Repositories\Contracts\WhitelistedCompanyInterface' => 'App\Repositories\WhitelistedCompanyRepository',
        'App\Repositories\Contracts\CandidateJobWatchlistInterface' => 'App\Repositories\CandidateJobWatchlistRepository',
        'App\Repositories\Contracts\PrivacyInterface' => 'App\Repositories\PrivacyRepository',
        'App\Repositories\Contracts\CandidateDocsInterface' => 'App\Repositories\CandidateDocsRepository',
        'App\Repositories\Contracts\JobPreApplyQuestionsInterface' => 'App\Repositories\JobPreApplyQuestionRepository',
        'App\Repositories\Contracts\CandidateEmailSettingsInterface' => 'App\Repositories\CandidateEmailSettingsRepository',
        'App\Repositories\Contracts\CandidateNotificationSettingsInterface' => 'App\Repositories\CandidateNotificationSettingsRepository',
        'App\Repositories\Contracts\CandidatePrivacySettingsInterface' => 'App\Repositories\CandidatePrivacySettingsRepository',
        'App\Repositories\Contracts\CandidateWhitelistedCompaniesInterface' => 'App\Repositories\CandidateWhitelistedCompaniesRepository',
        'App\Repositories\Contracts\JobApplicationQuestionsInterface' => 'App\Repositories\JobApplicationQuestionsRepository',
        'App\Repositories\Contracts\CandidateBlacklistedCompaniesInterface' => 'App\Repositories\CandidateBlacklistedCompaniesRepository',
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->bindings as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }
}
