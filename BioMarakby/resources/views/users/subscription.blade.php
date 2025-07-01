<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الاشتراك</title>
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
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-800">إدارة الاشتراك</h1>
                    <button class="md:hidden text-gray-800 focus:outline-none" id="sidebar-open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-gray-600 mb-4 text-sm sm:text-base">الدورة المسجلة:
                    {{ $user->enrolledCourse?->name ?? 'لا يوجد' }}</p>
                <form method="POST" action="{{ route('users.subscription') }}">
                    @csrf
                    <div class="mb-6">
                        <label for="type" class="block text-gray-700 mb-2 text-sm sm:text-base">نوع الاشتراك</label>
                        <select name="type" id="type"
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                            <option value="monthly"
                                {{ old('type', $subscription?->type) === 'monthly' ? 'selected' : '' }}>شهري</option>
                            <option value="semester"
                                {{ old('type', $subscription?->type) === 'semester' ? 'selected' : '' }}>فصلي</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <input type="hidden" name="course_id" value="{{ $user->course_id }}">
                    <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">تحديث
                        الاشتراك</button>
                </form>
                <a href="{{ route('users.index') }}"
                    class="mt-4 inline-block text-blue-500 hover:text-blue-600 text-center w-full">العودة إلى الطلاب</a>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
