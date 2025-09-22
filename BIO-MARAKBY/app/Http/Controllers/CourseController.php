<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of courses, with filtering for teachers and enrolled course for students.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $this->authorize('viewAny', Course::class);

        if ($user->role === 'teacher') {
            // Teachers see all their courses, filtered by stage and level
            $query = Course::where('user_id', $user->id)->with('user');

            if ($request->filled('stage')) {
                $query->where('stage', $request->input('stage'));
            }
            if ($request->filled('level')) {
                $query->where('level', $request->input('level'));
            }

            $courses = $query->orderBy('stage')->orderBy('level')
                            ->get()
                            ->groupBy(['stage', 'level']);
        } else {
            // Students see only their enrolled course, if any
            $courses = $user->enrolledCourse ? collect([$user->enrolledCourse])->groupBy(['stage', 'level']) : collect([]);
        }

        return view('courses.index', compact('courses', 'user'));
    }

    /**
     * Show the form for creating a new course.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('create', Course::class);
        return view('courses.create');
    }

    /**
     * Store a newly created course.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', Course::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'stage' => ['required', 'in:preparatory,secondary'],
            'level' => ['required', 'in:1,2,3'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $course = Auth::user()->courses()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'stage' => $validated['stage'],
            'level' => $validated['level'],
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('courses.index')->with('success', "الدورة {$course->name} تم إنشاؤها بنجاح!");
    }

    /**
     * Display the specified course.
     *
     * @param \App\Models\Course $course
     * @return \Illuminate\View\View
     */
    public function show(Course $course)
    {
        $this->authorize('view', $course);

        $user = auth()->user();
        $query = $course->lectures()->with('course');

        if ($user && $user->role !== 'teacher') {
            $query->where('is_published', true);
        }

        $lectures = $query->orderBy('position')->get();

        return view('courses.show', compact('course', 'lectures'));
    }

    /**
     * Show the form for editing the specified course.
     *
     * @param \App\Models\Course $course
     * @return \Illuminate\View\View
     */
    public function edit(Course $course)
    {
        $this->authorize('update', $course);
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified course.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'stage' => ['required', 'in:preparatory,secondary'],
            'level' => ['required', 'in:1,2,3'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $course->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'stage' => $validated['stage'],
            'level' => $validated['level'],
            'is_published' => $request->has('is_published'),
        ]);

        $course->refresh();

        return redirect()->route('courses.index')->with('success', "الدورة {$course->name} تم تحديثها بنجاح!");
    }

    /**
     * Remove the specified course.
     *
     * @param \App\Models\Course $course
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        if ($course->students()->count() > 0) {
            return redirect()->route('courses.index')->with('error', 'لا يمكن حذف الدورة لأنها تحتوي على طلاب مسجلين.');
        }

        $course->delete();
        return redirect()->route('courses.index')->with('success', "الدورة {$course->name} تم حذفها بنجاح!");
    }
}
