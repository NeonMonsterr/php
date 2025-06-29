<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LectureController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $this->authorize('viewAny', Lecture::class);

        $search = $request->query('search');

        if ($user->role === 'teacher') {
            $query = Lecture::with('course');
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhereHas('course', function ($q) use ($search) {
                          $q->where('name', 'like', '%' . $search . '%');
                      });
                });
            }
            $lectures = $query->orderBy('position')->get();
        } else {
            $query = Lecture::where('course_id', $user->course_id)->published()->with('course');
            if ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            }
            $lectures = $query->orderBy('position')->get();
        }

        return view('lectures.index', compact('lectures', 'user', 'search'));
    }

    public function create(Course $course)
    {
        $this->authorize('update', $course);
        $courses = Course::all();
        return view('lectures.create', compact('course', 'courses'));
    }

    public function store(Request $request, Course $course)
    {
        $this->authorize('create', Lecture::class);

        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'youtube_url' => [
                'required',
                'url',
                'max:255',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/(watch\?v=|embed\/|v\/)?([a-zA-Z0-9_-]{11})(\?.*)?$/',
                'unique:lectures,youtube_url,NULL,id,course_id,' . $request->course_id,
            ],
            'position' => ['required', 'integer', 'min:0', 'unique:lectures,position,NULL,id,course_id,' . $request->course_id],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['youtube_url'] = $this->normalizeYouTubeUrl($validated['youtube_url']);
        Lecture::create($validated);

        return redirect()->route('lectures.index')->with('success', 'Lecture created successfully!');
    }

    public function show(Lecture $lecture)
    {
        $this->authorize('view', $lecture);
        $videoId = $this->extractYouTubeVideoId($lecture->youtube_url);
        return view('lectures.show', compact('lecture', 'videoId'));
    }

    public function edit(Course $course, Lecture $lecture)
    {
        $this->authorize('update', $course);
        $courses = Course::all();
        return view('lectures.edit', compact('course', 'lecture', 'courses'));
    }

    public function update(Request $request, Course $course, Lecture $lecture)
    {
        $this->authorize('update', $lecture);

        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'title' => ['required', 'string', 'max:255'],
            'youtube_url' => [
                'required',
                'url',
                'max:255',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/(watch\?v=|embed\/|v\/)?([a-zA-Z0-9_-]{11})(\?.*)?$/',
                'unique:lectures,youtube_url,' . $lecture->id . ',id,course_id,' . $request->course_id,
            ],
            'position' => ['required', 'integer', 'min:0', 'unique:lectures,position,' . $lecture->id . ',id,course_id,' . $request->course_id],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['youtube_url'] = $this->normalizeYouTubeUrl($validated['youtube_url']);
        $lecture->update($validated);

        return redirect()->route('lectures.index')->with('success', 'Lecture updated successfully!');
    }

    public function destroy(Lecture $lecture)
    {
        $this->authorize('delete', $lecture);
        $lecture->delete();
        return redirect()->route('lectures.index')->with('success', 'Lecture deleted successfully!');
    }

    private function extractYouTubeVideoId(string $url): ?string
    {
        if (preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/(watch\?v=|embed\/|v\/)?([a-zA-Z0-9_-]{11})(\?.*)?$/', $url, $matches)) {
            return $matches[5];
        }
        return null;
    }

    private function normalizeYouTubeUrl(string $url): string
    {
        $videoId = $this->extractYouTubeVideoId($url);
        return $videoId ? "https://www.youtube.com/watch?v={$videoId}" : $url;
    }
}
