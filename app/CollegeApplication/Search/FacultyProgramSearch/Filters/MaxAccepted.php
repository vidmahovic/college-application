<?php

namespace CollegeApplication\Search\FacultyProgramSearch\Filters;

use CollegeApplication\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class MaxAccepted
 *
 * @package \CollegeApplication\Search\FacultyProgramSearch\Filters
 */
class MaxAccepted implements Filter
{

    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->where('max_accepted', '<=', $value);
    }
}
