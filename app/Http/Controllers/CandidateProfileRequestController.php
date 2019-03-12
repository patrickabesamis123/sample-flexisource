<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Http\Resources\CandidateProfileRequest as CandidateProfileRequestResource;
use App\Repositories\Contracts\WhitelistedCompanyInterface;
use \Prettus\Validator\Exceptions\ValidatorException;

class CandidateProfileRequestController extends Controller
{
    /**
     * @var [WhitelistedCompany]
     */
    private $repository;

    /**
     * Constructor setup
     *
     * @param WhitelistedCompanyInterface $repository
     */
    public function __construct(WhitelistedCompanyInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Fetches profile request
     *
     * @return void
     */
    public function index()
    {
        $candidate = Candidate::latest()->first();
        $whitelistedCompanies = $candidate->whitelistedCompanies(['requested' => 1]);
        return CandidateProfileRequestResource::collection($whitelistedCompanies->paginate(5));
    }

    /**
     * Update the resource
     *
     * @param Request $request
     * @return void
     */
    public function update(Request $request)
    {
        try {
            $request['requested'] = false;
            $this->repository->update($request->all(), $request->id);
            return response()->json([], 204);
        } catch (ValidatorException $e) {
            return response()->json($e->getMessageBag(), 400);
        }
    }
}
