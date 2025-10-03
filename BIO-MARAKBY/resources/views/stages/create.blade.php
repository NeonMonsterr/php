<!-- resources/views/stages/create.blade.php -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>➕ إضافة مرحلة</title>
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
            background: rgba(255, 255, 255, 0.85);
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
                    <h1 class="text-xl md:text-2xl font-bold text-gray-900">➕ إضافة مرحلة جديدة</h1>
                    <a href="{{ route('levels.show', $level->id) }}"
                       class="text-sm text-cyan-600 hover:text-cyan-500">⬅ العودة للمستوى: {{ $level->name }}</a>
                </div>

                {{-- Form --}}
                <form action="{{ route('stages.store', $level->id) }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Stage Name --}}
                    <div>
                        <label for="name" class="block text-gray-700 font-medium">اسم المرحلة</label>
                        <input type="text" id="name" name="name"
                               value="{{ old('name') }}"
                               class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500"
                               required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Stage Description --}}
                    <div>
                        <label for="description" class="block text-gray-700 font-medium">الوصف</label>
                        <textarea id="description" name="description" rows="4"
                                  class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('levels.show', $level->id) }}"
                           class="px-5 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 transition text-gray-800 font-semibold">
                            إلغاء
                        </a>
                        <button type="submit"
                                class="px-5 py-2 rounded-lg bg-green-500 hover:bg-green-600 transition text-white font-semibold">
                            ✅ حفظ المرحلة
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>
</html>
