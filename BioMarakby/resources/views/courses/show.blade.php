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
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <div class="flex min-h-screen">
            @if (auth()->user()->role === 'teacher')
                @include('partials.sidebar')
            @elseif (auth()->user()->role === 'student')
                @include('partials.student_sidebar')
            @endif
            <div class="flex-1 p-4 sm:p-6">
                <!-- Your view content here -->
            </div>
        </div>
        <div class="flex-1 p-4 sm:p-6">
            <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $course->name }}</h1>
                <p class="text-gray-600 mb-2"><strong>الوصف:</strong> {{ $course->description }}</p>
                <p class="text-gray-600 mb-2"><strong>المستوى:</strong>
                    {{ $course->level === 'preparatory' ? 'إعدادي' : ($course->level === 'secondary' ? 'ثانوي' : 'غير محدد') }}
                </p>
                <p class="text-gray-600 mb-6"><strong>منشور:</strong> {{ $course->is_published ? 'نعم' : 'لا' }}</p>
                @if (auth()->user() && auth()->user()->role === 'teacher')
                    <p class="text-gray-600 mb-6"><strong>أنشأها:</strong> {{ $course->user->name }}</p>
                @endif
                <div class="mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">المحاضرات</h2>
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
                                        <a href="{{ auth()->check() ? route('lectures.show', $lecture) : route('login') }}"
                                            class="text-blue-500 hover:text-blue-600 text-sm">
                                            عرض المحاضرة
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                 @if (auth()->user()->role==='teacher')
                <a href="{{ route('courses.index') }}" class="text-blue-500 hover:text-blue-600">العودة إلى الدورات</a>
                @endif
            </div>
        </div>
    </div>
<script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
