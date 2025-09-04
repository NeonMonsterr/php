<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // app/Http/Controllers/ExamController.php
    public function start(Exam $exam)
    {
        $user = auth()->user();

        // التحقق من تسجيل الطالب في الكورس
        if ($user->course_id != $exam->course_id) {
            abort(403, 'غير مسجل في هذه الدورة');
        }

        // التحقق من نشر الامتحان
        if (!$exam->is_published) {
            abort(403, 'هذا الامتحان غير متاح حالياً');
        }

        // التحقق من أنه لم يقدم الامتحان من قبل
        $alreadyAttempted = $user->examAttempts()->where('exam_id', $exam->id)->exists();
        if ($alreadyAttempted) {
            return redirect()->route('exams.results', $exam->id)
                ->with('info', 'لقد قمت بالفعل بتقديم هذا الامتحان');
        }

        // تحميل الأسئلة والخيارات
        $exam->load('questions.options');

        // جلب الإجابات المحفوظة (سواء خيار أو مقال)
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

        $correctAnswers = 0;         // عدد الأسئلة الصح (لو عايز تستخدمه)
        $totalScore = 0;             // مجموع الدرجات التي حصل عليها الطالب
        $totalPossibleScore = 0;     // مجموع الدرجات الكاملة للامتحان

        $detailedResults = [];

        foreach ($questions as $question) {
            $userAnswer = $userAnswers[$question->id] ?? null;
            $isCorrect = false;
            $questionPoints = $question->points ?? 1; // الافتراضي نقطة واحدة

            // إجمالي الدرجات الكلية
            $totalPossibleScore += $questionPoints;

            if ($question->type === 'mcq') {
                $correctOption = $question->options->where('is_correct', true)->first();
                if (
                    $userAnswer &&
                    $correctOption &&
                    $userAnswer->option_id == $correctOption->id
                ) {
                    $isCorrect = true;
                    $correctAnswers++;
                    $totalScore += $questionPoints;
                }
            } elseif ($question->type === 'essay') {
                // نعتبر أي إجابة مقال غير فاضية = صحيحة مؤقتًا (تقدر تغير ده بعدين بتصحيح يدوي)
                if ($userAnswer && !empty(trim($userAnswer->answer_text))) {
                    $isCorrect = true;
                    $correctAnswers++;
                    $totalScore += $questionPoints;
                }
            }

            $detailedResults[] = [
                'question' => $question,
                'userAnswer' => $userAnswer,
                'correctOption' => $correctOption ?? null,
                'isCorrect' => $isCorrect,
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
                $user->answers()->updateOrCreate(
                    ['question_id' => $questionId],
                    ['option_id' => $answer, 'answer_text' => null]
                );
            } elseif ($question->type === 'essay') {
                $user->answers()->updateOrCreate(
                    ['question_id' => $questionId],
                    ['answer_text' => $answer, 'option_id' => null]
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

        // التحقق إذا المستخدم قدم الامتحان من قبل
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
                // تحقق من صحة الإجابة للاختيارات
                $isCorrect = ($question->correct_option_id == $answer);

                $user->answers()->updateOrCreate(
                    ['question_id' => $questionId],
                    [
                        'option_id' => $answer,
                        'answer_text' => null,
                        'is_correct' => $isCorrect,
                    ]
                );
            } elseif ($question->type === 'essay') {
                // تحقق من صحة الإجابة المقالية (نصية) مع تجاهل حالة الأحرف والمسافات
                $userAnswer = trim(mb_strtolower($answer));
                $correctAnswer = trim(mb_strtolower($question->correct_answer ?? ''));

                $isCorrect = ($userAnswer === $correctAnswer);

                $user->answers()->updateOrCreate(
                    ['question_id' => $questionId],
                    [
                        'answer_text' => $answer,
                        'option_id' => null,
                        'is_correct' => $isCorrect,
                    ]
                );
            }
        }

        // تسجيل محاولة الامتحان
        $user->examAttempts()->create([
            'exam_id' => $exam->id,
            'completed_at' => now(),
            'remaining_time' => $request->input('remaining_time'),
        ]);

        return redirect()->route('exams.results', $exam->id)
            ->with('success', 'تم تقديم الامتحان بنجاح');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }


    // ExamQuestionController.php

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

                // حفظ الصور المرفوعة لهذا السؤال
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
    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
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
            'questions.*.id' => 'required|exists:questions,id',
            'questions.*.question_text' => 'required|string|max:1000',
            'questions.*.type' => 'required|in:mcq,essay',
            'questions.*.points' => 'required|integer|min:1',
            'questions.*.options' => 'array',
            'questions.*.options.*.id' => 'nullable|exists:options,id',
            'questions.*.options.*.text' => 'nullable|string|max:255',
            'questions.*.correct_option' => 'nullable|integer|between:0,3',
            'questions.*.answer_text' => 'nullable|string|max:2000',
            'questions.*.existing_images' => 'nullable|array',
            'questions.*.existing_images.*' => 'exists:question_images,id',
            'questions.*.new_images' => 'nullable|array',
            'questions.*.new_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        foreach ($validated['questions'] as $index => $questionData) {
            $question = Question::findOrFail($questionData['id']);

            // تحديث بيانات السؤال الأساسية
            $question->update([
                'question_text' => $questionData['question_text'],
                'type' => $questionData['type'],
                'points' => $questionData['points'],
            ]);

            // معالجة الصور الحالية والمحذوفة
            $existingImages = $questionData['existing_images'] ?? [];
            $imagesToDelete = $question->images()->whereNotIn('id', $existingImages)->get();

            foreach ($imagesToDelete as $image) {
                Storage::delete('public/' . $image->image_path);
                $image->delete();
            }

            // معالجة الصور الجديدة
            if ($request->hasFile("questions.$index.new_images")) {
                foreach ($request->file("questions.$index.new_images") as $image) {
                    $path = $image->store('question_images', 'public');
                    $question->images()->create(['image_path' => $path]);
                }
            }

            // معالجة الخيارات (لأسئلة الاختيار من متعدد)
            if ($questionData['type'] === 'mcq' && isset($questionData['options'])) {
                foreach ($questionData['options'] as $optIndex => $optionData) {
                    $option = $question->options()->updateOrCreate(
                        ['id' => $optionData['id'] ?? null],
                        ['option_text' => $optionData['text'] ?? '']
                    );

                    $option->update(['is_correct' => ($optIndex == $questionData['correct_option'])]);
                }
            }

            // معالجة الإجابة المقالية
            if ($questionData['type'] === 'essay' && isset($questionData['answer_text'])) {
                $question->essayAnswer()->updateOrCreate(
                    ['question_id' => $question->id],
                    ['answer_text' => $questionData['answer_text']]
                );
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الأسئلة بنجاح',
            'redirect' => route('exams.show', $exam->id)
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
