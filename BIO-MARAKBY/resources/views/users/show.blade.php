<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>الملف الشخصي - {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8fafc;
        }

        .background-gif {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: .06;
            z-index: -1;
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="background" class="background-gif" />

    <div class="flex min-h-screen">
        <!-- ✅ Sidebar always belongs to the logged-in user -->
        @if (auth()->user()->role === 'teacher')
            @include('partials.sidebar')
        @elseif (auth()->user()->role === 'student')
            @include('partials.student_sidebar')
        @endif

        <!-- ✅ Profile content belongs to the profile owner -->
        <div class="flex-1 p-4 sm:p-6 md:mr-64">
            <div class="max-w-2xl mx-auto bg-white rounded-xl shadow-lg p-6 sm:p-8">

                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">👤 الملف الشخصي</h1>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">تسجيل
                            الخروج</button>
                    </form>
                </div>
                @if (auth()->user()->id === $user->id)
                    <div
                        class="mb-6 p-4 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg shadow-sm">
                        @if ($user->role === 'student')
                            <p class="text-lg font-semibold text-blue-800">
                                🎓 مرحباً يا طالب <span class="text-blue-600">{{ $user->name }}</span>!
                            </p>
                            <p class="text-sm text-gray-600 mt-1">سعيدون بعودتك، استعد للتعلم 🚀</p>
                        @else
                            <p class="text-lg font-semibold text-green-800">
                                👨‍🏫 مرحباً أستاذ <span class="text-green-600">{{ $user->name }}</span>!
                            </p>
                            <p class="text-sm text-gray-600 mt-1">نتمنى لك يوماً موفقاً في التدريس 📘</p>
                        @endif
                    </div>
                @endif

                <!-- Student Details -->
                @if ($user->role === 'student')
                    <div class="grid gap-4">
                        <!-- الدورة -->
                        <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg shadow-sm">
                            <p class="text-gray-600">📘 الدورة المسجلة:</p>
                            <p class="font-bold text-blue-700 text-lg">{{ $enrolledCourse?->name ?? 'لا يوجد' }}</p>
                        </div>
                        <!--الارفام-->
                        <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg shadow-sm">
                            <p class="text-gray-600">رقم هاتف الطالب:</p>
                            <p class="font-bold text-green-700">{{ $user->phone_number ?? 'لا يوجد' }}</p>

                            <p class="text-gray-600 mt-2">رقم هاتف ولي أمر الطالب:</p>
                            <p class="font-bold text-green-700">{{ $user->parent_phone_number ?? 'لا يوجد' }}</p>
                        </div>

                        <!-- المرحلة + المستوى -->
                        <div class="bg-green-50 border border-green-200 p-4 rounded-lg shadow-sm">
                            <p class="text-gray-600">🏫 المرحلة:</p>
                            <p class="font-bold text-green-700">{{ $user->stage?->name ?? 'لا يوجد' }}</p>

                            <p class="text-gray-600 mt-2">📚 المستوى:</p>
                            <p class="font-bold text-green-700">{{ $user->level?->name ?? 'لا يوجد' }}</p>
                        </div>

                        <!-- الاشتراك -->
                        <div class="bg-purple-50 border border-purple-200 p-4 rounded-lg shadow-sm">
                            <p class="text-gray-600">💳 الاشتراك:</p>
                            @if ($subscription?->status)
                                <p class="font-bold text-purple-700">
                                    {{ $subscription->status === 'active' ? 'نشط ✅' : 'غير نشط ❌' }}
                                    <span class="text-sm text-gray-600">
                                        ({{ $subscription->type === 'monthly' ? 'شهري' : 'فصلي' }})
                                    </span>
                                </p>
                            @else
                                <p class="font-bold text-purple-700">لا يوجد</p>
                            @endif
                        </div>
                    </div>

                    <!-- روابط سريعة -->
                    <div class="mt-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-3">🔗 روابط سريعة</h2>
                        <div class="flex flex-wrap gap-3">
                            @if ($enrolledCourse)
                                <a href="{{ route('courses.show', $enrolledCourse) }}"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                    📘 عرض الدورة
                                </a>
                            @endif
                            <a href="{{ route('exams.index') }}"
                                class="bg-purple-500 text-white px-4 py-2 rounded-lg hover:bg-purple-600">
                                📝 الامتحانات
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
