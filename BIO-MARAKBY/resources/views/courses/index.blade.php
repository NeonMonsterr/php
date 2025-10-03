<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الدورات</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: white;
            position: relative;
            overflow-x: hidden;
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

        .main-box {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border-radius: 1rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            max-height: calc(100vh - 2rem);
            overflow-y: auto;
        }

        .toggle-btn {
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .toggle-btn.rotate {
            transform: rotate(90deg);
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="Biology Background" class="background-gif">

    <div class="flex min-h-screen">
        @if(auth()->user()->role === 'teacher')
            @include('partials.sidebar')
        @elseif(auth()->user()->role === 'student')
            @include('partials.student_sidebar')
        @endif

        <div class="flex-1 p-4 md:p-6 md:mr-64">
            <div class="max-w-5xl mx-auto p-4 md:p-6 main-box">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-xl md:text-2xl font-bold text-gray-800">الدورات</h1>
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-600">تسجيل الخروج</button>
                        </form>
                        <button class="md:hidden text-gray-800 focus:outline-none" id="sidebar-open">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- زر إنشاء دورة للمعلم فقط --}}
                @if(auth()->user()->role === 'teacher')
                    <div class="mb-6">
                        <a href="{{ route('courses.create') }}"
                           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 inline-block">
                            إنشاء دورة جديدة
                        </a>
                    </div>
                @endif

                {{-- عرض الدورات --}}
                @forelse($levels as $level)
                    <h2 class="text-lg md:text-xl font-bold text-gray-800 mt-6 mb-4">المستوى {{ $level->name }}</h2>
                    @foreach($level->stages as $stage)
                        @if($stage->courses->isNotEmpty())
                            <div class="border rounded-lg shadow-sm mb-4">
                                {{-- رأس المرحلة --}}
                                <div class="flex items-center justify-between bg-gray-100 px-4 py-2 cursor-pointer stage-header">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-gray-600 toggle-btn mr-2"
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 5l7 7-7 7" />
                                        </svg>
                                        <span class="font-semibold text-gray-700">{{ $stage->name }}</span>
                                    </div>
                                </div>

                                {{-- قائمة الدورات --}}
                                <div class="hidden px-6 py-3 space-y-3 stage-content">
                                    @foreach($stage->courses as $course)
                                        <div class="p-3 bg-white border rounded-lg shadow-sm flex flex-col md:flex-row md:items-center md:justify-between">
                                            <div>
                                                <span class="font-medium text-gray-800">{{ $course->name }}</span>
                                                @if(auth()->user()->role === 'teacher')
                                                    <span class="ml-2 text-sm text-gray-500">
                                                        ({{ $course->is_published ? 'منشور' : 'غير منشور' }})
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="flex space-x-2 space-x-reverse mt-2 md:mt-0">
                                                <a href="{{ route('courses.show', $course) }}" class="text-blue-500 hover:text-blue-600">عرض</a>
                                                @if(auth()->user()->role === 'teacher')
                                                    <a href="{{ route('courses.edit', $course) }}" class="text-green-500 hover:text-green-600">تعديل</a>
                                                    <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-600"
                                                                onclick="return confirm('هل أنت متأكد من حذف هذه الدورة؟')">حذف</button>
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
                    <p class="text-gray-600">لا توجد دورات متاحة.</p>
                @endforelse

                <a href="{{ route('dashboard') }}" class="mt-6 inline-block text-blue-500 hover:text-blue-600">
                    العودة إلى لوحة التحكم
                </a>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll(".stage-header").forEach(header => {
            header.addEventListener("click", () => {
                const content = header.nextElementSibling;
                const icon = header.querySelector(".toggle-btn");
                content.classList.toggle("hidden");
                icon.classList.toggle("rotate");
            });
        });
    </script>
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>
