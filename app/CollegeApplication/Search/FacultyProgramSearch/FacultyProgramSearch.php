<?php

namespace CollegeApplication\Search\FacultyProgramSearch;

use App\Models\FacultyProgram;
use CollegeApplication\Search\Search;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FacultyProgramSearch
 *
 * @package \CollegeApplication\Search\FacultyProgramSearch
 */
class FacultyProgramSearch extends Search
{

    protected function getModelInstance(): Model
    {
        return new FacultyProgram;
    }

    protected function getFiltersNamespace(): string
    {
        return __NAMESPACE__ . '\\Filters\\';
    }
}
