<?php

namespace App\Services;

use App\Models\QualificationProvider;

class QualificationProviderService
{
    /**
     * Get id via display_name or create new when qualification doesn't exist 
     *
     * @return string
     */
    public function getOrSetIdFromName($displayName)
    {
        $query = QualificationProvider::select('id')
                    ->where('provider_display_name', $displayName)
                    ->first();

        if(!isset($query['id'])) {
            $save = new QualificationProvider;

            $save->provider_display_name = $displayName;
            $save->provider_slug_name = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(trim($displayName)));
            $save->isAdminApproved = 0;
            $save->dateApproved = null;
            $save->recorded_date = date('Y-m-d H:i:s');
            $save->company_logo = null;

            $save->save();

            $query = $save;
        }

        return $query['id'];
    }

    /**
     * Get qualification logo
     *
     * @return string
     */
    public function getLogo($displayName)
    {
        $query = QualificationProvider::select('company_logo')
                    ->where('provider_display_name', $displayName)
                    ->first();

        $logo = null;
        if(isset($query['company_logo'])) {
            $logo = $query['company_logo'];
        }

        return $logo;
    }

}