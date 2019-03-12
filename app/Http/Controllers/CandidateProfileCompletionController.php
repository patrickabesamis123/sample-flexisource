<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CandidateService;

class CandidateProfileCompletionController extends Controller
{
    private $candidateService;

    /**
     * Constructor Set-up
     *
     * @param CandidateService $candidateService
     */
    public function __construct(CandidateService $candidateService)
    {
        $this->candidateService = $candidateService;
    }

    /**
     * Handles incoming requests
     *
     * @return void
     */
    public function __invoke()
    {
        return response()->json($this->candidateService->getCompletionProgress());
    }
}
