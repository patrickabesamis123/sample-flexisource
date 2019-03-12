<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CandidateQualificationInterface;
use App\Models\CandidateQualification;

use App\Services\QualificationService;
use App\Services\QualificationProviderService;

/**
 * Class CandidateQualificationRepository.
 *
 * @package namespace App\Repositories;
 */
class CandidateQualificationRepository extends BaseRepository implements CandidateQualificationInterface
{
    /**
     * Specify Model class name
     */
    public function model()
    {
        return CandidateQualification::class;
    }

    /**
     * Create new qualification on DB
     */
    public function createQualification($data)
    {
        //get qualification_id
        $qualificationServ = new QualificationService;
        $qualificationId = $qualificationServ->getOrSetIdFromName($data['qualification']);

        //get qualification_provider_id
        $qualificationProviderServ = new QualificationProviderService;
        $qualificationProviderId = $qualificationProviderServ->getOrSetIdFromName($data['qualification_provider']);
        $qualificationProviderLogo = $qualificationProviderServ->getLogo($data['qualification_provider']);

        //save on DB
        $cq = new CandidateQualification;

        $cq->qualification_id = $qualificationId;
        $cq->qualification_provider_id =  $qualificationProviderId;
        $cq->degree = $data['degree'];
        $cq->candidate_id = 1422;
        $cq->recorded_date = date('Y-m-d H:i:s');
        $cq->degree = $data['degree'];

        if(!empty($data['completed_date']))
            $cq->completed_date = $data['completed_date'];

        $cq = $cq->save();

        //recreate for angular variables
        $response['degree'] = $data['degree'];
        $response['completed_date'] = $data['completed_date'];
        $response['qualification']['display_name'] = $data['qualification'];
        $response['qualification_provider']['provider_display_name'] = $data['qualification_provider'];
        $response['qualification_provider']['company_logo'] = $qualificationProviderLogo;

        return $response;
    }

    /**
     * Update new qualification on DB
     */
    public function updateQualification($data, $UserQualificationId)
    {
        //get qualification_id
        $qualificationServ = new QualificationService;
        $qualificationId = $qualificationServ->getOrSetIdFromName($data['qualification']);

        //get qualification_provider_id
        $qualificationProviderServ = new QualificationProviderService;
        $qualificationProviderId = $qualificationProviderServ->getOrSetIdFromName($data['qualification_provider']);
        $qualificationProviderLogo = $qualificationProviderServ->getLogo($data['qualification_provider']);

        //save on DB
        $cq = CandidateQualification::find($UserQualificationId);

        $cq->qualification_id = $qualificationId;
        $cq->qualification_provider_id =  $qualificationProviderId;
        $cq->degree = $data['degree'];
        $cq->candidate_id = 1422;
        $cq->recorded_date = date('Y-m-d H:i:s');
        $cq->degree = $data['degree'];

        if(!empty($data['completed_date']))
            $cq->completed_date = $data['completed_date'];

        $cq = $cq->save();

        //recreate for angular variables
        $response['degree'] = $data['degree'];
        $response['completed_date'] = $data['completed_date'];
        $response['qualification']['display_name'] = $data['qualification'];
        $response['qualification_provider']['provider_display_name'] = $data['qualification_provider'];
        $response['qualification_provider']['company_logo'] = $qualificationProviderLogo;

        return $response;
    }

    /**
     * Delete qualification on DB
     */
    public function deleteQualification($qualificationId)
    {
        $cq = CandidateQualification::find($qualificationId);
        $cq->delete();

        return $qualificationId;
    }
}
