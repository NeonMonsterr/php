<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء دورة</title>
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
            opacity: 0.1;
            z-index: -1;
            pointer-events: none;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
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
            background-color: rgba(255, 255, 255, 0.95);
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
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background-color: #2563eb;
            transform: translateY(-2px);
        }
    </style>
</head>

<body class="bg-gray-100">
    <img src="/images/biology-bg.gif" alt="Biology Animation" class="background-gif">

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 p-4 sm:p-6">
            <div class="max-w-md mx-auto form-container">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">إنشاء دورة</h1>

                {{-- أخطاء التحقق --}}
                @if ($errors->any())
                    <div class="mb-4 text-red-500 bg-red-50 border border-red-200 rounded-lg p-3">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('courses.store') }}">
                    @csrf

                    {{-- الاسم --}}
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 mb-2">الاسم</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- الوصف --}}
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 mb-2">الوصف</label>
                        <textarea name="description" id="description" required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- المرحلة --}}
                    <div class="mb-4">
                        <label for="stage_id" class="block text-gray-700 mb-2">المرحلة</label>
                        <select name="stage_id" id="stage_id" required>
                            <option value="" disabled {{ old('stage_id') ? '' : 'selected' }}>اختر المرحلة</option>
                            @foreach($stages as $stage)
                                <option value="{{ $stage->id }}" {{ old('stage_id') == $stage->id ? 'selected' : '' }}>
                                    {{ $stage->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('stage_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- المستوى --}}
                    <div class="mb-4">
                        <label for="level_id" class="block text-gray-700 mb-2">المستوى</label>
                        <select name="level_id" id="level_id" required>
                            <option value="" disabled {{ old('level_id') ? '' : 'selected' }}>اختر المستوى</option>
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>
                                    {{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('level_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- نشر الدورة --}}
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_published" value="1" class="ml-2"
                                {{ old('is_published') ? 'checked' : '' }}>
                            <span class="text-gray-700">نشر الدورة</span>
                        </label>
                        @error('is_published')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- زر الإنشاء --}}
                    <button type="submit"
                        class="w-full bg-blue-500 text-white p-2 rounded-lg hover:bg-blue-600 font-semibold shadow-md">
                        إنشاء الدورة
                    </button>
                </form>

                <a href="{{ route('courses.index') }}"
                    class="text-blue-500 hover:text-blue-600 mt-4 inline-block font-medium">العودة إلى الدورات</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
