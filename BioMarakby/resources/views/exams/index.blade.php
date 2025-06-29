<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الامتحانات</title>
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
                    <h1 class="text-2xl font-bold text-gray-800">الامتحانات</h1>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-600">تسجيل الخروج</button>
                    </form>
                </div>
                <div class="mb-4 flex items-center space-x-4 space-x-reverse">
                    <form method="GET" action="{{ route('exams.index') }}" class="flex items-center flex-1">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="ابحث عن الامتحانات حسب العنوان أو الدورة..." class="w-full max-w-md p-2 border border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-l-md hover:bg-blue-600">بحث</button>
                    </form>
                    @if($user->role === 'teacher')
                        <a href="{{ route('exams.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">إضافة امتحان</a>
                    @endif
                </div>
                @if($exams->isEmpty())
                    <p class="text-gray-600">لا توجد امتحانات متاحة.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="p-2 text-right">العنوان</th>
                                    <th class="p-2 text-right">الدورة</th>
                                    <th class="p-2 text-right">تاريخ الامتحان</th>
                                    <th class="p-2 text-right">منشور</th>
                                    <th class="p-2 text-right">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exams as $exam)
                                    @can('view', $exam)
                                        <tr class="border-b">
                                            <td class="p-2">{{ $exam->title }}</td>
                                            <td class="p-2">{{ $exam->course?->name ?? 'لا يوجد' }}</td>
                                            <td class="p-2">{{ $exam->exam_date->format('Y-m-d') }}</td>
                                            <td class="p-2">{{ $exam->is_published ? 'نعم' : 'لا' }}</td>
                                            <td class="p-2">
                                                <a href="{{ route('exams.show', $exam) }}" class="text-blue-500 hover:text-blue-600 mr-2">عرض</a>
                                                @can('update', $exam)
                                                    <a href="{{ route('exams.edit', $exam) }}" class="text-green-500 hover:text-green-600 mr-2">تعديل</a>
                                                @endcan
                                                @can('delete', $exam)
                                                    <form action="{{ route('exams.destroy', $exam) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-600" onclick="return confirm('هل أنت متأكد من حذف هذا الامتحان؟')">حذف</button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endcan
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
