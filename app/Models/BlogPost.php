<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $table = 'blogpost';
    protected $guarded = [];

    public function file()
    {
        return $this->hasOne('App\Models\File', 'ID', 'FeaturedImageID');
    }

    public function detail()
    {
        return $this->hasOne('App\Models\SiteTree', 'ID', 'ID');
    }

    public function categories()
    {
        return $this->hasMany('App\Models\BlogPostCategories', 'BlogPostID', 'ID');
    }
}
