<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any users.
     */
    public function viewAny(User $user)
    {
        return $user->role === 'teacher';
    }

    /**
     * Determine if the user can view a specific user.
     */
    public function view(User $user, User $target)
    {
        return $user->id === $target->id || $user->role === 'teacher';
    }

    /**
     * Determine if the user can create users.
     */
    public function create(User $user)
    {
        return $user->role === 'teacher';
    }

    /**
     * Determine if the user can update a user.
     */
    public function update(User $user, User $target)
    {
        return $user->id === $target->id || $user->role === 'teacher';
    }

    /**
     * Determine if the user can delete a user.
     */
    public function delete(User $user, User $target)
    {
        return $user->role === 'teacher' && ($target->role !== 'teacher' || User::teachers()->count() > 1);
    }

    /**
     * Determine if the user can enroll in a course.
     */
    public function enroll(User $user)
    {
        return $user->role === 'student';
    }

    /**
     * Determine if the user can manage their subscription.
     */
    public function manageSubscription(User $user)
    {
        return $user->role === 'student';
    }
}
