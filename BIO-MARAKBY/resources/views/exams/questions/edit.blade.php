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
            background-color: white;
            color: black;
            overflow-x: hidden;
        }

        .question-block {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            background-color: #f8fafc;
            position: relative;
        }

        .remove-question {
            position: absolute;
            left: 1rem;
            top: 1rem;
            color: #ef4444;
            cursor: pointer;
            font-weight: bold;
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

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 p-6 flex flex-col items-center">
            <div class="w-full max-w-3xl bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-6 text-center">
                    تعديل أسئلة الامتحان: {{ $exam->name }}
                </h2>

                <form method="POST" action="{{ route('exams.questions.update', $exam) }}" id="questions-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div id="questions-container">
                        @foreach($exam->questions as $index => $question)
                        <div class="question-block" data-index="{{ $index }}" id="question-{{ $index }}">
                            <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question->id }}">

                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2 font-medium">نص السؤال</label>
                                <input type="text" name="questions[{{ $index }}][question_text]"
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-300"
                                    value="{{ $question->question_text }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2 font-medium">نوع السؤال</label>
                                <select name="questions[{{ $index }}][type]"
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-300 question-type-selector"
                                    data-index="{{ $index }}">
                                    <option value="mcq" {{ $question->type === 'mcq' ? 'selected' : '' }}>اختيار من متعدد</option>
                                    <option value="essay" {{ $question->type === 'essay' ? 'selected' : '' }}>مقالى</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2 font-medium">درجة السؤال</label>
                                <input type="number" name="questions[{{ $index }}][points]"
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-300" min="1"
                                    value="{{ $question->points }}" required>
                            </div>

                            <!-- قسم الصور -->
                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2 font-medium">صور السؤال</label>

                                @if($question->images->count() > 0)
                                <div class="grid grid-cols-3 gap-3 mb-3">
                                    @foreach($question->images as $image)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/'.$image->image_path) }}"
                                            class="w-full h-32 object-cover rounded border image-preview">
                                        <button type="button" onclick="deleteImage(event, {{ $image->id }})"
                                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                            ×
                                        </button>
                                        <input type="hidden" name="questions[{{ $index }}][existing_images][]" value="{{ $image->id }}">
                                    </div>
                                    @endforeach
                                </div>
                                @endif

                                <input type="file" name="questions[{{ $index }}][new_images][]" multiple
                                    class="w-full p-2 border rounded file:mr-2 file:py-1 file:px-4 file:rounded file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                    accept="image/*">
                                <p class="text-xs text-gray-500 mt-1">يمكنك رفع أكثر من صورة للسؤال (JPEG, PNG, JPG)</p>
                            </div>

                            <!-- قسم الخيارات (للأسئلة الاختيارية) -->
                            <div id="options-container-{{ $index }}" class="{{ $question->type === 'essay' ? 'hidden' : '' }}">
                                <label class="block text-gray-700 mb-2 font-medium">خيارات الإجابة</label>

                                @php
                                $options = $question->options->count() > 0 ? $question->options : collect([new App\Models\Option(), new App\Models\Option(), new App\Models\Option(), new App\Models\Option()]);
                                @endphp

                                @foreach($options as $optIndex => $option)
                                <div class="flex items-center mb-2">
                                    <input type="hidden" name="questions[{{ $index }}][options][{{ $optIndex }}][id]" value="{{ $option->id ?? '' }}">
                                    <input type="text" name="questions[{{ $index }}][options][{{ $optIndex }}][text]"
                                        class="flex-1 p-2 border rounded-l focus:ring-1 focus:ring-blue-300"
                                        value="{{ $option->option_text ?? '' }}"
                                        placeholder="الخيار {{ $optIndex + 1 }}" required>
                                    <label class="bg-gray-100 px-3 py-2 border-t border-b border-r rounded-r cursor-pointer">
                                        <input type="radio" name="questions[{{ $index }}][correct_option]"
                                            value="{{ $optIndex }}" class="mr-1"
                                            {{ ($option->is_correct ?? false) ? 'checked' : '' }}>
                                        الإجابة الصحيحة
                                    </label>
                                </div>
                                @endforeach
                            </div>

                            <!-- قسم الإجابة المقالية -->
                            <div id="essay-answer-{{ $index }}" class="{{ $question->type === 'mcq' ? 'hidden' : '' }}">
                                <label class="block text-gray-700 mb-2 font-medium">الإجابة المقالية</label>
                                <textarea name="questions[{{ $index }}][answer_text]"
                                    class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-300 h-32"
                                    placeholder="أدخل النموذج الإجابة المقالية هنا...">{{ $question->essayAnswer->answer_text ?? '' }}</textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="flex justify-between mt-6">
                        <button type="submit" id="submit-btn" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded transition-colors">
                            حفظ التعديلات
                        </button>
                        <a href="{{ route('exams.show', $exam->id) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded transition-colors">
                            العودة للامتحان
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

            // إرسال النموذج
            const form = document.getElementById('questions-form');
            if (form) {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const submitBtn = document.getElementById('submit-btn');
                    const originalText = submitBtn.textContent;

                    try {
                        submitBtn.disabled = true;
                        submitBtn.textContent = 'جاري الحفظ...';

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
                            window.location.href = data.redirect || '{{ route("exams.show", $exam->id) }}';
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
