<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>قائمة الامتحانات</title>
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
            justify-content: center;
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

        .course-group {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .course-group:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
        }

        .course-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 1.25rem;
            font-weight: 600;
            font-size: 1.125rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .course-header:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
        }

        .exam-item {
            display: grid;
            grid-template-columns: 1fr auto auto auto;
            gap: 1rem;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .exam-item:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            transform: translateY(-1px);
        }

        .exam-title {
            font-weight: 600;
            color: #374151;
        }

        .exam-date {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .action-btn {
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .action-btn:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .teacher-actions {
            display: flex;
            gap: 0.5rem;
        }

        .edit-btn {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .edit-btn:hover {
            background: linear-gradient(135deg, #d97706, #b45309);
        }

        .delete-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        .delete-btn:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
        }

        .add-exam-btn {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            margin-top: 2rem;
        }

        .add-exam-btn:hover {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
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
            .course-group {
                margin-bottom: 1rem;
            }
            .exam-item {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
            .teacher-actions {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <!-- Background -->
    <img src="/images/biology-bg.gif" alt="Background" class="background-gif" />

    <!-- Enhanced Decorative Stars -->
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>

    <!-- Sidebar include (has sidebar + overlay + toggle btn) -->
    @if (auth()->check() && auth()->user()->role === 'teacher')
        @include('partials.sidebar')
    @elseif (auth()->check() && auth()->user()->role === 'student')
        @include('partials.student_sidebar')
    @endif

    <!-- Main content -->
    <div class="p-6 md:mr-64 flex flex-col gap-8">
        <div class="card max-w-6xl mx-auto">
            <h1 class="section-header">
                <i class="fas fa-clipboard-list"></i> قائمة الامتحانات
            </h1>

            @if ($courses->isEmpty())
                <div class="empty-state text-center group">
                    <i class="fas fa-exclamation-triangle text-6xl text-yellow-500 mb-4"></i>
                    <p class="text-gray-600 text-xl font-semibold mb-2">لا يوجد امتحانات حتى الآن.</p>
                    <p class="text-gray-500">ابدأ بإضافة امتحان جديد لتبدأ الرحلة! 🚀</p>
                </div>
            @else
                @foreach ($courses as $course)
                    @if ($course->exams->count() > 0)
                        <div class="course-group">
                            <div class="course-header">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-book"></i>
                                    <span>{{ $course->name }}</span>
                                    <span class="text-sm opacity-90">({{ $course->exams->count() }} امتحان)</span>
                                </div>
                                @if (auth()->user()->role === 'teacher')
                                    <a href="{{ route('exams.create', $course) }}" class="action-btn text-xs">
                                        <i class="fas fa-plus"></i> إضافة امتحان
                                    </a>
                                @endif
                            </div>
                            <div class="divide-y divide-gray-100">
                                @foreach ($course->exams as $exam)
                                    <div class="exam-item group">
                                        <div class="flex flex-col">
                                            <div class="exam-title">{{ $exam->title }}</div>
                                            <div class="exam-date text-sm text-gray-500">
                                                {{ optional($exam->start_time)->format('Y-m-d') ?? 'غير محدد' }}
                                                <i class="fas fa-arrow-left mx-1"></i>
                                                {{ optional($exam->end_time)->format('Y-m-d') ?? 'غير محدد' }}
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                                {{ $exam->is_published ? 'منشور' : 'غير منشور' }}
                                            </span>
                                        </div>
                                        @if (auth()->user()->role === 'student' && !$exam->is_published)
                                            <div class="text-center text-gray-400 text-sm">غير متاح</div>
                                        @else
                                            <div class="text-center">
                                                <a href="{{ route('exams.show', $exam) }}" class="action-btn">
                                                    <i class="fas fa-eye"></i> عرض
                                                </a>
                                            </div>
                                        @endif
                                        @if (auth()->user()->role === 'teacher')
                                            <div class="teacher-actions">
                                                <a href="{{ route('exams.edit', $exam) }}" class="action-btn edit-btn text-xs">
                                                    <i class="fas fa-edit"></i> تعديل
                                                </a>
                                                <form action="{{ route('exams.destroy', $exam) }}" method="POST"
                                                    onsubmit="return confirm('هل أنت متأكد من حذف الامتحان؟');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="delete-btn action-btn text-xs">
                                                        <i class="fas fa-trash"></i> حذف
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif

            <!-- Teacher actions -->
            @if (auth()->check() && auth()->user()->role === 'teacher')
                <div class="text-center mt-8">
                    <a href="{{ route('exams.create') }}" class="add-exam-btn">
                        <i class="fas fa-plus"></i> إضافة امتحان جديد
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Sidebar script -->
    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
        // Light entrance animations
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.card, .course-group, .empty-state');
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
