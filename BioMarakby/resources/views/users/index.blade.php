<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الطلاب</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('partials.sidebar')
        <!-- Main Content -->
        <div class="flex-1 p-6 md:mr-64">
            <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">إدارة الطلاب</h1>
                    <button class="md:hidden text-gray-800 focus:outline-none" id="sidebar-open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <a href="{{ route('users.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-6 inline-block">إضافة طالب جديد</a>
                @if ($students->isEmpty())
                    <p class="text-gray-600">لا يوجد طلاب مسجلين.</p>
                @else
                    <div class="mb-4">
                        <form method="GET" action="{{ route('students.search') }}" class="flex items-center">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="البحث عن الطلاب بالاسم أو البريد الإلكتروني..." class="w-full max-w-md p-2 border border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-l-md hover:bg-blue-600">بحث</button>
                        </form>
                    </div>
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-2 text-right">الاسم</th>
                                <th class="p-2 text-right">البريد الإلكتروني</th>
                                <th class="p-2 text-right">الدورة</th>
                                <th class="p-2 text-right">الاشتراك</th>
                                <th class="p-2 text-right">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr class="border-b">
                                    <td class="p-2">{{ $student->name }}</td>
                                    <td class="p-2">{{ $student->email }}</td>
                                    <td class="p-2">{{ $student->enrolledCourse?->name ?? 'لا يوجد' }}</td>
                                    <td class="p-2">
                                        @can('view', $student->subscription)
                                            {{ $student->subscription?->status ? ($student->subscription->status === 'active' ? 'نشط' : 'غير نشط') : 'لا يوجد' }}
                                            @if ($student->subscription)
                                                ({{ $student->subscription->type === 'monthly' ? 'شهري' : 'فصلي' }})
                                            @endif
                                        @else
                                            لا يوجد
                                        @endcan
                                    </td>
                                    <td class="p-2">
                                        <a href="{{ route('users.show', $student) }}" class="text-blue-500 hover:text-blue-600 mr-2">عرض</a>
                                        <a href="{{ route('users.edit', $student) }}" class="text-green-500 hover:text-green-600 mr-2">تعديل</a>
                                        <form action="{{ route('users.destroy', $student) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-600" onclick="return confirm('هل أنت متأكد من حذف هذا الطالب؟')">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                <a href="{{ route('users.index') }}" class="mt-4 inline-block text-blue-500 hover:text-blue-600">العودة إلى الطلاب</a>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('sidebar-open').addEventListener('click', () => {
            document.querySelector('.bg-gray-800').classList.remove('-translate-x-full');
        });
        document.getElementById('sidebar-toggle').addEventListener('click', () => {
            document.querySelector('.bg-gray-800').classList.add('-translate-x-full');
        });
    </script>
</body>
</html>
