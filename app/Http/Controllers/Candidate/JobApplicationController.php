<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\JobRepository;
use App\Models\Job;
use JWTAuth;

class JobApplicationController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show()
    {
        return view('candidate/applications/index');
    }

    /**
     * Job application
     */
    public function apply($jObjectId)
    {
        $job = Job::select('id')->where('object_id', $jObjectId)->get();

        if(!isset($job[0]['id'])) {
            abort(404, 'Job not found');
        }

        // check if user is not login
        // unfinished
        // try {
        //     $tokenFetch = JWTAuth::parseToken()->authenticate();
        //     if (!$tokenFetch)
        //         return redirect('/');

        // } catch(\Tymon\JWTAuth\Exceptions\JWTException $e){ //general JWT exception
        //     return redirect('/');
        // }


        return view('candidate/roleapplication/index');
    }

}
