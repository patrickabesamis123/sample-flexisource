<?php

namespace App\Criteria\Company;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class WithCandidateCriteriaCriteria.
 *
 * @package namespace App\Criteria;
 */
class WithIndustryLocationCountryDocsCriteria implements CriteriaInterface
{
    private $fk_industry_id;
    private $fk_location_id;
    private $fk_country_id;
    private $fk_employer_id;

    /**
     * Constructor setup
     *
     * @param [string] $fk_industry_id - foreign key to connect to industry table
     * @param [string] $fk_location_id - foreign key to connect to location table
     * @param [string] $fk_country_id - foreign key to connect to country table
     * @param [string] $fk_employer_id - foreign key to connect to e_docs table
     */
    public function __construct(string $fk_industry_id, string $fk_location_id, string $fk_country_id, string $fk_employer_id)
    {
        $this->fk_industry_id = $fk_industry_id;
        $this->fk_location_id = $fk_location_id;
        $this->fk_country_id  = $fk_country_id;
        $this->fk_employer_id = $fk_employer_id;
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
        return $model->leftJoin('industry', 'industry.id', $this->fk_industry_id)
                    ->leftJoin('location', 'location.id', $this->fk_location_id)
                    ->leftJoin('country', 'country.id', $this->fk_country_id)
                    ->leftJoin('e_docs', 'e_docs.employer_id', $this->fk_employer_id);
    }
}
