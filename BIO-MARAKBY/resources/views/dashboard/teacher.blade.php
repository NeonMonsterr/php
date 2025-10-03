<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>لوحة تحكم المعلم</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: white;
            overflow: hidden;
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
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 1rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            padding: 2rem;
        }

        a,
        button {
            transition: all 0.2s ease;
        }

        a:hover,
        button:hover {
            opacity: 0.85;
        }

        @keyframes sparkle {
            0% {
                transform: rotate(0deg) scale(1);
                opacity: 1;
            }

            50% {
                transform: rotate(15deg) scale(1.2);
                opacity: 0.8;
            }

            100% {
                transform: rotate(0deg) scale(1);
                opacity: 1;
            }
        }

        .sparkle {
            animation: sparkle 1.5s infinite;
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="Biology Background" class="background-gif" />

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('partials.sidebar', ['user' => $user])

        <!-- Main Content -->
        <div class="flex-1 p-6 md:mr-64 space-y-6">
            <!-- Statistics Card -->
            <div class="max-w-6xl mx-auto card">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">لوحة تحكم المعلم</h1>
                    <button class="md:hidden text-gray-800 focus:outline-none" id="sidebar-open"
                        aria-label="فتح القائمة الجانبية">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-gray-700 mb-4">مرحبًا، {{ $user->name }}</p>

                <h2 class="text-xl font-semibold text-gray-800 mb-4">الإحصائيات</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-blue-100 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium text-gray-700">إجمالي الطلاب</h3>
                        <p class="text-2xl font-bold text-blue-600">{{ $statistics['students'] ?? 0 }}</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium text-gray-700">إجمالي الدورات</h3>
                        <p class="text-2xl font-bold text-green-600">{{ $statistics['courses'] ?? 0 }}</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium text-gray-700">إجمالي الدروس</h3>
                        <p class="text-2xl font-bold text-yellow-600">{{ $statistics['lectures'] ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-100 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium text-gray-700">إجمالي الامتحانات</h3>
                        <p class="text-2xl font-bold text-purple-600">{{ $statistics['exams'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            {{-- Honor Dashboard / Top 3 Students --}}
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
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
