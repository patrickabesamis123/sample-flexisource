<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateJobApplication extends Model
{
    const APPLIED = 'applied';
    const PENDING = 'pending';
	const CLOSED_BY_SYSTEM = 'pulled_by_system';
	const PROCESSING = 'processing';
	const SAVED = 'saved';
	const PULLED = 'pulled';
	const REJECTED = 'rejected';
    
    const CREATED_AT = 'recorded_date';
    const UPDATED_AT = 'updated_date';

    protected $table = 'c_job_application';
    //protected $hidden = ['recorded_date', 'updated_date'];

    // Disable Laravel's Eloquent timestamps
    public $timestamps = false;

    protected $fillable = ['candidate_id', 'job_id', 'app_status', 'app_steps', 'object_id', 'extra_info'];

    public function job()
    {
        return $this->hasOne('App\Models\Job', 'id', 'job_id');
    }

    public function candidateJobAppQuesAnswer()
    {
        return $this->hasMany('App\Models\CandidateJobAppQuesAnswer', 'application_id', 'id');
    }
}
