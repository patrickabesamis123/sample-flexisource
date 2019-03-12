<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Http\Resources\CandidateJobLog as CandidateJobLogResource;

class CandidateJobLogController extends Controller
{
    /**
     * Handles Incoming HTTP Requests
     *
     * @return void
     */
    public function __invoke()
    {
        $candidate = Candidate::latest()->first();
        return CandidateJobLogResource::collection($candidate->jobLogs()->paginate(10));
    }
}
