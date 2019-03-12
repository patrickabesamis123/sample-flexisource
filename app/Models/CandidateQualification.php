<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\CandidateProfileCompletion;
use App\Models\Candidate;

class CandidateQualification extends Model implements CandidateProfileCompletion
{
    protected $table = 'c_qualification';

    public $timestamps = false;

    /**
     * Get the candidate profile completion
     *
     * @return int
     */
    public static function completionProgress() : int
    {
        $candidate = Candidate::latest()->first();
        return self::where('candidate_id', $candidate->id)->count();
    }

    public function qualification()
    {
        return $this->belongsTo('App\Models\Qualification', 'qualification_id', 'id');
    }

    public function qualificationProvider()
    {
        return $this->belongsTo('App\Models\QualificationProvider', 'qualification_provider_id', 'id');
    }


}
