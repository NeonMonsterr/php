<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء دورة</title>
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
                <h1 class="text-2xl font-bold text-gray-800 mb-6">إنشاء دورة</h1>
                @if ($errors->any())
                    <div class="mb-4 text-red-500">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('courses.store') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 mb-2">الاسم</label>
                        <input type="text" name="name" id="name"
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 mb-2">الوصف</label>
                        <textarea name="description" id="description"
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="level" class="block text-gray-700 mb-2">المستوى</label>
                        <select name="level" id="level"
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="preparatory" {{ old('level') === 'preparatory' ? 'selected' : '' }}>إعدادي</option>
                            <option value="secondary" {{ old('level') === 'secondary' ? 'selected' : '' }}>ثانوي</option>
                        </select>
                        @error('level')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
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
                    <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">إنشاء الدورة</button>
                </form>
                <a href="{{ route('courses.index') }}" class="text-blue-500 hover:text-blue-600">العودة إلى الدورات</a>
            </div>
        </div>
    </div>
<script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>
