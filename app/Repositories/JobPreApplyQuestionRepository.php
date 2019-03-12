<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\JobPreApplyQuestionsInterface;
use App\Models\JobPreApplyQuestions;
use App\Models\Job;

/**
 * Class JobPreApplyQuestionRepository.
 *
 * @package namespace App\Repositories;
 */
class JobPreApplyQuestionRepository extends BaseRepository implements JobPreApplyQuestionsInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return JobPreApplyQuestions::class;
    }

    /**
     * Display question via job object id
     *
     * @return string
     */
    public function getQuestionsByJobObjectId($jobObjectId)
    {
        $job = Job::where('object_id', $jobObjectId)->first();

        $query = JobPreApplyQuestions::where('job_id', $job['id'])->get();

        return $query;
    }

}
