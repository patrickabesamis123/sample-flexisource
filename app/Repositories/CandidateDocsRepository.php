<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CandidateDocsInterface;
use App\Validators\CandidateDocsValidator;
use App\Models\CandidateDocs;

/**
 * Class CandidateDocsRepository.
 *
 * @package namespace App\Repositories;
 */
class CandidateDocsRepository extends BaseRepository implements CandidateDocsInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CandidateDocs::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
