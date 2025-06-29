<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة محاضرة إلى {{ $course->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Tajawal', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        @include('partials.sidebar')
        <div class="flex-1 p-4 sm:p-6">
            <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">إضافة محاضرة إلى {{ $course->name }}</h1>
                @if ($errors->any())
                    <div class="mb-4 text-red-500">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('lectures.store', $course) }}">
                    @csrf
                    <div class="mb-4">
                        <label for="course_id" class="block text-gray-700 mb-2">الدورة</label>
                        <select name="course_id" id="course_id" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">اختر دورة</option>
                            @foreach($courses as $course_option)
                                <option value="{{ $course_option->id }}" {{ old('course_id', $course->id) == $course_option->id ? 'selected' : '' }}>{{ $course_option->name }}</option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 mb-2">العنوان</label>
                        <input type="text" name="title" id="title" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('title') }}" required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="youtube_url" class="block text-gray-700 mb-2">رابط يوتيوب</label>
                        <input type="url" name="youtube_url" id="youtube_url" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('youtube_url') }}" required>
                        @error('youtube_url')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="position" class="block text-gray-700 mb-2">الترتيب</label>
                        <input type="number" name="position" id="position" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('position', $course->lectures()->max('position') + 1) }}" min="0" required>
                        @error('position')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="is_published" class="block text-gray-700 mb-2">منشور</label>
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="h-5 w-5 text-blue-500 focus:ring-blue-500 border-gray-300 rounded">
                        @error('is_published')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">إضافة المحاضرة</button>
                </form>
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
