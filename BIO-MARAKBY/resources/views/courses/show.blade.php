<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الدورة: {{ $course->name }}</title>
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

        .info-item {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border: 1px solid rgba(102, 126, 234, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            padding: 1.5rem;
            border-radius: 1rem;
            margin-bottom: 1rem;
        }

        .info-item::before {
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

        .info-item:hover::before {
            opacity: 1;
        }

        .info-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.15);
        }

        .lecture-item {
            background: linear-gradient(135deg, #fff, #f8f9ff);
            border: 1px solid rgba(240, 147, 251, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            padding: 1.5rem;
            border-radius: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .lecture-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(240, 147, 251, 0.15);
        }

        .add-lecture-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .add-lecture-btn:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
            transform: translateY(-2px);
        }

        .view-lecture-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .view-lecture-btn:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
            transform: translateY(-2px);
        }

        .back-btn {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, #4b5563, #374151);
            transform: translateY(-2px);
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
            .lecture-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="Biology Background" class="background-gif">

    <!-- Enhanced Decorative Stars -->
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>

    <div class="flex min-h-screen">
        {{-- Sidebar based on role --}}
        @if (auth()->user()->role === 'teacher')
            @include('partials.sidebar')
        @elseif (auth()->user()->role === 'student')
            @include('partials.student_sidebar')
        @endif

        <div class="flex-1 p-4 sm:p-6 md:mr-64 flex flex-col gap-8">
            <div class="card max-w-4xl mx-auto">
                <h1 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 mb-6 text-center">
                    {{ $course->name }}
                </h1>

                {{-- Course Info --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="info-item group">
                        <i class="fas fa-align-left text-2xl text-blue-500 mb-3"></i>
                        <p class="text-gray-600 font-medium mb-2">📝 الوصف</p>
                        <p class="font-bold text-blue-600 group-hover:text-blue-700">{{ $course->description }}</p>
                    </div>
                    <div class="info-item group">
                        <i class="fas fa-graduation-cap text-2xl text-green-500 mb-3"></i>
                        <p class="text-gray-600 font-medium mb-2">🏫 المرحلة</p>
                        <p class="font-bold text-green-600 group-hover:text-green-700">{{ $course->stage->name ?? 'غير محدد' }}</p>
                    </div>
                    <div class="info-item group">
                        <i class="fas fa-chart-line text-2xl text-yellow-500 mb-3"></i>
                        <p class="text-gray-600 font-medium mb-2">📊 المستوى</p>
                        <p class="font-bold text-yellow-600 group-hover:text-yellow-700">{{ $course->level->name ?? 'غير محدد' }}</p>
                    </div>
                    <div class="info-item group">
                        <i class="fas fa-eye text-2xl text-purple-500 mb-3"></i>
                        <p class="text-gray-600 font-medium mb-2">👁️ الحالة</p>
                        <p class="font-bold text-purple-600 group-hover:text-purple-700">{{ $course->is_published ? 'منشور ✅' : 'غير منشور ❌' }}</p>
                    </div>
                </div>

                @if (auth()->user() && auth()->user()->role === 'teacher')
                    <div class="info-item group mb-8">
                        <i class="fas fa-user-tie text-2xl text-indigo-500 mb-3"></i>
                        <p class="text-gray-600 font-medium mb-2">👨‍🏫 أنشأها</p>
                        <p class="font-bold text-indigo-600 group-hover:text-indigo-700">{{ $course->user->name }}</p>
                    </div>
                @endif

                {{-- Lectures --}}
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="section-header">📚 المحاضرات</h2>
                        @if (auth()->user() && auth()->user()->role === 'teacher')
                            <a href="{{ route('lectures.create', $course) }}" class="add-lecture-btn">
                                <i class="fas fa-plus"></i> إضافة محاضرة
                            </a>
                        @endif
                    </div>

                    @if ($lectures->isEmpty())
                        <div class="text-center py-12">
                            <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-600 text-lg">لا توجد محاضرات متاحة لهذه الدورة.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach ($lectures as $lecture)
                                <div class="lecture-item group">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-bold text-gray-800 mb-1 group-hover:text-purple-700">{{ $lecture->title }}</h3>
                                        <p class="text-gray-600 text-sm mb-1">الترتيب: <strong class="text-blue-600">{{ $lecture->position }}</strong></p>
                                        @if (auth()->user()->role === 'teacher')
                                            <p class="text-gray-600 text-sm">الحالة: <strong class="{{ $lecture->is_published ? 'text-green-600' : 'text-red-600' }}">{{ $lecture->is_published ? 'منشور' : 'غير منشور' }}</strong></p>
                                        @endif
                                    </div>
                                    <a href="{{ route('lectures.show', [$course, $lecture]) }}" class="view-lecture-btn">
                                        <i class="fas fa-eye"></i> عرض
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="text-center">
                    <a href="{{ route('courses.index') }}" class="back-btn">
                        <i class="fas fa-arrow-right"></i> العودة إلى الدورات
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
        // Light entrance animations
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.card, .info-item, .lecture-item');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 150);
            });
        });
    </script>
</body>
</html>
