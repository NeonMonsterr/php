<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the user can view any courses.
     */
    public function viewAny(User $user): bool
    {
        return true; // Both teachers and students can view courses (students see only their course)
    }

    /**
     * Determine if the user can view a specific course.
     */
    public function view(User $user, Course $course): bool
    {
        return $user->role === 'teacher' || $user->course_id === $course->id;
    }

    /**
     * Determine if the user can create courses.
     */
    public function create(User $user): bool
    {
        return $user->role === 'teacher';
    }

    /**
     * Determine if the user can delete a course.
     */
    public function delete(User $user, Course $course): bool
    {
        return $user->role === 'teacher';
    }

    public function update(User $user, Course $course): bool
    {
        return $user->role === 'teacher' ;
    }
}
