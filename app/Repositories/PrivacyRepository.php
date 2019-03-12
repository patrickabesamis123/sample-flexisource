<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\PrivacyInterface;
use App\Validators\PrivacyValidator;
use App\Models\Privacy;

/**
 * Class PrivacyRepository.
 *
 * @package namespace App\Repositories;
 */
class PrivacyRepository extends BaseRepository implements PrivacyInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Privacy::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
