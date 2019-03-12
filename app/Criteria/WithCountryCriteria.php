<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WithCountryCriteria.
 *
 * @package namespace App\Criteria;
 */
class WithCountryCriteria implements CriteriaInterface
{
    private $foreignKeyAlias;

    /**
     * Constructor setup
     *
     * @param [string] $foreignKeyAlias - foreign key to connect to jobs table
     */
    public function __construct(string $foreignKeyAlias)
    {
        $this->foreignKeyAlias = $foreignKeyAlias;
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
        return $model->leftJoin('country', 'country.id', $this->foreignKeyAlias);
    }
}
