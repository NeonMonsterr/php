<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الدرس: {{ $lecture->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: white;
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
            margin-bottom: 2rem;
        }

        .controls button {
            margin: 0 6px;
            padding: 8px 14px;
            font-size: 16px;
            background-color: #4f46e5;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .controls button:hover {
            background-color: #3730a3;
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

        <div class="flex-1 p-4 sm:p-6">
            <div class="max-w-4xl mx-auto">

                {{-- Lecture Header --}}
                <div class="glass-card">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">📘 الدرس: {{ $lecture->title }}</h1>

                    <p class="text-gray-700 mb-2"><strong>الدورة:</strong> {{ $lecture->course?->name ?? 'لا يوجد' }}
                    </p>
                    <p class="text-gray-700 mb-2"><strong>الترتيب:</strong> {{ $lecture->position }}</p>
                    @can('update', $lecture)
                        <p class="text-gray-700 mb-4"><strong>منشور:</strong> {{ $lecture->is_published ? 'نعم' : 'لا' }}
                        </p>
                    @endcan
                    @can('update', $lecture)
                        <a href="{{ route('lectures.edit', [$lecture->course, $lecture]) }}"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-2 inline-block">✏️ تعديل
                            الدرس</a>
                    @endcan

                    @can('delete', $lecture)
                        <form action="{{ route('lectures.destroy', [$lecture->course, $lecture]) }}" method="POST"
                            class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                                onclick="return confirm('هل أنت متأكد من حذف هذا الدرس؟')">🗑 حذف الدرس</button>
                        </form>
                    @endcan

                    <a href="{{ route('courses.show', $lecture->course) }}"
                        class="text-blue-500 hover:text-blue-600 block mt-4">
                        ⬅ العودة إلى الدورة
                    </a>
                </div>

                {{-- Sections --}}
                <h2 class="text-xl font-bold text-gray-800 mb-4">📂 أقسام الدرس</h2>

                @forelse ($sections as $section)
                    <div class="glass-card">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">📖 {{ $section->title }}</h3>

                        @if ($section->content)
                            <p class="text-gray-700 mb-3">{{ $section->content }}</p>
                        @endif

                        <div class="glass-card">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">📖 {{ $section->title }}</h3>

                            @if ($section->file)
                                <div class="mb-3">
                                    <p class="font-semibold">📎 ملف مرفق:</p>
                                    {{-- Download button --}}
                                    <a href="{{ route('sections.download', $section) }}"
                                        class="text-green-600 underline">
                                        تحميل الملف
                                    </a>
                                </div>
                            @endif

                            @if ($section->video_url)
                                <div class="mb-4">
                                    <iframe
                                        src="https://www.youtube-nocookie.com/embed/{{ $section->video_id }}?rel=0&modestbranding=1"
                                        class="w-full rounded-lg border-0" style="height: 360px;"
                                        allowfullscreen></iframe>
                                </div>
                            @endif

                            <div class="flex flex-wrap gap-2">
                                @can('view', $section)
                                    <a href="{{ route('sections.show', [$lecture->course, $lecture, $section]) }}"
                                        class="bg-gray-500 text-white px-3 py-1 rounded hover:bg-gray-600">
                                        👁 عرض القسم
                                    </a>
                                @endcan

                                @can('update', $section)
                                    <a href="{{ route('sections.edit', [$lecture->course, $lecture, $section]) }}"
                                        class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        ✏️ تعديل
                                    </a>
                                @endcan

                                @can('delete', $section)
                                    <form action="{{ route('sections.destroy', [$lecture->course, $lecture, $section]) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا القسم؟')">
                                            🗑 حذف
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-600">لا توجد أقسام لهذا الدرس بعد.</p>
                @endforelse


                @can('create', App\Models\Section::class)
                    <a href="{{ route('sections.create', [$lecture->course, $lecture]) }}"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mt-4 inline-block">
                        ➕ إضافة قسم جديد
                    </a>
                @endcan

            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
