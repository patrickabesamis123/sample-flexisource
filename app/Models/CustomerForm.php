<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerForm extends Model
{   
    const CONTACT_US = 'contact_us';
    const HARMFUL_COMPLAINT = 'harmful_comm_complaint';

    protected $table = 'customer_form';
    protected $guarded = [];
    public $timestamps = false;
}
