<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Exam;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Services\UserServices;

class UserController extends Controller
{
    use AuthorizesRequests;
    protected $userService;

    public function __construct(UserServices $userService)
    {
        $this->middleware('auth')->except(['showLoginForm', 'login']);
        $this->userService = $userService;
    }

    public function dashboard()
    {
        $user = Auth::user();
        $subscription = $user->subscription()->with('course')->first();

        if ($subscription) {
            $subscription->updateStatusBasedOnDates();
        }
        $enrolledCourse = $user->enrolledCourse;

        // Get top users from the service
        $topUsers = $this->userService->HonorDashboard();

        if ($user->role === 'teacher') {
            $students = User::students()->with('enrolledCourse')->get();
            $statistics = [
                'students' => User::where('role', 'student')->count(),
                'courses' => Course::where('user_id', $user->id)->count(),
                'lectures' => Lecture::whereIn('course_id', Course::where('user_id', $user->id)->pluck('id'))->count(),
                'exams' => Exam::count(),
            ];

            return view('dashboard.student', [
                'user' => $user,
                'subscription' => $subscription,
                'enrolledCourse' => $enrolledCourse,
                'stage' => $enrolledCourse?->stage,
                'level' => $enrolledCourse?->level,
                'topUsers' => $topUsers, // Pass top users
            ]);
        }

        return view('dashboard.student', compact('user', 'subscription', 'enrolledCourse', 'topUsers'));
    }


    public function teacherDashboard(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'teacher') {
            abort(403, 'غير مصرح لك بالوصول إلى لوحة تحكم المعلم');
        }

        $statistics = [
            'students' => User::where('role', 'student')->count(),
            'courses' => Course::where('user_id', $user->id)->count(),
            'lectures' => Lecture::whereIn('course_id', Course::where('user_id', $user->id)->pluck('id'))->count(),
            'exams' => Exam::count(),
        ];

        // Get top users
        $topUsers = $this->userService->HonorDashboard();

        return view('dashboard.teacher', compact('user', 'statistics', 'topUsers'));
    }


    public function index()
    {
        $this->authorize('viewAny', User::class);

        $students = User::students()->with('enrolledCourse', 'subscription.course')->get();
        // Update subscription statuses for all students
        foreach ($students as $student) {
            if ($student->subscription) {
                $student->subscription->updateStatusBasedOnDates();
            }
        }
        return view('users.index', compact('students'));
    }

    public function create()
    {
        $this->authorize('create', User::class);

        $courses = Course::published()->get();
        return view('users.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'course_id' => ['nullable', Rule::exists('courses', 'id')->where('is_published', true)],
            'phone_number' => ['required', 'regex:/^(010|011|012|015)[0-9]{8}$/'],
            'parent_phone_number' => ['required', 'regex:/^(010|011|012|015)[0-9]{8}$/'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
            'course_id' => $validated['course_id'],
            'phone_number' => $validated['phone_number'],
            'parent_phone_number' => $validated['parent_phone_number'],
        ]);

        if ($user->course_id) {
            $this->authorize('create', Subscription::class);
            $subscription = $user->subscription()->create([
                'course_id' => $user->course_id,
                'type' => 'monthly',
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addMonth(),
            ]);
            $subscription->updateStatusBasedOnDates();
        }

        return redirect()->route('users.index')->with('success', "Student {$user->name} created successfully!");
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        $subscription = $user->subscription()->with('course')->first();
        if ($subscription) {
            $subscription->updateStatusBasedOnDates();
        }
        $enrolledCourse = $user->enrolledCourse;
        return view('users.show', compact('user', 'subscription', 'enrolledCourse'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $courses = Course::where('is_published', true)->get();
        return view('users.edit', compact('user', 'courses'));
    }

    public function update(Request $request, User $user)
    {
        $course=Course::find($user->course_id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:student,teacher',
            'course_id' => 'nullable|exists:courses,id',
            'subscription_type' => 'nullable|in:monthly,yearly',
            'subscription_status' => 'nullable|in:active,expired,canceled',
            'subscription_course_id' => 'nullable|exists:courses,id',
            'subscription_start_date' => 'nullable|date',
            'subscription_end_date' => 'nullable|date|after_or_equal:subscription_start_date',
            'phone_number' => ['required', 'regex:/^(010|011|012|015)[0-9]{8}$/'],
            'parent_phone_number' => ['required', 'regex:/^(010|011|012|015)[0-9]{8}$/'],
        ]);

        // Update user details
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            'role' => $validated['role'],
            'course_id' => $validated['course_id'],
            'phone_number' => $validated['phone_number'],
            'parent_phone_number' => $validated['parent_phone_number'],
            'level' => $course ? $course->level : $user->level,
            'stage' => $course ? $course->stage : $user->stage,
        ]);

        // Update or create subscription for students
        if ($validated['role'] === 'student' && $validated['subscription_type'] && $validated['subscription_course_id']) {
            $subscriptionData = [
                'type' => $validated['subscription_type'],
                'course_id' => $validated['subscription_course_id'],
                'start_date' => $validated['subscription_start_date'] ? Carbon::parse($validated['subscription_start_date']) : now(),
                'end_date' => $validated['subscription_end_date'] ? Carbon::parse($validated['subscription_end_date']) : ($validated['subscription_type'] === 'monthly' ? now()->addMonth() : now()->addYear()),
                'status' => $validated['subscription_status'] ?? 'active',
            ];

            $subscription = $user->subscription()->updateOrCreate(
                ['user_id' => $user->id],
                $subscriptionData
            );
            $subscription->updateStatusBasedOnDates();
        } elseif ($user->subscription && $validated['role'] === 'teacher') {
            // Delete subscription if user is changed to teacher
            $user->subscription()->delete();
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        if ($user->role === 'teacher' && User::teachers()->count() === 1) {
            return redirect()->route('users.index')->with('error', 'Cannot delete the only teacher.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }

    public function enrollForm()
    {
        $this->authorize('enroll', User::class);

        $courses = Course::published()->get();
        return view('users.enroll', compact('courses'));
    }

    public function enroll(Request $request)
    {
        $user = Auth::user();
        $this->authorize('enroll', User::class);

        $validated = $request->validate([
            'course_id' => ['required', Rule::exists('courses', 'id')->where('is_published', true)],
        ]);

        if ($user->course_id) {
            return redirect()->route('dashboard')->with('error', 'You are already enrolled in a course.');
        }

        $user->update(['course_id' => $validated['course_id']]);

        $this->authorize('create', Subscription::class);
        $subscription = $user->subscription()->create([
            'course_id' => $validated['course_id'],
            'type' => 'monthly',
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
        ]);
        $subscription->updateStatusBasedOnDates();

        return redirect()->route('dashboard')->with('success', 'Successfully enrolled in course!');
    }

    public function subscriptionForm()
    {
        $user = Auth::user();
        $subscription = $user->subscription()->with('course')->first();
        $this->authorize('view', $subscription ?? Subscription::class);

        return view('users.subscription', compact('user', 'subscription'));
    }

    public function updateSubscription(Request $request)
    {
        $user = Auth::user();
        $subscription = $user->subscription()->first();
        $this->authorize('update', $subscription ?? Subscription::class);

        $validated = $request->validate([
            'type' => ['required', Rule::in(['monthly', 'yearly'])],
            'course_id' => ['required', Rule::in([$user->course_id])],
        ]);

        $endDate = $validated['type'] === 'monthly' ? now()->addMonth() : now()->addYear();

        if ($subscription) {
            $subscription->update([
                'type' => $validated['type'],
                'course_id' => $validated['course_id'],
                'status' => 'active',
                'start_date' => now(),
                'end_date' => $endDate,
            ]);
        } else {
            $this->authorize('create', Subscription::class);
            $subscription = $user->subscription()->create([
                'course_id' => $validated['course_id'],
                'type' => $validated['type'],
                'status' => 'active',
                'start_date' => now(),
                'end_date' => $endDate,
            ]);
        }

        $subscription->updateStatusBasedOnDates();

        return redirect()->route('dashboard')->with('success', 'Subscription updated successfully!');
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return $user->role === 'teacher'
                ? redirect()->route('dashboard.teacher')
                : redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Always remember the user (auto "remember me")
        if (Auth::attempt($credentials, true)) {
            $user = Auth::user();

            if ($user->role === 'student') {
                $subscription = $user->subscription()->first();
                if ($subscription) {
                    $subscription->updateStatusBasedOnDates();
                    if (!$subscription->active()->exists()) {
                        Auth::logout();
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();
                        return back()->withErrors([
                            'email' => 'الاشتراك منتهي أو ملغى أو غير موجود. يرجى تجديد الاشتراك لتسجيل الدخول.',
                        ])->onlyInput('email');
                    }
                } else {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();
                    return back()->withErrors([
                        'email' => 'الاشتراك غير موجود. يرجى الاشتراك في دورة لتسجيل الدخول.',
                    ])->onlyInput('email');
                }
            }

            $request->session()->regenerate();

            return $user->role === 'teacher'
                ? redirect()->route('dashboard.teacher')
                : redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('welcome');
    }

    public function search(Request $request)
    {
        $user = Auth::user();

        $query = User::where('role', 'student');

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $students = $query->with('enrolledCourse')->get();
        // Update subscription statuses for searched students
        foreach ($students as $student) {
            if ($student->subscription) {
                $student->subscription->updateStatusBasedOnDates();
            }
        }

        return view('users.index', compact('user', 'students'));
    }
}
