<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نتيجة الامتحان</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: white;
            overflow-x: hidden;
        }

        .background-gif {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.08;
            z-index: -1;
        }

        /* Content shift only on desktop (because sidebar fixed) */
        @media (min-width: 768px) {
            .content {
                margin-right: 16rem; /* same as sidebar width */
            }
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="Background" class="background-gif">

    <!-- Sidebar -->
    @if (auth()->user()->role === 'teacher')
        @include('partials.sidebar')
    @elseif (auth()->user()->role === 'student')
        @include('partials.student_sidebar')
    @endif

    <!-- Main Content -->
    <div class="content min-h-screen p-4 md:p-8">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-6 md:p-8">
            <h2 class="text-2xl font-bold mb-6 text-indigo-700">📊 نتيجة الامتحان: {{ $exam->title }}</h2>

            <div class="mb-6 space-y-2 text-gray-700">
                <p>عدد الأسئلة: <span class="font-semibold">{{ $exam->questions->count() }}</span></p>
                <p>عدد الإجابات الصحيحة: <span class="font-semibold">{{ $correctAnswers }}</span></p>
                <p>
                    الدرجة: <span class="font-semibold">{{ $totalScore }} / {{ $totalPossibleScore }}</span>
                    <span class="text-sm text-gray-500 block">(الأسئلة المقالية قد تكون بانتظار التصحيح اليدوي)</span>
                </p>
            </div>

            <!-- Questions Loop -->
            @foreach($detailedResults as $result)
                @php
                    $question = $result['question'];
                    $userAnswer = $result['userAnswer'];
                    $correctOption = $result['correctOption'];
                    $isCorrect = $result['isCorrect'];
                    $isPending = $result['isPending'];
                @endphp

                <div class="rounded-lg p-4 mb-4 shadow-sm
                    @if($question->type === 'essay' && $isPending) border border-blue-500 bg-blue-50
                    @elseif($isCorrect) border border-green-500 bg-green-50
                    @else border border-red-500 bg-red-50 @endif">

                    <h3 class="font-semibold text-lg mb-2">س: {{ $question->question_text }}</h3>
                    <span class="text-sm text-gray-600">(الدرجة: {{ $question->points }})</span>

                    @if($question->type === 'mcq')
                        <ul class="list-disc pr-6 mt-2 space-y-1 text-gray-800">
                            @foreach($question->options as $option)
                                <li
                                    @class([
                                        'text-green-700 font-bold' => $option->id === optional($correctOption)->id,
                                        'text-red-700 line-through' => $userAnswer && $userAnswer->option_id == $option->id && $option->id !== optional($correctOption)->id
                                    ])>
                                    {{ $option->option_text }}
                                    @if($userAnswer && $userAnswer->option_id == $option->id)
                                        <span class="ml-2 text-sm text-blue-600">(إجابتك)</span>
                                    @endif
                                    @if($option->id === optional($correctOption)->id)
                                        <span class="ml-2 text-sm text-green-600">(الصحيحة)</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @elseif($question->type === 'essay')
                        <div class="mt-3">
                            <label class="block text-sm text-gray-600">إجابتك:</label>
                            <div class="border rounded-lg p-3 bg-gray-50 mt-1 text-gray-800">
                                {{ $userAnswer->answer_text ?? 'لم يتم الإجابة' }}
                            </div>
                            @if(auth()->user()->role === 'teacher')
                                <div class="mt-3">
                                    <label class="block text-sm text-gray-600">الإجابة الصحيحة:</label>
                                    <div class="border rounded-lg p-3 bg-gray-50 mt-1 text-gray-800">
                                        {{ $question->essayAnswer->answer_text ?? 'غير محدد' }}
                                    </div>
                                </div>
                            @endif
                            <p class="mt-2 text-sm @if($isPending) text-blue-600 font-medium @elseif($isCorrect) text-green-600 font-medium @else text-red-600 font-medium @endif">
                                الحالة: {{ $isPending ? 'بانتظار التصحيح' : ($isCorrect ? 'صحيح' : 'خاطئ') }}
                                @if($userAnswer && $userAnswer->is_correct !== null)
                                    (الدرجة الممنوحة: {{ $userAnswer->points_earned }})
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            @endforeach

            <div class="text-center mt-6">
                <a href="{{ route('dashboard') }}"
                   class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-indigo-500 transition">
                    العودة للرئيسية
                </a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>
