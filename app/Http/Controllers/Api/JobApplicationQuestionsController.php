<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\JobApplicationQuestionsInterface;

class JobApplicationQuestionsController extends Controller
{

    private $jobAppQuestionsRepo;

    /**
     * Constructor setup
     *
     * @param Job Application Questions Repository $repository
     */
    public function __construct(JobApplicationQuestionsInterface $jobAppQuestionsRepo)
    {
        $this->jobAppQuestionsRepo = $jobAppQuestionsRepo;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuestions($jobObjectId)
    {
        try{
            // get preapply question via job object id
            $query = $this->jobAppQuestionsRepo->getQuestionsByJobObjectId($jobObjectId);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 200);
    }

}
