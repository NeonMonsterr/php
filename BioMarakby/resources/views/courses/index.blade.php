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
        #sidebar { transition: transform 0.3s ease-in-out; }
        #sidebar-overlay { transition: opacity 0.3s ease-in-out; }
        @media (max-width: 767px) {
            .responsive-table { display: block; }
            .responsive-table tbody, .responsive-table tr, .responsive-table td { display: block; width: 100%; }
            .responsive-table tr { margin-bottom: 1rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 0.5rem; }
            .responsive-table td { padding: 0.5rem; position: relative; }
            .responsive-table td::before { content: attr(data-label); font-weight: bold; display: block; margin-bottom: 0.25rem; color: #374151; }
            .responsive-table thead { display: none; }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        @if (auth()->user()->role === 'teacher')
            @include('partials.sidebar')
        @elseif (auth()->user()->role === 'student')
            @include('partials.student_sidebar')
        @endif
        <div class="flex-1 p-4 md:p-6 md:mr-64">
            <div class="max-w-4xl mx-auto bg-white p-4 md:p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-xl md:text-2xl font-bold text-gray-800">الدورات</h1>
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-600">تسجيل الخروج</button>
                        </form>
                        <button class="md:hidden text-gray-800 focus:outline-none" id="sidebar-open">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                @if($user->role === 'teacher')
                    <a href="{{ route('courses.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-6 inline-block">إنشاء دورة جديدة</a>
                @endif
                @if($courses->isEmpty())
                    <p class="text-gray-600">لا توجد دورات متاحة.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse responsive-table">
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
                                        <td class="p-2" data-label="الاسم">{{ $course->name }}</td>
                                        <td class="p-2" data-label="المستوى">{{ $course->level === 'preparatory' ? 'إعدادي' : 'ثانوي' }}</td>
                                        <td class="p-2" data-label="منشور">{{ $course->is_published ? 'نعم' : 'لا' }}</td>
                                        <td class="p-2 whitespace-nowrap md:whitespace-normal" data-label="الإجراءات">
                                            <div class="flex flex-col md:flex-row md:space-x-2 md:space-x-reverse">
                                                <a href="{{ route('courses.show', $course) }}" class="text-blue-500 hover:text-blue-600 mb-2 md:mb-0">عرض</a>
                                                @if($user->role === 'teacher')
                                                    <a href="{{ route('courses.edit', $course) }}" class="text-green-500 hover:text-green-600 mb-2 md:mb-0">تعديل</a>
                                                    <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-600" onclick="return confirm('هل أنت متأكد من حذف هذه الدورة؟')">حذف</button>
                                                    </form>
                                                @endif
                                            </div>
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
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>
