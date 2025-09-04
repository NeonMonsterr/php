<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الدرس: {{ $lecture->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: white;
        }

        .background-gif {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.08;
            z-index: -1;
            pointer-events: none;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 1rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            padding: 2rem;
        }

        .no-select {
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }

        .controls {
            margin-top: 20px;
            user-select: none;
        }

        .controls button {
            margin: 0 6px;
            padding: 8px 14px;
            font-size: 16px;
            background-color: #4f46e5;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .controls button:hover {
            background-color: #3730a3;
        }

        .controls label {
            margin-right: 16px;
            font-weight: bold;
            font-size: 16px;
        }

        .controls input[type="range"] {
            vertical-align: middle;
            width: 120px;
        }
    </style>
</head>

<body>
    <img src="/images/biology-bg.gif" alt="Background" class="background-gif">

    <div class="flex min-h-screen">
        @if (auth()->user()->role === 'teacher')
        @include('partials.sidebar')
        @elseif (auth()->user()->role === 'student')
        @include('partials.student_sidebar')
        @endif

        <div class="flex-1 p-4 sm:p-6">
            <div class="max-w-4xl mx-auto glass-card">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">الدرس: {{ $lecture->title }}</h1>

                <div class="mb-4">
                    <p class="text-gray-700"><strong>الدورة:</strong> {{ $lecture->course?->name ?? 'لا يوجد' }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-gray-700"><strong>العنوان:</strong> {{ $lecture->title }}</p>
                </div>


                @if($lecture->file)
                <div class="mb-4">
                    <p class="text-gray-700 font-semibold mb-1">الملف المرفق:</p>
                    <div class="bg-white border border-gray-200 rounded p-3 flex items-center justify-between">
                        <a href="{{ asset('storage/' . $lecture->file) }}" target="_blank" class="text-blue-600 underline">
                            تحميل / عرض الملف ({{ pathinfo($lecture->file, PATHINFO_EXTENSION) }})
                        </a>
                        <span class="text-sm text-gray-500">{{ basename($lecture->file) }}</span>
                    </div>
                </div>
                @endif



                <div class="mb-4">
                    <p class="text-gray-700"><strong>الترتيب:</strong> {{ $lecture->position }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-gray-700"><strong>منشور:</strong> {{ $lecture->is_published ? 'نعم' : 'لا' }}</p>
                </div>

                <div class="mb-6 no-select" style="max-width: 800px; margin: auto;">
                    <!-- container قابل للتكبير والتصغير -->
                    <div id="video-container"
                        style="position: relative; width: 100%; height: 360px; resize: both; overflow: auto; border: 1px solid #ccc; border-radius: 8px;">

                        <iframe id="lecture-video"
                            src="https://www.youtube-nocookie.com/embed/{{ $videoId }}?enablejsapi=1&rel=0&modestbranding=1&controls=0&disablekb=1&loop=1&playlist={{ $videoId }}&origin={{ urlencode(request()->getSchemeAndHttpHost()) }}"
                            class="w-full h-full rounded-lg border-0"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                        </iframe>

                        <!-- الطبقة الشفافة اللي تمنع الضغط على الفيديو -->
                        <div id="overlay"
                            style="position:absolute; top:0; left:0; width:100%; height:100%; cursor: not-allowed; z-index: 10;">
                        </div>
                    </div>

                    <!-- أدوات التحكم -->
                    <div class="controls">
                        <button onclick="seekBackward()">⏪ رجوع 10 ثواني</button>
                        <button onclick="playVideo()">▶️ تشغيل</button>
                        <button onclick="pauseVideo()">⏸ إيقاف مؤقت</button>
                        <button onclick="seekForward()">⏩ تقديم 10 ثواني</button>
                        <button onclick="seekVideo(0)">⏮ إعادة التشغيل</button>
                        <label>
                            الصوت:
                            <input type="range" min="0" max="100" value="100" onchange="setVolume(this.value)">
                        </label>
                    </div>
                </div>

                @can('update', $lecture)
                <a href="{{ route('lectures.edit', [$lecture->course, $lecture]) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-2 inline-block">تعديل الدرس</a>
                @endcan

                @can('delete', $lecture)
                <form action="{{ route('lectures.destroy', $lecture) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                        onclick="return confirm('هل أنت متأكد من حذف هذا الدرس؟')">حذف الدرس</button>
                </form>
                @endcan


                <a href="{{ route('lectures.index') }}" class="text-blue-500 hover:text-blue-600 block mt-4">
                    العودة إلى المحاضرات
                </a>
            </div>
        </div>
    </div>

    <script>
        // تحميل YouTube Iframe API
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('lecture-video', {
                events: {
                    'onReady': onPlayerReady
                }
            });
        }

        function onPlayerReady(event) {
            // جاهز للتشغيل
        }

        function playVideo() {
            if (player && player.playVideo) player.playVideo();
        }

        function pauseVideo() {
            if (player && player.pauseVideo) player.pauseVideo();
        }

        function seekVideo(seconds) {
            if (player && player.seekTo) player.seekTo(seconds, true);
        }

        function setVolume(volume) {
            if (player && player.setVolume) player.setVolume(volume);
        }

        function seekForward() {
            if (player && player.getCurrentTime && player.seekTo) {
                let current = player.getCurrentTime();
                player.seekTo(current + 10, true);
            }
        }

        function seekBackward() {
            if (player && player.getCurrentTime && player.seekTo) {
                let current = player.getCurrentTime();
                let newTime = current - 10;
                if (newTime < 0) newTime = 0;
                player.seekTo(newTime, true);
            }
        }
    </script>
    <script>
        // منع الضغط على F12
        document.addEventListener("keydown", function(e) {
            if (e.key === "F12" ||
                (e.ctrlKey && e.shiftKey && (e.key === "I" || e.key === "J" || e.key === "C")) ||
                (e.ctrlKey && e.key === "U")) {
                e.preventDefault();
                alert("تم تعطيل أدوات المطور.");
                return false;
            }
        });

        // مراقبة فتح أدوات المطور (طريقة ذكية لكن غير مضمونة)
        setInterval(function() {
            const start = performance.now();
            debugger;
            const end = performance.now();
            if (end - start > 100) {
                document.body.innerHTML = "<h1 style='color:red; text-align:center;'>تم الكشف عن أدوات المطور وتم إيقاف الموقع</h1>";
            }
        }, 1000);
    </script>
    <script>
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            alert("تم تعطيل كليك يمين.");
        });
    </script>


    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
