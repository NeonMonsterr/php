<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الطالب</title>
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
                    <h1 class="text-2xl font-bold text-gray-800">لوحة تحكم الطالب</h1>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-600">تسجيل الخروج</button>
                    </form>
                </div>
                <p class="text-gray-600 mb-4">مرحباً، {{ $user->name }}</p>
                <p class="text-gray-600 mb-2">الدورة المسجل فيها: {{ $enrolledCourse?->name ?? 'لا يوجد' }}</p>
                <p class="text-gray-600 mb-6">الاشتراك: {{ $subscription?->status === 'active' ? 'نشط' : ($subscription?->status === 'inactive' ? 'غير نشط' : 'لا يوجد') }}
                    ({{ $subscription?->type === 'monthly' ? 'شهري' : ($subscription?->type === 'semester' ? 'فصلي' : 'غير متاح') }})</p>
                @if ($enrolledCourse)
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">روابط سريعة</h2>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('courses.show', $enrolledCourse) }}"
                               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">عرض الدورة</a>
                            <a href="{{ route('lectures.index') }}"
                               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">عرض الدروس</a>
                            <a href="{{ route('exams.index') }}"
                               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">عرض الامتحانات</a>
                            <a href="{{ route('users.show', $user) }}"
                               class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">عرض الملف الشخصي</a>
                        </div>
                    </div>
                @else
                    <div class="mb-6">
                        <p class="text-gray-600 mb-4">لم تسجل في أي دورة بعد.</p>
                        <a href="{{ route('users.enroll.form') }}"
                           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">التسجيل في دورة</a>
                    </div>
                @endif
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
