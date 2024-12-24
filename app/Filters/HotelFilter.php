<?php

namespace App\Filters;

class HotelFilter extends QueryFilter
{
    public function city($name){
        $this->builder->where('city', $name);
    }

    public function name($name){
        $this->builder->where('name',"like", "%".$name."%");
    }
}
