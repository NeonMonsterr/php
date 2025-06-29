<div id="sidebar" class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2 fixed inset-y-0 right-0 transform md:translate-x-0 -translate-x-full transition-transform duration-200 ease-in-out md:relative z-30">
    <div class="flex items-center justify-between px-4">
        <h2 class="text-xl font-semibold">لوحة تحكم الطالب</h2>
        <button class="md:hidden text-white focus:outline-none" id="sidebar-toggle">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
    <nav>
        @auth
            <a href="{{ route('users.show', auth()->user()) }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('users.show') && Route::current()->parameter('user')?->id == auth()->id() ? 'bg-gray-700' : '' }}">عرض الملف الشخصي</a>
            @if (auth()->user()->course_id)
                <a href="{{ route('courses.show', auth()->user()->enrolledCourse) }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('courses.show') ? 'bg-gray-700' : '' }}">عرض الدورة</a>
                <a href="{{ route('lectures.index') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('lectures.index') ? 'bg-gray-700' : '' }}">عرض الدروس</a>
                <a href="{{ route('exams.index') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('exams.index') ? 'bg-gray-700' : '' }}">عرض الامتحانات</a>
            @else
                <a href="{{ route('users.enroll.form') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700 {{ request()->routeIs('users.enroll.form') ? 'bg-gray-700' : '' }}">التسجيل في دورة</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="block w-full text-right py-2.5 px-4 rounded hover:bg-gray-700">تسجيل الخروج</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="block py-2.5 px-4 rounded hover:bg-gray-700">تسجيل الدخول</a>
        @endauth
    </nav>
</div>
