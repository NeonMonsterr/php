<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المستخدم: {{ $user->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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

        input,
        select {
            background: rgba(255, 255, 255, 0.13);
            color: black;
        }

        input:focus,
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
            color: black;
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
    <img src="/images/biology-bg.gif" alt="خلفية" class="background-gif">

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 p-4 sm:p-6 md:mr-64">
            <div class="max-w-4xl mx-auto p-6 sm:p-8 glass-box">
                <div class="flex justify-between items-center mb-6">
                    <h1 style="color: black;" class="text-2xl font-bold">تعديل المستخدم: {{ $user->name }}</h1>
                    <button class="md:hidden text-white" id="sidebar-open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                @if ($errors->any())
                <ul class="text-red-400 text-sm mb-6">
                    @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
                @endif

                <form method="POST" style="color: black;" action="{{ route('users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col lg:flex-row lg:space-x-6 lg:space-x-reverse">
                        <!-- بيانات المستخدم -->
                        <div class="w-full lg:w-1/2 mb-6 lg:mb-0">
                            <h2 class="text-xl font-semibold mb-4">تفاصيل المستخدم</h2>

                            <!-- الاسم -->
                            <div class="mb-4">
                                <label for="name" class="mb-1 block">الاسم</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                    class="w-full p-2 rounded border">
                            </div>

                            <!-- البريد -->
                            <div class="mb-4">
                                <label for="email" class="mb-1 block">البريد الإلكتروني</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                    class="w-full p-2 rounded border">
                            </div>

                            <!-- كلمة المرور -->
                            <div class="mb-4">
                                <label for="password" class="mb-1 block">كلمة المرور (اتركه فارغًا)</label>
                                <input type="password" name="password" id="password" class="w-full p-2 rounded border">
                            </div>

                            <!-- تأكيد -->
                            <div class="mb-4">
                                <label for="password_confirmation" class="mb-1 block">تأكيد كلمة المرور</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="w-full p-2 rounded border">
                            </div>

                            <!-- الدور -->
                            <div class="mb-4">
                                <label for="role" class="mb-1 block">الدور</label>
                                <select name="role" id="role" class="w-full p-2 rounded border">
                                    <option value="student" {{ old('role', $user->role) === 'student' ? 'selected' : '' }}>طالب</option>
                                    <option value="teacher" {{ old('role', $user->role) === 'teacher' ? 'selected' : '' }}>معلم</option>
                                </select>
                            </div>

                            <!-- الدورة -->
                            <div class="mb-4">
                                <label for="course_id" class="mb-1 block">الدورة المسجلة</label>
                                <select name="course_id" id="course_id" class="w-full p-2 rounded border">
                                    <option value="">لا يوجد</option>
                                    @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id', $user->course_id) == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- فاصل -->
                        @if($user->role === 'student' || old('role', $user->role) === 'student')
                        <div class="hidden lg:block w-px bg-gradient-to-b from-blue-300 to-blue-500 shadow-sm mx-6"></div>

                        <!-- بيانات الاشتراك -->
                        <div class="w-full lg:w-1/2">
                            <h2 class="text-xl font-semibold mb-4">تفاصيل الاشتراك</h2>

                            <div class="mb-4">
                                <label for="subscription_type" class="mb-1 block">نوع الاشتراك</label>
                                <select name="subscription_type" id="subscription_type"
                                    class="w-full p-2 rounded border">
                                    <option value="">لا يوجد</option>
                                    <option value="monthly" {{ old('subscription_type', $user->subscription?->type) === 'monthly' ? 'selected' : '' }}>شهري</option>
                                    <option value="semester" {{ old('subscription_type', $user->subscription?->type) === 'semester' ? 'selected' : '' }}>فصلي</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="subscription_status" class="mb-1 block">حالة الاشتراك</label>
                                <select name="subscription_status" id="subscription_status"
                                    class="w-full p-2 rounded border">
                                    <option value="">لا يوجد</option>
                                    <option value="active" {{ old('subscription_status', $user->subscription?->status) === 'active' ? 'selected' : '' }}>نشط</option>
                                    <option value="expired" {{ old('subscription_status', $user->subscription?->status) === 'expired' ? 'selected' : '' }}>منتهي</option>
                                    <option value="canceled" {{ old('subscription_status', $user->subscription?->status) === 'canceled' ? 'selected' : '' }}>ملغي</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="subscription_course_id" class="mb-1 block">دورة الاشتراك</label>
                                <select name="subscription_course_id" id="subscription_course_id"
                                    class="w-full p-2 rounded border">
                                    <option value="">لا يوجد</option>
                                    @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('subscription_course_id', $user->subscription?->course_id) == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="subscription_start_date" class="mb-1 block">تاريخ البدء</label>
                                <input type="date" name="subscription_start_date" id="subscription_start_date"
                                    value="{{ old('subscription_start_date', $user->subscription?->start_date?->format('Y-m-d')) }}"
                                    class="w-full p-2 rounded border">
                            </div>

                            <div class="mb-4">
                                <label for="subscription_end_date" class="mb-1 block">تاريخ الانتهاء</label>
                                <input type="date" name="subscription_end_date" id="subscription_end_date"
                                    value="{{ old('subscription_end_date', $user->subscription?->end_date?->format('Y-m-d')) }}"
                                    class="w-full p-2 rounded border">
                            </div>
                        </div>
                        @endif
                    </div>

                    <button type="submit" class="submit-btn mt-6 w-full p-3 rounded text-white font-bold">
                        تحديث المستخدم
                    </button>
                </form>

                <a href="{{ route('users.index') }}" class="mt-4 inline-block text-center w-full link-back">⬅ العودة إلى الطلاب</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
