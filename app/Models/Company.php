<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Company extends Model
{
    use Sluggable;

    const ACTIVE = 'active';
    const CREATED_AT = 'recorded_date';

    protected $table = 'e_company';
    protected $fillable = ['industry_id', 'company_name', 'num_of_employees', 'website_url', 'company_phone',
                            'company_fax', 'ob_key', 'street_address', 'street_address_2', 'location_id',
                            'company_url', 'company_description', 'status'];
    
    /**
     * Returns the sluggable configuration array for this model.
     *
     * @return void
     */
    public function sluggable()
    {
        return [
            'company_url' => [
                'source' => 'company_name'
            ]
        ];
    }

    public function jobs()
    {
        return $this->hasMany('App\Models\Job', 'company_id', 'id')
                    ->where('j_job.job_status', '=', 'active');
    }

    public function location()
    {
        return $this->hasOne('App\Models\Location', 'id', 'location_id');
    }

    public function industry()
    {
        return $this->hasOne('App\Models\Industry', 'id', 'industry_id');
    }

    public function docs()
    {
        return $this->belongsTo('App\Models\EmployerDoc', 'id', 'employer_id');
    }

    public function doc_video()
    {
        return $this->belongsTo('App\Models\EmployerDoc', 'id', 'employer_id')->where('doc_file_type', 'mp4');
    }

    public function followers()
    {
        return $this->hasMany('App\Models\CompanyFollower', 'company_id', 'id');
    }

    public function employers()
    {
        return $this->hasMany('App\Models\Employer', 'company_id', 'id');
    }

    public function teams()
    {
        return $this->hasMany('App\Models\Team', 'company_id', 'id');
    }

    public  function scopeLikeCompanyName($query, $value){
        return $query->where('company_name', 'LIKE', "%$value%");
    }
}
