<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateJobWatchlist extends Model
{
    protected $table = 'c_job_watchlist';
    protected $fillable = ['job_id', 'candidate_id'];
}
