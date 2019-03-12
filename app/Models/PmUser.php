<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PmUser extends Model
{
    const DISABLED = 0;

    protected $table = 'pm_user';
    protected $fillable = ['username', 'username_canonical', 'email', 'email_canonical', 'enabled', 'salt', 'password',
                           'last_login', 'confirmation_token', 'password_requested_at', 'roles', 'first_name', 'last_name',
                           'user_type', 'ob_key', 'aa_token'];
    public $timestamps = false;

    public function employer()
    {
        return $this->hasOne('App\Models\Employer', 'user_id');
    }

    public function candidate()
    {
        return $this->hasOne('App\Models\Candidate', 'user_id');
    }
}
