
<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;


use Illuminate\Http\Request;

Route::delete('/question-images/{image}', function (App\Models\QuestionImage $image) {
    Storage::delete('public/' . $image->image_path);
    $image->delete();
    return response()->json(['success' => true]);
})->middleware('auth')->name('question-images.destroy');
// routes/web.php
Route::middleware(['auth'])->group(function () {
    Route::get('/exams/{exam}/start', [QuestionController::class, 'start'])->name('exams.exam');
    Route::post('/exams/{exam}/save-progress', [QuestionController::class, 'saveProgress'])->name('exams.save_progress');
    Route::post('/exams/{exam}/submit', [QuestionController::class, 'submit'])->name('exams.submit');
    Route::get('/exams/{exam}/result', [QuestionController::class, 'results'])->name('exams.results');
    Route::get('/exams/{exam}/student/{student}/grade-essay', [QuestionController::class, 'gradeEssayAnswers'])->name('exams.grade_essay');
    Route::post('/exams/{exam}/student/{student}/grade-essay', [QuestionController::class, 'storeEssayGrades'])->name('exams.grade_essay.save');
});


Route::get('/exams/{exam}/questions/edit', [QuestionController::class, 'edit'])->name('exams.questions.edit');
Route::put('/exams/{exam}/questions', [QuestionController::class, 'update'])->name('exams.questions.update');
Route::get('/exams/{exam}/allresult', [ExamController::class, 'allresult'])->name('exams.allresult');



Route::get('/exams/partials/question-block', function (Request $request) {
    $index = $request->query('index', 0);
    return view('exams.partials.question-block', ['index' => $index]);
})->name('exams.partials.question-block');


Route::get('/exams/questions/{exam}/create', [ExamController::class, 'createQuestion'])->name('exams.questions.create');
Route::post('/exams/questions/{exam}', [ExamController::class, 'storeQuestion'])->name('exams.questions.store');


Route::post('/exams/{exam}/questions-batch', [QuestionController::class, 'storeBatch'])->name('exams.questions.storeBatch');






Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
// Welcome route
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');
Route::view('/contact', 'contact')->name('contact');

//register routes
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

// مسارات الأسئلة

Route::get('/files', [FileController::class, 'listFiles'])->name('files.list');
Route::post('/upload-file', [FileController::class, 'upload'])->name('file.upload');

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
    Route::get('/courses/{course}/lectures/create', [LectureController::class, 'create'])->name('lectures.create');
    Route::post('/courses/{course}/lectures', [LectureController::class, 'store'])->name('lectures.store');
    Route::get('/courses/{course}/lectures/{lecture}', [LectureController::class, 'show'])->name('lectures.show');
    Route::get('/courses/{course}/lectures/{lecture}/edit', [LectureController::class, 'edit'])->name('lectures.edit');
    Route::put('/courses/{course}/lectures/{lecture}', [LectureController::class, 'update'])->name('lectures.update');
    Route::delete('/courses/{course}/lectures/{lecture}', [LectureController::class, 'destroy'])->name('lectures.destroy');

    // Section routes
    Route::get('/courses/{course}/lectures/{lecture}/sections/create', [\App\Http\Controllers\SectionController::class, 'create'])->name('sections.create');
    Route::post('/courses/{course}/lectures/{lecture}/sections', [\App\Http\Controllers\SectionController::class, 'store'])->name('sections.store');
    Route::get('/courses/{course}/lectures/{lecture}/sections/{section}', [\App\Http\Controllers\SectionController::class, 'show'])->name('sections.show');
    Route::get('/courses/{course}/lectures/{lecture}/sections/{section}/edit', [\App\Http\Controllers\SectionController::class, 'edit'])->name('sections.edit');
    Route::put('/courses/{course}/lectures/{lecture}/sections/{section}', [\App\Http\Controllers\SectionController::class, 'update'])->name('sections.update');
    Route::delete('/courses/{course}/lectures/{lecture}/sections/{section}', [\App\Http\Controllers\SectionController::class, 'destroy'])->name('sections.destroy');
    Route::get('/sections/{section}/download', [SectionController::class, 'download'])
    ->name('sections.download')->middleware('auth');
    // Exam routes
    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');
    Route::get('/exams/create', [ExamController::class, 'create'])->name('exams.create');
    Route::post('/exams', [ExamController::class, 'store'])->name('exams.store');
    Route::get('/exams/{exam}', [ExamController::class, 'show'])->name('exams.show');
    Route::get('/exams/{exam}/edit', [ExamController::class, 'edit'])->name('exams.edit');
    Route::put('/exams/{exam}', [ExamController::class, 'update'])->name('exams.update');
    Route::delete('/exams/{exam}', [ExamController::class, 'destroy'])->name('exams.destroy');
});
