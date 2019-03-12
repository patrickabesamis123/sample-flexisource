<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * Location Types
     */
    const STATE = 'state';
    const LOCATION = 'location';
    const AREA = 'area';
    const SUBURB = 'suburb';
    const USER_INPUT = 'user_input';

    protected $table = 'location';

    public function country()
    {
        return $this->hasMany('App\Models\Country', 'id', 'country_id');
    }

}
