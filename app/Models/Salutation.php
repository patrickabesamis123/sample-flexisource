<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salutation extends Model
{
    protected $fillable = [
        'name', 'message'
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
