<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>نتائج الامتحان: {{ $exam->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet" />
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
            padding: 1.5rem;
            max-width: 900px;
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

        th,
        td {
            text-align: center;
            padding: 0.5rem;
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

        <div class="flex-1  sm:p-6 flex items-center justify-center">
            <div class="card w-full">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6 text-center">
                    نتائج الامتحان: {{ $exam->title }}
                </h1>

                <!-- جدول النتائج -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow">
                        <thead class="bg-blue-100 text-blue-900">
                            <tr>
                                <th class="py-2 sm:py-3 px-2 sm:px-4 whitespace-nowrap">اسم الطالب</th>
                                <th class="py-2 sm:py-3 px-2 sm:px-4 whitespace-nowrap">البريد الإلكتروني</th>
                                <th class="py-2 sm:py-3 px-2 sm:px-4 whitespace-nowrap">الدرجة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($results as $result)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 px-2 sm:px-4">{{ $result['student']->name }}</td>
                                <td class="py-2 px-2 sm:px-4 truncate sm:max-w-none">{{ $result['student']->email }}</td>
                                <td class="py-2 px-2 sm:px-4">
                                    @if(is_null($result['score']))
                                    <span class="text-red-500">لم يمتحن بعد</span>
                                    @else
                                    {{ $result['score'] }} / {{ $exam->questions->sum('points') ?: $exam->questions->count() }}
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-6 text-gray-500">لا يوجد طلاب مشتركين في هذا الكورس.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="text-center mt-6">
                    <a href="{{ route('exams.show', $exam->id) }}" class="text-blue-500 hover:underline inline-block px-4 py-2 bg-blue-50 rounded-lg">
                        العودة إلى تفاصيل الامتحان
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>

</body>

</html>
