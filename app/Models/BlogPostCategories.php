<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPostCategories extends Model
{
    protected $table = 'blogpost_categories';
    protected $guarded = [];

    public function blogs()
    {
        return $this->hasMany('App\Models\BlogPost', 'ID', 'BlogPostID');
    }

    public function category()
    {
        return $this->hasOne('App\Models\BlogPostCategory', 'ID', 'BlogPostCategoryID');
    }
}
