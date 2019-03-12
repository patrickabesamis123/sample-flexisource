<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\IndustryInterface;
use App\Models\Industry;
use App\Validators\IndustryValidator;

/**
 * Class IndustryRepository.
 *
 * @package namespace App\Repositories;
 */
class IndustryRepository extends BaseRepository implements IndustryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Industry::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Fetches industry with its sub industry
     *
     * @return void
     */
    public function fetchIndustriesAndSubIndustries()
    {
        $allIndustries = $this->all();

        $industries = collect($allIndustries->filter(function ($industry) {
            return $industry->type === Industry::INDUSTRY;
        })->values()->all());

        $subIndustries = collect($allIndustries->diffAssoc($industries)->values()->all());

        foreach ($industries as $index => $industry) {
            $specificSubIndustry = $subIndustries->filter(function ($subIndustry) use ($industry) {
                return $subIndustry->parent_id === $industry->id;
            })->values()->all();
            $subIndustries = collect($subIndustries->diffAssoc($specificSubIndustry)->values()->all());
            $industries[$index]["sub"] = $specificSubIndustry;
        }

        return $industries->toArray();
    }

    /**
     * Display all parent industry
     *
     * @return string
     */
    public function listParent()
    {
        $query = Industry::select('id', 
                                  'display_name')
        				->where('parent_id', 0)
                        ->get();

        return $query;
    }

    /**
     * Display all parent industry with child
     *
     * @return string
     */
    public function listParentAndSub()
    {
        $parent = Industry::select('id', 
                                  'display_name')
                        ->where('parent_id', 0)
                        ->get();

        $industry = array();
        $ctr=0;
        foreach ($parent as $key => $value) {
            $industry[$ctr]['id'] = $value['id'];
            $industry[$ctr]['display_name'] = $value['display_name'];
            $industry[$ctr]['sub'] = Industry::select('id', 
                                                      'display_name')
                                               ->where('parent_id', $value['id'])
                                               ->get();
            $ctr++;
        }

        return $industry;
    }
}
