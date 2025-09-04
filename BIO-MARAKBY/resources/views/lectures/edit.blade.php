<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المحاضرة: {{ $lecture->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: white;
            overflow-x: hidden;
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
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
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
    <img src="/images/biology-bg.gif" alt="Background" class="background-gif" />

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 p-4 sm:p-6 flex items-center justify-center">
            <div class="card w-full">
                <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                    تعديل المحاضرة: {{ $lecture->title }}
                </h1>

                @if ($errors->any())
                <div class="mb-4 text-red-500">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('lectures.update', $lecture) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- الدورة --}}
                    <div class="mb-4">
                        <label for="course_id" class="block text-gray-700 mb-2 font-semibold">الدورة</label>
                        <select name="course_id" id="course_id" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">اختر دورة</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id', $lecture->course_id) == $course->id ? 'selected' : '' }}>
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
                        <input type="text" name="title" id="title"
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('title', $lecture->title) }}" required>
                        @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- رابط يوتيوب --}}
                    <div class="mb-4">
                        <label for="youtube_url" class="block text-gray-700 mb-2 font-semibold">رابط يوتيوب</label>
                        <input type="url" name="youtube_url" id="youtube_url"
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('youtube_url', $lecture->youtube_url) }}" required>
                        @error('youtube_url')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- عرض الملف القديم (لو موجود) --}}
                    @if($lecture->file)
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-semibold">الملف المرفق الحالي:</label>
                        <a href="{{ asset('storage/' . $lecture->file) }}" target="_blank" class="text-blue-600 underline">
                            عرض / تحميل الملف الحالي
                        </a>
                    </div>
                    @endif

                    {{-- رفع ملف جديد --}}
                    <div class="mb-4">
                        <label for="file" class="block text-gray-700 mb-2 font-semibold">تحديث الملف (اختياري):</label>
                        <input type="file" name="file" id="file"
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('file')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- الترتيب --}}
                    <div class="mb-4">
                        <label for="position" class="block text-gray-700 mb-2 font-semibold">الترتيب</label>
                        <input type="number" name="position" id="position" min="0"
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('position', $lecture->position) }}" required>
                        @error('position')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- حالة النشر --}}
                    <div class="mb-6 flex items-center space-x-2 space-x-reverse">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" name="is_published" id="is_published" value="1"
                            {{ old('is_published', $lecture->is_published) ? 'checked' : '' }}
                            class="h-5 w-5 text-blue-500 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_published" class="text-gray-700 font-semibold cursor-pointer select-none">منشور</label>
                        @error('is_published')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- زر الحفظ --}}
                    <button type="submit"
                        class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 font-semibold">
                        تحديث المحاضرة
                    </button>
                </form>

                <a href="{{ route('lectures.index') }}" class="block mt-6 text-center text-blue-500 hover:text-blue-600">
                    العودة إلى المحاضرات
                </a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
