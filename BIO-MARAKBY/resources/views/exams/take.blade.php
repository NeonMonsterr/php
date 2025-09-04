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

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 1rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            padding: 2rem;
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
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold">{{ $exam->title }}</h1>
                    <div class="bg-red-100 text-red-800 px-4 py-2 rounded-lg" id="timer">
                        الوقت المتبقي: <span id="time-display"></span>
                    </div>
                </div>

                <form id="exam-form" action="{{ route('exams.submit', $exam) }}" method="POST">
                    @csrf

                    @foreach($exam->questions as $question)
                    <div class="question mb-8 p-4 border rounded">
                        <h3 class="font-bold mb-3">
                            {{ $loop->iteration }}. {{ $question->question_text }} ({{ $question->points }} نقطة)
                        </h3>

                        @if($question->type === 'mcq')
                        @foreach($question->options as $option)
                        <div class="option mb-2">
                            <label class="flex items-center">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}"
                                    class="mr-2" {{ old("answers.$question->id") == $option->id ? 'checked' : '' }}>
                                {{ $option->option_text }}
                            </label>
                        </div>
                        @endforeach
                        @else
                        <textarea name="answers[{{ $question->id }}]" class="w-full p-2 border rounded" rows="4">{{ old("answers.$question->id") }}</textarea>
                        @endif
                    </div>
                    @endforeach

                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                        إنهاء الامتحان
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // عد تنازلي للوقت
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

        // منع مغادرة الصفحة
        window.addEventListener('beforeunload', function(e) {
            e.preventDefault();
            e.returnValue = 'إذا غادرت الصفحة، قد تفقد إجاباتك!';
        });
    </script>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
