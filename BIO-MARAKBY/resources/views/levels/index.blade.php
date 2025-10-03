<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>إدارة المستويات</title>
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
                border: 1px solid #e5e7eb;
                border-radius: 0.5rem;
                padding: 0.5rem;
                background-color: white;
            }

            .responsive-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #374151;
                display: block;
                margin-bottom: 0.25rem;
            }

            .responsive-table thead {
                display: none;
            }
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="background" class="background-gif">

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 p-4 md:p-6 md:mr-64">
            <div class="max-w-6xl mx-auto p-6 md:p-8 glass-box">

                {{-- Header --}}
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-xl md:text-2xl font-bold text-gray-900">🎯 إدارة المستويات</h1>
                    <button class="md:hidden text-gray-700" id="sidebar-open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                {{-- Add New Level --}}
                <a href="{{ route('levels.create') }}"
                    class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-5 py-2 rounded-md font-semibold hover:from-green-600 hover:to-emerald-600 transition mb-6 inline-block">
                    ➕ إضافة مستوى جديد
                </a>

                @if ($levels->isEmpty())
                    <p class="text-gray-500">🚫 لا يوجد مستويات مسجلة.</p>
                @else
                    {{-- Levels Table --}}
                    <div class="overflow-x-auto max-h-[600px] overflow-y-auto rounded-lg border border-gray-200 shadow-sm">
                        <table class="w-full border-collapse responsive-table text-sm">
                            <thead class="sticky top-0 bg-gray-50 shadow-sm z-10">
                                <tr>
                                    <th class="p-3 text-right">🎯 اسم المستوى</th>
                                    <th class="p-3 text-right">📖 الوصف</th>
                                    <th class="p-3 text-right">🏫 المراحل المرتبطة</th>
                                    <th class="p-3 text-right">⚙️ الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($levels as $level)
                                    <tr class="border-b hover:bg-gray-50 transition">
                                        <td class="p-2 whitespace-nowrap" data-label="اسم المستوى">{{ $level->name }}</td>
                                        <td class="p-2" data-label="الوصف">{{ $level->description ?? '—' }}</td>
                                        <td class="p-2" data-label="المراحل">
                                            @if($level->stages->isNotEmpty())
                                                <ul class="list-disc list-inside">
                                                    @foreach($level->stages as $stage)
                                                        <li>{{ $stage->name }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="text-gray-400">لا يوجد</span>
                                            @endif
                                        </td>
                                        <td class="p-2 whitespace-nowrap" data-label="الإجراءات">
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ route('levels.show', $level) }}"
                                                    class="text-sky-500 hover:text-sky-600 text-sm">👁️ عرض</a>
                                                <a href="{{ route('levels.edit', $level) }}"
                                                    class="text-green-500 hover:text-green-600 text-sm">✏️ تعديل</a>
                                                <form action="{{ route('levels.destroy', $level) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        onclick="return confirm('هل أنت متأكد من حذف هذا المستوى؟')"
                                                        class="text-red-500 hover:text-red-600 text-sm">🗑️ حذف</button>
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
                        {{ $levels->links('pagination::tailwind') }}
                    </div>
                @endif

                <a href="{{ route('dashboard') }}"
                    class="mt-6 inline-block text-cyan-600 hover:text-cyan-500 text-sm">⬅ العودة إلى لوحة التحكم</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
