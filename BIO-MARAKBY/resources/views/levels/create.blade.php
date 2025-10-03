<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>➕ إضافة مستوى جديد</title>
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
                    <h1 class="text-xl md:text-2xl font-bold text-gray-900">➕ إضافة مستوى جديد</h1>
                    <a href="{{ route('levels.index') }}"
                        class="text-sm text-cyan-600 hover:text-cyan-500">⬅ العودة إلى المستويات</a>
                </div>

                {{-- Create Level Form --}}
                <form action="{{ route('levels.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Level Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">📘 اسم المستوى</label>
                        <input type="text" name="name" id="name"
                               value="{{ old('name') }}"
                               required
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">⚠️ {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">📝 الوصف</label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">⚠️ {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-2 rounded-lg font-semibold hover:from-green-600 hover:to-emerald-600 transition">
                            💾 حفظ المستوى
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
