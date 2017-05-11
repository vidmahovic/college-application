<?php

namespace CollegeApplication\Search\FacultyProgramSearch\Filters;

use CollegeApplication\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class MinPoints
 *
 * @package \CollegeApplication\Search\FacultyProgramSearch\Filters
 */
class MinPoints implements Filter
{

    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->where('min_points', '>=', $value);
    }
}
