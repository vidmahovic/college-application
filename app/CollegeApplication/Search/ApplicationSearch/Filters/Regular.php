<?php

namespace CollegeApplication\Search\ApplicationSearch\Filters;
use CollegeApplication\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Regular
 *
 * @package \CollegeApplication\Search\ApplicationSearch\Filters
 */
class Regular implements Filter
{

    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->whereHas('wishes', function($q) use($value) {
            return $q->where('is_regular', $value);
        });
    }
}
