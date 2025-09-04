<div class="question-block border p-4 mb-4 rounded relative">
    <button type="button" onclick="removeQuestion(this)" class="absolute top-2 left-2 bg-red-500 text-white px-2 rounded hover:bg-red-600">
        حذف
    </button>


    <label class="block mb-1 font-semibold">نص السؤال رقم {{ $index + 1 }}</label>
    <input type="text" name="questions[{{ $index }}][text]" class="w-full border rounded p-2 mb-3" required>

    <!-- بعد حقل نص السؤال -->
    <div class="mb-3">
        <label class="block mb-1 font-semibold">صور السؤال (اختياري)</label>
        <input type="file" name="questions[{{ $index }}][images][]" multiple
            class="w-full border rounded p-2" accept="image/*">
    </div>
    
    <label class="block mb-1 font-semibold">نوع السؤال</label>
    <select name="questions[{{ $index }}][type]" class="question-type mb-3" onchange="toggleOptions(this)">
        <option value="mcq">اختيار من متعدد</option>
        <option value="essay">سؤال مقالي</option>
    </select>

    <div class="options-container" style="display: block;">
        <label class="block mb-1 font-semibold">خيارات السؤال (اختيار من متعدد)</label>
        <input type="text" name="questions[{{ $index }}][options][]" placeholder="الخيار 1" class="w-full border rounded p-1 mb-2" required>
        <input type="text" name="questions[{{ $index }}][options][]" placeholder="الخيار 2" class="w-full border rounded p-1 mb-2" required>
        <!-- أضف المزيد إذا أردت -->
    </div>
</div>
