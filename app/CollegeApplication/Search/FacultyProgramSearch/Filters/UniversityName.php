<?php

namespace CollegeApplication\Search\FacultyProgramSearch\Filters;

use CollegeApplication\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class UniversityName
 *
 * @package \CollegeApplication\Search\FacultyProgramSearch\Filters
 */
class UniversityName implements Filter
{

    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->whereHas('faculty.university', function($q) use($value) {
           $q->where('universities.name', 'like', '%'.$value.'%');
        });
    }
}
