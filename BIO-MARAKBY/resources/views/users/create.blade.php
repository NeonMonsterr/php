<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء طالب</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        .background-gif {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            opacity: 0.08;
        }

        .glass-box {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        .form-label {
            color: black;
        }

        .form-input {
            background: rgba(255, 255, 255, 0.15);
            color: black;
        }

        .form-input:focus {
            background: rgba(255, 255, 255, 0.2);
            border-color: #60a5fa;
            box-shadow: 0 0 0 2px #60a5fa;
        }

        .submit-btn {
            background-color: #3b82f6;
            transition: 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #2563eb;
            transform: scale(1.03);
        }

        a.return-link {
            color: #38bdf8;
        }

        a.return-link:hover {
            color: #0ea5e9;
        }

        @media (max-width: 640px) {
            .glass-box {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="خلفية" class="background-gif">

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 p-4 sm:p-6 md:mr-64">
            <div class="max-w-md mx-auto glass-box rounded-xl p-6 sm:p-8 text-white">
                <div class="flex justify-between items-center mb-6 md:hidden">
                    <h1 class="text-2xl font-bold">إنشاء طالب</h1>
                    <button class="text-white" id="sidebar-open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block form-label mb-2">الاسم</label>
                        <input type="text" id="name" name="name" required
                            value="{{ old('name') }}"
                            class="w-full p-2 border rounded form-input focus:outline-none focus:ring-2">
                        @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block form-label mb-2">البريد الإلكتروني</label>
                        <input type="email" id="email" name="email" required
                            value="{{ old('email') }}"
                            class="w-full p-2 border rounded form-input focus:outline-none focus:ring-2">
                        @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block form-label mb-2">كلمة المرور</label>
                        <input type="password" id="password" name="password" required
                            class="w-full p-2 border rounded form-input focus:outline-none focus:ring-2">
                        @error('password')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block form-label mb-2">تأكيد كلمة المرور</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full p-2 border rounded form-input focus:outline-none focus:ring-2">
                    </div>

                    <div class="mb-6">
                        <label for="course_id" class="block form-label mb-2">الدورة</label>
                        <select id="course_id" name="course_id"
                            class="w-full p-2 border rounded form-input text-black bg-white text-sm">
                            <option value="">لا يوجد</option>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}"
                                {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('course_id')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="submit-btn w-full p-3 rounded font-bold text-white">
                        إنشاء طالب
                    </button>
                </form>

                <a href="{{ route('users.index') }}" class="mt-5 inline-block return-link text-center w-full">⬅ العودة إلى الطلاب</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
