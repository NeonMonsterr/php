<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>لوحة تحكم الطالب</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f0f4f8;
            overflow-x: hidden;
            position: relative;
        }

        .background-gif {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.08;
            z-index: -1;
            pointer-events: none;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            padding: 2rem;
            width: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.2);
        }

        a,
        button {
            transition: all 0.2s ease;
        }

        a:hover,
        button:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        @keyframes sparkle {
            0% { transform: rotate(0deg) scale(1); opacity: 1; }
            50% { transform: rotate(15deg) scale(1.2); opacity: 0.8; }
            100% { transform: rotate(0deg) scale(1); opacity: 1; }
        }

        .sparkle {
            animation: sparkle 1.5s infinite;
        }

        .section-header {
            font-size: 1.5rem;
            font-weight: bold;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
            border-bottom: 2px solid #fcd34d;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .emoji-badge {
            font-size: 1.5rem;
        }

        /* Floating stars background decoration */
        .star {
            position: absolute;
            width: 6px;
            height: 6px;
            background: #facc15;
            border-radius: 50%;
            opacity: 0.8;
            animation: twinkle 3s infinite alternate;
        }

        @keyframes twinkle {
            0% { transform: translateY(0px) scale(1); opacity: 0.5; }
            50% { transform: translateY(-10px) scale(1.2); opacity: 1; }
            100% { transform: translateY(0px) scale(1); opacity: 0.5; }
        }

    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="Biology Background" class="background-gif" />

    <!-- Decorative Stars -->
    <div class="star" style="top:10%; left:15%;"></div>
    <div class="star" style="top:40%; left:80%;"></div>
    <div class="star" style="top:70%; left:25%;"></div>
    <div class="star" style="top:20%; left:50%;"></div>
    <div class="star" style="top:85%; left:70%;"></div>

    <div class="flex min-h-screen">
        @if (auth()->user()->role === 'teacher')
            @include('partials.sidebar')
        @elseif (auth()->user()->role === 'student')
            @include('partials.student_sidebar')
        @endif

        <div class="flex-1 p-4 sm:p-6 flex flex-col gap-6">

            {{-- Welcome / Course Info --}}
            <div class="card max-w-4xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">🎓 لوحة التحكم</h1>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-red-500 hover:text-red-600 font-semibold">
                            🔴 تسجيل الخروج
                        </button>
                    </form>
                </div>

                <p class="text-gray-700 mb-4">مرحباً، <strong>{{ $user->name }}</strong> 👋</p>

                <div class="space-y-2 mb-6">
                    <p class="text-gray-700">📚 الدورة المسجل فيها: <strong>{{ $enrolledCourse?->name ?? 'لا يوجد' }}</strong></p>

                    @if ($enrolledCourse)
                        <p class="text-gray-700">🏫 المرحلة:
                            <strong>
                                @if ($enrolledCourse->stage === 'preparatory') إعدادي
                                @elseif ($enrolledCourse->stage === 'secondary') ثانوي
                                @else غير محدد
                                @endif
                            </strong>
                        </p>

                        <p class="text-gray-700">🎯 المستوى:
                            <strong>
                                @if ((string) $enrolledCourse->level === '1') أولى
                                @elseif ((string) $enrolledCourse->level === '2') تانية
                                @elseif ((string) $enrolledCourse->level === '3') تالتة
                                @else غير محدد
                                @endif
                            </strong>
                        </p>
                    @endif

                    <p class="text-gray-700">💎 الاشتراك:
                        <strong>
                            {{ $subscription?->status === 'active' ? 'نشط' : ($subscription?->status === 'inactive' ? 'غير نشط' : 'لا يوجد') }}
                            ({{ $subscription?->type === 'monthly' ? 'شهري' : ($subscription?->type === 'semester' ? 'فصلي' : 'غير متاح') }})
                        </strong>
                    </p>
                </div>
            </div>

            {{-- Top Students --}}
           @if (isset($topUsers) && $topUsers->count() > 0)
                <div class="max-w-6xl mx-auto card">
                    <h2 class="text-2xl font-bold text-yellow-600 mb-4 flex items-center">
                        🏆 أفضل الطلاب
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @foreach ($topUsers as $index => $top)
                            <div
                                class="bg-white border border-yellow-300 rounded-xl shadow-lg p-5 text-center relative hover:scale-105 transition-transform duration-300">
                                {{-- Badge for position --}}
                                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                                    @if ($index === 0)
                                        <span
                                            class="bg-yellow-400 text-white font-bold px-4 py-1 rounded-full shadow-lg sparkle">🥇</span>
                                    @elseif($index === 1)
                                        <span
                                            class="bg-gray-400 text-white font-bold px-4 py-1 rounded-full shadow-lg">🥈</span>
                                    @elseif($index === 2)
                                        <span
                                            class="bg-orange-500 text-white font-bold px-4 py-1 rounded-full shadow-lg">🥉</span>
                                    @endif
                                </div>

                                {{-- Student Name --}}
                                <h3 class="mt-6 text-lg font-bold text-gray-800">{{ $top->name }}</h3>

                                {{-- Level & Stage --}}
                                <p class="text-gray-600 mt-1">
                                    المستوى: <strong>{{ $top->level_name ?? 'غير محدد' }}</strong> |
                                    المرحلة: <strong>{{ $top->stage_name ?? 'غير محددة' }}</strong>
                                </p>

                                {{-- Average Score --}}
                                <p class="text-gray-700 mt-2">متوسط الدرجات:
                                    <strong>{{ number_format($top->average, 2) }}</strong>
                                </p>

                                {{-- Crown / Sparkle for #1 --}}
                                @if ($index === 0)
                                    <div class="mt-2 text-yellow-500 text-3xl sparkle">👑</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Quick Links --}}
            <div class="card max-w-4xl mx-auto">
                <div class="section-header">⚡ روابط سريعة</div>
                @if ($enrolledCourse)
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <a href="{{ route('courses.show', $enrolledCourse) }}" class="bg-blue-500 text-white text-center py-3 rounded-lg shadow hover:bg-blue-600 flex items-center justify-center gap-2">📖 عرض الدورة</a>
                        <a href="{{ route('exams.index') }}" class="bg-purple-500 text-white text-center py-3 rounded-lg shadow hover:bg-purple-600 flex items-center justify-center gap-2">📝 عرض الامتحانات</a>
                        <a href="{{ route('users.show', $user) }}" class="bg-gray-600 text-white text-center py-3 rounded-lg shadow hover:bg-gray-700 flex items-center justify-center gap-2">👤 الملف الشخصي</a>
                    </div>
                @else
                    <p class="text-gray-600 mb-4">لم تسجل في أي دورة بعد.</p>
                    <a href="{{ route('users.enroll.form') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-600 flex items-center justify-center gap-2">📝 التسجيل في دورة</a>
                @endif
            </div>

        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
