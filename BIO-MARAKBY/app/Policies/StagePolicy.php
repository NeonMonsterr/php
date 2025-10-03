<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Stage;

class StagePolicy
{
    public function viewAny(User $user):bool
    {
        return $user->role==="teacher";
    }
    public function view(User $user,Stage $stage):bool
    {
        return $user->role==="teacher" || $user->stage_id===$stage->id;

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
