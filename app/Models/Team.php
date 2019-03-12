<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'e_teams';
    protected $guarded = [];
    public $timestamps = false;

    public function members()
    {
        return $this->hasMany('App\Models\TeamMember', 'team_id', 'id');
    }
}
