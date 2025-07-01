<!-- Mobile Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden transition-opacity duration-200"></div>

<!-- Sidebar Component -->
<div id="sidebar" class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2 fixed inset-y-0 right-0 transform translate-x-full md:translate-x-0 transition-transform duration-200 ease-in-out z-30">
    <div class="flex items-center justify-between px-4">
        <h2 class="text-xl font-semibold">لوحة تحكم المعلم</h2>
        <button class="md:hidden text-white focus:outline-none" id="sidebar-close">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    <nav>
        <a href="{{ route('users.index') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('users.index') || (request()->routeIs('users.show') && Route::current()->parameter('user')?->id != auth()->id()) ? 'bg-gray-700' : '' }}">إدارة الطلاب</a>
        <a href="{{ route('courses.index') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('courses.index') ? 'bg-gray-700' : '' }}">إدارة الدورات</a>
        <a href="{{ route('lectures.index') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('lectures.index') ? 'bg-gray-700' : '' }}">إدارة الدروس</a>
        <a href="{{ route('exams.index') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('exams.index') ? 'bg-gray-700' : '' }}">إدارة الامتحانات</a>
        @auth
            <a href="{{ route('users.show', auth()->user()) }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('users.show') && Route::current()->parameter('user')?->id == auth()->id() ? 'bg-gray-700' : '' }}">عرض الملف الشخصي</a>
            <a href="{{ route('dashboard.teacher') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('dashboard.teacher') ? 'bg-gray-700' : '' }}">العودة إلى لوحة تحكم المعلم</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-right py-2.5 px-4 rounded hover:bg-gray-700">تسجيل الخروج</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700">تسجيل الدخول</a>
        @endauth
    </nav>
</div>

<!-- Mobile Toggle Button (Hamburger Icon) -->
<button id="sidebar-open" class="md:hidden fixed top-4 right-4 text-gray-800 focus:outline-none z-40">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
    </svg>
</button>
