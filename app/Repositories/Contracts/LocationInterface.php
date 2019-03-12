<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface as PrettusInterface;

/**
 * Interface LocationInterface.
 *
 * @package namespace App\Repositories;
 */
interface LocationInterface extends PrettusInterface
{
    public function fetchLocationForSearchDisplay();
    public function searchForAutoComplete($data, $countryId);
    public function searchForAutoCompleteSearch($data);
    public function searchForLocationByCountry($slug_code);
}
