<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\IntegrationInterface;
use App\Models\Integration;

/**
 * Class IntegrationRepository.
 *
 * @package namespace App\Repositories;
 */
class IntegrationRepository extends BaseRepository implements IntegrationInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Integration::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get Javascript Integration Config
     *
     * @param [object] $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getJsIntegrationConfig($request)
    {
        $integration_config = Integration::where('company_id', $request->company_id)
                                ->select('config')
                                ->get();
        return $integration_config;
    }

    /**
     * Store Javascript Integration Config
     *
     * @param [object] $request
     * @return void
     */
    public function storeJsIntegrationConfig($request)
    {
        $integration = Integration::where('company_id', $request->company_id)->first();
        $integration->config = $request->config;
        if (!$integration->save()) return $this->response(false, 'Cannot process javascript integration request', 400);
        return $this->response(true, 'Javascript integration config was successfully updated', 200);
    }

    /**
     * Return Formatted JSON Response
     *
     * @param [Boolean] $success
     * @param [String] $message
     * @param [Integer] $status
     * @return \Illuminate\Http\JsonResponse
     */
    private function response($success, $message, $status)
    {
        return response()->json(['success' => $success, 'message' => $message], $status);
    }

}
