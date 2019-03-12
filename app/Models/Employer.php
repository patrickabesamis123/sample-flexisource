<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    const CREATED_AT = 'recorded_date';
    
    protected $table = 'e_employer';
    protected $fillables = ['user_id', 'company_id', 'nickname', 'phone_number', 'mobile_number', 'work_title', 'work_dept', 'profile_picture_url',
                            'recorded_date', 'phone_extension', 'account_type_id'];

    public function accountType()
    {
        return $this->hasOne('App\Models\AccountType', 'id', 'account_type_id');
    }

    public function company()
    {
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\PmUser', 'id', 'user_id');
    }

    public function permissions()
    {
        return $this->hasMany('App\Models\EmployerPermission', 'employer_id', 'id');
    }

    public function teams()
    {
        return $this->hasMany('App\Models\TeamMember', 'employer_id', 'id');
    }

}
