<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>✏️ تعديل المرحلة</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f9fafb;
            overflow-x: hidden;
            color: #111827;
        }

        .background-gif {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.06;
            z-index: -1;
        }

        .glass-box {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 16px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="background" class="background-gif">

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <div class="flex-1 p-4 md:p-6 md:mr-64">
            <div class="max-w-3xl mx-auto p-6 md:p-8 glass-box">

                {{-- Header --}}
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-xl md:text-2xl font-bold text-gray-900">✏️ تعديل المرحلة</h1>
                    <a href="{{ route('levels.show', $stage->level_id) }}"
                       class="text-sm text-cyan-600 hover:text-cyan-500">⬅ العودة إلى المستوى</a>
                </div>

                {{-- Edit Form --}}
                <form action="{{ route('stages.update', [$level,$stage]) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Stage Name --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">اسم المرحلة</label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name', $stage->name) }}"
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stage Description --}}
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">الوصف</label>
                        <textarea id="description" name="description" rows="4"
                                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">{{ old('description', $stage->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Save Button --}}
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('levels.show', $stage->level_id) }}"
                           class="px-5 py-2 bg-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-400 transition">
                            إلغاء
                        </a>
                        <button type="submit"
                                class="px-6 py-2 bg-cyan-600 text-white rounded-lg font-semibold hover:bg-cyan-700 transition">
                            💾 حفظ التغييرات
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
