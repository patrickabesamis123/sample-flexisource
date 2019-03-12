<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

/**
 * Class WithCompanyCriteria.
 *
 * @package namespace App\Criteria;
 */
class WithCompanyJobmetaCriteria implements CriteriaInterface
{
    private $company_fk;
    private $job_meta_fk;

    /**
     * Constructor setup
     *
     * @param [string] $foreignKeyAlias - foreign key to connect to jobs table
     */
    public function __construct(string $company_fk, string $job_meta_fk)
    {
        $this->company_fk  = $company_fk;
        $this->job_meta_fk = $job_meta_fk;
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
        return $model->leftJoin('e_company', 'e_company.id', $this->company_fk)
                    ->leftJoin('j_job_meta', function ($join) {
                        $join->on('j_job_meta.job_id', '=', $this->job_meta_fk)
                        ->on('meta_key', '=', DB::raw('\'job_video_url\''));
                    });
    }
}
