<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateJobAppQuesAnswer extends Model
{

    protected $table = 'c_job_app_ques_answer';
    public $timestamps = false;

    public function location()
    {
        return $this->hasOne('App\Models\Location', 'id', 'location_id');
    }

    public function question()
    {
        return $this->hasOne('App\Models\JobApplicationQuestions', 'id', 'question_id');
    }

}
