<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlacklistedCompany extends Model
{
    protected $table = 'blacklisted_companies';

    protected $fillable = ['candidate_id', 'enabled'];

    const CREATED_AT = 'recorded_date';
    const UPDATED_AT = 'updated_date';

    /**
     * Get the eloquent relationship with Company
     *
     * @return void
     */
    public function companies()
    {
        return $this->belongsTo('App\Models\Company', 'company_id');
    }

    /**
     * Get the eloquent relationship with Candidate
     *
     * @return void
     */
    public function candidates()
    {
        return $this->belongsTo('App\Models\Candidate', 'candidate_id');
    }
}
