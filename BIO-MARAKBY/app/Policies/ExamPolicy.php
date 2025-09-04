<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Exam;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExamPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role === 'teacher' || !is_null($user->course_id);
    }

    public function view(User $user, Exam $exam): bool
    {
        return $user->role === 'teacher' || ($user->course_id === $exam->course_id && $exam->is_published);
    }

    public function create(User $user): bool
    {
        return $user->role === 'teacher';
    }

    public function viewResults(User $user, Exam $exam)
    {
        return $user->role === 'teacher';
    }

    public function take(User $user, Exam $exam)
    {
        return $user->role === 'student'; // أو أي شرط تاني منطقي
    }

    public function update(User $user, Exam $exam): bool
    {
        return $user->role === 'teacher';
    }

    public function delete(User $user, Exam $exam): bool
    {
        return $user->role === 'teacher';
    }
}
