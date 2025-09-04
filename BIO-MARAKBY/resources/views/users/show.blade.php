<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>الملف الشخصي لـ {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: white;
        }

        .background-gif {
            position: fixed;
            top: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.07;
        }

        .glass-box {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            color: #f1f5f9;
        }

        label,
        p {
            color: black;
        }

        .highlight {
            font-weight: bold;
            color: black;
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="background" class="background-gif" />

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="flex min-h-screen">
            @if (auth()->user()->role === 'teacher')
            @include('partials.sidebar')
            @elseif (auth()->user()->role === 'student')
            @include('partials.student_sidebar')
            @endif
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-4 sm:p-6 md:mr-64">
            <div class="max-w-md mx-auto glass-box p-6 sm:p-8">

                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-xl sm:text-2xl font-bold text-black">👤 الملف الشخصي لـ {{ $user->name }}</h1>
                    <button class="md:hidden text-white focus:outline-none" id="sidebar-open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <p class="mb-2 text-sm sm:text-base">الدور: <span class="highlight">
                        {{ $user->role === 'teacher' ? 'معلم 👨‍🏫' : 'طالب 🎓' }}
                    </span></p>

                <p class="mb-2 text-sm sm:text-base">البريد الإلكتروني:
                    <span class="highlight">{{ $user->email }}</span>
                </p>

                @if ($user->role === 'student')
                <p class="mb-2 text-sm sm:text-base">الدورة المسجلة:
                    <span class="highlight">{{ $enrolledCourse?->name ?? 'لا يوجد' }}</span>
                </p>

                <p class="mb-2 text-sm sm:text-base">الاشتراك:
                    @if($subscription?->status)
                    <span class="highlight">
                        {{ $subscription->status === 'active' ? 'نشط ✅' : 'غير نشط ❌' }}
                    </span>
                    <span class="text-xs">({{ $subscription->type === 'monthly' ? 'شهري' : 'فصلي' }})</span>
                    @else
                    <span class="highlight">لا يوجد</span>
                    @endif
                </p>

                @if ($subscription && $subscription->course)
                <p class="mb-6 text-sm sm:text-base">دورة الاشتراك:
                    <span class="highlight">{{ $subscription->course->name }}</span>
                </p>
                @endif
                @endif

                <div class="flex flex-wrap gap-4 mt-4">
                    @if (auth()->user()->role === 'teacher')
                    <a href="{{ route('users.edit', $user) }}"
                        class="bg-gradient-to-r from-gray-500 to-gray-700 text-white px-4 py-2 rounded hover:from-gray-600 hover:to-gray-800 transition">🛠 تعديل الملف الشخصي</a>
                    @endif
                </div>

                @if (auth()->user()->role === 'teacher')
                <a href="{{ route('users.index') }}"
                    class="mt-4 inline-block text-cyan-300 hover:text-cyan-200 text-center w-full text-sm sm:text-base">⬅ العودة إلى الطلاب</a>
                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
