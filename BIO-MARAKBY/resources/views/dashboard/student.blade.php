<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>لوحة تحكم الطالب</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
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
            opacity: 0.1;
            z-index: -1;
            pointer-events: none;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            padding: 2.5rem;
            width: 100%;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c);
            background-size: 300% 300%;
            animation: gradientShift 3s ease infinite;
        }

        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.2);
        }

        a,
        button {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        a::before,
        button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s;
        }

        a:hover::before,
        button:hover::before {
            left: 100%;
        }

        a:hover,
        button:hover {
            transform: translateY(-3px);
            opacity: 0.95;
        }

        .section-header {
            font-size: 1.75rem;
            font-weight: 700;
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
            border-bottom: 3px solid transparent;
            background: linear-gradient(90deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
        }

        .section-header::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transition: width 0.3s ease;
        }

        .section-header:hover::after {
            width: 100%;
        }

        .sparkle {
            animation: sparkle 2s infinite ease-in-out;
        }

        @keyframes sparkle {

            0%,
            100% {
                transform: rotate(0deg) scale(1);
                opacity: 0.7;
                filter: drop-shadow(0 0 5px #f093fb);
            }

            50% {
                transform: rotate(180deg) scale(1.3);
                opacity: 1;
                filter: drop-shadow(0 0 20px #f093fb);
            }
        }

        /* Enhanced Stars */
        .star {
            position: absolute;
            width: 8px;
            height: 8px;
            background: #f093fb;
            border-radius: 50%;
            opacity: 0.6;
            animation: twinkle 4s infinite ease-in-out;
            box-shadow: 0 0 10px rgba(240, 147, 251, 0.5);
        }

        .star:nth-child(1) {
            top: 10%;
            left: 15%;
            animation-delay: 0s;
        }

        .star:nth-child(2) {
            top: 40%;
            left: 80%;
            animation-delay: 1s;
        }

        .star:nth-child(3) {
            top: 70%;
            left: 25%;
            animation-delay: 2s;
        }

        .star:nth-child(4) {
            top: 20%;
            left: 50%;
            animation-delay: 0.5s;
        }

        .star:nth-child(5) {
            top: 85%;
            left: 70%;
            animation-delay: 1.5s;
        }

        .star:nth-child(6) {
            top: 60%;
            left: 10%;
            animation-delay: 2.5s;
        }

        .star:nth-child(7) {
            top: 30%;
            left: 90%;
            animation-delay: 3s;
        }

        @keyframes twinkle {

            0%,
            100% {
                transform: translateY(0px) scale(1) rotate(0deg);
                opacity: 0.6;
            }

            50% {
                transform: translateY(-15px) scale(1.5) rotate(180deg);
                opacity: 1;
            }
        }

        /* Stat Boxes */
        .stat-box {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border: 1px solid rgba(102, 126, 234, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-box:hover::before {
            opacity: 1;
        }

        .stat-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.2);
        }

        /* Top Student Cards */
        .top-student {
            background: linear-gradient(135deg, #fff, #f8f9ff);
            border: 1px solid rgba(240, 147, 251, 0.3);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .top-student::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(transparent, rgba(240, 147, 251, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.4s ease;
            animation: none;
        }

        .top-student:hover::before {
            opacity: 1;
            animation: rotate 2s linear infinite;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .top-student:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 20px 50px rgba(240, 147, 251, 0.3);
        }

        /* Quick Links Buttons */
        .quick-link {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            position: relative;
            overflow: hidden;
        }

        .quick-link::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .quick-link:hover::after {
            width: 300px;
            height: 300px;
        }

        /* Logout Button */
        .logout-btn {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            border: none;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #ff5252, #d32f2f);
        }

        /* Mobile Responsiveness Enhancements */
        @media (max-width: 768px) {
            .card {
                padding: 1.5rem;
                margin: 0 1rem;
            }

            .section-header {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="Background" class="background-gif" />

    <!-- Enhanced Decorative Stars -->
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>

    <div class="flex min-h-screen">
        @if (auth()->user()->role === 'teacher')
            @include('partials.sidebar')
        @elseif (auth()->user()->role === 'student')
            @include('partials.student_sidebar')
        @endif

        <div class="flex-1 p-6 flex flex-col gap-8 md:mr-64">

            <!-- Welcome Card -->
            <div class="card max-w-5xl mx-auto">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <div>
                        <h1
                            class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 mb-2">
                            🎓 مرحباً، {{ $user->name }}!</h1>
                        <p class="text-gray-600 text-lg">استكشف رحلتك التعليمية اليوم ✨</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                        @csrf
                        <button type="submit"
                            class="logout-btn px-6 py-3 text-white font-semibold rounded-xl shadow-lg">🔴 تسجيل
                            الخروج</button>
                    </form>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="stat-box p-6 rounded-xl text-center group">
                        <i class="fas fa-book-open text-3xl text-blue-500 mb-3"></i>
                        <p class="text-gray-600 font-medium">📚 الدورة</p>
                        <p class="text-2xl font-bold text-blue-600 group-hover:text-blue-700">
                            {{ $enrolledCourse?->name ?? 'لا يوجد' }}</p>
                    </div>

                    <div class="stat-box p-6 rounded-xl text-center group">
                        <i class="fas fa-graduation-cap text-3xl text-green-500 mb-3"></i>
                        <p class="text-gray-600 font-medium">🏫 المرحلة</p>
                        <p class="text-2xl font-bold text-green-600 group-hover:text-green-700">
                            {{ $user->level->name ?? 'غير محدد' }}</p>
                    </div>

                    <div class="stat-box p-6 rounded-xl text-center group">
                        <i class="fas fa-chart-line text-3xl text-yellow-500 mb-3"></i>
                        <p class="text-gray-600 font-medium">🎯 المستوى</p>
                        <p class="text-2xl font-bold text-yellow-600 group-hover:text-yellow-700">
                            {{ $user->stage->name ?? 'غير محدد' }}</p>
                    </div>

                    <div class="stat-box p-6 rounded-xl text-center group">
                        <i class="fas fa-crown text-3xl text-purple-500 mb-3"></i>
                        <p class="text-gray-600 font-medium">💎 الاشتراك</p>
                        <p
                            class="text-xl font-bold {{ $subscription?->status === 'active' ? 'text-purple-600' : 'text-red-600' }}">
                            {{ $subscription?->status === 'active' ? 'نشط ✅' : 'غير نشط ❌' }}
                            <br class="sm:hidden"><span
                                class="text-sm">({{ $subscription?->type === 'monthly' ? 'شهري' : 'فصلي' }})</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Top Students -->
            @if (isset($topUsers) && $topUsers->count() > 0)
                <div class="card max-w-6xl mx-auto">
                    <h2 class="section-header">🏆 أفضل الطلاب</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-8">
                        <!-- Added pt-8 to make space for badges -->
                        @foreach ($topUsers->take(3) as $index => $top)
                            <div class="top-student rounded-2xl text-center relative overflow-visible group">
                                <!-- Changed to overflow-visible, added group for hover -->
                                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 z-20">
                                    <!-- Increased -top-8 and z-20 for better visibility -->
                                    @if ($index === 0)
                                        <span
                                            class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white font-bold px-5 py-2 rounded-full shadow-xl inline-block transition-transform duration-300 group-hover:scale-105">🥇
                                            الأول</span>
                                    @elseif($index === 1)
                                        <span
                                            class="bg-gradient-to-r from-gray-400 to-gray-500 text-white font-bold px-5 py-2 rounded-full shadow-xl inline-block transition-transform duration-300 group-hover:scale-105">🥈
                                            الثاني</span>
                                    @elseif($index === 2)
                                        <span
                                            class="bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold px-5 py-2 rounded-full shadow-xl inline-block transition-transform duration-300 group-hover:scale-105">🥉
                                            الثالث</span>
                                    @endif
                                </div>
                                <div class="pt-12 pb-6 transition-all duration-300 group-hover:pt-11">
                                    <!-- Added pt-12 to push content down, avoiding overlap with badge; light hover shift -->
                                    <i
                                        class="fas fa-user-graduate text-5xl text-purple-400 mb-4 transition-transform duration-300 group-hover:scale-110"></i>
                                    <h3
                                        class="text-xl font-bold text-gray-800 mb-2 transition-colors duration-300 group-hover:text-purple-700">
                                        {{ $top->name }}</h3>
                                    <p
                                        class="text-gray-600 mb-3 transition-colors duration-300 group-hover:text-gray-800">
                                        المستوى: <strong
                                            class="text-blue-600">{{ $top->level_name ?? 'غير محدد' }}</strong> |
                                        المرحلة: <strong
                                            class="text-green-600">{{ $top->stage_name ?? 'غير محددة' }}</strong></p>
                                    <p
                                        class="text-2xl font-bold text-gradient bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-4 transition-transform duration-300 group-hover:scale-105">
                                        متوسط الدرجات: {{ number_format($top->average, 2) }}</p>
                                    @if ($index === 0)
                                        <div
                                            class="text-yellow-500 text-4xl mb-2 transition-transform duration-300 group-hover:scale-110">
                                            👑</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Quick Links -->
            <div class="card max-w-5xl mx-auto">
                <h2 class="section-header">⚡ روابط سريعة</h2>
                @if ($enrolledCourse)
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <a href="{{ route('courses.show', $enrolledCourse) }}"
                            class="quick-link text-white py-4 rounded-xl flex items-center justify-center gap-3 font-semibold shadow-lg">
                            <i class="fas fa-book text-xl"></i> عرض الدورة
                        </a>
                        <a href="{{ route('exams.index') }}"
                            class="quick-link bg-gradient-to-r from-purple-500 to-purple-600 text-white py-4 rounded-xl flex items-center justify-center gap-3 font-semibold shadow-lg">
                            <i class="fas fa-clipboard-list text-xl"></i> الامتحانات
                        </a>
                        <a href="{{ route('users.show', $user) }}"
                            class="quick-link bg-gradient-to-r from-gray-600 to-gray-700 text-white py-4 rounded-xl flex items-center justify-center gap-3 font-semibold shadow-lg">
                            <i class="fas fa-user text-xl"></i> الملف الشخصي
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-exclamation-triangle text-6xl text-yellow-500 mb-4"></i>
                        <p class="text-gray-600 text-lg mb-6">لم تسجل في أي دورة بعد.</p>
                        <a href="{{ route('users.enroll.form') }}"
                            class="quick-link bg-gradient-to-r from-blue-500 to-blue-600 text-white py-4 px-8 rounded-xl font-semibold shadow-lg inline-flex items-center gap-3">
                            <i class="fas fa-plus-circle text-xl"></i> التسجيل في دورة
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
        // Add subtle entrance animations
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });
    </script>
</body>

</html>
