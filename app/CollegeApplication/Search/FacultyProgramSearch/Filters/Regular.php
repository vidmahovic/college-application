<?php

namespace CollegeApplication\Search\FacultyProgramSearch\Filters;

use CollegeApplication\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Regular
 *
 * @package \CollegeApplication\Search\FacultyProgramSearch\Filters
 */
class Regular implements Filter
{

    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->where('is_regular', (bool) $value);
    }
}
