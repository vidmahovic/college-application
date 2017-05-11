<?php

namespace CollegeApplication\Search\FacultyProgramSearch\Filters;

use CollegeApplication\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class UniversityDistrict
 *
 * @package \CollegeApplication\Search\FacultyProgramSearch\Filters
 */
class DistrictName implements Filter
{

    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->whereHas('faculty.district', function($q) use($value) {
            return $q->where('districts.name', 'like', '%'.$value.'%');
        });
    }
}
