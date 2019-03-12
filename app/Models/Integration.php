<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Integration extends Model 
{   
    protected $table = 'c_integration';
    protected $guarded = [];

    public function company()
    {
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }

    public function employer()
    {
        return $this->hasOne('App\Models\Employer', 'id', 'requested_by_id');
    }
}
