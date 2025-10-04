<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>الملف الشخصي - {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
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

        .detail-card {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border: 1px solid rgba(102, 126, 234, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            padding: 1.5rem;
            border-radius: 1rem;
        }

        .detail-card::before {
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

        .detail-card:hover::before {
            opacity: 1;
        }

        .detail-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.15);
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

        /* Quick Links Buttons */
        .quick-link {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            padding: 0.75rem 1.5rem;
            border-radius: 1rem;
            font-weight: 600;
        }

        .quick-link::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.8s, height 0.8s;
        }

        .quick-link:hover::after {
            width: 200px;
            height: 200px;
        }

        /* Logout Button */
        .logout-btn {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #ff5252, #d32f2f);
            transform: translateY(-2px);
        }

        /* Welcome Card */
        .welcome-card {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(139, 92, 246, 0.1));
            border: 1px solid rgba(59, 130, 246, 0.2);
            transition: all 0.3s ease;
        }

        .welcome-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(59, 130, 246, 0.15);
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
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="background" class="background-gif" />

    <!-- Enhanced Decorative Stars -->
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>

    <div class="flex min-h-screen">
        <!-- ✅ Sidebar always belongs to the logged-in user -->
        @if (auth()->user()->role === 'teacher')
            @include('partials.sidebar')
        @elseif (auth()->user()->role === 'student')
            @include('partials.student_sidebar')
        @endif

        <!-- ✅ Profile content belongs to the profile owner -->
        <div class="flex-1 p-4 sm:p-6 md:mr-64 flex flex-col gap-8">
            <div class="card max-w-4xl mx-auto">
                <!-- Header -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <h1 class="section-header">👤 الملف الشخصي</h1>
                    <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                        @csrf
                        <button type="submit" class="logout-btn">🔴 تسجيل الخروج</button>
                    </form>
                </div>

                @if (auth()->user()->id === $user->id)
                    <div class="welcome-card p-6 rounded-2xl mb-6 group">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fas fa-user-circle text-3xl text-blue-500"></i>
                            <div>
                                @if ($user->role === 'student')
                                    <p class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                                        🎓 مرحباً يا طالب {{ $user->name }}!
                                    </p>
                                    <p class="text-sm text-gray-600">سعيدون بعودتك، استعد للتعلم 🚀</p>
                                @else
                                    <p class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-emerald-600">
                                        👨‍🏫 مرحباً أستاذ {{ $user->name }}!
                                    </p>
                                    <p class="text-sm text-gray-600">نتمنى لك يوماً موفقاً في التدريس 📘</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Student Details -->
                @if ($user->role === 'student')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- الدورة -->
                        <div class="detail-card group">
                            <i class="fas fa-book-open text-2xl text-blue-500 mb-3"></i>
                            <p class="text-gray-600 font-medium mb-2">📘 الدورة المسجلة</p>
                            <p class="font-bold text-xl text-blue-600 group-hover:text-blue-700">{{ $enrolledCourse?->name ?? 'لا يوجد' }}</p>
                        </div>

                        <!-- الأرقام -->
                        <div class="detail-card group md:col-span-1">
                            <i class="fas fa-phone text-2xl text-green-500 mb-3"></i>
                            <p class="text-gray-600 font-medium mb-2">📞 الأرقام الهاتفية</p>
                            <p class="font-bold text-green-600 mb-1">رقم هاتف الطالب: {{ $user->phone_number ?? 'لا يوجد' }}</p>
                            <p class="font-bold text-green-600">رقم هاتف ولي الأمر: {{ $user->parent_phone_number ?? 'لا يوجد' }}</p>
                        </div>

                        <!-- المرحلة + المستوى -->
                        <div class="detail-card group md:col-span-1">
                            <i class="fas fa-graduation-cap text-2xl text-green-500 mb-3"></i>
                            <p class="text-gray-600 font-medium mb-2">🏫 المرحلة والمستوى</p>
                            <p class="font-bold text-green-600 mb-1">المرحلة: {{ $user->stage?->name ?? 'لا يوجد' }}</p>
                            <p class="font-bold text-green-600">المستوى: {{ $user->level?->name ?? 'لا يوجد' }}</p>
                        </div>

                        <!-- الاشتراك -->
                        <div class="detail-card group md:col-span-1">
                            <i class="fas fa-crown text-2xl text-purple-500 mb-3"></i>
                            <p class="text-gray-600 font-medium mb-2">💳 الاشتراك</p>
                            @if ($subscription?->status)
                                <p class="font-bold text-purple-600">
                                    {{ $subscription->status === 'active' ? 'نشط ✅' : 'غير نشط ❌' }}
                                    <span class="text-sm text-gray-600 block mt-1">
                                        ({{ $subscription->type === 'monthly' ? 'شهري' : 'فصلي' }})
                                    </span>
                                </p>
                            @else
                                <p class="font-bold text-purple-600">لا يوجد</p>
                            @endif
                        </div>
                    </div>

                    <!-- روابط سريعة -->
                    <div class="mt-8">
                        <h2 class="section-header">🔗 روابط سريعة</h2>
                        <div class="flex flex-wrap gap-4 justify-center">
                            @if ($enrolledCourse)
                                <a href="{{ route('courses.show', $enrolledCourse) }}" class="quick-link text-white flex items-center gap-2">
                                    <i class="fas fa-book"></i> عرض الدورة
                                </a>
                            @endif
                            <a href="{{ route('exams.index') }}" class="quick-link bg-gradient-to-r from-purple-500 to-purple-600 text-white flex items-center gap-2">
                                <i class="fas fa-clipboard-list"></i> الامتحانات
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
        // Light entrance animations
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.card, .detail-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.8s ease';
                    card.style.opacity = '1';
                }, index * 200);
            });
        });
    </script>
</body>

</html>
