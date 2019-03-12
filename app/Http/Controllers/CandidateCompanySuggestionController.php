<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CandidateCompanySuggestion;
use App\Models\Candidate;
use App\Repositories\Contracts\CompanyInterface;
use App\Criteria\Company\WithVideoCriteria;
use App\Criteria\WithIndustryCriteria;
use App\Criteria\WithLocationCriteria;
use App\Criteria\WithCountryCriteria;

class CandidateCompanySuggestionController extends Controller
{
    private $repository;

    public function __construct(CompanyInterface $repository)
    {
        $this->repository = $repository;
    }
   
    public function __invoke()
    {
        $this->repository->pushCriteria(WithVideoCriteria::class)
            ->pushCriteria(new WithIndustryCriteria('e_company.industry_id'))
            ->pushCriteria(new WithLocationCriteria('e_company.location_id'))
            ->pushCriteria(new WithCountryCriteria('location.country_id'));

        $cols = [
            'e_company.id',
            'e_company.ob_key',
            'e_company.company_name',
            'e_company.logo_url',
            'e_company.company_url',
            'e_company.company_banner_url',
            'industry.display_name as industry',
            'country.displayName as country',
            'location.display_name as location',
            'location.type as location_type',
            'e_docs.doc_url as video_url'
        ];

        $repositorySuggestions = $this->repository->scopeQuery(function ($query) {
            $candidate = Candidate::latest()->first();
            $repositoryId = $candidate->companyFollowers->pluck('id');
            return $query->whereNotIn('e_company.id', $repositoryId);
        })->paginate(4, $cols);

        return CandidateCompanySuggestion::collection($repositorySuggestions);
    }
}
