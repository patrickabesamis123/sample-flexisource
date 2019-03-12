<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteTree extends Model
{
    protected $table = 'sitetree';
    protected $guarded = [];

    public function blog()
    {
        return $this->hasOne('App\Models\BlogPost', 'ID', 'ID');
    }
}
