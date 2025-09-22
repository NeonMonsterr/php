<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>امتحان: {{ $exam->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f5f7fa;
        }

        /* Sidebar offset for content */
        .content {
            margin-right: 16rem;
            /* نفس عرض الشريط الجانبي */
        }

        .exam-container {
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .timer {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            font-weight: bold;
        }

        .question-card {
            transition: all 0.3s ease;
        }

        .question-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .option-label {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .option-label:hover {
            background-color: #f0f4ff;
        }

        .option-input:checked+.option-content {
            background-color: #e0e7ff;
            border-color: #4f46e5;
        }

        .progress-bar {
            height: 6px;
            background-color: #e0e7ff;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #4f46e5, #7c3aed);
            transition: width 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Sidebar -->
    <div class="fixed inset-y-0 right-0 w-64 bg-gray-800 text-white z-20 p-4">
        @if (auth()->check() && auth()->user()->role === 'teacher')
            @include('partials.sidebar')
        @elseif (auth()->check() && auth()->user()->role === 'student')
            @include('partials.student_sidebar')
        @endif
    </div>

    <!-- Main content -->
    <div class="content p-4 md:p-8">
        <div class="exam-container bg-white rounded-xl overflow-hidden">
            <!-- Exam Header -->
            <div class="bg-white border-b border-gray-200 p-4">
                <div class="flex justify-between items-center">
                    <h1 class="text-xl font-bold text-gray-800">{{ $exam->title }}</h1>
                    <div class="timer px-4 py-2 rounded-lg flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span id="countdown">00:00</span>
                    </div>
                </div>
                <div class="mt-2 text-sm text-gray-600">
                    <span>الدورة: {{ $exam->course->name }}</span>
                </div>

                <!-- Progress Bar -->
                <div class="progress-bar mt-3 rounded-full">
                    <div class="progress-fill rounded-full" id="exam-progress" style="width: 0%"></div>
                </div>
            </div>

            <!-- Exam Questions -->
            <form id="exam-form" action="{{ route('exams.submit', $exam->id) }}" method="POST">
                @csrf
                <input type="hidden" name="remaining_time" id="remaining-time">

                <div class="p-4 md:p-6 space-y-6">
                    @if ($exam->questions && $exam->questions->count())
                        @foreach ($exam->questions as $index => $question)
                            <div class="question-card bg-white border border-gray-200 rounded-lg p-5"
                                id="question-{{ $question->id }}">
                                <div class="flex items-start">
                                    <span class="bg-blue-100 text-blue-800 font-medium px-3 py-1 rounded-full mr-3">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-800 mb-3">{{ $question->question_text }}</h3>

                                        @foreach ($question->images as $image)
                                            <div class="my-2">
                                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="صورة السؤال" class="max-w-full h-auto rounded border">

                                            </div>
                                        @endforeach



                                        <div class="space-y-2">
                                            @if ($question->type === 'mcq')
                                                @foreach ($question->options ?? [] as $option)
                                                    <label class="option-label block">
                                                        <input type="radio" name="answers[{{ $question->id }}]"
                                                            value="{{ $option->id }}" class="option-input hidden"
                                                            @if (isset($existingAnswers[$question->id]) && $existingAnswers[$question->id]->option_id == $option->id) checked @endif
                                                            data-question="{{ $question->id }}">
                                                        <div
                                                            class="option-content border border-gray-200 rounded-lg p-3 hover:border-blue-300">
                                                            {{ $option->option_text }}
                                                        </div>
                                                    </label>
                                                @endforeach
                                            @elseif($question->type === 'essay')
                                                <textarea name="answers[{{ $question->id }}]" rows="5" class="w-full p-3 border rounded-lg"
                                                    placeholder="أكتب إجابتك هنا...">
@if (isset($existingAnswers[$question->id]))
{{ $existingAnswers[$question->id]->answer_text }}
@endif
</textarea>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-red-500">لا توجد أسئلة متاحة لهذا الامتحان حالياً.</p>
                    @endif
                </div>

                <!-- Exam Footer -->
                <div class="bg-gray-50 border-t border-gray-200 p-4 flex justify-end">
                    <button type="button" onclick="confirmSubmit()"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium">
                        إنهاء الامتحان
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const examDuration = {{ $exam->duration_minutes }} * 60;
        let timeLeft = localStorage.getItem('remaining_time_{{ $exam->id }}');
        timeLeft = timeLeft !== null ? parseInt(timeLeft) : examDuration;
        let hasSubmitted = false;

        function startTimer() {
            timerInterval = setInterval(() => {
                timeLeft--;
                updateTimerDisplay();
                localStorage.setItem('remaining_time_{{ $exam->id }}', timeLeft);
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    submitExam();
                }
            }, 1000);
        }

        function updateTimerDisplay() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            document.getElementById('countdown').textContent =
                `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            const progressPercent = ((examDuration - timeLeft) / examDuration) * 100;
            document.getElementById('exam-progress').style.width = `${progressPercent}%`;

            if (timeLeft < 300) {
                document.querySelector('.timer').style.background = 'linear-gradient(135deg, #ef4444, #dc2626)';
            }
        }

        async function autoSave() {
            try {
                document.getElementById('remaining-time').value = timeLeft;
                const formData = new FormData(document.getElementById('exam-form'));
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('is_auto_save', true);

                const response = await fetch('{{ route('exams.save_progress', $exam->id) }}', {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    console.log('تم حفظ الإجابات تلقائيًا');
                } else {
                    console.error('فشل في حفظ التقدم');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        async function confirmSubmit() {
            if (confirm('هل أنت متأكد أنك تريد إنهاء الامتحان؟ لا يمكنك العودة بعد الإرسال.')) {
                await autoSave();
                submitExam();
            }
        }

        async function submitExam() {
            if (hasSubmitted) return;
            hasSubmitted = true;

            clearInterval(timerInterval);
            document.getElementById('remaining-time').value = timeLeft;
            localStorage.removeItem('remaining_time_{{ $exam->id }}');

            try {
                const form = document.getElementById('exam-form');
                const formData = new FormData(form);

                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    window.location.href = '{{ route('exams.results', $exam->id) }}';
                } else {
                    alert('حدث خطأ أثناء تقديم الامتحان!');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('حدث خطأ في الاتصال بالخادم!');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateTimerDisplay();
            startTimer();
            setInterval(autoSave, 10000);

            window.addEventListener('beforeunload', (e) => {
                if (!hasSubmitted) {
                    e.preventDefault();
                    e.returnValue = 'لديك امتحان قيد التقدم. هل أنت متأكد أنك تريد المغادرة؟';
                    return e.returnValue;
                }
            });

            document.querySelectorAll('input[type="radio"], textarea').forEach(element => {
                element.addEventListener('change', () => {
                    autoSave();
                });
            });
        });
    </script>

</body>

</html>
