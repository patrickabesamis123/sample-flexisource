<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CandidateJobWatchlist as CandidateJobWatchlistResource;
use App\Repositories\Contracts\CandidateJobWatchlistInterface;
use App\Http\Requests\CandidateJobWatchlist\StoreRequest;
use App\Criteria\Job\ActiveJobCriteria;
use App\Criteria\WithJobCriteria;
use App\Criteria\WithCompanyCriteria;
use App\Criteria\WithCandidateCriteria;
use App\Models\CandidateJobWatchlist;
use App\Models\Candidate;

class CandidateJobWatchlistController extends Controller
{
    private $repository;

    public function __construct(CandidateJobWatchlistInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $this->repository
            ->pushCriteria(new WithCandidateCriteria('c_job_watchlist.candidate_id'))
            ->pushCriteria(new WithJobCriteria('c_job_watchlist.job_id'))
            ->pushCriteria(ActiveJobCriteria::class)
            ->pushCriteria(new WithCompanyCriteria('j_job.company_id'));

        $cols = [
            'j_job.object_id',
            'j_job.job_title',
            'j_job.expiry_date',
            'c_job_watchlist.created_at',
            'e_company.company_name',
            'e_company.company_url',
            'e_company.logo_url'
        ];
        $watchlists = $this->repository->scopeQuery(function ($query) {
            $candidate = Candidate::latest()->first();
            return $query->where('c_job_watchlist.candidate_id', $candidate->id);
        })->orderBy('created_at', 'desc')->paginate(5, $cols);

        return CandidateJobWatchlistResource::collection($watchlists);
    }
   
    public function store(StoreRequest $request)
    {
        $candidate = Candidate::latest()->first();
        $this->repository->create(['job_id' => $request->job_id, 'candidate_id' => $candidate->id]);
        return response()->json([], 201);
    }

    public function destroy(int $jobId)
    {
        $candidate = Candidate::latest()->first();
        $deleted = $this->repository->deleteWhere(['job_id' => $jobId, 'candidate_id' => $candidate->id]);
        return response()->json([], 204);
    }
}
