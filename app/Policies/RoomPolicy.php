<?php

namespace App\Policies;

use App\Models\User;

class RoomPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function create(User $user){
        $roles = $user->roles->pluck('name')->toArray();
        return in_array('Admin', $roles);
    }
}
