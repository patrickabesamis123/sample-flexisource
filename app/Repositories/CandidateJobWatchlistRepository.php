<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CandidateJobWatchlistInterface;
use App\Models\CandidateJobWatchlist;
use App\Validators\CandidateJobWatchlistValidator;

/**
 * Interface CandidateJobWatchlistRepository.
 *
 * @package namespace App\Repositories;
 */

class CandidateJobWatchlistRepository extends BaseRepository implements CandidateJobWatchlistInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CandidateJobWatchlist::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
