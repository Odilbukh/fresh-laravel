<?php

namespace App\Filters;

use App\Filters\QueryFilter;

class UserFilter extends QueryFilter
{
    public function role($roleName) {

        $this->builder->whereHas('roles', function ($query) use ($roleName) {
            $query->where('name', $roleName);
        });
    }
}
