<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المعلم</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('partials.sidebar', ['user' => $user])

        <!-- Main Content -->
        <div class="flex-1 p-6 md:mr-64">
            <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">لوحة تحكم المعلم</h1>
                    <button class="md:hidden text-gray-800 focus:outline-none" id="sidebar-open">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <p class="text-gray-600 mb-4">مرحبًا، {{ $user->name }}</p>
                <h2 class="text-xl font-semibold text-gray-800 mb-4">الإحصائيات</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-blue-100 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium text-gray-700">إجمالي الطلاب</h3>
                        <p class="text-2xl font-bold text-blue-600">{{ $statistics['students'] ?? 0 }}</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium text-gray-700">إجمالي الدورات</h3>
                        <p class="text-2xl font-bold text-green-600">{{ $statistics['courses'] ?? 0 }}</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium text-gray-700">إجمالي الدروس</h3>
                        <p class="text-2xl font-bold text-yellow-600">{{ $statistics['lectures'] ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-100 p-4 rounded-lg shadow-sm">
                        <h3 class="text-lg font-medium text-gray-700">إجمالي الامتحانات</h3>
                        <p class="text-2xl font-bold text-purple-600">{{ $statistics['exams'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('sidebar-open').addEventListener('click', () => {
            document.querySelector('.bg-gray-800').classList.remove('-translate-x-full');
        });
        document.getElementById('sidebar-toggle').addEventListener('click', () => {
            document.querySelector('.bg-gray-800').classList.add('-translate-x-full');
        });
    </script>
</body>
</html>
