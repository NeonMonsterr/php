<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lecture;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class SectionController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /** List sections for a lecture */
    public function index(Request $request, Course $course, Lecture $lecture)
    {
        $this->authorize('viewAny', Section::class);

        $search = $request->query('search');

        $query = Section::where('lecture_id', $lecture->id);

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $sections = $query->orderBy('position')->get();

        return view('sections.index', compact('sections', 'course', 'lecture', 'search'));
    }

    /** Show form to create a new section */
    public function create(Course $course, Lecture $lecture)
    {
        $this->authorize('create', Section::class);
        $this->authorize('update', $lecture);

        return view('sections.create', compact('course', 'lecture'));
    }

    /** Store a newly created section */
    public function store(Request $request, Course $course, Lecture $lecture)
    {
        $this->authorize('create', Section::class);
        $this->authorize('update', $lecture);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'youtube_url' => [
                'required',
                'url',
                'max:255',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/(watch\?v=|embed\/|v\/)?([a-zA-Z0-9_-]{11})(\?.*)?$/',
                'unique:sections,youtube_url,NULL,id,lecture_id,' . $lecture->id,
            ],
            'file' => ['nullable', 'file', 'max:20480'],
            'position' => ['required', 'integer', 'min:0', 'unique:sections,position,NULL,id,lecture_id,' . $lecture->id],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['youtube_url'] = $this->normalizeYouTubeUrl($validated['youtube_url']);
        $validated['lecture_id'] = $lecture->id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $directory = 'sections';

            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $extension = $file->getClientOriginalExtension();
            $newFileName = 'section_' . $timestamp . '.' . $extension;
            $path = $file->storeAs($directory, $newFileName, 'public');
            $validated['file'] = $path;
        }
        $validated['video_title'] = $validated['title'];

        Section::create($validated);

        return redirect()
            ->route('lectures.show', [$course, $lecture])
            ->with('success', 'تم إنشاء القسم بنجاح!');
    }

    /** Show one section */
    public function show(Course $course, Lecture $lecture, Section $section)
    {
        $this->authorize('view', $section);

        $videoId = $this->extractYouTubeVideoId($section->youtube_url);

        return view('sections.show', compact('course', 'lecture', 'section', 'videoId'));
    }

    /** Edit section */
    public function edit(Course $course, Lecture $lecture, Section $section)
    {
        $this->authorize('update', $lecture);
        $this->authorize('update', $section);

        // Get all lectures in the same course
        $lectures = $course->lectures()->orderBy('title')->get();

        return view('sections.edit', compact('course', 'lecture', 'section', 'lectures'));
    }

    /** Update section */
    public function update(Request $request, Course $course, Lecture $lecture, Section $section)
    {
        $this->authorize('update', $lecture);
        $this->authorize('update', $section);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'youtube_url' => [
                'required',
                'url',
                'max:255',
                'regex:/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/(watch\?v=|embed\/|v\/)?([a-zA-Z0-9_-]{11})(\?.*)?$/',
                'unique:sections,youtube_url,' . $section->id . ',id,lecture_id,' . $lecture->id,
            ],
            'position' => ['required', 'integer', 'min:0', 'unique:sections,position,' . $section->id . ',id,lecture_id,' . $lecture->id],
            'file' => ['nullable', 'file', 'max:20480'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['youtube_url'] = $this->normalizeYouTubeUrl($validated['youtube_url']);
        $validated['lecture_id'] = $lecture->id;

        if ($request->hasFile('file')) {
            if ($section->file && Storage::disk('public')->exists($section->file)) {
                Storage::disk('public')->delete($section->file);
            }

            $file = $request->file('file');
            $directory = 'sections';

            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }

            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $extension = $file->getClientOriginalExtension();
            $newFileName = 'section_' . $timestamp . '.' . $extension;
            $path = $file->storeAs($directory, $newFileName, 'public');
            $validated['file'] = $path;
        }
        $validated['video_title'] = $validated['title'];
        $section->update($validated);

        return redirect()
            ->route('lectures.show', [$course, $lecture])
            ->with('success', 'تم تعديل القسم بنجاح!');
    }

    /** Delete section */
    public function destroy(Course $course, Lecture $lecture, Section $section)
    {
        $this->authorize('delete', $section);

        if ($section->file && Storage::disk('public')->exists($section->file)) {
            Storage::disk('public')->delete($section->file);
        }

        $section->delete();

        return redirect()
            ->route('lectures.show', [$course, $lecture])
            ->with('success', 'تم حذف القسم بنجاح!');
    }

    /** Extract YouTube video ID */
    private function extractYouTubeVideoId(string $url): ?string
    {
        if (preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/(watch\?v=|embed\/|v\/)?([a-zA-Z0-9_-]{11})(\?.*)?$/', $url, $matches)) {
            return $matches[5];
        }
        return null;
    }

    /** Normalize YouTube URL */
    private function normalizeYouTubeUrl(string $url): string
    {
        $videoId = $this->extractYouTubeVideoId($url);
        return $videoId ? "https://www.youtube.com/watch?v={$videoId}" : $url;
    }
    public function download(Section $section)
{
    $this->authorize('view', $section);

    if (!$section->file || !Storage::disk('public')->exists($section->file)) {
        abort(404, 'الملف غير موجود.');
    }

    return Storage::disk('public')->download($section->file);
}

}
