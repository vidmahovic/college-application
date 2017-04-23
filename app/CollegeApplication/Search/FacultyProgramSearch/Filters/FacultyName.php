<?php

namespace CollegeApplication\Search\FacultyProgramSearch\Filters;
use CollegeApplication\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FacultyName
 *
 * @package \CollegeApplication\Search\FacultyProgramSearch\Filters
 */
class FacultyName implements Filter
{

    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->whereHas('faculty', function($q) use ($value) {
           $q->where('name', 'like', '%'.$value.'%');
        });
    }
}
