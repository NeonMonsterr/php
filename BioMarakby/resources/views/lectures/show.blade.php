<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الدرس: {{ $lecture->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }

        /* Disable text selection */
        .no-select {
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        @if (auth()->user()->role === 'teacher')
            @include('partials.sidebar')
        @elseif (auth()->user()->role === 'student')
            @include('partials.student_sidebar')
        @endif
        <div class="flex-1 p-4 sm:p-6">
            <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">الدرس: {{ $lecture->title }}</h1>
                <div class="mb-4">
                    <p class="text-gray-700"><strong>الدورة:</strong> {{ $lecture->course?->name ?? 'لا يوجد' }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-700"><strong>العنوان:</strong> {{ $lecture->title }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-700"><strong>الترتيب:</strong> {{ $lecture->position }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-700"><strong>منشور:</strong> {{ $lecture->is_published ? 'نعم' : 'لا' }}</p>
                </div>
                <div class="mb-6 no-select">
                    <iframe id="lecture-video" src="https://www.youtube.com/embed/{{ $videoId }}"
                        class="w-full h-64 md:h-96" frameborder="0" allowfullscreen></iframe>
                </div>
                @can('update', $lecture)
                    <a href="{{ route('lectures.edit', [$lecture->course, $lecture]) }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-2 inline-block">تعديل الدرس</a>
                @endcan
                @can('delete', $lecture)
                    <form action="{{ route('lectures.destroy', $lecture) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                            onclick="return confirm('هل أنت متأكد من حذف هذا الدرس؟')">حذف الدرس</button>
                    </form>
                @endcan
                <a href="{{ route('lectures.index') }}" class="text-blue-500 hover:text-blue-600">العودة إلى
                    المحاضرات</a>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
