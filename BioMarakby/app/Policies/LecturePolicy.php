<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Lecture;
use Illuminate\Auth\Access\HandlesAuthorization;

class LecturePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role === 'teacher' || !is_null($user->course_id);
    }

    public function view(User $user, Lecture $lecture): bool
    {
        return $user->role === 'teacher' || ($user->course_id === $lecture->course_id && $lecture->is_published);
    }

    public function create(User $user): bool
    {
        return $user->role === 'teacher';
    }

    public function update(User $user, Lecture $lecture): bool
    {
        return $user->role === 'teacher';
    }

    public function delete(User $user, Lecture $lecture): bool
    {
        return $user->role === 'teacher';
    }
}
