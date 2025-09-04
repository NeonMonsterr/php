<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>إدارة الاشتراك</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
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
            opacity: 0.07;
            z-index: -1;
        }

        .glass-box {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            color: #f1f5f9;
        }

        select,
        input,
        button {
            color: #0f172a;
        }

        label {
            color: #f1f5f9;
        }

        p {
            color: #cbd5e1;
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="background" class="background-gif">

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 p-4 sm:p-6 md:mr-64">
            <div class="max-w-md mx-auto glass-box p-6 sm:p-8">

                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-xl sm:text-2xl font-bold">🔧 إدارة الاشتراك</h1>
                    <button class="md:hidden text-white focus:outline-none" id="sidebar-open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <p class="mb-4 text-sm sm:text-base">📚 الدورة المسجلة:
                    <span class="font-semibold text-blue-300">{{ $user->enrolledCourse?->name ?? 'لا يوجد' }}</span>
                </p>

                <form method="POST" action="{{ route('users.subscription') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="type" class="block mb-2 text-sm sm:text-base">نوع الاشتراك</label>
                        <select name="type" id="type"
                            class="w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                            required>
                            <option value="monthly" {{ old('type', $subscription?->type) === 'monthly' ? 'selected' : '' }}>شهري</option>
                            <option value="semester" {{ old('type', $subscription?->type) === 'semester' ? 'selected' : '' }}>فصلي</option>
                        </select>
                        @error('type')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <input type="hidden" name="course_id" value="{{ $user->course_id }}">

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold p-2 rounded hover:from-blue-600 hover:to-cyan-600 transition">💾 تحديث الاشتراك</button>
                </form>

                <a href="{{ route('users.index') }}"
                    class="mt-4 inline-block text-cyan-300 hover:text-cyan-200 text-center w-full text-sm">⬅ العودة إلى الطلاب</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
