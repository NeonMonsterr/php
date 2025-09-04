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
            position: relative;
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
            pointer-events: none;
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="Background" class="background-gif">

    <div class="flex min-h-screen">
        @if (auth()->user()->role === 'teacher')
        @include('partials.sidebar')
        @elseif (auth()->user()->role === 'student')
        @include('partials.student_sidebar')
        @endif

        <div class="container mx-auto px-4 py-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
                    <h2 class="text-xl font-bold mb-4">نتيجة الامتحان: {{ $exam->title }}</h2>

                    <p class="mb-2">عدد الأسئلة: {{ $exam->questions->count() }}</p>
                    <p class="mb-2">عدد الإجابات الصحيحة: {{ $correctAnswers }}</p>
                    <p class="mb-4">الدرجة: {{ $totalScore  }} / {{ $totalPossibleScore  }}</p>

                    @foreach($detailedResults as $result)
                    @php
                    $question = $result['question'];
                    $userAnswer = $result['userAnswer'];
                    $correctOption = $result['correctOption'];
                    $isCorrect = $result['isCorrect'];
                    @endphp

                    <div class="border rounded-lg p-4 mb-4 {{ $isCorrect ? 'border-green-500 bg-green-50' : 'border-red-500 bg-red-50' }}">
                        <h3 class="font-semibold mb-2">س: {{ $question->question_text }}</h3>
                        <span class="text-sm text-gray-600">(الدرجة: {{ $question->points }})</span>


                        @if($question->type === 'mcq')
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($question->options as $option)
                            <li
                                @class([ 'text-green-700 font-bold'=> $option->id === optional($correctOption)->id,
                                'text-red-700 line-through' => $userAnswer && $userAnswer->option_id == $option->id && $option->id !== optional($correctOption)->id
                                ])
                                >
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
                        <div>
                            <label class="block text-sm text-gray-600">إجابتك:</label>
                            <div class="border rounded-lg p-3 bg-white mt-1 text-gray-800">
                                {{ $userAnswer->answer_text ?? 'لم يتم الإجابة' }}
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach



                    <a href="{{ route('dashboard') }}" class="mt-6 inline-block bg-blue-600 text-white px-4 py-2 rounded">العودة للرئيسية</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
