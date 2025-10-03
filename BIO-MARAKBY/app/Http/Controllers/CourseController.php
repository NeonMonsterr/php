<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Level;
use App\Models\Stage;
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
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $this->authorize('viewAny', Course::class);

        if ($user->role === 'teacher') {
            // Get levels with stages and courses filtered by this teacher
            $levels = Level::with(['stages.courses' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])->get();
        } else {
            // Students see only their enrolled course
            $levels = Level::with(['stages.courses' => function ($query) use ($user) {
                if ($user->enrolledCourse) {
                    $query->where('id', $user->enrolledCourse->id);
                } else {
                    $query->whereRaw('0=1'); // no courses
                }
            }])->get();
        }

        return view('courses.index', compact('levels', 'user'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $this->authorize('create', Course::class);

        $levels = Level::all();
        $stages = Stage::all();

        return view('courses.create', compact('levels', 'stages'));
    }

    /**
     * Store a newly created course.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Course::class);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'stage_id' => ['required', 'exists:stages,id'],
            'level_id' => ['required', 'exists:levels,id'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $course = Auth::user()->courses()->create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'stage_id' => $validated['stage_id'],
            'level_id' => $validated['level_id'],
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('courses.index')->with('success', "الدورة {$course->name} تم إنشاؤها بنجاح!");
    }

    /**
     * Display the specified course.
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
        $course->load(['stage', 'level', 'user', 'lectures']);

        return view('courses.show', compact('course', 'lectures'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        $this->authorize('update', $course);

        $levels = Level::all();
        $stages = Stage::all();

        return view('courses.edit', compact('course', 'levels', 'stages'));
    }

    /**
     * Update the specified course.
     */
    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'stage_id' => ['required', 'exists:stages,id'],
            'level_id' => ['required', 'exists:levels,id'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $course->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'stage_id' => $validated['stage_id'],
            'level_id' => $validated['level_id'],
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('courses.index')->with('success', "الدورة {$course->name} تم تحديثها بنجاح!");
    }

    /**
     * Remove the specified course.
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
