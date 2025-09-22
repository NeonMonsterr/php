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
        // Teachers can see all, students only see their enrolled course
        return true;
    }

    /**
     * Determine if the user can view a specific course.
     */
    public function view(User $user, Course $course): bool
    {
        if ($user->role === 'teacher') {
            return true; // Teachers can view all courses
        }

        if ($user->role === 'student') {
            // Students can view only the course they are enrolled in
            return $user->enrolledCourse && $user->enrolledCourse->id === $course->id;
        }

        return false;
    }

    /**
     * Determine if the user can create courses.
     */
    public function create(User $user): bool
    {
        return $user->role === 'teacher';
    }

    /**
     * Determine if the user can update a course.
     */
    public function update(User $user, Course $course): bool
    {
        return $user->role === 'teacher' && $course->user_id === $user->id;
    }

    /**
     * Determine if the user can delete a course.
     */
    public function delete(User $user, Course $course): bool
    {
        return $user->role === 'teacher' && $course->user_id === $user->id;
    }
}
