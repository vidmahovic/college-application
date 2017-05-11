<?php

namespace CollegeApplication\Search;

use Illuminate\Http\Request;

trait Searchable
{
    public function search(Request $request)
    {
        return (new static::$search_class)->applyFiltersFromRequest($request);
    }
}
