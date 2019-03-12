<?php

namespace App\Services;

use App\Repositories\Contracts\CandidateJobApplicationInterface;
use Illuminate\Http\Request;
use App\Strategy\JobApplication\JobApplicationParser;

class CandidateJobApplicationService
{
    private $jobApplication;
    private $repository;

    /**
     * Constructor setup
     *
     * @param JobApplicationContract $jobApplication
     * @param CandidateJobApplicationInterface $repository
     */
    public function __construct(Request $request, CandidateJobApplicationInterface $repository)
    {
        $this->jobApplication = (new JobApplicationParser())->make($request->type);
        $this->repository = $repository;
    }

    /**
     * Fetches the job application
     *
     * @return void
     */
    public function fetchJobApplication()
    {
        return $this->jobApplication->fetchJobApplication($this->repository);
    }

}
