<?php

namespace CollegeApplication\Entities;

trait FiltersEntities
{

    public function scopeFilter($query, $filter, $value, $relation = '=') {
        return $query->where($filter, $relation, $value);
    }

//    public function __get($name)
//    {
//        if(strpos($name, 'filterBy') !== false) {
//
//            $filter = snake_case(substr($name, 8));
//
//            if(property_exists($this, 'filters')) {
//                if(in_array($filter, $this::$filters)) {
//                    $this->filter($name, $value);
//                }
//            }
//        }

 //   }
}
