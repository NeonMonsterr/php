<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الامتحان: {{ $exam->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', sans-serif; }
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
            <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">الامتحان: {{ $exam->title }}</h1>
                <div class="mb-4">
                    <p class="text-gray-700"><strong>الدورة:</strong> {{ $exam->course?->name ?? 'لا يوجد' }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-700"><strong>العنوان:</strong> {{ $exam->title }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-700"><strong>رابط النموذج:</strong> <a href="{{ $exam->form_url }}" class="text-blue-500 hover:underline" target="_blank">{{ $exam->form_url }}</a></p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-700"><strong>تاريخ الامتحان:</strong> {{ $exam->exam_date->format('Y-m-d') }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-700"><strong>منشور:</strong> {{ $exam->is_published ? 'نعم' : 'لا' }}</p>
                </div>
                @can('update', $exam)
                    <a href="{{ route('exams.edit', $exam) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-2 inline-block">تعديل الامتحان</a>
                @endcan
                @can('delete', $exam)
                    <form action="{{ route('exams.destroy', $exam) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="return confirm('هل أنت متأكد من حذف هذا الامتحان؟')">حذف الامتحان</button>
                    </form>
                @endcan
                @include('partials.back-to-home')
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const toggleButton = document.getElementById('sidebar-toggle');
            toggleButton.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        });
    </script>
</body>
</html>
