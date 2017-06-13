<?php

namespace CollegeApplication\Search\ApplicationSearch\Filters;
use CollegeApplication\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class AcceptedFaculty
 *
 * @package \CollegeApplication\Search\ApplicationSearch\Filters
 */
class AcceptedFaculty implements Filter
{

    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->whereHas('acceptedWish', function($q) use($value) {
            return $q->where('faculty_programs.faculty_id', $value);
        });
    }
}
