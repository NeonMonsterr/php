<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>إدارة الطلاب</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: white;
            overflow-x: hidden;
            color: black;
        }

        .background-gif {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.07;
            z-index: -1;
        }

        .glass-box {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            color: #e2e8f0;
        }

        th,
        td {
            color: black;
        }

        .table th {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .btn-primary {
            background-color: #3b82f6;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-danger:hover {
            color: #ef4444;
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
            }

            .responsive-table td::before {
                content: attr(data-label);
                font-weight: bold;
                color: black;
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

                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-xl md:text-2xl font-bold text-black">👨‍🎓 إدارة الطلاب</h1>
                    <button class="md:hidden text-white" id="sidebar-open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <a href="{{ route('users.create') }}"
                    class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-5 py-2 rounded font-semibold hover:from-blue-600 hover:to-cyan-600 transition mb-6 inline-block">➕ إضافة طالب جديد</a>

                @if ($students->isEmpty())
                <p class="text-slate-300">🚫 لا يوجد طلاب مسجلين.</p>
                @else
                <div class="mb-6">
                    <form method="GET" action="{{ route('students.search') }}" class="flex items-center">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="🔍 البحث عن الطلاب بالاسم أو البريد..."
                            class="w-full max-w-md p-2 border border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white text-gray-800">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-l-md hover:bg-blue-600">بحث</button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse responsive-table table">
                        <thead>
                            <tr>
                                <th class="p-3 text-right">👤 الاسم</th>
                                <th class="p-3 text-right">📧 البريد الإلكتروني</th>
                                <th class="p-3 text-right">📚 الدورة</th>
                                <th class="p-3 text-right">💳 الاشتراك</th>
                                <th class="p-3 text-right">⚙️ الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                            <tr class="border-b border-slate-600">
                                <td class="p-2" data-label="الاسم">{{ $student->name }}</td>
                                <td class="p-2" data-label="البريد الإلكتروني">{{ $student->email }}</td>
                                <td class="p-2" data-label="الدورة">{{ $student->enrolledCourse?->name ?? 'لا يوجد' }}</td>
                                <td class="p-2" data-label="الاشتراك">
                                    @can('view', $student->subscription)
                                    {{ match ($student->subscription?->status) {
                            'active' => 'نشط',
                            'expired' => 'منتهي',
                            'canceled' => 'ملغي',
                            default => 'لا يوجد',
                        } }}
                                    @if ($student->subscription)
                                    ({{ $student->subscription->type === 'monthly' ? 'شهري' : 'فصلي' }})
                                    @endif
                                    @else
                                    لا يوجد
                                    @endcan
                                </td>
                                <td class="p-2 whitespace-nowrap" data-label="الإجراءات">
                                    <div class="flex flex-col md:flex-row md:space-x-2 md:space-x-reverse">
                                        <a href="{{ route('users.show', $student) }}"
                                            class="text-sky-400 hover:text-sky-300 mb-2 md:mb-0">👁️ عرض</a>
                                        <a href="{{ route('users.edit', $student) }}"
                                            class="text-green-400 hover:text-green-300 mb-2 md:mb-0">✏️ تعديل</a>
                                        <form action="{{ route('users.destroy', $student) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('هل أنت متأكد من حذف هذا الطالب؟')"
                                                class="text-red-400 hover:text-red-500">🗑️ حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                <a href="{{ route('users.index') }}" class="mt-4 inline-block text-cyan-400 hover:text-cyan-300 text-sm">⬅ العودة إلى الطلاب</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
