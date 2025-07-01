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
                    <h1 class="text-xl md:text-2xl font-bold text-gray-800">الامتحانات</h1>
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
                        <table class="w-full border-collapse responsive-table">
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
                                            <td class="p-2" data-label="العنوان">{{ $exam->title }}</td>
                                            <td class="p-2" data-label="الدورة">{{ $exam->course?->name ?? 'لا يوجد' }}</td>
                                            <td class="p-2" data-label="تاريخ الامتحان">{{ $exam->exam_date->format('Y-m-d') }}</td>
                                            <td class="p-2" data-label="منشور">{{ $exam->is_published ? 'نعم' : 'لا' }}</td>
                                            <td class="p-2 whitespace-nowrap md:whitespace-normal" data-label="الإجراءات">
                                                <div class="flex flex-col md:flex-row md:space-x-2 md:space-x-reverse">
                                                    <a href="{{ route('exams.show', $exam) }}" class="text-blue-500 hover:text-blue-600 mb-2 md:mb-0">عرض</a>
                                                    @can('update', $exam)
                                                        <a href="{{ route('exams.edit', $exam) }}" class="text-green-500 hover:text-green-600 mb-2 md:mb-0">تعديل</a>
                                                    @endcan
                                                    @can('delete', $exam)
                                                        <form action="{{ route('exams.destroy', $exam) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-500 hover:text-red-600" onclick="return confirm('هل أنت متأكد من حذف هذا الامتحان؟')">حذف</button>
                                                        </form>
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                    @endcan
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>
