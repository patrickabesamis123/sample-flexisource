<?php

namespace App\Http\Controllers\Job;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\JobInterface;
use Illuminate\Http\JsonResponse;

class ListingController extends Controller
{
    /** @var \App\Repositories\Contracts\JobInterface */
    private $jobRepo;

    /**
     * ListingController constructor.
     *
     * @param App\Repositories\Interfaces\PhoneInterface $jobRepo
     */
    public function __construct(JobInterface $jobRepo)
    {
        $this->jobRepo = $jobRepo;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $object_id
     * @return \Illuminate\Http\Response
     */
    public function show($object_id)
    {
        if($object_id == 'job-listing-sample') {
            return view('home/job_listing_sample');
        }

        $checkObjectId = $this->jobRepo->checkOjectIdExist($object_id);

        if(!$checkObjectId) {
            abort(404, 'Job not found');
        }

        return view('job.show', [
            'id' => $object_id,
        ]);
    }

}
