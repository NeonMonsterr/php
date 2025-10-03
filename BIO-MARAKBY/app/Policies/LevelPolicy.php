<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Level;


class LevelPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user):bool
    {
        return $user->role==="teacher";
    }

    public function view(User $user ,Level $level ):bool
    {
        return $user->role==="teacher" || $user->level_id===$level->id;
    }

    public function create(User $user):bool
    {
        return $user->role==="teacher";
    }

        public function update(User $user):bool
    {
        return $user->role==="teacher";
    }

        public function delete(User $user):bool
    {
        return $user->role==="teacher";
    }

}
