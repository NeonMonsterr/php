<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المحاضرات</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: white;
            position: relative;
            overflow: hidden;
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

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 1rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            padding: 2rem;
        }

        @media (max-width: 767px) {
            .responsive-table {
                display: block;
            }

            .responsive-table thead {
                display: none;
            }

            .responsive-table tbody,
            .responsive-table tr,
            .responsive-table td {
                display: block;
                width: 100%;
            }

            .responsive-table tr {
                margin-bottom: 1rem;
                border: 1px solid #e5e7eb;
                border-radius: 0.5rem;
                padding: 0.5rem;
            }

            .responsive-table td {
                padding: 0.5rem;
                position: relative;
            }

            .responsive-table td::before {
                content: attr(data-label);
                font-weight: bold;
                display: block;
                margin-bottom: 0.25rem;
                color: #374151;
            }
        }

        a,
        button {
            transition: all 0.2s ease;
        }

        a:hover,
        button:hover {
            opacity: 0.85;
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="Background" class="background-gif">

    <div class="flex min-h-screen">
        @if (auth()->user()->role === 'teacher')
        @include('partials.sidebar')
        @elseif (auth()->user()->role === 'student')
        @include('partials.student_sidebar')
        @endif

        <div class="flex-1 p-4 md:p-6 md:mr-64">
            <div class="max-w-6xl mx-auto glass-card">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">المحاضرات</h1>
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-600">تسجيل الخروج</button>
                        </form>
                        <button class="md:hidden text-gray-800" id="sidebar-open">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="mb-4 flex items-center space-x-4 space-x-reverse">
                    <form method="GET" action="{{ route('lectures.index') }}" class="flex items-center flex-1">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            placeholder="ابحث عن المحاضرات حسب العنوان{{ $user->role === 'teacher' ? ' أو الدورة' : '' }}..."
                            class="w-full max-w-md p-2 border border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-l-md hover:bg-blue-600">بحث</button>
                    </form>

                    @can('create', App\Models\Lecture::class)
                    <div class="relative">
                        <button id="create-lecture-btn" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            إضافة درس
                        </button>
                        <div id="create-lecture-dropdown" class="hidden absolute mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg z-10">
                            @foreach (App\Models\Course::where('user_id', auth()->id())->get() as $course)
                            <a href="{{ route('lectures.create', $course) }}"
                                class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                {{ $course->name }}
                            </a>
                            @endforeach
                            @if (App\Models\Course::where('user_id', auth()->id())->count() === 0)
                            <p class="px-4 py-2 text-gray-500">لا توجد دورات متاحة</p>
                            @endif
                        </div>
                    </div>
                    @endcan
                </div>

                @if (session('success'))
                <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
                @endif

                @if ($lectures->isEmpty())
                <p class="text-gray-600">لم يتم العثور على محاضرات.</p>
                @else
                @if ($user->role === 'student')
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($lectures as $lecture)
                    <div
                        class="bg-white border border-gray-200 rounded-lg p-4 shadow hover:shadow-md transition backdrop-blur">
                        <h2 class="text-lg font-bold text-blue-600 mb-2">
                            <a href="{{ route('lectures.show', $lecture) }}" class="hover:underline">
                                {{ $lecture->title }}
                            </a>
                        </h2>
                        @if ($lecture->course)
                        <p class="text-sm text-gray-500 mb-1">الدورة: {{ $lecture->course->name }}</p>
                        @endif
                        <p class="text-sm text-gray-600">الترتيب: {{ $lecture->position ?? 'غير محدد' }}</p>
                        <p class="text-sm text-gray-600 mt-1">الحالة: {{ $lecture->is_published ? 'منشور' : 'غير منشور' }}</p>
                    </div>
                    @endforeach
                </div>
                @else
                @foreach ($lectures->groupBy('course_id') as $course_id => $course_lectures)
                <h2 class="text-lg font-bold text-gray-800 mt-6 mb-4">
                    {{ $course_lectures->first()->course->name ?? 'دورة غير متوفرة' }}
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse responsive-table mb-6">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="p-2 text-right">العنوان</th>
                                <th class="p-2 text-right">الترتيب</th>
                                <th class="p-2 text-right">منشور</th>
                                <th class="p-2 text-right">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($course_lectures as $lecture)
                            <tr class="border-b">
                                <td class="p-2" data-label="العنوان">
                                    <a href="{{ route('lectures.show', $lecture) }}"
                                        class="text-blue-500 hover:underline">{{ $lecture->title }}</a>
                                </td>
                                <td class="p-2" data-label="الترتيب">{{ $lecture->position }}</td>
                                <td class="p-2" data-label="منشور">{{ $lecture->is_published ? 'نعم' : 'لا' }}</td>
                                <td class="p-2" data-label="الإجراءات">
                                    <div class="flex flex-col md:flex-row md:space-x-2 md:space-x-reverse">
                                        @can('update', $lecture)
                                        <a href="{{ route('lectures.edit', [$lecture->course, $lecture]) }}"
                                            class="text-blue-500 hover:underline mb-2 md:mb-0">تعديل</a>
                                        @endcan
                                        @can('delete', $lecture)
                                        <form action="{{ route('lectures.destroy', $lecture) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:underline"
                                                onclick="return confirm('هل أنت متأكد؟')">حذف</button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endforeach
                @endif
                @endif
            </div>
        </div>
    </div>

    <script>
        const sidebarOpen = document.getElementById('sidebar-open');
        const sidebar = document.querySelector('.sidebar');
        sidebarOpen?.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });

        const createLectureBtn = document.getElementById('create-lecture-btn');
        const createLectureDropdown = document.getElementById('create-lecture-dropdown');
        createLectureBtn?.addEventListener('click', () => {
            createLectureDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!createLectureBtn.contains(e.target) && !createLectureDropdown.contains(e.target)) {
                createLectureDropdown.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
