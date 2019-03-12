<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CandidateWorkHistoryInterface;
use App\Models\CandidateWorkhistory;
use App\Models\CandidateWorkhistoryIndustry;
use App\Models\WorkType;
use App\Services\WorkHistoryService;

/**
 * Class CandidateWorkHistoryRepository.
 *
 * @package namespace App\Repositories;
 */
class CandidateWorkHistoryRepository extends BaseRepository implements CandidateWorkHistoryInterface
{
    /**
     * Specify Model class name
     */
    public function model()
    {
        return CandidateWorkhistory::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Create new qualification on DB
     */
    public function createWorkHistory($data)
    {
        //compute experience days
        $whService = new WorkHistoryService();
        $experience_in_days = $whService->computeExperienceDays($data['start_date'], $data['end_date']);

        //save on DB
        $wh = new CandidateWorkhistory;

        $wh->work_type_id = $data['work_type'];
        $wh->candidate_id = 1422;
        $wh->company_name = $data['company_name'];
        $wh->start_date = $data['start_date'];
        $wh->end_date = $data['end_date'];
        $wh->recorded_date = date('Y-m-d H:i:s');
        $wh->job_title = $data['job_title'];
        //$wh->key_accountabilities = $data['key_accountabilities'];
        $wh->description = $data['description'];
        $wh->experience_in_days = $experience_in_days;
        
        if(isset($data['salary']))
            $wh->salary = $data['salary'];

        $wh->save();

        //save on workhistory industry
        if(isset($data['industrySelect'])) {
            $saveWHIndustry =  new CandidateWorkhistoryIndustry;
            $saveWHIndustry->work_history_id = $wh['id'];
            $saveWHIndustry->industry_id = $data['industrySelect'];
            $saveWHIndustry->save();
        }

        if(isset($data['sub_industrySelect'])) {
            $saveWHIndustry =  new CandidateWorkhistoryIndustry;
            $saveWHIndustry->work_history_id = $wh['id'];
            $saveWHIndustry->industry_id = $data['sub_industrySelect'];
            $saveWHIndustry->save();
        }

        $workType = WorkType::find($data['work_type']);

        $data['id'] = $wh['id'];
        $data['display_date'] = $whService->getDisplayDate($data['start_date'], $data['end_date']);
        $data['work_type'] = $workType['displayName'];

        return $data;
    }

    /**
     * Update new qualification on DB
     */
    public function updateWorkHistory($data, $workHistoryId)
    {
        //compute experience days
        $experience_in_days = new WorkHistoryService();
        $experience_in_days = $experience_in_days->computeExperienceDays($data['start_date'], $data['end_date']);

        //update on DB
        $wh = CandidateWorkhistory::find($workHistoryId);

        $wh->work_type_id = $data['work_type'];
        $wh->candidate_id = 1422;
        $wh->company_name = $data['company_name'];
        $wh->start_date = $data['start_date'];
        $wh->end_date = $data['end_date'];
        $wh->recorded_date = date('Y-m-d H:i:s');
        $wh->job_title = $data['job_title'];
        //$wh->key_accountabilities = $data['key_accountabilities'];
        $wh->description = $data['description'];
        $wh->experience_in_days = $experience_in_days;

        if(isset($data['salary']))
            $wh->salary = $data['salary'];

        $wh->save();
        
        $whId = $wh['id'];

        //save on workhistory industry
        CandidateWorkhistoryIndustry::where('work_history_id',$whId)->delete();

        if(isset($data['industrySelect'])) {
            $saveWHIndustry =  new CandidateWorkhistoryIndustry;
            $saveWHIndustry->work_history_id = $whId;
            $saveWHIndustry->industry_id = $data['industrySelect'];
            $saveWHIndustry->save();
        }

        if(isset($data['sub_industrySelect'])) {
            $saveWHIndustry =  new CandidateWorkhistoryIndustry;
            $saveWHIndustry->work_history_id = $whId;
            $saveWHIndustry->industry_id = $data['sub_industrySelect'];
            $saveWHIndustry->save();
        }

        return $wh['id'];
    }

    /**
     * Delete qualification on DB
     */
    public function deleteWorkHistory($workHistoryId)
    {
        //delete first on c_workhistory_industry table
        CandidateWorkhistoryIndustry::where('work_history_id',$workHistoryId)->delete();

        //delete on c_workhistory table
        $wh = CandidateWorkhistory::find($workHistoryId);
        $wh->delete();

        return $workHistoryId;
    }
}
