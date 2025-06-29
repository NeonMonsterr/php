<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الدورات</title>
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
                    <h1 class="text-2xl font-bold text-gray-800">الدورات</h1>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-600">تسجيل الخروج</button>
                    </form>
                </div>
                @if($user->role === 'teacher')
                    <a href="{{ route('courses.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-6 inline-block">إنشاء دورة جديدة</a>
                @endif
                @if($courses->isEmpty())
                    <p class="text-gray-600">لا توجد دورات متاحة.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="p-2 text-right">الاسم</th>
                                    <th class="p-2 text-right">المستوى</th>
                                    <th class="p-2 text-right">منشور</th>
                                    <th class="p-2 text-right">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $course)
                                    <tr class="border-b">
                                        <td class="p-2">{{ $course->name }}</td>
                                        <td class="p-2">{{ $course->level === 'preparatory' ? 'إعدادي' : 'ثانوي' }}</td>
                                        <td class="p-2">{{ $course->is_published ? 'نعم' : 'لا' }}</td>
                                        <td class="p-2">
                                            <a href="{{ route('courses.show', $course) }}" class="text-blue-500 hover:text-blue-600 mr-2">عرض</a>
                                            @if($user->role === 'teacher')
                                                <a href="{{ route('courses.edit', $course) }}" class="text-green-500 hover:text-green-600 mr-2">تعديل</a>
                                                <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-500 hover:text-red-600" onclick="return confirm('هل أنت متأكد من حذف هذه الدورة؟')">حذف</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <a href="{{ route('dashboard') }}" class="mt-6 inline-block text-blue-500 hover:text-blue-600">العودة إلى لوحة التحكم</a>
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
