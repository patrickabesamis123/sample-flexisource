<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CandidateService;
use App\Repositories\Contracts\PMUserInterface;
use Input;

class CandidateProfileController extends Controller
{
    private $candidate;
    
    /** @var \App\Repositories\Contracts\JobInterface */
    private $pmUserRepo;

    public function __construct(CandidateService $candidate, PMUserInterface $pmUserRepo)
    {
        $this->candidate = $candidate;
        $this->pmUserRepo = $pmUserRepo;
    }

    public function index()
    {
        $profile = $this->candidate->getCandidateInfo();
        $profile['privacy'] = $this->candidate->getCandidatePrivacy();
        return response()->json($profile, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('candidate/show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('candidate/edit');
    }
    

}
