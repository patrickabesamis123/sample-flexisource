<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\JobPreApplyQuestionsInterface;

class JobPreApplyQuestionsController extends Controller
{

    private $jobPreAppQuesRepo;

    /**
     * Constructor setup
     *
     * @param IndustryRepository $repository
     */
    public function __construct(JobPreApplyQuestionsInterface $jobPreAppQuesRepo)
    {
        $this->jobPreAppQuesRepo = $jobPreAppQuesRepo;
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPreApplyQuestions($jobObjectId)
    {
        try{
            // get preapply question via job object id
            $query = $this->jobPreAppQuesRepo->getQuestionsByJobObjectId($jobObjectId);
        } catch (\Exception $e) {
            // return error response if something goes wrong
            return response()->json(['error'=>$e->getMessage()], 400);
        }

        return response()->json($query, 200);
    }

}
