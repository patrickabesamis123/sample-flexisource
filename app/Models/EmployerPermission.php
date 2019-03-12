<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerPermission extends Model
{
    protected $table = 'e_employer_permissions';
    protected $guarded = [];

    public function permission()
    {
        return $this->hasOne('App\Models\Permission', 'id', 'permission_id');
    }
    
}
