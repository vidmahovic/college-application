<?php

namespace CollegeApplication\Search\FacultyProgramSearch\Filters;
use CollegeApplication\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Name
 *
 * @package \CollegeApplication\Search\FacultyProgramSearch\Filters
 */
class Name implements Filter
{

    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->where('name', 'like', '%'.$value.'%');
    }
}
