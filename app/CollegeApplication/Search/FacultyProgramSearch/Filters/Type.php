<?php

namespace CollegeApplication\Search\FacultyProgramSearch\Filters;

use CollegeApplication\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Type
 *
 * @package \CollegeApplication\Search\FacultyProgramSearch\Filters
 */
class Type implements Filter
{

    public static function apply(Builder $builder, $value): Builder
    {
        if(is_array($value))
            return $builder->whereIn('type', $value);

        return $builder->where('type', $value);
    }
}
