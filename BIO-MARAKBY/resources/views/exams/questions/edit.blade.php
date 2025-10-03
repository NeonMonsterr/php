<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تعديل أسئلة الامتحان</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f9fafb;
            color: #111827;
            overflow-x: hidden;
        }

        .remove-question {
            position: absolute;
            left: 1rem;
            top: 1rem;
            color: #ef4444;
            cursor: pointer;
            font-size: 1.25rem;
        }

        .image-preview {
            transition: all 0.3s ease;
        }

        .image-preview:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="flex min-h-screen bg-gray-100">
        @include('partials.sidebar')

        <div class="flex-1 p-6 flex flex-col items-center">
            <div class="w-full max-w-4xl bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-extrabold mb-8 text-center text-gray-900 border-b pb-4">
                    ✏️ تعديل أسئلة الامتحان: <span class="text-blue-600">{{ $exam->name }}</span>
                </h2>

                <form method="POST" action="{{ route('exams.questions.update', $exam) }}" id="questions-form"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div id="questions-container">
                        @foreach ($exam->questions as $index => $question)
                            <div class="question-block relative border border-gray-200 rounded-lg p-6 mb-6 bg-gray-50 shadow-sm"
                                id="question-{{ $index }}" data-index="{{ $index }}">
                                <input type="hidden" name="questions[{{ $index }}][id]"
                                    value="{{ $question->id }}">

                                {{-- Question Header --}}
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="text-lg font-semibold text-gray-800">📝 سؤال رقم {{ $index + 1 }}</h3>
                                    <button type="button" class="remove-question"
                                        onclick="document.getElementById('question-{{ $index }}').remove()">×</button>
                                </div>

                                {{-- Question Text --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">نص السؤال</label>
                                    <input type="text" name="questions[{{ $index }}][question_text]"
                                        value="{{ $question->question_text }}" required
                                        class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-2">
                                </div>

                                {{-- Question Type + Points --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">نوع السؤال</label>
                                        <select name="questions[{{ $index }}][type]"
                                            class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-2 question-type-selector"
                                            data-index="{{ $index }}">
                                            <option value="mcq"
                                                {{ $question->type === 'mcq' ? 'selected' : '' }}>اختيار من متعدد</option>
                                            <option value="essay"
                                                {{ $question->type === 'essay' ? 'selected' : '' }}>مقالي</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">الدرجة</label>
                                        <input type="number" name="questions[{{ $index }}][points]" min="1"
                                            value="{{ $question->points }}" required
                                            class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-2">
                                    </div>
                                </div>

                                {{-- MCQ Options --}}
                                <div id="options-container-{{ $index }}"
                                    class="{{ $question->type === 'essay' ? 'hidden' : '' }} mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">الخيارات</label>
                                    @php
                                        $options =
                                            $question->options->count() > 0
                                                ? $question->options
                                                : collect([new App\Models\Option(), new App\Models\Option(), new App\Models\Option(), new App\Models\Option()]);
                                    @endphp
                                    @foreach ($options as $optIndex => $option)
                                        <div class="flex items-center gap-2 mb-2">
                                            <input type="text"
                                                name="questions[{{ $index }}][options][{{ $optIndex }}][text]"
                                                value="{{ $option->option_text ?? '' }}"
                                                placeholder="الخيار {{ $optIndex + 1 }}"
                                                class="flex-1 rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-2">
                                            <input type="radio" name="questions[{{ $index }}][correct_option]"
                                                value="{{ $optIndex }}"
                                                {{ $option->is_correct ?? false ? 'checked' : '' }}>
                                            <span class="text-sm text-gray-600">إجابة صحيحة</span>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Essay Answer --}}
                                <div id="essay-answer-{{ $index }}"
                                    class="{{ $question->type === 'mcq' ? 'hidden' : '' }} mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">نموذج الإجابة</label>
                                    <textarea name="questions[{{ $index }}][answer_text]" rows="3"
                                        class="w-full rounded-md border-gray-300 focus:ring-blue-500 focus:border-blue-500 p-2">{{ $question->essayAnswer->answer_text ?? '' }}</textarea>
                                </div>

                                {{-- Images --}}
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">صور مرفقة</label>
                                    <div class="flex flex-wrap gap-3">
                                        @if ($question->images->count())
                                            @foreach ($question->images as $image)
                                                <div class="relative w-32 h-24 group border rounded overflow-hidden">
                                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                                        class="w-full h-full object-cover image-preview">
                                                    <button type="button"
                                                        class="absolute top-1 right-1 bg-red-500 text-white rounded-full px-2 py-0.5 text-xs opacity-80 hover:opacity-100"
                                                        onclick="deleteImage(event, {{ $image->id }})">×</button>
                                                    <input type="hidden"
                                                        name="questions[{{ $index }}][existing_images][]"
                                                        value="{{ $image->id }}">
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <input type="file" name="questions[{{ $index }}][new_images][]" multiple
                                        class="mt-3 block w-full text-sm text-gray-600 border border-gray-300 rounded-md cursor-pointer focus:outline-none">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 flex justify-center">
                        <button type="submit" id="submit-btn"
                            class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-2 rounded-lg shadow hover:from-blue-600 hover:to-indigo-700 transition">
                            💾 حفظ التعديلات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // إدارة عرض الخيارات بناءً على نوع السؤال
            document.querySelectorAll('.question-type-selector').forEach(select => {
                const index = select.dataset.index;
                toggleQuestionType(index);

                select.addEventListener('change', function() {
                    toggleQuestionType(index);
                });
            });

            function toggleQuestionType(index) {
                const questionBlock = document.getElementById(`question-${index}`);
                if (!questionBlock) return;

                const type = questionBlock.querySelector(`select[name="questions[${index}][type]"]`).value;
                const optionsContainer = document.getElementById(`options-container-${index}`);
                const essayContainer = document.getElementById(`essay-answer-${index}`);

                if (type === 'mcq') {
                    optionsContainer.classList.remove('hidden');
                    essayContainer.classList.add('hidden');
                } else {
                    optionsContainer.classList.add('hidden');
                    essayContainer.classList.remove('hidden');
                }
            }

            // حذف الصورة
            window.deleteImage = function(event, imageId) {
                event.preventDefault();

                if (confirm('هل أنت متأكد من حذف هذه الصورة؟')) {
                    fetch(`/question-images/${imageId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    }).then(response => {
                        if (response.ok) {
                            event.target.closest('.relative').remove();
                        } else {
                            alert('فشل في حذف الصورة');
                        }
                    });
                }
            };

            // إرسال النموذج مع حالة زر التحميل
            const form = document.getElementById('questions-form');
            if (form) {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const submitBtn = document.getElementById('submit-btn');
                    const originalText = submitBtn.textContent;

                    try {
                        submitBtn.disabled = true;
                        submitBtn.textContent = '⏳ جاري الحفظ...';

                        const formData = new FormData(form);
                        const response = await fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        });

                        const data = await response.json();

                        if (response.ok && data.success) {
                            window.location.href = data.redirect ||
                                '{{ route('exams.show', $exam->id) }}';
                        } else {
                            alert(data.message || 'حدث خطأ أثناء الحفظ');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('حدث خطأ في الاتصال بالخادم');
                    } finally {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                    }
                });
            }
        });
    </script>
</body>

</html>
