<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\JobApplicationQuestionsInterface;
use App\Models\JobApplicationQuestions;
use App\Models\Job;
use App\Models\EmployerDoc;

/**
 * Class JobPreApplyQuestionRepository.
 *
 * @package namespace App\Repositories;
 */
class JobApplicationQuestionsRepository extends BaseRepository implements JobApplicationQuestionsInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return JobApplicationQuestions::class;
    }

    /**
     * Display question via job object id
     *
     * @return string
     */
    public function getQuestionsByJobObjectId($jobObjectId)
    {
        $job = Job::where('object_id', $jobObjectId)->first();
        
        $query = JobApplicationQuestions::where('job_id', $job['id'])
                                        ->orderBy('id', 'desc')
                                        ->get();

        foreach ($query as $key => $value) {
            $strAns = str_replace(array('[', '"', ']'), "", $value['answer_type']);
            $explodeAnsType = explode(",", $strAns);

            $strAnsChoices = str_replace(array('[', '"', ']'), "", $value['answer_choices']);
            $explodeAnsChoices = explode(",", $strAnsChoices);

            $query[$key]['answer_type'] = $explodeAnsType;
            $query[$key]['answer_choices'] = $explodeAnsChoices;

            $query[$key]['question_document'] = array();
            if(!empty($value['question_document_id'])) {
                $query[$key]['question_document'] = EmployerDoc::find($value['question_document_id'])->first();
            }

            $query[$key]['video_document'] = array();
            if(!empty($value['video_document_id'])) {
                $query[$key]['video_document'] = EmployerDoc::find($value['video_document_id'])->first();
            }
        }

        return $query;
    }

}
