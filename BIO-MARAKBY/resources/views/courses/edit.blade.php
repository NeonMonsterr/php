<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل الدورة: {{ $course->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: white;
            position: relative;
            overflow: hidden;
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

        .form-container {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 1rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            transition: transform 0.3s ease;
        }

        .form-container:hover {
            transform: scale(1.01);
        }

        input,
        textarea,
        select {
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid #ccc;
            border-radius: 0.5rem;
            padding: 0.75rem;
            width: 100%;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            outline: none;
        }

        button {
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2563eb;
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="Biology Animation" class="background-gif">

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 p-4 sm:p-6">
            <div class="max-w-md mx-auto form-container">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">تعديل الدورة: {{ $course->name }}</h1>

                @if ($errors->any())
                <div class="mb-4 text-red-500">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('courses.update', $course) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 mb-2">الاسم</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $course->name) }}" required>
                        @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 mb-2">الوصف</label>
                        <textarea name="description" id="description" required>{{ old('description', $course->description) }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="stage" class="block text-gray-700 mb-2">المرحلة</label>
                        <select name="stage" id="stage" required>
                            <option value="preparatory" {{ old('stage', $course->stage) === 'preparatory' ? 'selected' : '' }}>إعدادي</option>
                            <option value="secondary" {{ old('stage', $course->stage) === 'secondary' ? 'selected' : '' }}>ثانوي</option>
                        </select>
                        @error('stage')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="level" class="block text-gray-700 mb-2">المستوى</label>
                        <select name="level" id="level" required>
                            <option value="1" {{ old('level', $course->level) === '1' ? 'selected' : '' }}>الأول</option>
                            <option value="2" {{ old('level', $course->level) === '2' ? 'selected' : '' }}>الثاني</option>
                            <option value="3" {{ old('level', $course->level) === '3' ? 'selected' : '' }}>الثالث</option>
                        </select>
                        @error('level')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_published" value="1" class="ml-2" {{ old('is_published', $course->is_published) ? 'checked' : '' }}>
                            <span class="text-gray-700">نشر الدورة</span>
                        </label>
                        @error('is_published')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">تحديث الدورة</button>
                </form>

                <a href="{{ route('courses.index') }}" class="text-blue-500 hover:text-blue-600 mt-4 inline-block">العودة إلى الدورات</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
