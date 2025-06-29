<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Exam;
use App\Models\Subscription;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth')->except(['showLoginForm', 'login']);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $subscription = $user->subscription()->with('course')->first();
        $enrolledCourse = $user->enrolledCourse;

        if ($user->role === 'teacher') {
            $students = User::students()->with('enrolledCourse')->get();
            $statistics = [
                'students' => User::where('role', 'student')->count(),
                'courses' => Course::where('user_id', $user->id)->count(),
                'lectures' => Lecture::whereIn('course_id', Course::where('user_id', $user->id)->pluck('id'))->count(),
                'exams' => Exam::count(),
            ];
            return view('dashboard.teacher', compact('user', 'students', 'subscription', 'statistics'));
        }

        return view('dashboard.student', compact('user', 'subscription', 'enrolledCourse'));
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

        return view('dashboard.teacher', compact('user', 'statistics'));
    }

    public function index()
    {
        $this->authorize('viewAny', User::class);

        $students = User::students()->with('enrolledCourse', 'subscription.course')->get();
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
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student',
            'course_id' => $validated['course_id'],
        ]);

        if ($user->course_id) {
            $this->authorize('create', Subscription::class);
            $user->subscription()->create([
                'course_id' => $user->course_id,
                'type' => 'monthly',
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addMonth(),
            ]);
        }

        return redirect()->route('users.index')->with('success', "Student {$user->name} created successfully!");
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        $subscription = $user->subscription()->with('course')->first();
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
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:student,teacher'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'subscription_type' => ['nullable', 'in:monthly,yearly'],
            'subscription_status' => ['nullable', 'in:active,inactive'],
            'subscription_start_date' => ['nullable', 'date'],
            'subscription_end_date' => ['nullable', 'date', 'after_or_equal:subscription_start_date'],
            'subscription_course_id' => ['nullable', 'exists:courses,id'],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
            'role' => $validated['role'],
            'course_id' => $validated['course_id'],
        ]);

        if ($user->role === 'student') {
            $this->authorize('update', $user->subscription ?? Subscription::class);
            if ($request->filled(['subscription_type', 'subscription_status', 'subscription_start_date', 'subscription_end_date'])) {
                if ($user->subscription) {
                    $user->subscription->update([
                        'type' => $validated['subscription_type'],
                        'status' => $validated['subscription_status'],
                        'start_date' => $validated['subscription_start_date'],
                        'end_date' => $validated['subscription_end_date'],
                        'course_id' => $validated['subscription_course_id'],
                    ]);
                } else {
                    $user->subscription()->create([
                        'type' => $validated['subscription_type'],
                        'status' => $validated['subscription_status'],
                        'start_date' => $validated['subscription_start_date'],
                        'end_date' => $validated['subscription_end_date'],
                        'course_id' => $validated['subscription_course_id'],
                    ]);
                }
            } elseif ($user->subscription) {
                $user->subscription->delete();
            }
        }

        return redirect()->route('users.index')->with('success', "User {$user->name} updated successfully!");
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
        $user->subscription()->create([
            'course_id' => $validated['course_id'],
            'type' => 'monthly',
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
        ]);

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
            'type' => ['required', Rule::in(['monthly', 'semester'])],
            'course_id' => ['required', Rule::in([$user->course_id])],
        ]);

        if ($subscription) {
            $subscription->update([
                'type' => $validated['type'],
                'status' => 'active',
                'start_date' => now(),
                'end_date' => $validated['type'] === 'monthly' ? now()->addMonth() : now()->addMonths(6),
            ]);
        } else {
            $this->authorize('create', Subscription::class);
            $user->subscription()->create([
                'course_id' => $user->course_id,
                'type' => $validated['type'],
                'status' => 'active',
                'start_date' => now(),
                'end_date' => $validated['type'] === 'monthly' ? now()->addMonth() : now()->addMonths(6),
            ]);
        }

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

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
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

        return view('users.index', compact('user', 'students'));
    }
}
