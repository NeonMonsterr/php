<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Exam;
use App\Models\Lecture;
use App\Models\Subscription;
use App\Models\User;
use App\Policies\CoursePolicy;
use App\Policies\ExamPolicy;
use App\Policies\LecturePolicy;
use App\Policies\SubscriptionPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Course::class => CoursePolicy::class,
        Subscription::class=>SubscriptionPolicy::class,
        Lecture::class=>LecturePolicy::class,
        Exam::class=>ExamPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
