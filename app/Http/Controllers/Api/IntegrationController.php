<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Contracts\IntegrationInterface;

class IntegrationController extends Controller
{
    private $integrationRepo;

    public function __construct(IntegrationInterface $integrationRepo)
    {   
        $this->integrationRepo = $integrationRepo;
    }

    /**
     * Gets the Javascript Integration Configurations
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getJsIntegrationConfig(Request $request)
    {
        return $this->integrationRepo->getJsIntegrationConfig($request);
    }

    /**
     * Store Javascript Integration Configurations
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeJsIntegrationConfig(Request $request)
    {
        return $this->integrationRepo->storeJsIntegrationConfig($request);
    }
}
