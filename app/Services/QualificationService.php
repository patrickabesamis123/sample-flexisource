<?php

namespace App\Services;

use App\Models\Qualification;

class QualificationService
{
    /**
     * Get id via display_name or create new when qualification doesn't exist 
     *
     * @return string
     */
    public function getOrSetIdFromName($displayName)
    {
        $query = Qualification::select('id')
                    ->where('display_name', $displayName)
                    ->first();

        if(empty($query)) {
            $save = new Qualification;

            $save->is_admin_approved = 0;
            $save->recorded_date = date('Y-m-d H:i:s');
            $save->display_name = $displayName;
            $save->slug_name = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower(trim($displayName)));
            $save->parent_id = 0;

            $save->save();

            $query = $save;
        }

        return $query['id'];
    }
}