<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>تعديل الامتحان: {{ $exam->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet" />
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

        .card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 1rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            max-width: 500px;
            margin: auto;
        }

        a,
        button {
            transition: all 0.2s ease;
        }

        a:hover,
        button:hover {
            opacity: 0.85;
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="Biology Background" class="background-gif" />

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 p-6 flex items-center justify-center">
            <div class="card w-full">
                <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">تعديل الامتحان: {{ $exam->title }}</h1>

                {{-- عرض الأخطاء --}}
                @if ($errors->any())
                <div class="mb-4 text-red-600 bg-red-100 border border-red-300 p-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('exams.update', $exam) }}">
                    @csrf
                    @method('PUT')

                    {{-- اختيار الدورة --}}
                    <div class="mb-4">
                        <label for="course_id" class="block text-gray-700 mb-2 font-semibold">الدورة</label>
                        <select name="course_id" id="course_id" required class="w-full p-2 border rounded">
                            <option value="">اختر دورة</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}"
                                {{ old('course_id', $exam->course_id) == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('course_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- العنوان --}}
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 mb-2 font-semibold">العنوان</label>
                        <input type="text" name="title" id="title" required
                            value="{{ old('title', $exam->title) }}"
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- وقت البدء --}}
                    <div class="mb-4">
                        <label for="start_time" class="block text-gray-700 mb-2 font-semibold">وقت البدء</label>
                        <input type="datetime-local" name="start_time" id="start_time" required
                            value="{{ old('start_time', $exam->start_time->format('Y-m-d\TH:i')) }}"
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        @error('start_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- وقت الانتهاء --}}
                    <div class="mb-4">
                        <label for="end_time" class="block text-gray-700 mb-2 font-semibold">وقت الانتهاء</label>
                        <input type="datetime-local" name="end_time" id="end_time" required
                            value="{{ old('end_time', $exam->end_time->format('Y-m-d\TH:i')) }}"
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        @error('end_time')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- مدة الامتحان --}}
                    <div class="mb-4">
                        <label for="duration_minutes" class="block text-gray-700 mb-2 font-semibold">مدة الامتحان (دقائق)</label>
                        <input type="number" name="duration_minutes" id="duration_minutes" min="1" required
                            value="{{ old('duration_minutes', $exam->duration_minutes) }}"
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                        @error('duration_minutes')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- عرض النتيجة مباشرة --}}
                    <div class="mb-4 flex items-center space-x-2 space-x-reverse">
                        <input type="hidden" name="show_score_immediately" value="0" />
                        <input type="checkbox" name="show_score_immediately" id="show_score_immediately" value="1"
                            {{ old('show_score_immediately', $exam->show_score_immediately) ? 'checked' : '' }}
                            class="h-5 w-5 text-blue-500 border-gray-300 rounded" />
                        <label for="show_score_immediately" class="text-gray-700 font-semibold cursor-pointer">عرض النتيجة فوراً</label>
                    </div>

                    {{-- حالة النشر --}}
                    <div class="mb-6 flex items-center space-x-2 space-x-reverse">
                        <input type="hidden" name="is_published" value="0" />
                        <input type="checkbox" name="is_published" id="is_published" value="1"
                            {{ old('is_published', $exam->is_published) ? 'checked' : '' }}
                            class="h-5 w-5 text-blue-500 border-gray-300 rounded" />
                        <label for="is_published" class="text-gray-700 font-semibold cursor-pointer">منشور</label>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 font-semibold transition-transform duration-200 hover:scale-105">
                        تحديث الامتحان
                    </button>
                </form>

                <a href="{{ route('exams.index') }}" class="block mt-6 text-center text-blue-500 hover:text-blue-600">
                    العودة إلى الامتحانات
                </a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
