<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyFollower extends Model
{
    protected $table = 'e_company_followers';
    protected $fillable = ['company_id', 'candidate_id'];
    
    const CREATED_AT = 'recorded_date';
}
