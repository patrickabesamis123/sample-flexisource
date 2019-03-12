<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobLog extends Model
{
    const POSTED = 'P';
    
    protected $fillabe = ['job_id'];
}
