<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الامتحان: {{ $exam->title }}</title>
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

        .card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 1rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            max-width: 500px;
            margin: auto;
        }

        a,
        button {
            transition: all 0.2s ease;
        }

        a:hover,
        button:hover {
            opacity: 0.85;
        }

        .exam-duration {
            background-color: #f0f7ff;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            display: inline-block;
            margin-top: 0.5rem;
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="Background" class="background-gif" />

    <div class="flex min-h-screen">
        @if(auth()->user()->role === 'teacher')
        @include('partials.sidebar')
        @elseif(auth()->user()->role === 'student')
        @include('partials.student_sidebar')
        @endif

        <div class="flex-1 p-4 sm:p-6 flex items-center justify-center">
            <div class="card w-full">
                <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">تفاصيل الامتحان: {{ $exam->title }}</h1>

                <div class="mb-4">
                    <p class="text-gray-700"><strong>الدورة:</strong> {{ $exam->course?->name ?? 'لا يوجد' }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-gray-700"><strong>العنوان:</strong> {{ $exam->title }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-gray-700"><strong>مدة الامتحان:</strong></p>
                    <div class="exam-duration">
                        {{ $exam->duration_minutes }} دقائق
                    </div>
                </div>

                @if($exam->form_url)
                <div class="mb-4">
                    <p class="text-gray-700"><strong>رابط النموذج:</strong>
                        <a href="{{ $exam->form_url }}" class="text-blue-500 hover:underline" target="_blank">
                            {{ $exam->form_url }}
                        </a>
                    </p>
                </div>
                @endif

                <div class="mb-4">
                    <p class="text-gray-700"><strong>تاريخ الامتحان:</strong> {{ optional($exam->start_time)->format('Y-m-d') ?? 'غير محدد' }}
                    </p>
                </div>

                <div class="mb-6">
                    <p class="text-gray-700"><strong>الحالة:</strong> {{ $exam->is_published ? 'منشور' : 'غير منشور' }}</p>
                </div>

                @if(auth()->user()->role === 'student')
                <div class="mb-6 text-center">
                    <a href="{{ route('exams.exam', $exam->id) }}"
                        class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 text-lg font-medium inline-block">
                        بدء الامتحان
                    </a>
                </div>
                @endif

                <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-2 md:space-y-0 md:space-x-2 md:space-x-reverse mb-6">
                    @can('update', $exam)
                    <a href="{{ route('exams.edit', $exam) }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full md:w-auto text-center">
                        تعديل الامتحان
                    </a>
                    @endcan


                    @can('update', $exam)
                    <a href="{{ route('exams.allresult', $exam->id) }}" style="background-color: green;"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full md:w-auto text-center">
                        اظهار نتائج الامتحان
                    </a>
                    @endcan


                    @can('update', $exam)
                    <a href="{{ route('exams.questions.edit', $exam->id) }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        تعديل الأسئلة
                    </a>
                    @endcan

                    @can('delete', $exam)
                    <form action="{{ route('exams.destroy', $exam) }}" method="POST"
                        onsubmit="return confirm('هل أنت متأكد من حذف هذا الامتحان؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 w-full md:w-auto">
                            حذف الامتحان
                        </button>
                    </form>
                    @endcan
                </div>

                <a href="{{ route('exams.index') }}" class="block text-center text-blue-500 hover:text-blue-600">
                    العودة إلى قائمة الامتحانات
                </a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
