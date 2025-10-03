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

        .note-text {
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 0.25rem;
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

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-700">
                        <ul class="text-sm list-disc pr-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

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

                    <div class="mb-4">
                        <label for="phone_number" class="block form-label mb-2">رقم الهاتف</label>
                        <input type="text" id="phone_number" name="phone_number" required
                            value="{{ old('phone_number') }}"
                            class="w-full p-2 border rounded form-input focus:outline-none focus:ring-2"
                            placeholder="01012345678">
                        @error('phone_number')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="parent_phone_number" class="block form-label mb-2">رقم هاتف ولي الأمر</label>
                        <input type="text" id="parent_phone_number" name="parent_phone_number" required
                            value="{{ old('parent_phone_number') }}"
                            class="w-full p-2 border rounded form-input focus:outline-none focus:ring-2"
                            placeholder="01012345678">
                        @error('parent_phone_number')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Level Selection -->
                    <div class="mb-4">
                        <label for="level_id" class="block form-label mb-2">المستوى</label>
                        <select id="level_id" name="level_id"
                            class="w-full p-2 border rounded form-input text-black bg-white text-sm">
                            <option value="">اختر المستوى...</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>
                                    {{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('level_id')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stage Selection -->
                    <div class="mb-4">
                        <label for="stage_id" class="block form-label mb-2">المرحلة</label>
                        <select id="stage_id" name="stage_id"
                            class="w-full p-2 border rounded form-input text-black bg-white text-sm">
                            <option value="">اختر المرحلة...</option>
                            @foreach ($stages as $stage)
                                <option value="{{ $stage->id }}"
                                    data-level="{{ $stage->level_id }}"
                                    {{ old('stage_id') == $stage->id ? 'selected' : '' }}>
                                    {{ $stage->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('stage_id')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="note-text">يرجى اختيار المستوى أولاً لعرض المراحل المتاحة</p>
                    </div>

                    <div class="mb-6">
                        <label for="course_id" class="block form-label mb-2">الدورة</label>
                        <select id="course_id" name="course_id"
                            class="w-full p-2 border rounded form-input text-black bg-white text-sm">
                            <option value="">اختر الدورة...</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}"
                                    data-stage="{{ $course->stage_id }}"
                                    data-level="{{ $course->level_id }}"
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stageSelect = document.getElementById('stage_id');
            const levelSelect = document.getElementById('level_id');
            const courseSelect = document.getElementById('course_id');

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

            // Add event listeners
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
        });
    </script>
</body>

</html>
