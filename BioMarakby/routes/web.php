
<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
// Welcome route
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::view('/contact', 'contact')->name('contact');

// Authentication routes
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/teacher', [UserController::class, 'teacherDashboard'])->name('dashboard.teacher');

    // User routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/enroll', [UserController::class, 'enrollForm'])->name('users.enroll.form');
    Route::post('/users/enroll', [UserController::class, 'enroll'])->name('users.enroll');
    Route::get('/users/subscription', [UserController::class, 'subscriptionForm'])->name('users.subscription.form');
    Route::post('/users/subscription', [UserController::class, 'updateSubscription'])->name('users.subscription');
    Route::get('/users/teacher', [UserController::class, 'search'])->name('students.search');

    // Course routes
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');

    // Lecture routes
    Route::get('/lectures', [LectureController::class, 'index'])->name('lectures.index');
    Route::get('/lectures/create', [LectureController::class, 'create'])->name('lectures.create');
    Route::post('/lectures', [LectureController::class, 'store'])->name('lectures.store');
    Route::get('/lectures/{lecture}', [LectureController::class, 'show'])->name('lectures.show');
    Route::get('/courses/{course}/lectures/{lecture}/edit', [LectureController::class, 'edit'])->name('lectures.edit');
    Route::put('/lectures/{lecture}', [LectureController::class, 'update'])->name('lectures.update');
    Route::delete('/lectures/{lecture}', [LectureController::class, 'destroy'])->name('lectures.destroy');

    // Exam routes
    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');
    Route::get('/exams/create', [ExamController::class, 'create'])->name('exams.create');
    Route::post('/exams', [ExamController::class, 'store'])->name('exams.store');
    Route::get('/exams/{exam}', [ExamController::class, 'show'])->name('exams.show');
    Route::get('/exams/{exam}/edit', [ExamController::class, 'edit'])->name('exams.edit');
    Route::put('/exams/{exam}', [ExamController::class, 'update'])->name('exams.update');
    Route::delete('/exams/{exam}', [ExamController::class, 'destroy'])->name('exams.destroy');
});

