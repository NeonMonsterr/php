<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء طالب</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            opacity: 0.1;
            z-index: -1;
            pointer-events: none;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            padding: 2.5rem;
            width: 100%;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c);
            background-size: 300% 300%;
            animation: gradientShift 6s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.18);
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-input, .form-select {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.8), rgba(248, 250, 252, 0.8));
            border: 1px solid rgba(102, 126, 234, 0.3);
            border-radius: 1rem;
            color: #2d3748;
            font-size: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-input:focus, .form-select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-1px);
        }

        .input-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 1.1rem;
            pointer-events: none;
        }

        .submit-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 1rem;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            display: block;
            width: 100%;
            cursor: pointer;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #5a67d8, #6b46c1);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .return-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: #60a5fa;
            font-weight: 600;
            text-decoration: none;
            padding: 0.75rem 1.5rem;
            border: 1px solid #60a5fa;
            border-radius: 1rem;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .return-link:hover {
            background: #60a5fa;
            color: white;
            transform: translateY(-2px);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .note-text {
            color: #a0aec0;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            font-style: italic;
        }

        .error-alert {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.1));
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 1rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .error-alert ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .error-alert li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #dc2626;
            font-size: 0.875rem;
        }

        /* Enhanced Stars - Light twinkle */
        .star {
            position: absolute;
            width: 8px;
            height: 8px;
            background: #f093fb;
            border-radius: 50%;
            opacity: 0.6;
            animation: twinkle 5s infinite ease-in-out;
            box-shadow: 0 0 10px rgba(240, 147, 251, 0.5);
        }

        .star:nth-child(1) { top: 10%; left: 15%; animation-delay: 0s; }
        .star:nth-child(2) { top: 40%; left: 80%; animation-delay: 1s; }
        .star:nth-child(3) { top: 70%; left: 25%; animation-delay: 2s; }
        .star:nth-child(4) { top: 20%; left: 50%; animation-delay: 0.5s; }
        .star:nth-child(5) { top: 85%; left: 70%; animation-delay: 1.5s; }
        .star:nth-child(6) { top: 60%; left: 10%; animation-delay: 2.5s; }
        .star:nth-child(7) { top: 30%; left: 90%; animation-delay: 3s; }

        @keyframes twinkle {
            0%, 100% {
                transform: translateY(0px) scale(1);
                opacity: 0.6;
            }
            50% {
                transform: translateY(-5px) scale(1.1);
                opacity: 0.8;
            }
        }

        /* Mobile Responsiveness */
        @media (max-width: 640px) {
            .card {
                padding: 1.5rem;
                margin: 0 1rem;
            }
            .form-input, .form-select {
                padding-right: 2.5rem;
            }
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="خلفية" class="background-gif">

    <!-- Enhanced Decorative Stars -->
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>
    <div class="star"></div>

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 p-4 sm:p-6 md:mr-64 flex flex-col gap-8">
            <div class="card max-w-lg mx-auto">
                <div class="flex justify-between items-center mb-6 md:hidden">
                    <h1 class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">إنشاء طالب</h1>
                    <button class="text-gray-600" id="sidebar-open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>

                <h1 class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 mb-6 text-center hidden md:block">إنشاء طالب</h1>

                @if ($errors->any())
                    <div class="error-alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-user"></i> الاسم
                        </label>
                        <input type="text" id="name" name="name" required
                            value="{{ old('name') }}"
                            class="form-input" placeholder="أدخل الاسم الكامل">
                        <div class="input-icon"><i class="fas fa-user"></i></div>
                        @error('name')
                        <p class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i> البريد الإلكتروني
                        </label>
                        <input type="email" id="email" name="email" required
                            value="{{ old('email') }}"
                            class="form-input" placeholder="example@email.com">
                        <div class="input-icon"><i class="fas fa-envelope"></i></div>
                        @error('email')
                        <p class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i> كلمة المرور
                        </label>
                        <input type="password" id="password" name="password" required
                            class="form-input" placeholder="••••••••">
                        <div class="input-icon"><i class="fas fa-lock"></i></div>
                        @error('password')
                        <p class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock-open"></i> تأكيد كلمة المرور
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="form-input" placeholder="••••••••">
                        <div class="input-icon"><i class="fas fa-lock-open"></i></div>
                    </div>

                    <div class="form-group">
                        <label for="phone_number" class="form-label">
                            <i class="fas fa-phone"></i> رقم الهاتف
                        </label>
                        <input type="text" id="phone_number" name="phone_number" required
                            value="{{ old('phone_number') }}"
                            class="form-input" placeholder="01012345678">
                        <div class="input-icon"><i class="fas fa-phone"></i></div>
                        @error('phone_number')
                        <p class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="parent_phone_number" class="form-label">
                            <i class="fas fa-user-friends"></i> رقم هاتف ولي الأمر
                        </label>
                        <input type="text" id="parent_phone_number" name="parent_phone_number" required
                            value="{{ old('parent_phone_number') }}"
                            class="form-input" placeholder="01012345678">
                        <div class="input-icon"><i class="fas fa-user-friends"></i></div>
                        @error('parent_phone_number')
                        <p class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Level Selection -->
                    <div class="form-group">
                        <label for="level_id" class="form-label">
                            <i class="fas fa-chart-line"></i> المستوى
                        </label>
                        <select id="level_id" name="level_id" class="form-select">
                            <option value="">اختر المستوى...</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>
                                    {{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="input-icon"><i class="fas fa-chart-line"></i></div>
                        @error('level_id')
                        <p class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stage Selection -->
                    <div class="form-group">
                        <label for="stage_id" class="form-label">
                            <i class="fas fa-graduation-cap"></i> المرحلة
                        </label>
                        <select id="stage_id" name="stage_id" class="form-select">
                            <option value="">اختر المرحلة...</option>
                            @foreach ($stages as $stage)
                                <option value="{{ $stage->id }}"
                                    data-level="{{ $stage->level_id }}"
                                    {{ old('stage_id') == $stage->id ? 'selected' : '' }}>
                                    {{ $stage->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="input-icon"><i class="fas fa-graduation-cap"></i></div>
                        @error('stage_id')
                        <p class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</p>
                        @enderror
                        <p class="note-text">يرجى اختيار المستوى أولاً لعرض المراحل المتاحة</p>
                    </div>

                    <div class="form-group">
                        <label for="course_id" class="form-label">
                            <i class="fas fa-book"></i> الدورة
                        </label>
                        <select id="course_id" name="course_id" class="form-select">
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
                        <div class="input-icon"><i class="fas fa-book"></i></div>
                        @error('course_id')
                        <p class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-user-plus mr-2"></i> إنشاء طالب
                    </button>
                </form>

                <a href="{{ route('users.index') }}" class="return-link">
                    <i class="fas fa-arrow-right"></i> العودة إلى الطلاب
                </a>
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

            // Light entrance animations
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.opacity = '0';
                group.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    group.style.transition = 'all 0.6s ease';
                    group.style.opacity = '1';
                    group.style.transform = 'translateY(0)';
                }, index * 150);
            });
        });
    </script>
</body>

</html>
