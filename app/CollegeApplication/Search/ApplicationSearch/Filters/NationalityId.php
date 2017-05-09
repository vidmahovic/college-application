<?php

namespace CollegeApplication\Search\ApplicationSearch\Filters;
use CollegeApplication\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Nationality
 *
 * @package \CollegeApplication\Search\ApplicationSearch\Filters
 */
class NationalityId implements Filter
{

    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->where('citizen_id', $value);
    }
}
