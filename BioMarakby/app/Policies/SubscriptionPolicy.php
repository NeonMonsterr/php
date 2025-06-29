<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubscriptionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role === 'teacher';
    }

    public function view(User $user, ?Subscription $subscription): bool
    {
        if ($subscription === null) {
            return $user->role === 'teacher';
        }
        return $user->role === 'teacher' || $user->id === $subscription->user_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'teacher';
    }

    public function update(User $user): bool
    {
        return $user->role === 'teacher';
    }

    public function delete(User $user, Subscription $subscription): bool
    {
        return $user->role === 'teacher';
    }
}
