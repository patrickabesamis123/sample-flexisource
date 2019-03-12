<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CandidateProfileCompletion;
use App\Models\Candidate;

class CandidateWorkhistory extends Model implements CandidateProfileCompletion
{
    protected $table = 'c_workhistory';
    
    public $timestamps = false;

    public static function completionProgress()
    {
        $candidate = Candidate::latest()->first();
        return self::where('candidate_id', $candidate->id)->count();
    }

    public function work_type()
    {
        return $this->hasOne('App\Models\WorkType', 'id', 'work_type_id');
    }

    public function work_history_industry()
    {
        return $this->hasMany('App\Models\CandidateWorkhistoryIndustry', 'work_history_id', 'id');
    }
}
