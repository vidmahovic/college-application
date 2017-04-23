<?php

namespace CollegeApplication\Search\FacultyProgramSearch\Filters;
use CollegeApplication\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class AllowDoubleDegree
 *
 * @package \CollegeApplication\Search\FacultyProgramSearch\Filters
 */
class DoubleDegree implements Filter
{

    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->where('allow_double_degree', (bool) $value);
    }
}
