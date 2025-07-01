<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي لـ {{ $user->name }}</title>
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
        <div class="flex min-h-screen">
            @if (auth()->user()->role === 'teacher')
                @include('partials.sidebar')
            @elseif (auth()->user()->role === 'student')
                @include('partials.student_sidebar')
            @endif
            <div class="flex-1 p-4 sm:p-6">
                <!-- Your view content here -->
            </div>
        </div>
        <!-- Main Content -->
        <div class="flex-1 p-4 sm:p-6 md:mr-64">
            <div class="max-w-md mx-auto bg-white p-6 sm:p-8 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-800">الملف الشخصي لـ {{ $user->name }}</h1>
                    <button class="md:hidden text-gray-800 focus:outline-none" id="sidebar-open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-gray-600 mb-2 text-sm sm:text-base">الدور:
                    {{ $user->role === 'teacher' ? 'معلم' : 'طالب' }}</p>
                <p class="text-gray-600 mb-2 text-sm sm:text-base">البريد الإلكتروني: {{ $user->email }}</p>
                @if ($user->role === 'student')
                    <p class="text-gray-600 mb-2 text-sm sm:text-base">الدورة المسجلة:
                        {{ $enrolledCourse?->name ?? 'لا يوجد' }}</p>
                    <p class="text-gray-600 mb-6 text-sm sm:text-base">الاشتراك:
                        {{ $subscription?->status ? ($subscription->status === 'active' ? 'نشط' : 'غير نشط') : 'لا يوجد' }}
                        {{ $subscription?->type ? '(' . ($subscription->type === 'monthly' ? 'شهري' : 'سنوي') . ')' : '' }}
                    </p>
                    @if ($subscription && $subscription->course)
                        <p class="text-gray-600 mb-6 text-sm sm:text-base">دورة الاشتراك:
                            {{ $subscription->course->name }}</p>
                    @endif
                @endif
                <div class="flex flex-wrap gap-4">
                    @if (auth()->user()->role === 'teacher')
                        <a href="{{ route('users.edit', $user) }}"
                            class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">تعديل الملف الشخصي</a>
                    @endif

                </div>
                @if (auth()->user()->role === 'teacher')
                    <a href="{{ route('users.index') }}"
                        class="mt-4 inline-block text-blue-500 hover:text-blue-600 text-center w-full text-sm sm:text-base">العودة
                        إلى الطلاب</a>
                @endif
            </div>
        </div>
    </div>
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
