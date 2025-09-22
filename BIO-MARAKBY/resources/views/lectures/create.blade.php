<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <title>إضافة محاضرة جديدة</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="max-w-3xl mx-auto py-10">
        <h1 class="text-2xl font-bold mb-6 text-center">إضافة محاضرة جديدة - {{ $course->title }}</h1>

        {{-- رسائل النجاح والأخطاء --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc pr-5">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- الفورم --}}
        <form method="POST" action="{{ route('lectures.store', $course) }}" class="bg-white p-6 rounded shadow">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">عنوان المحاضرة</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-4">
                <label for="position" class="block text-gray-700 mb-2 font-semibold">الترتيب</label>
                <input type="number" name="position" id="position"
                    class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ old('position', $course->lectures()->max('position') + 1) }}" min="0" required>
                @error('position')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4 flex items-center">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                    class="mr-2">
                <label class="text-sm">نشر المحاضرة الآن</label>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('courses.show', $course) }}" class="text-gray-600 hover:underline">⬅ العودة للكورس</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    حفظ المحاضرة
                </button>
            </div>
        </form>
    </div>
</body>

</html>
