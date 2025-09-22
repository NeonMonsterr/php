<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Lecture;
use Illuminate\Auth\Access\HandlesAuthorization;

class LecturePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any lectures.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'teacher' || !is_null($user->course_id);
    }

    /**
     * Determine if the user can view a specific lecture.
     */
    public function view(User $user, Lecture $lecture): bool
    {
        return $user->role === 'teacher' || ($user->course_id === $lecture->course_id && $lecture->is_published);
    }

    /**
     * Determine if the user can create lectures.
     */
    public function create(User $user): bool
    {
        return $user->role === 'teacher';
    }

    /**
     * Determine if the user can update a lecture.
     */
    public function update(User $user, Lecture $lecture): bool
    {
        return $user->role === 'teacher' && $lecture->course->user_id === $user->id;
    }

    /**
     * Determine if the user can delete a lecture.
     */
    public function delete(User $user, Lecture $lecture): bool
    {
        return $user->role === 'teacher' && $lecture->course->user_id === $user->id;
    }
}
