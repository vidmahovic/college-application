<?php

namespace CollegeApplication\Search\ApplicationSearch\Filters;
use CollegeApplication\Search\Filter;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ProgramId
 *
 * @package \CollegeApplication\Search\ApplicationSearch\Filters
 */
class ProgramId implements Filter
{

    public static function apply(Builder $builder, $value): Builder
    {
        return $builder->whereHas('wishes', function($q) use($value) {
            return $q->where('faculty_programs.id', $value);
        });
    }
}
