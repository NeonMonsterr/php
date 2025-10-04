<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>إدارة الطلاب</title>
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
            color: #111827;
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

        .add-student-btn {
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
        }

        .add-student-btn:hover {
            background: linear-gradient(135deg, #2563eb, #0891b2);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }

        .search-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.8), rgba(248, 250, 252, 0.8));
            border: 1px solid rgba(102, 126, 234, 0.3);
            border-radius: 1rem;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .search-container:focus-within {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 0.75rem 1rem;
            background: transparent;
            color: #2d3748;
            font-size: 1rem;
        }

        .search-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .search-btn:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
            transform: translateY(-2px);
        }

        .table-container {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 1.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
            max-height: 600px;
            overflow-y: auto;
        }

        .table-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table-row {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .table-row:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05));
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
        }

        .action-link {
            color: #60a5fa;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 0.25rem 0.5rem;
            border-radius: 0.5rem;
        }

        .action-link:hover {
            background: #60a5fa;
            color: white;
            transform: translateY(-1px);
        }

        .delete-link {
            color: #ef4444;
        }

        .delete-link:hover {
            background: #ef4444;
            color: white;
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
        @media (max-width: 767px) {
            .responsive-table {
                display: block;
            }

            .responsive-table tbody,
            .responsive-table tr,
            .responsive-table td {
                display: block;
                width: 100%;
            }

            .responsive-table tr {
                margin-bottom: 1rem;
                border: 1px solid rgba(102, 126, 234, 0.2);
                border-radius: 1rem;
                padding: 1rem;
                background: rgba(255, 255, 255, 0.9);
            }

            .responsive-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #4a5568;
                display: block;
                margin-bottom: 0.5rem;
                background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), transparent);
                padding: 0.5rem;
                border-radius: 0.5rem;
            }

            .responsive-table thead {
                display: none;
            }
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="background" class="background-gif">

    <!-- Enhanced Decorative Stars -->
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 p-4 md:p-6 md:mr-64 flex flex-col gap-8">
            <div class="card max-w-6xl mx-auto">
                {{-- Header --}}
                <div class="flex justify-between items-center mb-6">
                    <h1 class="section-header">👨‍🎓 إدارة الطلاب</h1>
                    <button class="md:hidden text-gray-600" id="sidebar-open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                {{-- Add New Student --}}
                <a href="{{ route('users.create') }}" class="add-student-btn mb-6">
                    <i class="fas fa-user-plus"></i> إضافة طالب جديد
                </a>

                {{-- Search (Always visible) --}}
                <div class="mb-6">
                    <form method="GET" action="{{ route('students.search') }}" class="search-container">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="🔍 البحث عن الطلاب بالاسم أو البريد..."
                            class="search-input">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i> بحث
                        </button>
                    </form>
                </div>

                @if ($students->isEmpty())
                    <div class="empty-state text-center group">
                        <i class="fas fa-users text-6xl text-purple-400 mb-4"></i>
                        <p class="text-gray-600 text-xl font-semibold mb-2">🚫 لا يوجد طلاب مسجلين{{ request('search') ? ' بناءً على البحث "' . request('search') . '"' : '' }}.</p>
                        <p class="text-gray-500">ابدأ بإضافة طالب جديد لتبدأ الإدارة! ✨</p>
                    </div>
                @else
                    {{-- Students Table --}}
                    <div class="table-container">
                        <table class="w-full border-collapse responsive-table text-sm md:text-base">
                            <thead>
                                <tr class="table-header">
                                    <th class="px-6 py-4 text-center">👤 الاسم</th>
                                    <th class="px-6 py-4 text-center">📧 البريد الإلكتروني</th>
                                    <th class="px-6 py-4 text-center">📚 الدورة</th>
                                    <th class="px-6 py-4 text-center">💳 الاشتراك</th>
                                    <th class="px-6 py-4 text-center">⚙️ الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr class="table-row">
                                        <td class="px-6 py-4 text-center font-medium text-gray-700" data-label="الاسم">{{ $student->name }}</td>
                                        <td class="px-6 py-4 text-center font-medium text-gray-600" data-label="البريد الإلكتروني">
                                            {{ $student->email }}</td>
                                        <td class="px-6 py-4 text-center" data-label="الدورة">
                                            <span class="font-semibold text-blue-600">{{ $student->enrolledCourse?->name ?? 'لا يوجد' }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-center" data-label="الاشتراك">
                                            <span class="font-semibold {{ $student->subscription?->status === 'active' ? 'text-green-600' : 'text-red-600' }}">
                                                {{ match ($student->subscription?->status) {
                                                    'active' => 'نشط ✅',
                                                    'expired' => 'منتهي الصلاحية ❌',
                                                    'canceled' => 'ملغي ❌',
                                                    default => 'لا يوجد',
                                                } }}
                                            </span>
                                            @if ($student->subscription)
                                                <br><small class="text-gray-500">({{ $student->subscription->type === 'monthly' ? 'شهري' : 'فصلي' }})</small>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4" data-label="الإجراءات">
                                            <div class="flex flex-wrap justify-center gap-2">
                                                <a href="{{ route('users.show', $student) }}" class="action-link">
                                                    <i class="fas fa-eye"></i> عرض
                                                </a>
                                                <a href="{{ route('users.edit', $student) }}" class="action-link">
                                                    <i class="fas fa-edit"></i> تعديل
                                                </a>
                                                <form action="{{ route('users.destroy', $student) }}" method="POST"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('هل أنت متأكد من حذف هذا الطالب؟')"
                                                        class="delete-link action-link">
                                                        <i class="fas fa-trash"></i> حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6 flex justify-center">
                        {{ $students->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                @endif

                <a href="{{ route('users.index') }}" class="return-link mt-6">
                    <i class="fas fa-arrow-right"></i> العودة إلى قائمة الطلاب
                </a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
        // Light entrance animations
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.card, .table-row, .empty-state');
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
