<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use App\Models\Answer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function start(Exam $exam)
    {
        $user = auth()->user();

        if ($user->course_id != $exam->course_id) {
            abort(403, 'غير مسجل في هذه الدورة');
        }

        if (!$exam->is_published) {
            abort(403, 'هذا الامتحان غير متاح حالياً');
        }

        $alreadyAttempted = $user->examAttempts()->where('exam_id', $exam->id)->exists();
        if ($alreadyAttempted) {
            return redirect()->route('exams.results', $exam->id)
                ->with('info', 'لقد قمت بالفعل بتقديم هذا الامتحان');
        }

        $exam->load('questions.options');

        $existingAnswers = $user->answers()
            ->whereIn('question_id', $exam->questions->pluck('id'))
            ->get()
            ->keyBy('question_id');

        return view('exams.exam', compact('exam', 'existingAnswers'));
    }

    public function results(Exam $exam)
    {
        $user = auth()->user();

        $questions = $exam->questions()->with('options')->get();
        $userAnswers = $user->answers()->whereIn('question_id', $questions->pluck('id'))->get()->keyBy('question_id');

        $correctAnswers = 0;
        $totalScore = 0;
        $totalPossibleScore = 0;

        $detailedResults = [];

        foreach ($questions as $question) {
            $userAnswer = $userAnswers[$question->id] ?? null;
            $isCorrect = false;
            $isPending = false;
            $questionPoints = $question->points ?? 1;

            $totalPossibleScore += $questionPoints;

            if ($question->type === 'mcq') {
                $correctOption = $question->options->where('is_correct', true)->first();
                if ($userAnswer && $correctOption && $userAnswer->option_id == $correctOption->id) {
                    $isCorrect = true;
                    $correctAnswers++;
                    $totalScore += $userAnswer->score ?? $questionPoints;
                }
            } elseif ($question->type === 'essay') {
                if ($userAnswer) {
                    $isPending = $userAnswer->score === null;
                    $isCorrect = $userAnswer->score > 0;
                    if ($userAnswer->score !== null) {
                        $totalScore += $userAnswer->score;
                    }
                    if ($isCorrect) {
                        $correctAnswers++;
                    }
                }
            }

            $detailedResults[] = [
                'question' => $question,
                'userAnswer' => $userAnswer,
                'correctOption' => $correctOption ?? null,
                'isCorrect' => $isCorrect,
                'isPending' => $isPending,
            ];
        }

        return view('exams.result', compact(
            'exam',
            'correctAnswers',
            'totalScore',
            'totalPossibleScore',
            'detailedResults'
        ));
    }

    public function saveProgress(Request $request, Exam $exam)
    {
        $user = auth()->user();
        $answers = $request->input('answers', []);

        foreach ($answers as $questionId => $answer) {
            $question = $exam->questions()->find($questionId);
            if (!$question) continue;

            if ($question->type === 'mcq') {
                $isCorrect = ($question->options()->where('is_correct', true)->first()->id ?? null) == $answer;
                $user->answers()->updateOrCreate(
                    ['question_id' => $questionId],
                    [
                        'option_id' => $answer,
                        'answer_text' => null,
                        'score' => $isCorrect ? $question->points : 0,
                    ]
                );
            } elseif ($question->type === 'essay') {
                $user->answers()->updateOrCreate(
                    ['question_id' => $questionId],
                    [
                        'answer_text' => $answer ?? '',
                        'option_id' => null,
                        'score' => null,
                    ]
                );
            }
        }

        if ($request->input('is_auto_save')) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'تم حفظ الإجابات بنجاح');
    }

    public function submit(Request $request, Exam $exam)
    {
        $user = auth()->user();

        $alreadyAttempted = $user->examAttempts()->where('exam_id', $exam->id)->exists();
        if ($alreadyAttempted) {
            return redirect()->route('exams.results', $exam->id)
                ->with('info', 'لقد قمت بتقديم هذا الامتحان مسبقًا');
        }

        $answers = $request->input('answers', []);

        foreach ($answers as $questionId => $answer) {
            $question = $exam->questions()->find($questionId);
            if (!$question) continue;

            if ($question->type === 'mcq') {
                $isCorrect = ($question->options()->where('is_correct', true)->first()->id ?? null) == $answer;
                $user->answers()->updateOrCreate(
                    ['question_id' => $questionId],
                    [
                        'option_id' => $answer,
                        'answer_text' => null,
                        'score' => $isCorrect ? $question->points : 0,
                    ]
                );
            } elseif ($question->type === 'essay') {
                $user->answers()->updateOrCreate(
                    ['question_id' => $questionId],
                    [
                        'answer_text' => $answer ?? '',
                        'option_id' => null,
                        'score' => null,
                    ]
                );
            }
        }

        $user->examAttempts()->create([
            'exam_id' => $exam->id,
            'completed_at' => now(),
            'remaining_time' => $request->input('remaining_time'),
            'score' => 0, // Initialize score
        ]);

        return redirect()->route('exams.results', $exam->id)
            ->with('success', 'تم تقديم الامتحان بنجاح');
    }

    public function gradeEssayAnswers(Exam $exam, User $student)
    {
        $this->authorize('update', $exam);

        if ($student->role !== 'student' || $student->course_id !== $exam->course_id) {
            abort(403, 'المستخدم ليس طالبًا في هذه الدورة');
        }

        $attempt = $student->examAttempts()->where('exam_id', $exam->id)->first();
        if (!$attempt) {
            return redirect()->route('exams.allresult', $exam->id)
                ->with('error', 'الطالب لم يقدم الامتحان بعد');
        }

        $questions = $exam->questions()->where('type', 'essay')->with(['essayAnswer', 'answers' => function ($query) use ($student) {
            $query->where('user_id', $student->id);
        }])->get();

        return view('exams.grade_essay', compact('exam', 'student', 'questions', 'attempt'));
    }

    public function storeEssayGrades(Request $request, Exam $exam, User $student)
    {
        $this->authorize('update', $exam);

        if ($student->role !== 'student' || $student->course_id !== $exam->course_id) {
            abort(403, 'المستخدم ليس طالبًا في هذه الدورة');
        }

        $attempt = $student->examAttempts()->where('exam_id', $exam->id)->first();
        if (!$attempt) {
            return redirect()->route('exams.allresult', $exam->id)
                ->with('error', 'الطالب لم يقدم الامتحان بعد');
        }

        $validated = $request->validate([
            'grades' => 'required|array',
            'grades.*.question_id' => 'required|exists:questions,id',
            'grades.*.points_earned' => 'required|integer|min:0',
        ]);

        Log::info('storeEssayGrades: Validated input', ['grades' => $validated['grades'], 'student_id' => $student->id, 'exam_id' => $exam->id]);

        // Use transaction to ensure consistency
        DB::transaction(function () use ($exam, $student, $validated, $attempt) {
            // Fetch all answers for the student and exam
            $answers = Answer::where('user_id', $student->id)
                ->whereIn('question_id', $exam->questions->pluck('id'))
                ->get()
                ->keyBy('question_id');

            $totalScore = 0;

            // Calculate MCQ scores
            foreach ($exam->questions as $question) {
                if ($question->type === 'mcq') {
                    $answer = $answers[$question->id] ?? null;
                    if ($answer && $answer->score !== null) {
                        $totalScore += $answer->score;
                        Log::info('MCQ Score', ['question_id' => $question->id, 'score' => $answer->score]);
                    }
                }
            }

            // Process essay grades
            foreach ($validated['grades'] as $grade) {
                $question = $exam->questions->where('id', $grade['question_id'])->first();
                if (!$question || $question->type !== 'essay' || $question->exam_id !== $exam->id) {
                    Log::warning('Invalid question or type', ['question_id' => $grade['question_id'], 'type' => $question->type ?? 'N/A']);
                    continue;
                }

                if ($grade['points_earned'] > $question->points) {
                    throw new \Exception("الدرجة الممنوحة يجب ألا تتجاوز {$question->points} لهذا السؤال: {$question->id}");
                }

                $answer = $answers[$grade['question_id']] ?? null;
                if (!$answer) {
                    $answer = Answer::create([
                        'user_id' => $student->id,
                        'question_id' => $grade['question_id'],
                        'answer_text' => '',
                        'option_id' => null,
                        'score' => $grade['points_earned'],
                    ]);
                    Log::info('Created new Answer record', ['answer_id' => $answer->id, 'question_id' => $grade['question_id'], 'score' => $grade['points_earned']]);
                } else {
                    $answer->update([
                        'score' => $grade['points_earned'],
                    ]);
                    Log::info('Updated Answer record', ['answer_id' => $answer->id, 'question_id' => $grade['question_id'], 'score' => $grade['points_earned']]);
                }

                $totalScore += $grade['points_earned'];
            }

            // Update ExamAttempt
            $attempt->update(['score' => $totalScore]);
            Log::info('Updated ExamAttempt', ['exam_id' => $exam->id, 'student_id' => $student->id, 'score' => $totalScore]);
        });

        return redirect()->route('exams.allresult', $exam->id)
            ->with('success', 'تم حفظ درجات الأسئلة المقالية بنجاح وإعادة حساب الدرجة الإجمالية!');
    }

    public function storeBatch(Request $request, Exam $exam)
    {
        try {
            $requestData = $request->all();

            $validator = Validator::make($requestData, [
                'questions' => 'required|array|min:1',
                'questions.*.question_text' => 'required|string|max:1000',
                'questions.*.type' => 'required|in:mcq,essay',
                'questions.*.points' => 'required|integer|min:1',
                'questions.*.options' => 'required_if:questions.*.type,mcq|array|min:4|max:4',
                'questions.*.options.*' => 'required_if:questions.*.type,mcq|string|max:255',
                'questions.*.correct_option' => 'required_if:questions.*.type,mcq|integer|between:0,3',
                'questions.*.answer_text' => 'required_if:questions.*.type,essay|string|max:2000|nullable',
                'questions.*.images' => 'nullable|array',
                'questions.*.images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'questions.*.options.*.string' => 'يجب أن يكون الخيار نصاً.',
                'questions.*.correct_option.integer' => 'يجب أن تكون الإجابة الصحيحة رقماً.',
                'questions.*.answer_text.required_if' => 'حقل الإجابة المقالية مطلوب.'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'request_data' => $requestData
                ], 422);
            }

            foreach ($request->questions as $index => $questionData) {
                $question = $exam->questions()->create([
                    'question_text' => $questionData['question_text'],
                    'type' => $questionData['type'],
                    'points' => $questionData['points'],
                ]);

                if ($questionData['type'] === 'mcq') {
                    foreach ($questionData['options'] as $optionIndex => $optionText) {
                        $question->options()->create([
                            'option_text' => $optionText,
                            'is_correct' => $optionIndex == $questionData['correct_option'],
                        ]);
                    }
                } else {
                    $question->essayAnswer()->create([
                        'answer_text' => $questionData['answer_text'] ?? '',
                    ]);
                }

                if ($request->hasFile("questions.$index.images")) {
                    foreach ($request->file("questions.$index.images") as $image) {
                        $path = $image->store('question_images', 'public');
                        $question->images()->create(['image_path' => $path]);
                    }
                }
            }

            return response()->json([
                'success' => true,
                'redirect' => route('exams.show', $exam->id),
                'message' => 'تم إضافة الأسئلة والصور بنجاح'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function edit(Exam $exam)
    {
        $exam->load(['questions' => function ($query) {
            $query->with([
                'options' => function ($query) {
                    $query->orderBy('id');
                },
                'answers' => function ($query) {
                    $query->orderBy('id');
                }
            ]);
        }]);

        return view('exams.questions.edit', compact('exam'));
    }

    public function update(Request $request, Exam $exam)
{
    $validated = $request->validate([
        'questions' => 'required|array|min:1',
        'questions.*.id' => 'nullable|exists:questions,id',
        'questions.*.question_text' => 'required|string|max:1000',
        'questions.*.type' => 'required|in:mcq,essay',
        'questions.*.points' => 'required|integer|min:1',
        'questions.*.options' => 'nullable|array',
        'questions.*.options.*.text' => 'nullable|string|max:255',
        'questions.*.correct_option' => 'nullable|integer',
        'questions.*.answer_text' => 'nullable|string|max:2000',
        'questions.*.new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'questions.*.existing_images' => 'nullable|array',
    ]);

    DB::transaction(function () use ($validated, $exam, $request) {
        foreach ($validated['questions'] as $index => $questionData) {
            // Find or create question
            $question = isset($questionData['id'])
                ? $exam->questions()->find($questionData['id'])
                : $exam->questions()->create([
                    'question_text' => $questionData['question_text'],
                    'type' => $questionData['type'],
                    'points' => $questionData['points'],
                ]);

            if (!$question) continue;

            // Update question fields
            $question->update([
                'question_text' => $questionData['question_text'],
                'type' => $questionData['type'],
                'points' => $questionData['points'],
            ]);

            // Handle MCQ options
            if ($questionData['type'] === 'mcq') {
                $question->options()->delete(); // reset old options
                if (!empty($questionData['options'])) {
                    foreach ($questionData['options'] as $optIndex => $opt) {
                        $question->options()->create([
                            'option_text' => $opt['text'] ?? '',
                            'is_correct' => isset($questionData['correct_option']) &&
                                $questionData['correct_option'] == $optIndex,
                        ]);
                    }
                }
            }

            // Handle Essay answer
            if ($questionData['type'] === 'essay') {
                $question->essayAnswer()->updateOrCreate(
                    ['question_id' => $question->id],
                    ['answer_text' => $questionData['answer_text'] ?? '']
                );
            }

            // Handle Images
            // 1. Delete removed images
            $existing = $questionData['existing_images'] ?? [];
            foreach ($question->images as $img) {
                if (!in_array($img->id, $existing)) {
                    Storage::disk('public')->delete($img->image_path);
                    $img->delete();
                }
            }

            // 2. Add new images
            if ($request->hasFile("questions.$index.new_images")) {
                foreach ($request->file("questions.$index.new_images") as $file) {
                    $path = $file->store('question_images', 'public');
                    $question->images()->create(['image_path' => $path]);
                }
            }
        }
    });

    return response()->json([
        'success' => true,
        'redirect' => route('exams.show', $exam->id),
        'message' => 'تم تحديث الأسئلة بنجاح'
    ]);
}

    public function destroy(string $id)
    {
        //
    }
}
