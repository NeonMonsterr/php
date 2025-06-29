<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المحاضرات</title>
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
            <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">المحاضرات</h1>
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-600">تسجيل الخروج</button>
                        </form>
                    </div>
                </div>
                <div class="mb-4 flex items-center space-x-4 space-x-reverse">
                    <form method="GET" action="{{ route('lectures.index') }}" class="flex items-center flex-1">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="ابحث عن المحاضرات حسب العنوان{{ $user->role === 'teacher' ? ' أو الدورة' : '' }}..." class="w-full max-w-md p-2 border border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-l-md hover:bg-blue-600">بحث</button>
                    </form>
                    @can('create', App\Models\Lecture::class)
                        <a href="{{ route('lectures.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">إضافة درس</a>
                    @endcan
                </div>
                @if (session('success'))
                    <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($lectures->isEmpty())
                    <p class="text-gray-600">لم يتم العثور على محاضرات.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="p-2 text-right">العنوان</th>
                                    <th class="p-2 text-right">الدورة</th>
                                    <th class="p-2 text-right">الترتيب</th>
                                    <th class="p-2 text-right">منشور</th>
                                    @if ($user->role === 'teacher')
                                        <th class="p-2 text-right">الإجراءات</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lectures as $lecture)
                                    <tr class="border-b">
                                        <td class="p-2">
                                            <a href="{{ route('lectures.show', $lecture) }}" class="text-blue-500 hover:underline">{{ $lecture->title }}</a>
                                        </td>
                                        <td class="p-2">{{ $lecture->course?->name ?? 'غير متوفر' }}</td>
                                        <td class="p-2">{{ $lecture->position }}</td>
                                        <td class="p-2">{{ $lecture->is_published ? 'نعم' : 'لا' }}</td>
                                        @if ($user->role === 'teacher')
                                            <td class="p-2">
                                                @can('update', $lecture)
                                                    @if ($lecture->course)
                                                        <a href="{{ route('lectures.edit', [$lecture->course, $lecture]) }}" class="text-blue-500 hover:underline">تعديل</a>
                                                    @else
                                                        <span class="text-gray-500 cursor-not-allowed">تعديل (الدورة غير متوفرة)</span>
                                                    @endif
                                                @endcan
                                                @can('delete', $lecture)
                                                    <form action="{{ route('lectures.destroy', $lecture) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                                                    </form>
                                                @endcan
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
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
