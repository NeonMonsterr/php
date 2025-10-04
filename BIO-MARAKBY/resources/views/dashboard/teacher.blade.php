<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>لوحة تحكم المعلم</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet" />
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
            opacity: 0.08;
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
            transition: all 0.3s ease;
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
            animation: gradientShift 6s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.18);
        }

        a, button {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        a::before, button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }

        a:hover::before, button:hover::before {
            left: 100%;
        }

        a:hover, button:hover {
            transform: translateY(-2px);
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
            transition: all 0.3s ease;
        }

        .section-header::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transition: width 0.4s ease;
        }

        .section-header:hover::after {
            width: 100%;
        }

        /* Stats Boxes */
        .stat-box {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border: 1px solid rgba(102, 126, 234, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-align: center;
            padding: 1.5rem;
            border-radius: 1rem;
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
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.15);
        }

        /* Top Student Cards */
        .top-student {
            background: linear-gradient(135deg, #fff, #f8f9ff);
            border: 1px solid rgba(240, 147, 251, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: visible;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            min-height: 360px;
            padding: 4rem 1.5rem 2rem;
        }

        .top-student::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: conic-gradient(transparent, rgba(240, 147, 251, 0.05), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .top-student:hover::before {
            opacity: 1;
        }

        .top-student:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(240, 147, 251, 0.2);
        }

        .top-student-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            text-align: center;
            gap: 1rem;
        }

        .top-student-info {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            width: 100%;
        }

        .top-student-info p {
            margin: 0;
            text-align: center;
        }

        /* Enhanced Stars - Light twinkle */
        .star {
            position: absolute;
            width: 8px;
            height: 8px;
            background: #f093fb;
            border-radius: 50%;
            opacity: 0.6;
            animation: twinkle 5s infinite ease-in-out;
            box-shadow: 0 0 10px rgba(240, 147, 251, 0.5);
        }

        .star:nth-child(1) { top: 10%; left: 15%; animation-delay: 0s; }
        .star:nth-child(2) { top: 40%; left: 80%; animation-delay: 1s; }
        .star:nth-child(3) { top: 70%; left: 25%; animation-delay: 2s; }
        .star:nth-child(4) { top: 20%; left: 50%; animation-delay: 0.5s; }
        .star:nth-child(5) { top: 85%; left: 70%; animation-delay: 1.5s; }
        .star:nth-child(6) { top: 60%; left: 10%; animation-delay: 2.5s; }
        .star:nth-child(7) { top: 30%; left: 90%; animation-delay: 3s; }

        @keyframes twinkle {
            0%, 100% {
                transform: translateY(0px) scale(1);
                opacity: 0.6;
            }
            50% {
                transform: translateY(-5px) scale(1.1);
                opacity: 0.8;
            }
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .card {
                padding: 1.5rem;
                margin: 0 1rem;
            }
            .section-header {
                font-size: 1.5rem;
            }
            .top-student {
                min-height: 300px;
                padding: 3.5rem 1rem 1.5rem;
            }
            .top-student-info p {
                font-size: 0.875rem;
            }
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="Biology Background" class="background-gif" />

    <!-- Enhanced Decorative Stars -->
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('partials.sidebar', ['user' => $user])

        <!-- Main Content -->
        <div class="flex-1 p-6 md:mr-64 space-y-8">

            <!-- Statistics Card -->
            <div class="card max-w-6xl mx-auto">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <div>
                        <h1 class="section-header">لوحة تحكم المعلم</h1>
                        <p class="text-gray-600 text-lg mt-2">مرحبًا، {{ $user->name }}! 📚</p>
                    </div>
                    <button class="md:hidden text-gray-600 focus:outline-none" id="sidebar-open"
                        aria-label="فتح القائمة الجانبية">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <h2 class="section-header mb-6">📊 الإحصائيات</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="stat-box group">
                        <i class="fas fa-users text-3xl text-blue-500 mb-3"></i>
                        <h3 class="text-lg font-medium text-gray-700 mb-2">إجمالي الطلاب</h3>
                        <p class="text-2xl font-bold text-blue-600 group-hover:text-blue-700">{{ $statistics['students'] ?? 0 }}</p>
                    </div>
                    <div class="stat-box group">
                        <i class="fas fa-book text-3xl text-green-500 mb-3"></i>
                        <h3 class="text-lg font-medium text-gray-700 mb-2">إجمالي الدورات</h3>
                        <p class="text-2xl font-bold text-green-600 group-hover:text-green-700">{{ $statistics['courses'] ?? 0 }}</p>
                    </div>
                    <div class="stat-box group">
                        <i class="fas fa-chalkboard-teacher text-3xl text-yellow-500 mb-3"></i>
                        <h3 class="text-lg font-medium text-gray-700 mb-2">إجمالي الدروس</h3>
                        <p class="text-2xl font-bold text-yellow-600 group-hover:text-yellow-700">{{ $statistics['lectures'] ?? 0 }}</p>
                    </div>
                    <div class="stat-box group">
                        <i class="fas fa-clipboard-list text-3xl text-purple-500 mb-3"></i>
                        <h3 class="text-lg font-medium text-gray-700 mb-2">إجمالي الامتحانات</h3>
                        <p class="text-2xl font-bold text-purple-600 group-hover:text-purple-700">{{ $statistics['exams'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            {{-- Honor Dashboard / Top 3 Students --}}
            @if (isset($topUsers) && $topUsers->count() > 0)
            <div class="card max-w-6xl mx-auto">
                <h2 class="section-header">🏆 أفضل الطلاب</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach ($topUsers->take(3) as $index => $top)
                    <div class="top-student relative group">
                        <div class="absolute -top-8 left-1/2 transform -translate-x-1/2 z-20">
                            @if ($index === 0)
                                <span class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white font-bold px-5 py-2 rounded-full shadow-xl inline-block transition-transform duration-300 group-hover:scale-105">🥇 الأول</span>
                            @elseif($index === 1)
                                <span class="bg-gradient-to-r from-gray-400 to-gray-500 text-white font-bold px-5 py-2 rounded-full shadow-xl inline-block transition-transform duration-300 group-hover:scale-105">🥈 الثاني</span>
                            @elseif($index === 2)
                                <span class="bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold px-5 py-2 rounded-full shadow-xl inline-block transition-transform duration-300 group-hover:scale-105">🥉 الثالث</span>
                            @endif
                        </div>
                        <div class="top-student-content">
                            <i class="fas fa-user-graduate text-5xl text-purple-400 mb-4 transition-transform duration-300 group-hover:scale-110"></i>
                            <h3 class="text-xl font-bold text-gray-800 mb-4 transition-colors duration-300 group-hover:text-purple-700">{{ $top->name }}</h3>
                            <div class="top-student-info">
                                <p class="text-gray-600 text-sm transition-colors duration-300 group-hover:text-gray-800">المستوى: <strong class="text-blue-600">{{ $top->level_name ?? 'غير محدد' }}</strong></p>
                                <p class="text-gray-600 text-sm transition-colors duration-300 group-hover:text-gray-800">المرحلة: <strong class="text-green-600">{{ $top->stage_name ?? 'غير محددة' }}</strong></p>
                            </div>
                            <p class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mt-4 transition-transform duration-300 group-hover:scale-105">متوسط الدرجات: {{ number_format($top->average, 2) }}</p>
                            @if ($index === 0)
                            <div class="text-yellow-500 text-4xl mt-2 transition-transform duration-300 group-hover:scale-110">👑</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
        // Light entrance animations
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.8s ease';
                    card.style.opacity = '1';
                }, index * 300);
            });
        });
    </script>
</body>

</html>
