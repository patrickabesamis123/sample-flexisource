<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamsMembers extends Model
{
    protected $table = 'e_teams_members';
    protected $fillable = ['team_id', 'team_role', 'recorded_date', 'employer_id'];
    public $timestamps = false;

    public function employer()
    {
        return $this->hasMany('App\Models\Employer', 'employer_id');
    }

}
