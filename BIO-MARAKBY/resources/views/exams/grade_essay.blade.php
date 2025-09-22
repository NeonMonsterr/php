```html
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تصحيح الأسئلة المقالية - {{ $exam->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f9fafb;
        }
        .background-gif {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.06;
            z-index: -1;
        }
        .error-message, .warning-message {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        .error-message {
            color: #dc2626;
        }
        .warning-message {
            color: #f59e0b;
        }
        .debug-section {
            display: none;
            background-color: #f3f4f6;
            padding: 1rem;
            margin-top: 1rem;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>
    <img src="/images/biology-bg.gif" alt="Background" class="background-gif">

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 p-6 md:p-10">
            <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-6 md:p-8">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">📖 تصحيح الأسئلة المقالية</h1>
                        <p class="text-gray-600 mt-1">امتحان: <span class="font-semibold">{{ $exam->title }}</span></p>
                        <p class="text-gray-600">الطالب: <span class="font-semibold">{{ $student->name }}</span></p>
                    </div>
                    <a href="{{ route('exams.allresult', $exam->id) }}"
                       class="text-blue-600 hover:text-blue-800 font-medium">
                        ← العودة للنتائج
                    </a>
                </div>

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <p class="font-semibold">أخطاء أثناء الحفظ:</p>
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('exams.grade_essay.save', [$exam->id, $student->id]) }}" method="POST" class="space-y-6" id="gradeForm">
                    @csrf

                    @forelse($questions as $question)
                        @php
                            $userAnswer = $question->answers->first();
                        @endphp
                        <div class="border rounded-lg p-5 bg-gray-50 shadow-sm hover:shadow-md transition">
                            <h3 class="font-semibold text-lg text-gray-800 mb-2">س: {{ $question->question_text }}</h3>
                            <p class="text-sm text-gray-500 mb-4">الدرجة الكلية: {{ $question->points }} | السؤال ID: {{ $question->id }}</p>

                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-600">✏️ إجابة الطالب:</label>
                                <div class="border rounded-lg p-3 bg-white mt-1 text-gray-800 min-h-[60px]">
                                    {{ $userAnswer->answer_text ?? 'لم يتم الإجابة' }}
                                </div>
                                @if(!$userAnswer)
                                    <p class="warning-message">⚠️ لا توجد إجابة مقدمة لهذا السؤال، سيتم إنشاء سجل عند التصحيح.</p>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-600">✅ الإجابة النموذجية:</label>
                                <div class="border rounded-lg p-3 bg-white mt-1 text-gray-800 min-h-[60px]">
                                    {{ $question->essayAnswer->answer_text ?? 'غير محدد' }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-600">🎯 الدرجة الممنوحة:</label>
                                <input type="number"
                                       name="grades[{{$question->id}}][points_earned]"
                                       value="{{ $userAnswer->score ?? 0 }}"
                                       min="0"
                                       max="{{ $question->points }}"
                                       step="1"
                                       class="border rounded-lg p-2 w-full focus:ring focus:ring-green-300 points-earned"
                                       data-max-points="{{ $question->points }}"
                                       data-question-id="{{ $question->id }}"
                                       required>
                                <input type="hidden" name="grades[{{$question->id}}][question_id]" value="{{ $question->id }}">
                                @error("grades.{$question->id}.points_earned")
                                    <p class="error-message" data-laravel-error="true">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="debug-section">
                                <p>Debug Info for Question ID: {{ $question->id }}</p>
                                <p>Answer Exists: {{ $userAnswer ? 'Yes (ID: ' . $userAnswer->id . ')' : 'No' }}</p>
                                <p>Current score: {{ $userAnswer->score ?? 'N/A' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-red-600 font-medium">⚠️ لا توجد أسئلة مقالية لهذا الامتحان.</p>
                    @endforelse

                    <div class="flex justify-between items-center pt-4 border-t">
                        <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium shadow">
                            💾 حفظ الدرجات
                        </button>
                        <a href="{{ route('exams.allresult', $exam->id) }}"
                           class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium shadow">
                            ← العودة
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('gradeForm');
            const pointInputs = document.querySelectorAll('.points-earned');

            form.addEventListener('submit', function (e) {
                const formData = new FormData(form);
                const data = Object.fromEntries(formData);
                console.log('Form Data:', JSON.stringify(data, null, 2));
                pointInputs.forEach(input => {
                    const questionId = input.getAttribute('data-question-id');
                    const value = parseInt(input.value);
                    const maxPoints = parseInt(input.getAttribute('data-max-points'));
                    console.log(`Question ${questionId}: points_earned=${value}, max=${maxPoints}`);
                });

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                })
                .then(response => response.json().catch(() => ({})))
                .then(data => console.log('Server Response:', data))
                .catch(error => console.error('Fetch Error:', error));
            });

            pointInputs.forEach(input => {
                input.addEventListener('input', function () {
                    const maxPoints = parseInt(this.getAttribute('data-max-points'));
                    let value = parseInt(this.value);

                    if (isNaN(value) || value < 0) {
                        this.value = 0;
                    } else if (value > maxPoints) {
                        this.value = maxPoints;
                    } else {
                        this.value = Math.floor(value);
                    }
                });
            });

            form.addEventListener('submit', function (e) {
                let hasError = false;
                pointInputs.forEach(input => {
                    const maxPoints = parseInt(input.getAttribute('data-max-points'));
                    const value = parseInt(input.value);
                    const questionId = input.getAttribute('data-question-id');

                    if (isNaN(value) || value < 0 || value > maxPoints) {
                        hasError = true;
                        input.classList.add('border-red-500');
                        let errorDiv = input.nextElementSibling;
                        if (!errorDiv || !errorDiv.classList.contains('error-message')) {
                            errorDiv = document.createElement('div');
                            errorDiv.className = 'error-message';
                            errorDiv.textContent = `يجب أن تكون الدرجة بين 0 و ${maxPoints}`;
                            input.parentNode.insertBefore(errorDiv, input.nextSibling);
                        }
                    } else {
                        input.classList.remove('border-red-500');
                        const errorDiv = input.nextElementSibling;
                        if (errorDiv && errorDiv.classList.contains('error-message') && !errorDiv.getAttribute('data-laravel-error')) {
                            errorDiv.remove();
                        }
                    }
                });

                if (hasError) {
                    e.preventDefault();
                    alert('يرجى تصحيح أخطاء إدخال الدرجات قبل الحفظ.');
                }
            });

            const debugSections = document.querySelectorAll('.debug-section');
            debugSections.forEach(section => {
                section.style.display = 'block'; // Set to 'none' in production
            });
        });
    </script>
</body>
</html>
```
