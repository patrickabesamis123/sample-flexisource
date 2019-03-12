<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Privacy.
 *
 * @package namespace App\Models;
 */
class Privacy extends Model implements Transformable
{
    use TransformableTrait;

    const PUBLIC_TYPE = 'public';
    const PRIVATE_TYPE = 'private';

    protected $table = 'privacy';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['candidate_id', 'settings', 'type'];

    const CREATED_AT = 'recorded_date';
    const UPDATED_AT = 'updated_date';

    /**
     * Get the privacy settings attribute
     * @link https://laravel.com/docs/5.7/eloquent-mutators#accessors-and-mutators
     * @param $value
     * @return void
     */
    public function getSettingsAttribute($value)
    {
        return json_decode($value);
    }
}
