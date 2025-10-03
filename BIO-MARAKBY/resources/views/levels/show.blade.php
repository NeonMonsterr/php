<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>📘 عرض المستوى</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f9fafb;
            overflow-x: hidden;
            color: #111827;
        }

        .background-gif {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.06;
            z-index: -1;
        }

        .glass-box {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="background" class="background-gif">

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 p-4 md:p-6 md:mr-64">
            <div class="max-w-4xl mx-auto p-6 md:p-8 glass-box">

                {{-- Header --}}
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-xl md:text-2xl font-bold text-gray-900">📘 تفاصيل المستوى</h1>
                    <a href="{{ route('levels.index') }}" class="text-sm text-cyan-600 hover:text-cyan-500">⬅ العودة إلى
                        المستويات</a>
                </div>

                {{-- Level Info --}}
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-800">اسم المستوى:</h2>
                    <p class="text-gray-700 mt-1">{{ $level->name }}</p>
                </div>

                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-gray-800">الوصف:</h2>
                    <p class="text-gray-700 mt-1">
                        {{ $level->description ?? 'لا يوجد وصف متاح' }}
                    </p>
                </div>

                {{-- Related Stages --}}
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-lg font-semibold text-gray-800">📚 المراحل المرتبطة بهذا المستوى:</h2>

                        {{-- Add New Stage --}}
                        <a href="{{ route('stages.create', $level) }}"
                            class="bg-green-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-600 transition">
                            ➕ إضافة مرحلة
                        </a>
                    </div>

                    @if ($level->stages->isEmpty())
                        <p class="text-gray-500">🚫 لا توجد مراحل مرتبطة بهذا المستوى.</p>
                    @else
                        <ul class="space-y-3">
                            @foreach ($level->stages as $stage)
                                <li
                                    class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <h3 class="font-bold text-indigo-700">{{ $stage->name }}</h3>
                                            <p class="text-gray-600 text-sm">{{ $stage->description ?? 'لا يوجد وصف' }}
                                            </p>
                                        </div>

                                        {{-- Actions --}}
                                        <div class="flex gap-2">
                                            <a href="{{ route('stages.edit', [$level,$stage]) }}"
                                                class="bg-yellow-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-yellow-600 transition">
                                                ✏️ تعديل
                                            </a>

                                            <form action="{{ route('stages.destroy', [$level,$stage]) }}" method="POST"
                                                onsubmit="return confirm('هل أنت متأكد من حذف هذه المرحلة؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-600 transition">
                                                    🗑️ حذف
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="flex gap-4">
                    <a href="{{ route('levels.edit', $level) }}"
                        class="bg-yellow-500 text-white px-5 py-2 rounded-lg font-semibold hover:bg-yellow-600 transition">
                        ✏️ تعديل
                    </a>

                    <form action="{{ route('levels.destroy', $level) }}" method="POST"
                        onsubmit="return confirm('هل أنت متأكد من حذف هذا المستوى؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 text-white px-5 py-2 rounded-lg font-semibold hover:bg-red-600 transition">
                            🗑️ حذف
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
