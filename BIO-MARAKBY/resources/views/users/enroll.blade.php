<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>التسجيل في دورة</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
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

        select {
            background: rgba(255, 255, 255, 0.12);
            color: black;
        }

        select:focus {
            background: rgba(255, 255, 255, 0.2);
            outline: none;
            border-color: #60a5fa;
            box-shadow: 0 0 0 2px #60a5fa;
        }

        label {
            color: black;
        }

        .submit-btn {
            background-color: #3b82f6;
            transition: 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #2563eb;
            transform: scale(1.03);
        }

        .link-back {
            color: #38bdf8;
        }

        .link-back:hover {
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
    <img src="/images/biology-bg.gif" class="background-gif" alt="background gif">

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 p-4 sm:p-6 md:mr-64">
            <div class="max-w-md mx-auto p-6 sm:p-8 glass-box">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-xl sm:text-2xl font-bold">التسجيل في دورة</h1>
                    <button class="md:hidden text-white" id="sidebar-open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('users.enroll') }}">
                    @csrf
                    <div class="mb-6">
                        <label for="course_id" class="block mb-2 text-sm sm:text-base">الدورة</label>
                        <select name="course_id" id="course_id" required class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500">
                            <option value="">اختر دورة</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('course_id')
                        <p class="text-red-500 text-sm mt-1">⚠️ {{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="submit-btn w-full text-white p-3 rounded font-bold">تسجيل</button>
                </form>

                <a href="{{ route('users.index') }}" class="link-back mt-4 inline-block text-center w-full">
                    ⬅ العودة إلى الطلاب
                </a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
