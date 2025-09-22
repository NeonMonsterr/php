<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>قائمة الامتحانات</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: white;
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
    </style>
</head>

<body>
    <!-- Background -->
    <img src="/images/biology-bg.gif" alt="Background" class="background-gif" />

    <!-- Sidebar include (has sidebar + overlay + toggle btn) -->
    @if (auth()->check() && auth()->user()->role === 'teacher')
        @include('partials.sidebar')
    @elseif (auth()->check() && auth()->user()->role === 'student')
        @include('partials.student_sidebar')
    @endif

    <!-- Main content -->
    <div class="p-6 md:mr-64">
        <h1 class="text-2xl font-bold mb-6 text-center md:text-right">قائمة الامتحانات</h1>

        <!-- Table -->
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full bg-white border border-gray-200 text-sm md:text-base">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-center">#</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">عنوان الامتحان</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">التاريخ</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">الكورس</th>
                        <th class="border border-gray-300 px-4 py-2 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($exams as $exam)
                        <tr class="hover:bg-gray-50">
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">{{ $exam->title }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                {{ optional($exam->exam_date)->format('Y-m-d') ?? 'غير محدد' }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                {{ $exam->course->name ?? 'بدون كورس' }}
                            </td>
                            <td class="border border-gray-300 px-4 py-2">
                                <div class="flex flex-wrap justify-center gap-2">
                                    <a href="{{ route('exams.show', $exam->id) }}"
                                        class="bg-green-500 px-3 py-1 rounded text-white hover:bg-green-600">عرض</a>
                                    @if (auth()->check() && auth()->user()->role === 'teacher')
                                        <a href="{{ route('exams.edit', $exam->id) }}"
                                            class="bg-blue-500 px-3 py-1 rounded text-white hover:bg-blue-600">تعديل</a>
                                        <form action="{{ route('exams.destroy', $exam->id) }}" method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من حذف الامتحان؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 px-3 py-1 rounded text-white hover:bg-red-600">حذف</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4">لا يوجد امتحانات حتى الآن.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Teacher actions -->
        @if (auth()->check() && auth()->user()->role === 'teacher')
            <div class="mt-6 text-center">
                <a href="{{ route('exams.create') }}"
                    class="bg-blue-500 px-6 py-3 rounded text-white hover:bg-blue-600 inline-block">
                    إضافة امتحان جديد
                </a>
            </div>
        @endif
    </div>

    <!-- Sidebar script -->
    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
