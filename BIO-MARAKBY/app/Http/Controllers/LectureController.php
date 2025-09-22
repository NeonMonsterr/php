<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lecture;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /** Show all lectures in a course */
    public function index(Course $course)
    {
        $this->authorize('view', $course);

        $lectures = $course->lectures()->with('sections')->orderBy('position')->get();

        return view('lectures.index', compact('course', 'lectures'));
    }

    /** Show form to create new lecture */
   public function create(Course $course)
{
    $this->authorize('update', $course);

    // Get the next position (last + 1)
    $nextPosition = $course->lectures()->max('position') + 1;

    return view('lectures.create', compact('course', 'nextPosition'));
}

    /** Store a new lecture */
public function store(Request $request, Course $course)
{
    $this->authorize('update', $course);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'position' => 'required|integer|min:0|unique:lectures,position,NULL,id,course_id,' . $course->id,
        'is_published' => 'nullable|boolean',
    ]);

    $validated['course_id'] = $course->id;

    // Save lecture and keep the reference
    $lecture = Lecture::create($validated);

    // Redirect to the new lecture’s page
    return redirect()->route('lectures.show', [$course, $lecture])
        ->with('success', 'تم إنشاء المحاضرة بنجاح!');
}

    /** Show one lecture and its sections */
    public function show(Course $course, Lecture $lecture)
    {
        $this->authorize('view', $lecture);

        $sections = $lecture->sections()->published()->orderBy('position')->get();

        return view('lectures.show', compact('course', 'lecture', 'sections'));
    }

    /** Edit lecture */
    public function edit(Course $course, Lecture $lecture)
    {
        $this->authorize('update', $course);
        $this->authorize('update', $lecture);

        return view('lectures.edit', compact('course', 'lecture'));
    }

    /** Update lecture */
    public function update(Request $request, Course $course, Lecture $lecture)
    {
        $this->authorize('update', $course);
        $this->authorize('update', $lecture);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'position' => 'required|integer|min:0|unique:lectures,position,' . $lecture->id . ',id,course_id,' . $course->id,
            'is_published' => 'nullable|boolean',
        ]);

        $lecture->update($validated);

        return redirect()->route('lectures.show', [$course, $lecture])
            ->with('success', 'تم تعديل المحاضرة بنجاح!');
    }

    /** Delete lecture */
    public function destroy(Course $course, Lecture $lecture)
    {
        $this->authorize('delete', $lecture);
        $lecture->delete();

        return redirect()->route('lectures.index', $course)
            ->with('success', 'تم حذف المحاضرة بنجاح!');
    }
}
