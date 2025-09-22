<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الامتحان: {{ $exam->title }}</title>
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
            pointer-events: none;
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="Background" class="background-gif">

    <div class="flex min-h-screen flex-col md:flex-row">
        <!-- Sidebar -->
        <div class="w-full md:w-64 flex-shrink-0">
            @if (auth()->user()->role === 'teacher')
                @include('partials.sidebar')
            @elseif (auth()->user()->role === 'student')
                @include('partials.student_sidebar')
            @endif
        </div>

        <!-- Main Content -->
        <main class="flex-1 p-4 sm:p-6">
            <div class="bg-white/90 backdrop-blur-md rounded-lg shadow-lg p-6 max-w-4xl mx-auto">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-800">{{ $exam->title }}</h1>
                    <div class="bg-red-100 text-red-800 px-4 py-2 rounded-lg w-full sm:w-auto text-center sm:text-right">
                        الوقت المتبقي: <span id="time-display"></span>
                    </div>
                </div>

                <!-- Exam Form -->
                <form id="exam-form" action="{{ route('exams.submit', $exam) }}" method="POST" class="space-y-6">
                    @csrf

                    @foreach($exam->questions as $question)
                        <div class="question p-4 border rounded-lg bg-gray-50">
                            <h3 class="font-bold mb-3 text-gray-800">
                                {{ $loop->iteration }}. {{ $question->question_text }}
                                <span class="text-sm text-gray-600">({{ $question->points }} نقطة)</span>
                            </h3>

                            @if($question->type === 'mcq')
                                <div class="space-y-2">
                                    @foreach($question->options as $option)
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio"
                                                   name="answers[{{ $question->id }}]"
                                                   value="{{ $option->id }}"
                                                   class="text-blue-500 focus:ring focus:ring-blue-300"
                                                   {{ old("answers.$question->id") == $option->id ? 'checked' : '' }}>
                                            <span>{{ $option->option_text }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <textarea name="answers[{{ $question->id }}]"
                                          class="w-full p-3 border rounded-lg focus:ring focus:ring-blue-300"
                                          rows="4">{{ old("answers.$question->id") }}</textarea>
                            @endif
                        </div>
                    @endforeach

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit"
                                class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 text-lg font-medium w-full sm:w-auto">
                            إنهاء الامتحان
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Timer Script -->
    <script>
        const examEndTime = new Date("{{ $exam->end_time->format('Y-m-d H:i:s') }}").getTime();
        const timer = setInterval(() => {
            const now = new Date().getTime();
            const distance = examEndTime - now;

            if (distance <= 0) {
                clearInterval(timer);
                document.getElementById('time-display').innerHTML = "انتهى الوقت!";
                document.getElementById('exam-form').submit();
            } else {
                const hours = Math.floor(distance / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById('time-display').innerHTML =
                    `${hours}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
        }, 1000);

        // Prevent leaving page
        window.addEventListener('beforeunload', function(e) {
            e.preventDefault();
            e.returnValue = 'إذا غادرت الصفحة، قد تفقد إجاباتك!';
        });
    </script>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>
