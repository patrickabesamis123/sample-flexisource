<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\WhitelistedCompanyInterface;
use \Prettus\Validator\Contracts\ValidatorInterface;
use App\Models\WhitelistedCompany;

/**
 * Class WhitelistedCompanyRepository.
 *
 * @package namespace App\Repositories;
 */
class WhitelistedCompanyRepository extends BaseRepository implements WhitelistedCompanyInterface
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_UPDATE => [
            'enabled' => 'required|boolean'
        ],
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WhitelistedCompany::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
