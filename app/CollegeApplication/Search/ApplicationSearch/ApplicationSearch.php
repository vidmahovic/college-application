<?php

namespace CollegeApplication\Search\ApplicationSearch;

use App\Models\Application;
use CollegeApplication\Search\Search;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ApplicantSearch
 *
 * @package \CollegeApplication\Search\ApplicantSearch
 */
class ApplicationSearch extends Search
{

    protected function getModelInstance(): Model
    {
        return new Application;
    }

    protected function getFiltersNamespace(): string
    {
        return __NAMESPACE__ . '\\Filters\\';
    }
}
