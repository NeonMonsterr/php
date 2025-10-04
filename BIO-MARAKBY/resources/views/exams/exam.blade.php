<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>امتحان: {{ $exam->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            min-height: 100vh;
        }

        /* Main content */
        .content {
            transition: margin-right 0.3s ease-in-out;
        }

        @media (min-width: 769px) {
            .content {
                margin-right: 16rem;
                /* w-64 = 256px ≈ 16rem */
            }
        }

        .exam-container {
            max-width: 900px;
            margin: 1.5rem auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 1rem;
            background-color: #ffffff;
        }

        .timer {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            font-weight: 500;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
        }

        .question-card {
            transition: all 0.3s ease;
            border-radius: 0.75rem;
        }

        .question-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .option-label {
            cursor: pointer;
            transition: all 0.2s ease;
            border-radius: 0.5rem;
        }

        .option-label:hover {
            background-color: #f0f4ff;
        }

        .option-input:checked+.option-content {
            background-color: #e0e7ff;
            border-color: #4f46e5;
        }

        .progress-bar {
            height: 8px;
            background-color: #e5e7eb;
            border-radius: 9999px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #4f46e5, #7c3aed);
            transition: width 0.3s ease;
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .exam-container {
                margin: 1rem;
            }

            .question-card {
                padding: 1rem;
            }

            h1 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- Mobile Overlay -->
    <div id="student-sidebar-overlay"
        class="fixed inset-0 bg-black bg-opacity-40 z-20 hidden md:hidden transition-opacity duration-300"></div>

    <!-- Sidebar Component -->
    <div id="student-sidebar"
        class="bg-gradient-to-b from-blue-900 to-blue-700 text-white w-64 space-y-6 py-7 px-2 fixed inset-y-0 right-0 transform translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl z-30 rounded-l-2xl">

        <!-- Header -->
        <div class="flex items-center justify-between px-4 mb-6">
            <h2 class="text-2xl font-bold tracking-wide">لوحة الطالب</h2>
            <button class="md:hidden text-white hover:text-gray-200 focus:outline-none" id="student-sidebar-close">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Navigation -->
        <nav class="px-2 space-y-2">
            @auth
                <a href="{{ route('dashboard') }}"
                    class="flex items-center py-3 px-4 rounded-lg transition duration-200
                      hover:bg-blue-600 hover:shadow-md {{ request()->routeIs('dashboard') ? 'bg-blue-600 shadow-md' : '' }}">
                    🏠 <span class="ml-2">الصفحة الرئيسية</span>
                </a>

                <a href="{{ route('users.show', auth()->user()) }}"
                    class="flex items-center py-3 px-4 rounded-lg transition duration-200
                      hover:bg-blue-600 hover:shadow-md {{ request()->routeIs('users.show') && Route::current()->parameter('user')?->id == auth()->id() ? 'bg-blue-600 shadow-md' : '' }}">
                    🙍‍♂️ <span class="ml-2">الملف الشخصي</span>
                </a>

                @if (auth()->user()->course_id)
                    <a href="{{ route('courses.show', auth()->user()->enrolledCourse) }}"
                        class="flex items-center py-3 px-4 rounded-lg transition duration-200
                      hover:bg-blue-600 hover:shadow-md {{ request()->routeIs('courses.show') ? 'bg-blue-600 shadow-md' : '' }}">
                        📚 <span class="ml-2">عرض الدورة</span>
                    </a>

                    <a href="{{ route('exams.index') }}"
                        class="flex items-center py-3 px-4 rounded-lg transition duration-200
                      hover:bg-blue-600 hover:shadow-md {{ request()->routeIs('exams.index') ? 'bg-blue-600 shadow-md' : '' }}">
                        📝 <span class="ml-2">الامتحانات</span>
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-start py-3 px-4 rounded-lg transition duration-200 hover:bg-red-600 hover:shadow-md">
                        🚪 <span class="ml-2">تسجيل الخروج</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                    class="flex items-center py-3 px-4 rounded-lg transition duration-200
                      hover:bg-blue-600 hover:shadow-md">
                    🔑 <span class="ml-2">تسجيل الدخول</span>
                </a>
            @endauth

            <!-- Footer -->
            <a href="https://www.facebook.com/profile.php?id=61563825393233"
                class="block py-3 px-4 mt-6 text-center text-gray-300 hover:text-white transition duration-200">
                <span class="opacity-80">تم الإنشاء بواسطة</span> <span class="font-semibold">SoftCode</span>
            </a>
        </nav>
    </div>

    <!-- Mobile Toggle Button -->
    <button id="student-sidebar-open"
        class="md:hidden fixed top-4 right-4 bg-blue-600 text-white p-2 rounded-lg shadow-lg hover:bg-blue-500 focus:outline-none z-40 transition duration-200">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
    </button>

    <!-- Main content -->
    <div class="content p-4 sm:p-6 md:p-8">
        <div class="exam-container">
            <!-- Exam Header -->
            <div class="bg-white border-b border-gray-200 p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $exam->title }}</h1>
                    <div class="timer flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span id="countdown">00:00</span>
                    </div>
                </div>
                <div class="mt-3 text-sm text-gray-600">
                    <span>الدورة: {{ $exam->course->name }}</span>
                </div>
                <div class="progress-bar mt-4">
                    <div class="progress-fill" id="exam-progress" style="width: 0%"></div>
                </div>
            </div>

            <!-- Exam Questions -->
            <form id="exam-form" action="{{ route('exams.submit', $exam->id) }}" method="POST">
                @csrf
                <input type="hidden" name="remaining_time" id="remaining-time">

                <div class="p-4 sm:p-6 space-y-6">
                    @if ($exam->questions && $exam->questions->count())
                        @foreach ($exam->questions as $index => $question)
                            <div class="question-card bg-white border border-gray-200 p-4 sm:p-5"
                                id="question-{{ $question->id }}">
                                <div class="flex items-start gap-3">
                                    <span class="bg-blue-100 text-blue-800 font-medium px-3 py-1 rounded-full">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="flex-1">
                                        <h3 class="font-medium text-gray-800 mb-3 text-base sm:text-lg">
                                            {{ $question->question_text }}</h3>

                                        @foreach ($question->images as $image)
                                            <div class="my-3">
                                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                                    alt="صورة السؤال" class="max-w-full h-auto rounded border">
                                            </div>
                                        @endforeach

                                        <div class="space-y-3">
                                            @if ($question->type === 'mcq')
                                                @foreach ($question->options ?? [] as $option)
                                                    <label class="option-label block">
                                                        <input type="radio" name="answers[{{ $question->id }}]"
                                                            value="{{ $option->id }}" class="option-input hidden"
                                                            @if (isset($existingAnswers[$question->id]) && $existingAnswers[$question->id]->option_id == $option->id) checked @endif
                                                            data-question="{{ $question->id }}">
                                                        <div
                                                            class="option-content border border-gray-200 rounded-lg p-3 hover:border-blue-300 text-sm sm:text-base">
                                                            {{ $option->option_text }}
                                                        </div>
                                                    </label>
                                                @endforeach
                                            @elseif($question->type === 'essay')
                                                <textarea name="answers[{{ $question->id }}]" rows="5"
                                                    class="w-full p-3 border rounded-lg text-sm sm:text-base" placeholder="أكتب إجابتك هنا...">
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
                        <p class="text-red-500 text-center">لا توجد أسئلة متاحة لهذا الامتحان حالياً.</p>
                    @endif
                </div>

                <!-- Exam Footer -->
                <div class="bg-gray-50 border-t border-gray-200 p-4 flex justify-end">
                    <button type="button" onclick="confirmSubmit()"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 sm:px-6 py-2 rounded-lg font-medium text-sm sm:text-base">
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

        // Sidebar toggle functionality
        const sidebar = document.getElementById('student-sidebar');
        const overlay = document.getElementById('student-sidebar-overlay');
        const openBtn = document.getElementById('student-sidebar-open');
        const closeBtn = document.getElementById('student-sidebar-close');

        if (openBtn) {
            openBtn.addEventListener('click', () => {
                sidebar.classList.remove('translate-x-full');
                overlay.classList.remove('hidden');
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                sidebar.classList.add('translate-x-full');
                overlay.classList.add('hidden');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.add('translate-x-full');
                overlay.classList.add('hidden');
            });
        }

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
