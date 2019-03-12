<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobDefaultWorkflowStep extends Model
{
    const HIRED = 'hired';
    const REJECTED = 'rejected';

    protected $table = 'j_default_workflow_step';
}
