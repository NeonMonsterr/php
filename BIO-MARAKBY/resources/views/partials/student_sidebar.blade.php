<!-- Mobile Overlay -->
<div id="student-sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden transition-opacity duration-200"></div>

<!-- Sidebar Component -->
<div id="student-sidebar" class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2 fixed inset-y-0 right-0 transform translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out z-30">
    <div class="flex items-center justify-between px-4">
        <h2 class="text-xl font-semibold">لوحة تحكم الطالب</h2>
        <button class="md:hidden text-white focus:outline-none" id="student-sidebar-close">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    <nav>
        @auth
        <a href="{{ route('dashboard') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('dashboard') ? 'bg-gray-700' : '' }}">العودة إلى الصفحة الرئيسية</a>
        <a href="{{ route('users.show', auth()->user()) }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('users.show') && Route::current()->parameter('user')?->id == auth()->id() ? 'bg-gray-700' : '' }}">عرض الملف الشخصي</a>
        @if (auth()->user()->course_id)
        <a href="{{ route('courses.show', auth()->user()->enrolledCourse) }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('courses.show') ? 'bg-gray-700' : '' }}">عرض الدورة</a>
        <a href="{{ route('lectures.index') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('lectures.index') ? 'bg-gray-700' : '' }}">عرض الدروس</a>
        <a href="{{ route('exams.index') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('exams.index') ? 'bg-gray-700' : '' }}">عرض الامتحانات</a>
        @endif
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="block w-full text-right py-2.5 px-4 rounded hover:bg-gray-700">تسجيل الخروج</button>
        </form>
        @else
        <a href="{{ route('login') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700">تسجيل الدخول</a>
        @endauth
        <!-- هذا الجزء سوف يظهر للجميع -->
        <a href="https://www.facebook.com/profile.php?id=61563825393233" class="block py-2.5 px-4 mt-4 text-center text-gray-400 hover:bg-transparent">
            تم الانشاء بواسطة <span class="font-semibold">SoftCode</span>
        </a>
    </nav>
</div>

<!-- Mobile Toggle Button (Hamburger Icon) -->
<button id="student-sidebar-open" class="md:hidden fixed top-4 right-4 text-gray-800 focus:outline-none z-40">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>
