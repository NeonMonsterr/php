<!-- Mobile Overlay -->
<div id="student-sidebar-overlay"
     class="fixed inset-0 bg-black bg-opacity-40 z-20 hidden md:hidden transition-opacity duration-300"></div>

<!-- Sidebar Component -->
<div id="student-sidebar"
     class="bg-gradient-to-b from-blue-900 to-blue-700 text-white w-64 space-y-6 py-7 px-2 fixed inset-y-0 right-0 transform translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out shadow-2xl z-30 rounded-l-2xl">

    <!-- Header -->
    <div class="flex items-center justify-between px-4 mb-6">
        <h2 class="text-2xl font-bold tracking-wide">لوحة الطالب</h2>
        <button class="md:hidden text-white hover:text-gray-200 focus:outline-none" id="student-sidebar-close">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="px-2 space-y-2">
        @auth
        <a href="{{ route('dashboard') }}"
           class="flex items-center py-3 px-4 rounded-lg transition duration-200
                  hover:bg-blue-600 hover:shadow-md {{ request()->routeIs('dashboard') ? 'bg-blue-600 shadow-md' : '' }}">
            🏠 <span class="ml-2">الصفحة الرئيسية</span>
        </a>

        <a href="{{ route('users.show', auth()->user()) }}"
           class="flex items-center py-3 px-4 rounded-lg transition duration-200
                  hover:bg-blue-600 hover:shadow-md {{ request()->routeIs('users.show') && Route::current()->parameter('user')?->id == auth()->id() ? 'bg-blue-600 shadow-md' : '' }}">
            🙍‍♂️ <span class="ml-2">الملف الشخصي</span>
        </a>

        @if (auth()->user()->course_id)
        <a href="{{ route('courses.show', auth()->user()->enrolledCourse) }}"
           class="flex items-center py-3 px-4 rounded-lg transition duration-200
                  hover:bg-blue-600 hover:shadow-md {{ request()->routeIs('courses.show') ? 'bg-blue-600 shadow-md' : '' }}">
            📚 <span class="ml-2">عرض الدورة</span>
        </a>

        <a href="{{ route('exams.index') }}"
           class="flex items-center py-3 px-4 rounded-lg transition duration-200
                  hover:bg-blue-600 hover:shadow-md {{ request()->routeIs('exams.index') ? 'bg-blue-600 shadow-md' : '' }}">
            📝 <span class="ml-2">الامتحانات</span>
        </a>
        @endif

        <form method="POST" action="{{ route('logout') }}" class="mt-2">
            @csrf
            <button type="submit"
                    class="w-full flex items-center justify-start py-3 px-4 rounded-lg transition duration-200 hover:bg-red-600 hover:shadow-md">
                🚪 <span class="ml-2">تسجيل الخروج</span>
            </button>
        </form>
        @else
        <a href="{{ route('login') }}"
           class="flex items-center py-3 px-4 rounded-lg transition duration-200
                  hover:bg-blue-600 hover:shadow-md">
            🔑 <span class="ml-2">تسجيل الدخول</span>
        </a>
        @endauth

        <!-- Footer -->
        <a href="https://www.facebook.com/profile.php?id=61563825393233"
           class="block py-3 px-4 mt-6 text-center text-gray-300 hover:text-white transition duration-200">
            <span class="opacity-80">تم الإنشاء بواسطة</span> <span class="font-semibold">SoftCode</span>
        </a>
    </nav>
</div>

<!-- Mobile Toggle Button -->
<button id="student-sidebar-open"
        class="md:hidden fixed top-4 right-4 bg-blue-600 text-white p-2 rounded-lg shadow-lg hover:bg-blue-500 focus:outline-none z-40 transition duration-200">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16m-7 6h7"></path>
    </svg>
</button>
