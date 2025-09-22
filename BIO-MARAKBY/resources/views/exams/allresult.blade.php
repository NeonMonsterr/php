<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>نتائج الامتحان: {{ $exam->title }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Tajawal', sans-serif;
      background-color: #f9fafb;
      overflow-x: hidden;
    }

    .background-gif {
      position: fixed;
      inset: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0.08;
      z-index: -1;
      pointer-events: none;
    }
  </style>
</head>

<body>
  <!-- Background -->
  <img src="/images/biology-bg.gif" alt="Background" class="background-gif" />

  <!-- Sidebar overlay (mobile) -->
  <div id="student-sidebar-overlay"
       class="fixed inset-0 bg-black bg-opacity-50 z-20 hidden md:hidden transition-opacity duration-200"></div>

  <!-- Sidebar -->
  <div id="student-sidebar"
       class="bg-gray-800 text-white w-64 py-7 px-2 fixed inset-y-0 right-0 transform translate-x-full
              md:translate-x-0 transition-transform duration-200 ease-in-out z-30">
    @if(auth()->user()->role === 'teacher')
      @include('partials.sidebar')
    @elseif(auth()->user()->role === 'student')
      @include('partials.student_sidebar')
    @endif
  </div>

  <!-- Sidebar toggle button (mobile) -->
  <button id="student-sidebar-open"
          class="md:hidden fixed top-4 right-4 text-gray-800 focus:outline-none z-40 bg-white p-2 rounded shadow">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
  </button>

  <!-- Main content -->
  <div class="p-4 sm:p-6 md:mr-64">
    <div class="max-w-6xl mx-auto bg-white/90 backdrop-blur rounded-2xl shadow-lg p-4 sm:p-6">
      <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6 text-center">
        نتائج الامتحان: {{ $exam->title }}
      </h1>

      <!-- 🔍 Search bar -->
      <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row items-center justify-between gap-3">
        <input type="text" id="searchInput"
               placeholder="ابحث عن طالب..."
               class="w-full sm:w-80 px-3 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 text-sm sm:text-base" />
        <a href="{{ route('exams.show', $exam->id) }}"
           class="px-3 sm:px-4 py-2 text-sm text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100">
          العودة إلى تفاصيل الامتحان
        </a>
      </div>

      <!-- Results table -->
      <div class="overflow-x-auto">
        <table id="resultsTable" class="min-w-full text-sm sm:text-base bg-white rounded-lg shadow">
          <thead class="bg-blue-100 text-blue-900 text-sm sm:text-base">
            <tr>
              <th class="py-3 px-2 sm:px-4 whitespace-nowrap">اسم الطالب</th>
              <th class="py-3 px-2 sm:px-4 whitespace-nowrap">البريد الإلكتروني</th>
              <th class="py-3 px-2 sm:px-4 whitespace-nowrap">الدرجة</th>
              <th class="py-3 px-2 sm:px-4 whitespace-nowrap">إجراءات</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @forelse($results as $result)
              <tr class="hover:bg-gray-50">
                <td class="py-2 px-2 sm:px-4">{{ $result['student']->name }}</td>
                <td class="py-2 px-2 sm:px-4 break-all">{{ $result['student']->email }}</td>
                <td class="py-2 px-2 sm:px-4">
                  @if(is_null($result['score']))
                    <span class="text-red-500">لم يمتحن بعد</span>
                  @else
                    {{ $result['score'] }} / {{ $exam->questions->sum('points') ?: $exam->questions->count() }}
                  @endif
                </td>
                <td class="py-2 px-2 sm:px-4 space-x-1 sm:space-x-2 space-x-reverse">
                  @if(!is_null($result['score']))
                    <a href="#" class="details-toggle text-blue-600 hover:underline"
                       data-target="details-{{ $result['student']->id }}">
                      عرض التفاصيل
                    </a>
                    <a href="{{ route('exams.grade_essay', [$exam->id, $result['student']->id]) }}"
                       class="text-yellow-600 hover:underline ml-1 sm:ml-2">
                      تصحيح المقالي
                    </a>
                  @endif
                </td>
              </tr>
              @if(!is_null($result['score']))
                <tr id="details-{{ $result['student']->id }}" class="hidden">
                  <td colspan="4" class="p-3 sm:p-4 bg-gray-50">
                    <div class="space-y-4">
                      @foreach($result['answers'] as $answer)
                        <div class="border rounded-lg p-3 sm:p-4
                          @if($answer['question']->type === 'essay' && $answer['isPending']) border-blue-500 bg-blue-50
                          @elseif($answer['isCorrect']) border-green-500 bg-green-50
                          @else border-red-500 bg-red-50 @endif">
                          <h3 class="font-semibold mb-2">س: {{ $answer['question']->question_text }}</h3>
                          <span class="text-xs sm:text-sm text-gray-600">(الدرجة: {{ $answer['question']->points }})</span>

                          @if($answer['question']->type === 'mcq')
                            <ul class="list-disc pr-5 space-y-1">
                              @foreach($answer['question']->options as $option)
                                <li @class([
                                  'text-green-700 font-bold' => $option->is_correct,
                                  'text-red-700 line-through' => $answer['userAnswer'] && $answer['userAnswer']->option_id == $option->id && !$option->is_correct
                                ])>
                                  {{ $option->option_text }}
                                  @if($answer['userAnswer'] && $answer['userAnswer']->option_id == $option->id)
                                    <span class="ml-2 text-xs sm:text-sm text-blue-600">(إجابة الطالب)</span>
                                  @endif
                                  @if($option->is_correct)
                                    <span class="ml-2 text-xs sm:text-sm text-green-600">(الصحيحة)</span>
                                  @endif
                                </li>
                              @endforeach
                            </ul>
                          @elseif($answer['question']->type === 'essay')
                            <div>
                              <label class="block text-xs sm:text-sm text-gray-600">إجابة الطالب:</label>
                              <div class="border rounded-lg p-2 sm:p-3 bg-white mt-1 text-gray-800 text-sm">
                                {{ $answer['userAnswer']?->answer_text ?? 'لم يتم الإجابة' }}
                              </div>
                              <label class="block text-xs sm:text-sm text-gray-600 mt-2">الإجابة الصحيحة:</label>
                              <div class="border rounded-lg p-2 sm:p-3 bg-white mt-1 text-gray-800 text-sm">
                                {{ $answer['question']->essayAnswer->answer_text ?? 'غير محدد' }}
                              </div>
                              <p class="mt-2 text-xs sm:text-sm @if($answer['isPending']) text-blue-600 @else text-gray-600 @endif">
                                الحالة: {{ $answer['isPending'] ? 'بانتظار التصحيح' : ($answer['isCorrect'] ? 'صحيح' : 'خاطئ') }}
                                @if($answer['userAnswer'] && $answer['userAnswer']->score !== null)
                                  (الدرجة الممنوحة: {{ $answer['userAnswer']->score }})
                                @endif
                              </p>
                            </div>
                          @endif
                        </div>
                      @endforeach
                    </div>
                  </td>
                </tr>
              @endif
            @empty
              <tr>
                <td colspan="4" class="text-center py-6 text-gray-500">
                  لا يوجد طلاب مشتركين في هذا الكورس.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Sidebar script -->
  <script src="{{ asset('js/sidebar.js') }}"></script>

  <!-- Page scripts -->
  <script>
    // Toggle details
    document.querySelectorAll('.details-toggle').forEach(toggle => {
      toggle.addEventListener('click', (e) => {
        e.preventDefault();
        const targetId = toggle.dataset.target;
        document.getElementById(targetId)?.classList.toggle('hidden');
      });
    });

    // Search filter
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('keyup', function () {
      const term = this.value.toLowerCase();
      document.querySelectorAll('#resultsTable tbody tr').forEach(row => {
        const name = row.querySelector('td:first-child')?.textContent.toLowerCase() || '';
        const email = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
        row.style.display = (name.includes(term) || email.includes(term)) ? '' : 'none';
      });
    });
  </script>
</body>
</html>
