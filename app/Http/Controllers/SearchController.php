<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SearchService;
use Illuminate\Support\Facades\Input;
use App\Transformers\JobTransformer;
use App\Transformers\CompanyTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\ArraySerializer;

class SearchController extends Controller
{
    private $job_search;

    public function __construct(SearchService $search)
    {
        $this->search = $search;
    }

    public function getJobSearchList(Request $request)
    {   
        $jobs = $this->search->getJobs($request->all());

        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer());
        $job_response = $fractal->createData(new Collection($jobs, new JobTransformer()))->toArray();
        
        $page['more_present'] = ($jobs->toArray()["next_page_url"]) ? true : false;
        $page['limit'] = 10;
        $page['offset'] = $request->offset;

        $response = [
            'results' => [
                'jobs' => $job_response,
                'companies' => [],
                'groups' => []
            ],
            'num_found' => $jobs->toArray()['total'],
            'facets' => [],
            'request_params' => $request->all(),
            'pagination' => $page
        ];
        return response()->json($response, 200);
    }

    public function getCompanySearchList(Request $request)
    {
        $companies = $this->search->getCompanies($request->all());

        $fractal = new Manager();
        $fractal->setSerializer(new ArraySerializer());
        $company_response = $fractal->createData(new Collection($companies, new CompanyTransformer()))->toArray();
        
        $page['more_present'] = ($companies->toArray()["next_page_url"]) ? true : false;
        $page['limit'] = 10;
        $page['offset'] = $request->offset;

        $response = [
            'results' => [
                'jobs' => [],
                'companies' => $company_response,
                'groups' => []
            ],
            'num_found' => $companies->toArray()['total'],
            'facets' => [],
            'request_params' => $request->all(),
            'pagination' => $page
        ];
        return response()->json($response, 200);
    }
}
