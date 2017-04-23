<?php

namespace CollegeApplication\Search;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class Search
{

    public function applyFiltersFromRequest(Request $request): Builder
    {
        $query = $this->getModelInstance()->newQuery();

        if ($request->has('filters')) {

            foreach ($request->get('filters') as $filter_name => $filter_val) {

                $filter_class = ucfirst(camel_case($filter_name));
                $decorator = $this->getFiltersNamespace() . $filter_class;

                if (class_exists($decorator))
                    $query = $decorator::apply($query, $filter_val);

            }

        }

        return $query;
    }

    protected abstract function getModelInstance(): Model;

    protected abstract function getFiltersNamespace(): string;
}