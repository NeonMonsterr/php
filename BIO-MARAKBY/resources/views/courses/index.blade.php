<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الدورات</title>
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

        .level-header {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border: 1px solid rgba(102, 126, 234, 0.2);
            border-radius: 1rem;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            cursor: default;
        }

        .level-header:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
        }

        .stage-group {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 1rem;
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stage-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 1rem 1.25rem;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .stage-header:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
        }

        .toggle-btn {
            transition: transform 0.3s ease;
            color: rgba(255, 255, 255, 0.8);
        }

        .toggle-btn.rotate {
            transform: rotate(90deg);
        }

        .stage-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease;
        }

        .stage-content.open {
            max-height: 1000px;
        }

        .course-item {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .course-item:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            transform: translateY(-1px);
        }

        .course-name {
            font-weight: 600;
            color: #374151;
        }

        .course-status {
            font-size: 0.875rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-weight: 500;
        }

        .course-status.published {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        .course-status.draft {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .course-actions {
            display: flex;
            gap: 0.75rem;
        }

        .action-link {
            color: #60a5fa;
            font-weight: 500;
            text-decoration: none;
            padding: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .action-link:hover {
            background: #60a5fa;
            color: white;
            transform: translateY(-1px);
        }

        .create-course-btn {
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            border: none;
            color: white;
            padding: 0.875rem 1.5rem;
            border-radius: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            margin-bottom: 1.5rem;
        }

        .create-course-btn:hover {
            background: linear-gradient(135deg, #2563eb, #0891b2);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }

        .return-link {
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

        .return-link:hover {
            background: linear-gradient(135deg, #4b5563, #374151);
            transform: translateY(-2px);
        }

        .empty-state {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border: 1px solid rgba(102, 126, 234, 0.2);
            border-radius: 1.5rem;
            padding: 4rem 2rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .empty-state:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.15);
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
            .stage-header {
                padding: 0.875rem 1rem;
            }
            .course-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }
            .course-actions {
                justify-content: flex-start;
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
        @if(auth()->user()->role === 'teacher')
            @include('partials.sidebar')
        @elseif(auth()->user()->role === 'student')
            @include('partials.student_sidebar')
        @endif

        <div class="flex-1 p-4 md:p-6 md:mr-64 flex flex-col gap-8">
            <div class="card max-w-5xl mx-auto">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="section-header">📚 الدورات</h1>
                    <div class="flex items-center gap-4">
                        <form method="POST" action="{{ route('logout') }}" class="flex-shrink-0">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-600 font-semibold">تسجيل الخروج</button>
                        </form>
                        <button class="md:hidden text-gray-600 focus:outline-none" id="sidebar-open">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- زر إنشاء دورة للمعلم فقط --}}
                @if(auth()->user()->role === 'teacher')
                    <div class="mb-6 text-center">
                        <a href="{{ route('courses.create') }}" class="create-course-btn">
                            <i class="fas fa-plus"></i> إنشاء دورة جديدة
                        </a>
                    </div>
                @endif

                {{-- عرض الدورات --}}
                @forelse($levels as $level)
                    <div class="level-header group">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-chart-line text-xl text-blue-500"></i>
                            <h2 class="text-lg font-bold text-gray-800">المستوى {{ $level->name }}</h2>
                        </div>
                        <span class="text-sm text-gray-600">({{ $level->stages->flatMap->courses->count() }} دورة)</span>
                    </div>
                    @foreach($level->stages as $stage)
                        @if($stage->courses->isNotEmpty())
                            <div class="stage-group">
                                {{-- رأس المرحلة --}}
                                <div class="stage-header" onclick="toggleStage(this)">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-chevron-right toggle-btn"></i>
                                        <span>{{ $stage->name }}</span>
                                    </div>
                                    <span class="text-sm opacity-90">({{ $stage->courses->count() }} دورة)</span>
                                </div>

                                {{-- قائمة الدورات --}}
                                <div class="stage-content">
                                    @foreach($stage->courses as $course)
                                        <div class="course-item group">
                                            <div class="flex items-center gap-3">
                                                <i class="fas fa-book text-blue-500"></i>
                                                <div>
                                                    <span class="course-name">{{ $course->name }}</span>
                                                    @if(auth()->user()->role === 'teacher')
                                                        <span class="course-status {{ $course->is_published ? 'published' : 'draft' }}">
                                                            {{ $course->is_published ? 'منشور' : 'غير منشور' }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="course-actions">
                                                <a href="{{ route('courses.show', $course) }}" class="action-link">
                                                    <i class="fas fa-eye"></i> عرض
                                                </a>
                                                @if(auth()->user()->role === 'teacher')
                                                    <a href="{{ route('courses.edit', $course) }}" class="action-link">
                                                        <i class="fas fa-edit"></i> تعديل
                                                    </a>
                                                    <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="action-link delete-link"
                                                                onclick="return confirm('هل أنت متأكد من حذف هذه الدورة؟')">
                                                            <i class="fas fa-trash"></i> حذف
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                @empty
                    <div class="empty-state text-center group">
                        <i class="fas fa-book-open text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600 text-xl font-semibold mb-2">لا توجد دورات متاحة.</p>
                        <p class="text-gray-500">ابدأ بإنشاء دورة جديدة! ✨</p>
                    </div>
                @endforelse

                <div class="text-center mt-8">
                    <a href="{{ route('dashboard') }}" class="return-link">
                        <i class="fas fa-arrow-right"></i> العودة إلى لوحة التحكم
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
        function toggleStage(header) {
            const content = header.nextElementSibling;
            const icon = header.querySelector('.toggle-btn');
            content.classList.toggle('open');
            icon.classList.toggle('rotate');
        }

        // Light entrance animations
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.level-header, .stage-group, .empty-state');
            elements.forEach((el, index) => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    el.style.transition = 'all 0.6s ease';
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                }, index * 150);
            });
        });
    </script>
</body>

</html>
