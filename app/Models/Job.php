<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    const EXPIRED = 'expired';
    const ACTIVE = 'active';
    const CLOSED = 'closed';
    const DELETED = 'deleted';
    const DRAFT = 'draft';
    const HIRED = 'hired';

    const CREATED_AT = 'recorded_date';
    const UPDATED_AT = 'modified_date';
    
    protected $table = 'j_job';

    protected $fillables = ['company_id', 'role_type_id', 'job_title', 'min_salary', 'max_salary', 'working_days',
                            'start_time', 'finish_time', 'created_by_id', 'job_description', 'job_status', 'visibility',
                            'location_id', 'object_id', 'expiry_date', 'industry_id', 'min_experience', 'max_experience',
                            'is_salary_public', 'salary_notes', 'salary_type', 'flexibile_hours', 'published_date', 'role_duration',
                            'closing_date'];

    public static function isJobExpired(String $jobStatus) : bool
    {
        return $jobStatus === self::EXPIRED;
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }

    public function location()
    {
        return $this->hasOne('App\Models\Location', 'id', 'location_id');
    }

    public function role_type()
    {
        return $this->hasOne('App\Models\WorkType', 'id', 'role_type_id');
    }

    public function job_meta()
    {
        return $this->hasMany('App\Models\JobMeta', 'job_id', 'id');
    }

    public function job_meta_video_url()
    {
        return $this->hasMany('App\Models\JobMeta', 'job_id', 'id')->where('meta_key', 'job_video_url');
    }

    public function industry()
    {
        return $this->hasOne('App\Models\Industry', 'id', 'industry_id');
    }

    public function accountabilities()
    {
        return $this->hasMany('App\Models\Accountability', 'job_id', 'id');
    }
    
    public function requirements()
    {
        return $this->hasMany('App\Models\Requirement', 'job_id', 'id');
    }

    public function objectives()
    {
        return $this->hasMany('App\Models\Objective', 'job_id', 'id');
    }


    public  function scopeLikeJobTitle($query, $value){
        return $query->where('job_title', 'LIKE', "%$value%");
    }

    public function search_helpers()
    {
        return $this->hasMany('App\Models\SearchHelpers', 'job_id', 'id');
    }

    public function benefits()
    {
        return $this->hasMany('App\Models\Benefit', 'job_id', 'id');
    }

    public function pre_apply_questions()
    {
        return $this->hasMany('App\Models\PreApplyQuestions', 'job_id', 'id');
    }

}
