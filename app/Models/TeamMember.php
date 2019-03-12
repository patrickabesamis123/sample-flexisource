<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $table = 'e_teams_members';
    protected $guarded = [];
    public $timestamps = false;

    public function employer()
    {
        return $this->hasOne('App\Models\Employer', 'id', 'employer_id');
    }

    public function team()
    {
        return $this->belongsTo('App\Models\Team', 'team_id', 'id');
    }
}
