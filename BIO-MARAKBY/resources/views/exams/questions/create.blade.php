<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>إضافة أسئلة للامتحان</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: white;
            color: black;
            overflow-x: hidden;
        }

        .background-gif {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.08;
            z-index: -1;
            pointer-events: none;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            border-radius: 1rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            max-width: 800px;
            margin: auto;
        }

        a,
        button {
            transition: all 0.2s ease;
        }

        a:hover,
        button:hover {
            opacity: 0.85;
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
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .image-preview-item {
            position: relative;
            width: 100px;
            height: 100px;
        }

        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 4px;
        }

        .image-preview-item .remove-image {
            position: absolute;
            top: -5px;
            left: -5px;
            background: red;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 12px;
        }

        input:disabled,
        textarea:disabled {
            background-color: #f8f9fa;
            opacity: 1;
        }

        .question-block {
            transition: all 0.3s ease;
        }

        .image-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .image-preview-item {
            position: relative;
            width: 100px;
            height: 100px;
        }

        .image-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" class="background-gif" />

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 p-6 flex flex-col items-center">
            <div class="card w-full max-w-3xl">
                <h2 class="text-2xl font-bold mb-6 text-center">
                    الكورس: {{ $exam->course->name ?? 'غير محدد' }}
                </h2>

                <form method="POST" action="{{ route('exams.questions.storeBatch', $exam->id) }}" id="questions-form" enctype="multipart/form-data">
                    @csrf

                    <div id="questions-container">
                        <!-- السؤال الأول افتراضياً -->
                        <div class="question-block" data-index="0" id="question-0">
                            <span class="remove-question" onclick="removeQuestion(0)">✕</span>

                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">نص السؤال</label>
                                <input type="text" name="questions[0][question_text]" class="w-full p-2 border rounded" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">نوع السؤال</label>
                                <select name="questions[0][type]" class="w-full p-2 border rounded" onchange="toggleOptions(0)">
                                    <option value="mcq" selected>اختيار من متعدد</option>
                                    <option value="essay">مقالى</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">صور السؤال (اختياري)</label>
                                <input type="file" name="questions[0][images][]" multiple
                                    class="w-full p-2 border rounded" accept="image/*" onchange="previewImages(this, 0)">
                                <p class="text-sm text-gray-500 mt-1">يمكنك رفع عدة صور لهذا السؤال</p>
                                <div class="image-preview" id="image-preview-0"></div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 mb-2">درجة السؤال</label>
                                <input type="number" name="questions[0][points]" class="w-full p-2 border rounded" min="1" value="1" required>
                            </div>

                            <div id="options-container-0">
                                <label class="block text-gray-700 mb-2">خيارات الإجابة</label>
                                <div class="flex items-center mb-2">
                                    <input type="text" name="questions[0][options][0]" class="flex-1 p-2 border rounded mr-2" placeholder="خيار 1" required>
                                    <input type="radio" name="questions[0][correct_option]" value="0" class="ml-2">
                                    <span class="text-sm text-gray-600">إجابة صحيحة</span>
                                </div>
                                <div class="flex items-center mb-2">
                                    <input type="text" name="questions[0][options][1]" class="flex-1 p-2 border rounded mr-2" placeholder="خيار 2" required>
                                    <input type="radio" name="questions[0][correct_option]" value="1" class="ml-2">
                                    <span class="text-sm text-gray-600">إجابة صحيحة</span>
                                </div>
                                <div class="flex items-center mb-2">
                                    <input type="text" name="questions[0][options][2]" class="flex-1 p-2 border rounded mr-2" placeholder="خيار 3" required>
                                    <input type="radio" name="questions[0][correct_option]" value="2" class="ml-2">
                                    <span class="text-sm text-gray-600">إجابة صحيحة</span>
                                </div>
                                <div class="flex items-center mb-2">
                                    <input type="text" name="questions[0][options][3]" class="flex-1 p-2 border rounded mr-2" placeholder="خيار 4" required>
                                    <input type="radio" name="questions[0][correct_option]" value="3" class="ml-2">
                                    <span class="text-sm text-gray-600">إجابة صحيحة</span>
                                </div>
                            </div>

                            <div id="essay-answer-0" style="display:none;">
                                <label class="block text-gray-700 mb-2">الإجابة المقالية</label>
                                <textarea name="questions[0][answer_text]" class="w-full p-2 border rounded h-24" data-required-if="essay"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between mt-6">
                        <button type="button" onclick="addQuestion()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            + إضافة سؤال جديد
                        </button>

                        <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                            حفظ جميع الأسئلة
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <a href="{{ route('exams.show', $exam->id) }}" class="text-blue-500 hover:text-blue-600">
                        العودة إلى صفحة الامتحان
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        let questionCount = 1;

        function addQuestion() {
            const container = document.getElementById('questions-container');
            const newIndex = questionCount;

            let optionsHtml = '';
            for (let i = 0; i < 4; i++) {
                optionsHtml += `
                    <div class="flex items-center mb-2">
                        <input type="text" name="questions[${newIndex}][options][${i}]" class="flex-1 p-2 border rounded mr-2" placeholder="خيار ${i+1}">
                        <input type="radio" name="questions[${newIndex}][correct_option]" value="${i}" class="ml-2">
                        <span class="text-sm text-gray-600">إجابة صحيحة</span>
                    </div>
                `;
            }

            const newQuestion = document.createElement('div');
            newQuestion.className = 'question-block';
            newQuestion.id = `question-${newIndex}`;
            newQuestion.setAttribute('data-index', newIndex);
            newQuestion.innerHTML = `
                <span class="remove-question" onclick="removeQuestion(${newIndex})">✕</span>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">نص السؤال</label>
                    <input type="text" name="questions[${newIndex}][question_text]" class="w-full p-2 border rounded" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">نوع السؤال</label>
                    <select name="questions[${newIndex}][type]" class="w-full p-2 border rounded" onchange="toggleOptions(${newIndex})">
                        <option value="mcq" selected>اختيار من متعدد</option>
                        <option value="essay">مقالى</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">صور السؤال (اختياري)</label>
                    <input type="file" name="questions[${newIndex}][images][]" multiple
                           class="w-full p-2 border rounded" accept="image/*" onchange="previewImages(this, ${newIndex})">
                    <p class="text-sm text-gray-500 mt-1">يمكنك رفع عدة صور لهذا السؤال</p>
                    <div class="image-preview" id="image-preview-${newIndex}"></div>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">درجة السؤال</label>
                    <input type="number" name="questions[${newIndex}][points]" class="w-full p-2 border rounded" min="1" value="1" required>
                </div>

                <div id="options-container-${newIndex}">
                    <label class="block text-gray-700 mb-2">خيارات الإجابة</label>
                    ${optionsHtml}
                </div>

                <div id="essay-answer-${newIndex}" style="display:none;">
                    <label class="block text-gray-700 mb-2">الإجابة المقالية</label>
                    <textarea name="questions[${newIndex}][answer_text]" class="w-full p-2 border rounded h-24" data-required-if="essay"></textarea>
                </div>
            `;

            container.appendChild(newQuestion);
            toggleOptions(newIndex);
            questionCount++;
        }

        function removeQuestion(index) {
            const container = document.getElementById('questions-container');
            const questionToRemove = document.getElementById(`question-${index}`);

            if (!questionToRemove) return;

            if (container.children.length === 1) {
                alert('يجب أن يحتوي الامتحان على سؤال واحد على الأقل');
                return;
            }

            container.removeChild(questionToRemove);
        }

        function toggleOptions(index) {
            const questionBlock = document.getElementById(`question-${index}`);
            if (!questionBlock) return;

            const typeSelect = questionBlock.querySelector(`select[name="questions[${index}][type]"]`);
            const mcqContainer = document.getElementById(`options-container-${index}`);
            const essayContainer = document.getElementById(`essay-answer-${index}`);
            const optionInputs = questionBlock.querySelectorAll(`input[name^="questions[${index}][options]"]`);
            const radioButtons = questionBlock.querySelectorAll(`input[name="questions[${index}][correct_option]"]`);
            const essayTextarea = questionBlock.querySelector(`textarea[name="questions[${index}][answer_text]"]`);

            if (typeSelect.value === 'mcq') {
                mcqContainer.style.display = 'block';
                essayContainer.style.display = 'none';

                optionInputs.forEach(input => {
                    input.required = true;
                    input.disabled = false;
                });
                radioButtons.forEach(radio => radio.required = true);

                if (essayTextarea) {
                    essayTextarea.required = false;
                    essayTextarea.disabled = true;
                }
            } else {
                mcqContainer.style.display = 'none';
                essayContainer.style.display = 'block';

                optionInputs.forEach(input => {
                    input.required = false;
                    input.disabled = true;
                    input.value = ''; // مسح القيم عند التبديل لنوع مقالي
                });
                radioButtons.forEach(radio => {
                    radio.required = false;
                    radio.checked = false;
                });

                if (essayTextarea) {
                    essayTextarea.required = true;
                    essayTextarea.disabled = false;
                }
            }
        }

        // تعديل دالة addQuestion لتعطيل الحقول غير الضرورية

        // معاينة الصور قبل الرفع
        function previewImages(input, questionIndex) {
            const previewContainer = document.getElementById(`image-preview-${questionIndex}`);
            previewContainer.innerHTML = '';

            if (input.files && input.files.length > 0) {
                for (let i = 0; i < input.files.length; i++) {
                    const file = input.files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const previewItem = document.createElement('div');
                        previewItem.className = 'image-preview-item';
                        previewItem.innerHTML = `
                            <span class="remove-image" onclick="removeImagePreview(${questionIndex}, ${i})">✕</span>
                            <img src="${e.target.result}" alt="Preview">
                        `;
                        previewContainer.appendChild(previewItem);
                    }

                    reader.readAsDataURL(file);
                }
            }
        }

        // إزالة صورة من المعاينة
        function removeImagePreview(questionIndex, fileIndex) {
            const fileInput = document.querySelector(`#question-${questionIndex} input[type="file"]`);
            const dt = new DataTransfer();
            const files = fileInput.files;

            for (let i = 0; i < files.length; i++) {
                if (i !== fileIndex) {
                    dt.items.add(files[i]);
                }
            }

            fileInput.files = dt.files;
            previewImages(fileInput, questionIndex);
        }

        // ضبط الخيارات عند تحميل الصفحة
        window.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('questions-container');
            const questionBlocks = container.querySelectorAll('.question-block');
            questionBlocks.forEach(qb => {
                const index = qb.getAttribute('data-index');
                toggleOptions(index);
            });
        });

        // إرسال النموذج
        document.getElementById('questions-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            // إضافة مؤشر تحميل
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;
            submitButton.innerHTML = 'جاري الحفظ...';
            submitButton.disabled = true;

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = data.redirect;
                    } else {
                        let errorMessage = 'حدثت الأخطاء التالية:\n';
                        for (const [key, errors] of Object.entries(data.errors)) {
                            errorMessage += `- ${errors.join(', ')}\n`;
                        }
                        alert(errorMessage);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('حدث خطأ أثناء إرسال البيانات');
                })
                .finally(() => {
                    submitButton.innerHTML = originalButtonText;
                    submitButton.disabled = false;
                });
        });
    </script>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
