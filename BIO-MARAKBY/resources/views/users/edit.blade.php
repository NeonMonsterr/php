<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المستخدم: {{ $user->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                        },
                        secondary: {
                            500: '#8b5cf6',
                            600: '#7c3aed',
                        }
                    },
                    fontFamily: {
                        'tajawal': ['Tajawal', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 4px 20px rgba(0, 0, 0, 0.08)',
                        'medium': '0 8px 30px rgba(0, 0, 0, 0.12)',
                    }
                }
            }
        }
    </script>
    <style>
        * {
            font-family: 'Tajawal', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .form-input {
            transition: all 0.3s ease;
            border: 2px solid #e2e8f0;
            background: rgba(255, 255, 255, 0.7);
        }

        .form-input:focus {
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
            background: rgba(255, 255, 255, 0.9);
        }

        .section-title {
            position: relative;
            padding-bottom: 12px;
            margin-bottom: 24px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #0ea5e9, #8b5cf6);
            border-radius: 2px;
        }

        .btn-primary {
            background: linear-gradient(90deg, #0ea5e9, #8b5cf6);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(14, 165, 233, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 1);
            border-color: #0ea5e9;
            transform: translateY(-1px);
        }

        .divider {
            width: 1px;
            background: linear-gradient(to bottom, transparent, #cbd5e1, transparent);
        }

        .user-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0ea5e9, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 40px;
            margin: 0 auto 20px;
            box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
        }

        .subscription-section {
            transition: all 0.4s ease;
        }

        .subscription-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-active {
            background: rgba(34, 197, 94, 0.15);
            color: #16a34a;
        }

        .badge-expired {
            background: rgba(239, 68, 68, 0.15);
            color: #dc2626;
        }

        .badge-canceled {
            background: rgba(107, 114, 128, 0.15);
            color: #6b7280;
        }

        .floating-label {
            position: absolute;
            top: -10px;
            right: 12px;
            background: white;
            padding: 0 8px;
            font-size: 0.85rem;
            color: #0ea5e9;
            font-weight: 600;
            border-radius: 4px;
        }

        .input-container {
            position: relative;
            margin-top: 10px;
        }

        .course-option {
            display: flex;
            justify-content: space-between;
            padding: 8px 12px;
        }

        .course-type-badge {
            font-size: 0.75rem;
            padding: 2px 8px;
            border-radius: 12px;
            background: #f1f5f9;
        }

        .course-type-user {
            background: #e0f2fe;
            color: #0369a1;
        }

        .course-type-subscription {
            background: #f3e8ff;
            color: #7c3aed;
        }

        @media (max-width: 1024px) {
            .divider {
                width: 100%;
                height: 1px;
                margin: 20px 0;
            }
        }

        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.05;
        }

        .animated-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%230ea5e9' fill-opacity='0.2' fill-rule='evenodd'/%3E%3C/svg%3E");
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0);
            }
            100% {
                transform: translate(-100px, -100px);
            }
        }
    </style>
</head>

<body>
    <div class="animated-bg"></div>

    <div class="min-h-screen flex items-center justify-center p-4 py-8">
        <div class="glass-card w-full max-w-5xl">
            <div class="p-8">
                <!-- Header Section -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="user-avatar">
                            <i class="fas fa-user-edit"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">تعديل المستخدم</h1>
                            <p class="text-gray-600 mt-1">{{ $user->name }}</p>
                        </div>
                    </div>

                    <div class="flex space-x-3 space-x-reverse">
                        <a href="{{ route('users.index') }}" class="btn-secondary px-5 py-2.5 rounded-lg font-medium flex items-center">
                            <i class="fas fa-arrow-right ml-2"></i>
                            العودة إلى المستخدمين
                        </a>
                    </div>
                </div>

                <!-- Status Messages -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 ml-2"></i>
                            <h3 class="text-red-700 font-semibold">يوجد أخطاء في المدخلات</h3>
                        </div>
                        <ul class="mt-2 text-red-600 text-sm list-disc pr-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center">
                        <i class="fas fa-check-circle text-green-500 ml-2"></i>
                        <span class="text-green-700 font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- User Edit Form -->
                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-col lg:flex-row">
                        <!-- User Details Section -->
                        <div class="w-full lg:w-1/2 lg:pr-6">
                            <div class="section-title">
                                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                                    <i class="fas fa-user-circle ml-2 text-primary-500"></i>
                                    بيانات المستخدم
                                </h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="input-container">
                                    <label for="name" class="floating-label">الاسم الكامل</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                           class="form-input w-full p-3.5 rounded-lg">
                                    @error('name')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-container">
                                    <label for="email" class="floating-label">البريد الإلكتروني</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                           class="form-input w-full p-3.5 rounded-lg">
                                    @error('email')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-container md:col-span-2">
                                    <label for="role" class="floating-label">الدور</label>
                                    <select name="role" id="role" class="form-input w-full p-3.5 rounded-lg">
                                        <option value="student" {{ old('role', $user->role) === 'student' ? 'selected' : '' }}>طالب</option>
                                        <option value="teacher" {{ old('role', $user->role) === 'teacher' ? 'selected' : '' }}>معلم</option>
                                    </select>
                                    @error('role')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Level Selection -->
                                <div class="input-container">
                                    <label for="level_id" class="floating-label">المستوى</label>
                                    <select name="level_id" id="level_id" class="form-input w-full p-3.5 rounded-lg">
                                        <option value="">اختر المستوى...</option>
                                        @foreach($levels as $level)
                                            <option value="{{ $level->id }}" {{ old('level_id', $user->level_id) == $level->id ? 'selected' : '' }}>
                                                {{ $level->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('level_id')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Stage Selection -->
                                <div class="input-container">
                                    <label for="stage_id" class="floating-label">المرحلة</label>
                                    <select name="stage_id" id="stage_id" class="form-input w-full p-3.5 rounded-lg">
                                        <option value="">اختر المرحلة...</option>
                                        @foreach($stages as $stage)
                                            <option value="{{ $stage->id }}"
                                                data-level="{{ $stage->level_id }}"
                                                {{ old('stage_id', $user->stage_id) == $stage->id ? 'selected' : '' }}>
                                                {{ $stage->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('stage_id')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                    <p class="text-xs text-gray-500 mt-1">يرجى اختيار المستوى أولاً لعرض المراحل المتاحة</p>
                                </div>

                                <div class="input-container">
                                    <label for="phone_number" class="floating-label">رقم الهاتف</label>
                                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                                           class="form-input w-full p-3.5 rounded-lg" placeholder="01012345678">
                                    @error('phone_number')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-container">
                                    <label for="parent_phone_number" class="floating-label">رقم ولي الأمر</label>
                                    <input type="text" name="parent_phone_number" id="parent_phone_number" value="{{ old('parent_phone_number', $user->parent_phone_number) }}"
                                           class="form-input w-full p-3.5 rounded-lg" placeholder="01012345678">
                                    @error('parent_phone_number')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Courses Filtered by Stage + Level -->
                                <div class="input-container md:col-span-2">
                                    <label for="course_id" class="floating-label">الدورة</label>
                                    <select name="course_id" id="course_id" class="form-input w-full p-3.5 rounded-lg">
                                        <option value="">اختر دورة...</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}"
                                                data-stage="{{ $course->stage_id }}"
                                                data-level="{{ $course->level_id }}"
                                                {{ old('course_id', $user->course_id) == $course->id ? 'selected' : '' }}>
                                                {{ $course->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('course_id')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-6">
                                <h3 class="font-semibold text-gray-700 mb-3 flex items-center">
                                    <i class="fas fa-lock ml-2 text-primary-500"></i>
                                    كلمة المرور
                                </h3>
                                <p class="text-sm text-gray-500 mb-4">اترك الحقول فارغة إذا لم ترد تغيير كلمة المرور</p>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="input-container">
                                        <label for="password" class="floating-label">كلمة المرور الجديدة</label>
                                        <input type="password" name="password" id="password"
                                               class="form-input w-full p-3.5 rounded-lg">
                                        @error('password')
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="input-container">
                                        <label for="password_confirmation" class="floating-label">تأكيد كلمة المرور</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                               class="form-input w-full p-3.5 rounded-lg">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="divider my-6 lg:my-0 lg:mx-6"></div>

                        <!-- Subscription Section -->
                        <div class="w-full lg:w-1/2 lg:pl-6 subscription-section" id="subscription-section">
                            <div class="section-title">
                                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                                    <i class="fas fa-crown ml-2 text-secondary-600"></i>
                                    تفاصيل الاشتراك
                                    @if($user->subscription)
                                        @if($user->subscription->status === 'active')
                                            <span class="subscription-badge badge-active mr-3">
                                                <i class="fas fa-check-circle ml-1"></i> نشط
                                            </span>
                                        @elseif($user->subscription->status === 'expired')
                                            <span class="subscription-badge badge-expired mr-3">
                                                <i class="fas fa-clock ml-1"></i> منتهي
                                            </span>
                                        @else
                                            <span class="subscription-badge badge-canceled mr-3">
                                                <i class="fas fa-times-circle ml-1"></i> ملغي
                                            </span>
                                        @endif
                                    @endif
                                </h2>
                            </div>

                            <div class="grid grid-cols-1 gap-5">
                                <div class="input-container">
                                    <label for="subscription_type" class="floating-label">نوع الاشتراك</label>
                                    <select name="subscription_type" id="subscription_type" class="form-input w-full p-3.5 rounded-lg">
                                        <option value="">اختر نوع الاشتراك...</option>
                                        <option value="monthly" {{ old('subscription_type', $user->subscription?->type) === 'monthly' ? 'selected' : '' }}>اشتراك شهري</option>
                                        <option value="yearly" {{ old('subscription_type', $user->subscription?->type) === 'yearly' ? 'selected' : '' }}>اشتراك سنوي</option>
                                    </select>
                                    @error('subscription_type')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-container">
                                    <label for="subscription_status" class="floating-label">حالة الاشتراك</label>
                                    <select name="subscription_status" id="subscription_status" class="form-input w-full p-3.5 rounded-lg">
                                        <option value="">اختر الحالة...</option>
                                        <option value="active" {{ old('subscription_status', $user->subscription?->status) === 'active' ? 'selected' : '' }}>نشط</option>
                                        <option value="expired" {{ old('subscription_status', $user->subscription?->status) === 'expired' ? 'selected' : '' }}>منتهي</option>
                                        <option value="canceled" {{ old('subscription_status', $user->subscription?->status) === 'canceled' ? 'selected' : '' }}>ملغي</option>
                                    </select>
                                    @error('subscription_status')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="input-container">
                                    <label for="subscription_course_id" class="floating-label">دورة الاشتراك</label>
                                    <select name="subscription_course_id" id="subscription_course_id" class="form-input w-full p-3.5 rounded-lg">
                                        <option value="">اختر دورة الاشتراك...</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{ old('subscription_course_id', $user->subscription?->course_id) == $course->id ? 'selected' : '' }}>
                                                {{ $course->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subscription_course_id')
                                        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div class="input-container">
                                        <label for="subscription_start_date" class="floating-label">تاريخ البدء</label>
                                        <input type="date" name="subscription_start_date" id="subscription_start_date"
                                            value="{{ old('subscription_start_date', $user->subscription?->start_date?->format('Y-m-d')) }}"
                                            class="form-input w-full p-3.5 rounded-lg">
                                        @error('subscription_start_date')
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="input-container">
                                        <label for="subscription_end_date" class="floating-label">تاريخ الانتهاء</label>
                                        <input type="date" name="subscription_end_date" id="subscription_end_date"
                                            value="{{ old('subscription_end_date', $user->subscription?->end_date?->format('Y-m-d')) }}"
                                            class="form-input w-full p-3.5 rounded-lg">
                                        @error('subscription_end_date')
                                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-100">
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle text-blue-500 mt-1 ml-2"></i>
                                    <div>
                                        <h4 class="font-semibold text-blue-700">ملاحظة حول الاشتراك</h4>
                                        <p class="text-blue-600 text-sm mt-1">سيتم إخفاء قسم الاشتراك تلقائيًا عند اختيار دور "معلم". الاشتراكات متاحة للطلاب فقط.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-10 pt-6 border-t border-gray-200 flex justify-center">
                        <button type="submit" class="btn-primary px-8 py-3.5 rounded-lg text-white font-semibold text-lg flex items-center">
                            <i class="fas fa-save ml-2"></i>
                            تحديث بيانات المستخدم
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const subscriptionSection = document.getElementById('subscription-section');
            const courseSelect = document.getElementById('course_id');
            const subscriptionCourseSelect = document.getElementById('subscription_course_id');
            const stageSelect = document.getElementById('stage_id');
            const levelSelect = document.getElementById('level_id');

            function toggleSubscriptionSection() {
                if (roleSelect.value === 'student') {
                    subscriptionSection.style.display = 'block';
                    setTimeout(() => {
                        subscriptionSection.style.opacity = '1';
                        subscriptionSection.style.transform = 'translateY(0)';
                    }, 10);
                } else {
                    subscriptionSection.style.opacity = '0';
                    subscriptionSection.style.transform = 'translateY(10px)';
                    setTimeout(() => {
                        subscriptionSection.style.display = 'none';
                    }, 400);
                }
            }

            // Filter stages based on selected level
            function filterStages() {
                const selectedLevel = levelSelect.value;

                Array.from(stageSelect.options).forEach(option => {
                    if (!option.value) return; // skip placeholder
                    const level = option.dataset.level;
                    option.style.display = (level === selectedLevel) ? 'block' : 'none';
                });

                // Reset selection if current stage not matching
                const selectedStage = stageSelect.value;
                const selectedOption = stageSelect.querySelector(`option[value="${selectedStage}"]`);
                if (selectedOption && selectedOption.style.display === 'none') {
                    stageSelect.value = '';
                }

                // Trigger course filter after stage reset
                filterCourses();
            }

            // Filter courses based on selected stage and level
            function filterCourses() {
                const selectedStage = stageSelect.value;
                const selectedLevel = levelSelect.value;

                Array.from(courseSelect.options).forEach(option => {
                    if (!option.value) return; // skip placeholder
                    const stage = option.dataset.stage;
                    const level = option.dataset.level;
                    option.style.display = (stage === selectedStage && level === selectedLevel) ? 'block' : 'none';
                });

                // Reset selection if current course not matching
                const selectedCourse = courseSelect.value;
                const selectedOption = courseSelect.querySelector(`option[value="${selectedCourse}"]`);
                if (selectedOption && selectedOption.style.display === 'none') {
                    courseSelect.value = '';
                }
            }

            // Initial toggle based on current role
            toggleSubscriptionSection();

            // Add event listener for role changes
            roleSelect.addEventListener('change', toggleSubscriptionSection);

            // Add event listeners for level and stage changes
            levelSelect.addEventListener('change', filterStages);
            stageSelect.addEventListener('change', filterCourses);

            // Initial filter on page load
            filterStages();
            filterCourses();

            // Add phone number formatting
            const phoneInputs = document.querySelectorAll('input[type="text"][name*="phone"]');
            phoneInputs.forEach(input => {
                input.addEventListener('input', function(e) {
                    // Remove any non-digit characters
                    let value = e.target.value.replace(/\D/g, '');

                    // Limit to 11 digits (01012345678)
                    if (value.length > 11) {
                        value = value.substring(0, 11);
                    }

                    e.target.value = value;
                });
            });

            // Add animation to form inputs on focus
            const formInputs = document.querySelectorAll('.form-input');
            formInputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('transform', 'scale-105');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('transform', 'scale-105');
                });
            });

            // Sync course selection between user course and subscription course
            courseSelect.addEventListener('change', function() {
                if (this.value) {
                    subscriptionCourseSelect.value = this.value;
                }
            });

            subscriptionCourseSelect.addEventListener('change', function() {
                if (this.value) {
                    courseSelect.value = this.value;
                }
            });
        });
    </script>
</body>

</html>
