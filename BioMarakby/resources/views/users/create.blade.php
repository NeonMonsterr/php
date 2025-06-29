<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء طالب</title>
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
        <div class="flex-1 p-4 sm:p-6 md:mr-64">
            <div class="max-w-md mx-auto bg-white p-6 sm:p-8 rounded-lg shadow-md">
                <!-- Mobile Menu Toggle -->
                <div class="flex justify-between items-center mb-6 md:hidden">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-800">إنشاء طالب</h1>
                    <button class="text-gray-800 focus:outline-none" id="sidebar-open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf
                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 mb-2 text-sm sm:text-base">الاسم</label>
                        <input type="text" name="name" id="name" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 mb-2 text-sm sm:text-base">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('email') }}" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 mb-2 text-sm sm:text-base">كلمة المرور</label>
                        <input type="password" name="password" id="password" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Password Confirmation -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-gray-700 mb-2 text-sm sm:text-base">تأكيد كلمة المرور</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <!-- Course -->
                    <div class="mb-6">
                        <label for="course_id" class="block text-gray-700 mb-2 text-sm sm:text-base">الدورة</label>
                        <select name="course_id" id="course_id" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">لا يوجد</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition">إنشاء طالب</button>
                </form>
                <a href="{{ route('users.index') }}" class="mt-4 inline-block text-blue-500 hover:text-blue-600 text-center w-full">العودة إلى الطلاب</a>
            </div>
        </div>
    </div>
    <script>
        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('sidebar-open');
        const closeBtn = document.getElementById('sidebar-toggle');

        if (openBtn && sidebar) {
            openBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                sidebar.classList.remove('-translate-x-full');
            });
        }

        if (closeBtn && sidebar) {
            closeBtn.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
            });
        }

        document.addEventListener('click', (e) => {
            if (sidebar && !sidebar.contains(e.target) && !openBtn.contains(e.target) && !sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    </script>
