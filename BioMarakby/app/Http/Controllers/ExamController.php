<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ExamController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $this->authorize('viewAny', Exam::class);

        if ($user->role === 'teacher') {
            $exams = Exam::with('course')->orderBy('exam_date')->get();
        } else {
            $exams = Exam::where('course_id', $user->course_id)->published()->with('course')->orderBy('exam_date')->get();
        }

        return view('exams.index', compact('exams', 'user'));
    }

    public function create()
    {
        $this->authorize('create', Exam::class);
        $courses = Course::where('is_published', true)->get();
        return view('exams.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Exam::class);

        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'form_url' => ['required', 'url', 'max:255'],
            'exam_date' => ['required', 'date'],
            'is_published' => ['boolean'],
        ]);

        Exam::create($validated);

        return redirect()->route('exams.index')->with('success', 'Exam created successfully!');
    }

    public function show(Exam $exam)
    {
        $this->authorize('view', $exam);
        return view('exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $this->authorize('update', $exam);
        $courses = Course::where('is_published', true)->get();
        return view('exams.edit', compact('exam', 'courses'));
    }

    public function update(Request $request, Exam $exam)
    {
        $this->authorize('update', $exam);

        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'form_url' => ['required', 'url', 'max:255'],
            'exam_date' => ['required', 'date'],
            'is_published' => ['boolean'],
        ]);

        $exam->update($validated);

        return redirect()->route('exams.index')->with('success', 'Exam updated successfully!');
    }

    public function destroy(Exam $exam)
    {
        $this->authorize('delete', $exam);
        $exam->delete();
        return redirect()->route('exams.index')->with('success', 'Exam deleted successfully!');
    }
}
