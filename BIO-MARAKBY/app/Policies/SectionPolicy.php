<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Section;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any sections.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'teacher' || !is_null($user->course_id);
    }

    /**
     * Determine if the user can view a specific section.
     */
    public function view(User $user, Section $section): bool
    {
        return $user->role === 'teacher'
            || ($user->course_id === $section->lecture->course_id && $section->lecture->is_published);
    }

    /**
     * Determine if the user can create sections.
     */
    public function create(User $user): bool
    {
        return $user->role === 'teacher';
    }

    /**
     * Determine if the user can update a section.
     */
    public function update(User $user, Section $section): bool
    {
        return $user->role === 'teacher'
            && $section->lecture->course->user_id === $user->id;
    }

    /**
     * Determine if the user can delete a section.
     */
    public function delete(User $user, Section $section): bool
    {
        return $user->role === 'teacher'
            && $section->lecture->course->user_id === $user->id;
    }
}
