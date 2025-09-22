<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الدورة: {{ $course->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: white;
            overflow: hidden;
            position: relative;
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

        .card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 1rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            padding: 2rem;
        }

        a,
        button {
            transition: all 0.2s ease;
        }

        a:hover {
            opacity: 0.85;
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="Biology Background" class="background-gif">

    <div class="flex min-h-screen">
        @if (auth()->user()->role === 'teacher')
            @include('partials.sidebar')
        @elseif (auth()->user()->role === 'student')
            @include('partials.student_sidebar')
        @endif

        <div class="flex-1 p-4 sm:p-6">
            <div class="max-w-3xl mx-auto card">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $course->name }}</h1>

                <p class="text-gray-700 mb-2"><strong>الوصف:</strong> {{ $course->description }}</p>
                <p class="text-gray-700 mb-2"><strong>المرحلة:</strong>
                    {{ $course->stage === 'preparatory' ? 'إعدادي' : 'ثانوي' }}</p>
                <p class="text-gray-700 mb-2"><strong>المستوى:</strong>
                    {{ $course->level === '1' ? 'الأول' : ($course->level === '2' ? 'الثاني' : 'الثالث') }}</p>
                <p class="text-gray-700 mb-6"><strong>منشور:</strong> {{ $course->is_published ? 'نعم' : 'لا' }}</p>

                @if (auth()->user() && auth()->user()->role === 'teacher')
                    <p class="text-gray-700 mb-6"><strong>أنشأها:</strong> {{ $course->user->name }}</p>
                @endif

                <div class="mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">المحاضرات</h2>
                        @if (auth()->user() && auth()->user()->role === 'teacher')
                            <a href="{{ route('lectures.create', $course) }}"
                                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 font-semibold">
                                إضافة محاضرة
                            </a>
                        @endif
                    </div>
                    @if ($lectures->isEmpty())
                        <p class="text-gray-600">لا توجد محاضرات متاحة لهذه الدورة.</p>
                    @else
                        <ul class="space-y-4">
                            @foreach ($lectures as $lecture)
                                <li class="bg-gray-50 p-4 rounded-lg shadow-sm">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-700">{{ $lecture->title }}</h3>
                                            <p class="text-gray-500 text-sm">الترتيب: {{ $lecture->position }}</p>
                                            @if (auth()->user() && auth()->user()->role === 'teacher')
                                                <p class="text-gray-500 text-sm">الحالة:
                                                    {{ $lecture->is_published ? 'منشور' : 'غير منشور' }}</p>
                                            @endif
                                        </div>
                                        <a href="{{ route('lectures.show', [$lecture->course, $lecture]) }}"
                                            class="btn btn-info">
                                            عرض
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <a href="{{ route('courses.index') }}" class="text-blue-500 hover:text-blue-600">العودة إلى الدورات</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
