<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Candidate extends Model
{
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships, Sluggable;

    const CREATED_AT = 'recorded_date';
    const UPDATED_AT = 'date_modified';

    protected $table = 'candidate';
    protected $fillable = [
                           'user_id', 'nickaname', 'nationality_id', 'phone_number', 'mobile_number', 'work_type_id', 'dob',
                           'industry_id', 'min_salary', 'max_salary', 'long_description', 'preferred_location_id', 'willing_to_relocate',
                           'new_to_workforce'
    ];

    public function jobApplications()
    {
        return $this->hasMany('App\Models\CandidateJobApplication', 'candidate_id');
    }

    public function watchlists()
    {
        return $this->belongsToMany('App\Models\Job', 'c_job_watchlist', 'candidate_id', 'job_id')
            ->select('job_title', 'object_id', 'closing_date', 'job_status', 'expiry_date', 'company_id');
    }

    public function companyFollowers()
    {
        return $this->belongsToMany('App\Models\Company', 'e_company_followers', 'candidate_id', 'company_id');
    }

    public function preferredLocation()
    {
        return $this->hasOne('App\Models\Location', 'id', 'preferred_location_id');
    }

    public function industry()
    {
        return $this->hasOne('App\Models\Industry', 'id', 'industry_id');
    }

    public function workType()
    {
        return $this->hasOne('App\Models\WorkType', 'id', 'work_type_id');
    }

    public function nationality()
    {
        return $this->hasOne('App\Models\Nationality', 'id', 'nationality_id');
    }

    public function qualifications()
    {
        return $this->hasMany('App\Models\CandidateQualification', 'candidate_id', 'id');
    }

    public function workHistory()
    {
        return $this->hasMany('App\Models\CandidateWorkhistory', 'candidate_id', 'id');
    }

    public function reference()
    {
        return $this->hasMany('App\Models\CandidateReference', 'candidate_id', 'id');
    }

    public function docs()
    {
        return $this->hasMany('App\Models\CandidateDocs', 'candidate_id', 'id');
    }

    public function whitelistedCompanies($params)
    {
        $query = $this->hasMany('App\Models\WhitelistedCompany', 'candidate_id')
            ->with('companies');
        if (array_key_exists('requested', $params)) {
            $query->where('requested', $params['requested']);
        }
        return $query;
    }

    /**
     * Fetch all the job logs that the candidate followed
     * @link https://github.com/staudenmeir/eloquent-has-many-deep
     * @return void
     */
    public function jobLogs()
    {
        return $this->hasManyDeep(
            'App\Models\JobLog',
            ['App\Models\CompanyFollower', 'App\Models\Job'], // Intermediate models to fetch job logs
            [
                'candidate_id', // FK on "company follower" table
                'company_id', // FK on "jobs" table
                'job_id' // FK on job logs table
            ],
            [
                'id', // Local key on "candidate" table
                'company_id', // Local key on "company follower" table
                'id' // Local key on "jobs" table
            ]
        )->select('job_logs.id', 'status', 'created_at', 'e_company_followers.company_id')
            ->withIntermediate('App\Models\Job', ['object_id', 'job_title']);
    }

    public function pmUser()
    {
        return $this->belongsTo('App\Models\PmUser', 'user_id')
                    ->select('id', 'first_name', 'last_name', 'email');
    }

    public function sluggable()
    {
        return [
            'profile_url' => [
                'source' => ['pmUser.first_name', 'pmUser.last_name'],
                'seperator' => '.',
                'unique' => true
            ]
        ];
    }

    public function emailSetting()
    {
        return $this->hasOne('App\Models\CandidateEmailSettings', 'candidate_id', 'id');
    }

    public function notificationSetting()
    {
        return $this->hasOne('App\Models\CandidateNotificationSettings', 'candidate_id', 'id');
    }

    public function privacySetting()
    {
        return $this->hasOne('App\Models\Privacy', 'candidate_id', 'id');
    }

    public function whitelistCompanies()
    {
        return $this->hasMany('App\Models\WhitelistedCompany', 'candidate_id', 'id');
    }
}
