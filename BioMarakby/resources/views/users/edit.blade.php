<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المستخدم: {{ $user->name }}</title>
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
            <div class="max-w-4xl mx-auto bg-white p-6 sm:p-8 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-800">تعديل المستخدم: {{ $user->name }}</h1>
                    <button class="md:hidden text-gray-800 focus:outline-none" id="sidebar-open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                @if ($errors->any())
                    <div class="mb-6 text-red-500 text-sm sm:text-base">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    <div class="flex flex-col lg:flex-row lg:space-x-6 lg:space-x-reverse">
                        <!-- User Details Container -->
                        <div class="w-full lg:w-1/2 mb-6 lg:mb-0">
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4">تفاصيل المستخدم</h2>
                            <div class="mb-4">
                                <label for="name" class="block text-gray-700 mb-2 text-sm sm:text-base">الاسم</label>
                                <input type="text" name="name" id="name" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-gray-700 mb-2 text-sm sm:text-base">البريد الإلكتروني</label>
                                <input type="email" name="email" id="email" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password" class="block text-gray-700 mb-2 text-sm sm:text-base">كلمة المرور (اتركه فارغًا للاحتفاظ بالحالية)</label>
                                <input type="password" name="password" id="password" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="password_confirmation" class="block text-gray-700 mb-2 text-sm sm:text-base">تأكيد كلمة المرور</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div class="mb-4">
                                <label for="role" class="block text-gray-700 mb-2 text-sm sm:text-base">الدور</label>
                                <select name="role" id="role" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    <option value="student" {{ old('role', $user->role) === 'student' ? 'selected' : '' }}>طالب</option>
                                    <option value="teacher" {{ old('role', $user->role) === 'teacher' ? 'selected' : '' }}>معلم</option>
                                </select>
                                @error('role')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="course_id" class="block text-gray-700 mb-2 text-sm sm:text-base">الدورة المسجلة</label>
                                <select name="course_id" id="course_id" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">لا يوجد</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id', $user->course_id) == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <!-- Dividing Line -->
                        @if($user->role === 'student' || old('role', $user->role) === 'student')
                            <div class="hidden lg:block w-px bg-gradient-to-b from-blue-300 to-blue-500 shadow-sm mx-6"></div>
                            <!-- Subscription Details Container -->
                            <div class="w-full lg:w-1/2">
                                <h2 class="text-lg sm:text-xl font-semibold text-gray-800 mb-4">تفاصيل الاشتراك</h2>
                                <div class="mb-4">
                                    <label for="subscription_type" class="block text-gray-700 mb-2 text-sm sm:text-base">نوع الاشتراك</label>
                                    <select name="subscription_type" id="subscription_type" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">لا يوجد</option>
                                        <option value="monthly" {{ old('subscription_type', $user->subscription?->type) === 'monthly' ? 'selected' : '' }}>شهري</option>
                                        <option value="semester" {{ old('subscription_type', $user->subscription?->type) === 'semester' ? 'selected' : '' }}>فصلي</option>
                                    </select>
                                    @error('subscription_type')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="subscription_status" class="block text-gray-700 mb-2 text-sm sm:text-base">حالة الاشتراك</label>
                                    <select name="subscription_status" id="subscription_status" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">لا يوجد</option>
                                        <option value="active" {{ old('subscription_status', $user->subscription?->status) === 'active' ? 'selected' : '' }}>نشط</option>
                                        <option value="expired" {{ old('subscription_status', $user->subscription?->status) === 'expired' ? 'selected' : '' }}>منتهي</option>
                                        <option value="canceled" {{ old('subscription_status', $user->subscription?->status) === 'canceled' ? 'selected' : '' }}>ملغي</option>
                                    </select>
                                    @error('subscription_status')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="subscription_course_id" class="block text-gray-700 mb-2 text-sm sm:text-base">دورة الاشتراك</label>
                                    <select name="subscription_course_id" id="subscription_course_id" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">لا يوجد</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{ old('subscription_course_id', $user->subscription?->course_id) == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('subscription_course_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="subscription_start_date" class="block text-gray-700 mb-2 text-sm sm:text-base">تاريخ البدء</label>
                                    <input type="date" name="subscription_start_date" id="subscription_start_date" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('subscription_start_date', $user->subscription?->start_date?->format('Y-m-d')) }}">
                                    @error('subscription_start_date')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="subscription_end_date" class="block text-gray-700 mb-2 text-sm sm:text-base">تاريخ الانتهاء</label>
                                    <input type="date" name="subscription_end_date" id="subscription_end_date" class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ old('subscription_end_date', $user->subscription?->end_date?->format('Y-m-d')) }}">
                                    @error('subscription_end_date')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600 mt-6">تحديث المستخدم</button>
                </form>
                <a href="{{ route('users.index') }}" class="mt-4 inline-block text-blue-500 hover:text-blue-600 text-center w-full">العودة إلى الطلاب</a>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>
