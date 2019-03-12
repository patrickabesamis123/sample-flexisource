<?php

namespace App\Criteria\Candidate;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WithJobWatchlistCriteria.
 *
 * @package namespace App\Criteria;
 */
class WithJobWatchlistCriteria implements CriteriaInterface
{
    private $candidateId;

    /**
     * Constructor setup
     *
     * @param [int] $candidateId
     */
    public function __construct(int $candidateId)
    {
        $this->candidateId = $candidateId;
    }

    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->leftJoin('c_job_watchlist', 'c_job_watchlist.candidate_id', 'candidate.id')
                     ->where('candidate_id', $this->candidateId);
    }
}
