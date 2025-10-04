<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Course;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Option;
use App\Models\Question;
use App\Models\QuestionImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ExamController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function allresult(Exam $exam)
    {
        $this->authorize('viewResults', $exam);

        $students = $exam->course?->students()->get();
        $questions = $exam->questions()->with(['options', 'essayAnswer'])->get();

        $results = [];

        foreach ($students as $student) {
            $attempt = ExamAttempt::where('exam_id', $exam->id)
                ->where('user_id', $student->id)
                ->first();

            $detailedAnswers = [];

            if (!$attempt) {
                $results[] = [
                    'student' => $student,
                    'score' => null,
                    'answers' => [],
                ];
                continue;
            }

            $userAnswers = Answer::where('user_id', $student->id)
                ->whereIn('question_id', $questions->pluck('id'))
                ->get()
                ->keyBy('question_id');

            foreach ($questions as $question) {
                $userAnswer = $userAnswers[$question->id] ?? null;
                $isCorrect = false;
                $isPending = false;

                if ($question->type === 'mcq') {
                    $correctOption = $question->options->where('is_correct', true)->first();
                    $isCorrect = $userAnswer && $correctOption && $userAnswer->option_id == $correctOption->id;
                } elseif ($question->type === 'essay') {
                    $isPending = $userAnswer && $userAnswer->score === null;
                    $isCorrect = $userAnswer && $userAnswer->score > 0;
                }

                $detailedAnswers[$question->id] = [
                    'question' => $question,
                    'userAnswer' => $userAnswer,
                    'isCorrect' => $isCorrect,
                    'isPending' => $isPending,
                ];
            }

            $results[] = [
                'student' => $student,
                'score' => $attempt->score, // Use ExamAttempt->score directly
                'answers' => $detailedAnswers,
            ];
        }

        return view('exams.allresult', compact('exam', 'results'));
    }

    public function index()
    {
        $user = auth()->user();
        $this->authorize('viewAny', Exam::class);

        if ($user->role === 'teacher') {
            // Get all courses with exams ordered by exam_date
            $courses = Course::with(['exams' => function ($query) {
                $query->orderBy('exam_date');
            }])->orderBy('name')->get();
        } else {
            // Student: only their course with published exams
            $courses = Course::where('id', $user->course_id)
                ->with(['exams' => function ($query) {
                    $query->published()->orderBy('exam_date');
                }])
                ->get();
        }

        return view('exams.index', compact('courses', 'user'));
    }

    public function create()
    {
        $this->authorize('create', Exam::class);
        $courses = Course::where('is_published', true)->get();

        if ($courses->isEmpty()) {
            return redirect()->route('courses.index')->with('error', 'لا توجد دورات متاحة لإنشاء امتحان.');
        }

        if (auth()->user()->role !== 'teacher') {
            return redirect()->route('exams.index')->with('error', 'ليس لديك صلاحية لإنشاء امتحانات.');
        }

        return view('exams.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'type' => 'required|in:mcq,essay,mixed',
            'duration_minutes' => 'required|integer|min:1',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'exam_date' => 'required|date',
            'show_score_immediately' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
        ]);

        $exam = Exam::create($validated);

        return redirect()->route('exams.questions.create', $exam->id)
            ->with('success', 'تم إنشاء الامتحان بنجاح، يمكنك الآن إضافة الأسئلة');
    }

    public function createQuestion(Exam $exam)
    {
        $this->authorize('update', $exam);
        $exam->load('course');
        return view('exams.questions.create', compact('exam'));
    }

    public function storeBatchQuestions(Request $request, Exam $exam)
    {
        $this->authorize('update', $exam);

        $request->validate([
            'questions' => 'required|array',
            'questions.*.question_text' => 'required|string',
            'questions.*.type' => 'required|in:mcq,essay',
            'questions.*.points' => 'required|integer|min:1',
            'questions.*.options' => 'required_if:questions.*.type,mcq|array',
            'questions.*.options.*' => 'required_if:questions.*.type,mcq|string',
            'questions.*.correct_option' => 'required_if:questions.*.type,mcq|integer',
            'questions.*.answer_text' => 'required_if:questions.*.type,essay|string|nullable',
            'questions.*.images' => 'nullable|array',
            'questions.*.images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $createdQuestions = [];

        try {
            foreach ($request->questions as $questionData) {
                $question = $exam->questions()->create([
                    'question_text' => $questionData['question_text'],
                    'type' => $questionData['type'],
                    'points' => $questionData['points'],
                ]);

                if ($questionData['type'] === 'mcq') {
                    foreach ($questionData['options'] as $index => $optionText) {
                        $question->options()->create([
                            'option_text' => $optionText,
                            'is_correct' => $questionData['correct_option'] == $index,
                        ]);
                    }
                } else {
                    $question->essayAnswer()->create([
                        'answer_text' => $questionData['answer_text'] ?? '',
                    ]);
                }

                if (!empty($questionData['images'])) {
                    foreach ($questionData['images'] as $image) {
                        $path = $image->store('question_images', 'public');
                        $question->images()->create([
                            'image_path' => $path
                        ]);
                    }
                }

                $createdQuestions[] = $question;
            }

            return response()->json([
                'success' => true,
                'message' => 'تم حفظ الأسئلة بنجاح',
                'redirect' => route('exams.show', $exam->id)
            ]);
        } catch (\Exception $e) {
            foreach ($createdQuestions as $question) {
                foreach ($question->images as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
                $question->delete();
            }

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حفظ الأسئلة',
                'errors' => ['general' => [$e->getMessage()]]
            ], 500);
        }
    }

    public function show(Exam $exam)
    {
        $this->authorize('view', $exam);
        $exam->load(['questions.images', 'questions.options', 'questions.essayAnswer']);
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
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'duration_minutes' => 'required|integer|min:1',
            'is_published' => 'nullable|boolean',
            'show_score_immediately' => 'nullable|boolean',
        ]);

        $exam->update($validated);

        return redirect()->route('exams.show', $exam->id)
            ->with('success', 'تم تحديث بيانات الامتحان بنجاح');
    }

    public function destroy(Exam $exam)
    {
        $this->authorize('delete', $exam);

        foreach ($exam->questions as $question) {
            foreach ($question->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }

        $exam->delete();

        return redirect()->route('exams.index')
            ->with('success', 'تم حذف الامتحان بنجاح');
    }

    public function submit(Request $request, Exam $exam)
    {
        $this->authorize('take', $exam);

        $user = Auth::user();

        if ($exam->attempts()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'لقد قمت بتقديم هذا الامتحان من قبل');
        }

        if (!now()->between($exam->start_time, $exam->end_time)) {
            return redirect()->back()->with('error', 'الامتحان غير متاح حالياً');
        }

        $attempt = $exam->attempts()->create([
            'user_id' => $user->id,
            'started_at' => now(),
            'finished_at' => null,
            'score' => 0,
        ]);

        $totalScore = 0;

        foreach ($request->input('answers', []) as $questionId => $answer) {
            $question = Question::findOrFail($questionId);

            $answerData = [
                'user_id' => $user->id,
                'question_id' => $questionId,
                'score' => 0, // Use 'score' to match Answer model
            ];

            if ($question->type == 'mcq') {
                $option = Option::find($answer);
                $isCorrect = $option ? $option->is_correct : false;

                $answerData['option_id'] = $answer;
                $answerData['score'] = $isCorrect ? $question->points : 0;
                $totalScore += $isCorrect ? $question->points : 0;
            } else {
                $answerData['answer_text'] = $answer ?? '';
                $answerData['score'] = null; // Essay answers pending grading
            }

            $attempt->answers()->create($answerData);
        }

        $attempt->update([
            'finished_at' => now(),
            'score' => $totalScore,
        ]);

        return redirect()->route('exams.result', [$exam, $attempt])
            ->with('success', 'تم تقديم الامتحان بنجاح');
    }

    public function result(Exam $exam, ExamAttempt $attempt)
    {
        $this->authorize('view', $attempt);
        $attempt->load(['answers.question', 'answers.option']);
        return view('exams.result', compact('exam', 'attempt'));
    }

    public function deleteQuestionImage(QuestionImage $image)
    {
        $this->authorize('delete', $image->question->exam);

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return response()->json(['success' => true]);
    }
}
