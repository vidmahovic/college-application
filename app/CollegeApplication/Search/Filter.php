<?php

namespace CollegeApplication\Search;

use Illuminate\Database\Eloquent\Builder;

interface Filter
{
    public static function apply(Builder $builder, $value): Builder;
}
