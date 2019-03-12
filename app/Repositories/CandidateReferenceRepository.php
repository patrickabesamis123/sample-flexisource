<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CandidateReferenceInterface;
use App\Models\CandidateReference;

/**
 * Class CandidateReferenceRepository.
 *
 * @package namespace App\Repositories;
 */
class CandidateReferenceRepository extends BaseRepository implements CandidateReferenceInterface
{
    /**
     * Specify Model class name
     */
    public function model()
    {
        return CandidateReference::class;
    }

    /**
     * Create new qualification on DB
     */
    public function createReference($data)
    {
        //save on DB
        $cr = new CandidateReference;

        $cr->candidate_id = 1958;

        $cr->employer_name = $data['employer_name'];
        $cr->contactEmail = $data['contact_email'];
        $cr->companyName = $data['company_name'];
        $cr->description = $data['description'];
        $cr->recorded_date = date('Y-m-d H:i:s');
        $cr->contact_phone = $data['contact_phone'];

        $cr->save();

        //recreate for angular variables
        $data['id'] = $cr['id'];

        return $data;
    }

    /**
     * Update new qualification on DB
     */
    public function updateReference($data, $referenceId)
    {
        //update on DB
        $cr = CandidateReference::find($referenceId);

        $cr->candidate_id = 1958;

        $cr->employer_name = $data['employer_name'];
        $cr->contactEmail = $data['contact_email'];
        $cr->companyName = $data['company_name'];
        $cr->description = $data['description'];
        $cr->recorded_date = date('Y-m-d H:i:s');
        $cr->contact_phone = $data['contact_phone'];

        $cr = $cr->save();

        //recreate for angular variables
        $data['id'] = $referenceId;

        return $data;
    }

    /**
     * Delete qualification on DB
     */
    public function deleteReference($referenceId)
    {
        $cr = CandidateReference::find($referenceId);
        $cr->delete();

        return $referenceId;
    }
}
