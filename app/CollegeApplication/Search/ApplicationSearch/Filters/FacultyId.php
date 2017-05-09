<?php

namespace CollegeApplication\Search\ApplicationSearch\Filters;
use CollegeApplication\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FacultyId
 *
 * @package \CollegeApplication\Search\ApplicationSearch\Filters
 */
class FacultyId implements Filter
{

    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->whereHas('wishes', function($q) use($value) {
            return $q->where('faculty_id', $value);
        });
    }
}
