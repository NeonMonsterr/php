<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المقطع: {{ $section->title }}</title>
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
            display: flex;
            /* use flex layout */
            flex-wrap: wrap;
            /* allow buttons to wrap on smaller screens */
            gap: 10px;
            /* space between buttons */
            align-items: center;
            /* vertical alignment with label */
        }

        .controls button {
            padding: 8px 16px;
            /* slightly more horizontal padding */
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
                <h1 class="text-2xl font-bold text-gray-800 mb-6">المقطع: {{ $section->title }}</h1>

                <div class="mb-4">
                    <p class="text-gray-700"><strong>المحاضرة:</strong> {{ $section->lecture?->title ?? 'لا يوجد' }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-gray-700"><strong>العنوان:</strong> {{ $section->title }}</p>
                </div>

                <div class="mb-4">
                    <p class="text-gray-700"><strong>الترتيب:</strong> {{ $section->position }}</p>
                </div>
                @can('update', $section)
                    <div class="mb-4">
                        <p class="text-gray-700"><strong>منشور:</strong> {{ $section->is_published ? 'نعم' : 'لا' }}</p>
                    </div>
                @endcan


                <div class="mb-6 no-select" style="max-width: 800px; margin: auto;">
                    <div id="video-container"
                        style="position: relative; width: 100%; height: 360px; resize: both; overflow: auto; border: 1px solid #ccc; border-radius: 8px;">

                        <iframe id="section-video"
                            src="https://www.youtube-nocookie.com/embed/{{ $videoId }}?enablejsapi=1&rel=0&modestbranding=1&controls=0&disablekb=1&loop=1&playlist={{ $videoId }}&origin={{ urlencode(request()->getSchemeAndHttpHost()) }}"
                            class="w-full h-full rounded-lg border-0" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                        </iframe>

                        <div id="overlay"
                            style="position:absolute; top:0; left:0; width:100%; height:100%; cursor: not-allowed; z-index: 10;">
                        </div>
                    </div>

                    <div class="controls">
                        <button onclick="seekBackward()">⏪ رجوع 10 ثواني</button>
                        <button onclick="playVideo()">▶️ تشغيل</button>
                        <button onclick="pauseVideo()">⏸ إيقاف مؤقت</button>
                        <button onclick="seekForward()">⏩ تقديم 10 ثواني</button>
                        <button onclick="seekVideo(0)">⏮ إعادة التشغيل</button>
                        <button id="fullscreen-btn">🖵 تكبير الشاشة</button>
                        <label>
                            الصوت:
                            <input type="range" min="0" max="100" value="100"
                                onchange="setVolume(this.value)">
                        </label>
                    </div>
                    {{-- Display uploaded file if exists --}}
                    @if ($section->file)
                        @php
                            $extension = pathinfo($section->file, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array(strtolower($extension), ['pdf']))
                            <iframe src="{{ asset('storage/' . $section->file) }}"
                                style="width:100%; height:500px; border:1px solid #ccc; border-radius:8px;"></iframe>
                        @elseif(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                            <img src="{{ asset('storage/' . $section->file) }}" alt="Section Image"
                                class="rounded-lg mx-auto max-h-96">
                        @elseif(in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                            <video controls class="w-full rounded-lg">
                                <source src="{{ asset('storage/' . $section->file) }}"
                                    type="video/{{ $extension }}">
                                المتصفح لا يدعم عرض الفيديو.
                            </video>
                        @else
                            <p class="text-red-500">نوع الملف غير مدعوم للعرض.</p>
                        @endif
                    @endif

                </div>

                @can('update', $section)
                    <a href="{{ route('sections.edit', [$section->lecture->course, $section->lecture, $section]) }}"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mr-2 inline-block">
                        تعديل المقطع
                    </a>
                @endcan

                @can('delete', $section)
                    <form
                        action="{{ route('sections.destroy', [$section->lecture->course, $section->lecture, $section]) }}"
                        method="POST">

                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
                            onclick="return confirm('هل أنت متأكد من حذف هذا المقطع؟')">
                            حذف المقطع
                        </button>
                    </form>
                @endcan

                <a href="{{ route('lectures.show', [$section->lecture->course, $section->lecture]) }}"
                    class="text-blue-500 hover:text-blue-600 block mt-4">
                    العودة إلى المحاضرة
                </a>
            </div>
        </div>
    </div>

    <script>
        // YouTube API
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('section-video', {
                events: {
                    'onReady': onPlayerReady
                }
            });
        }

        function onPlayerReady(event) {}

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
        // Disable F12 and Devtools
        document.addEventListener("keydown", function(e) {
            if (e.key === "F12" ||
                (e.ctrlKey && e.shiftKey && (e.key === "I" || e.key === "J" || e.key === "C")) ||
                (e.ctrlKey && e.key === "U")) {
                e.preventDefault();
                alert("تم تعطيل أدوات المطور.");
                return false;
            }
        });

        setInterval(function() {
            const start = performance.now();
            debugger;
            const end = performance.now();
            if (end - start > 100) {
                document.body.innerHTML =
                    "<h1 style='color:red; text-align:center;'>تم الكشف عن أدوات المطور وتم إيقاف الموقع</h1>";
            }
        }, 1000);
    </script>

    <script>
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            alert("تم تعطيل كليك يمين.");
        });

        const fullscreenBtn = document.getElementById('fullscreen-btn');
        const videoContainer = document.getElementById('video-container');

        fullscreenBtn.addEventListener('click', () => {
            if (!document.fullscreenElement) {
                if (videoContainer.requestFullscreen) {
                    videoContainer.requestFullscreen();
                } else if (videoContainer.webkitRequestFullscreen) {
                    videoContainer.webkitRequestFullscreen();
                } else if (videoContainer.msRequestFullscreen) {
                    videoContainer.msRequestFullscreen();
                }
                fullscreenBtn.textContent = '❎ خروج من وضع الشاشة الكاملة';
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    document.msExitFullscreen();
                }
                fullscreenBtn.textContent = '🖵 تكبير الشاشة';
            }
        });

        document.addEventListener('fullscreenchange', () => {
            if (!document.fullscreenElement) {
                fullscreenBtn.textContent = '🖵 تكبير الشاشة';
            }
        });
    </script>

    <script src="{{ asset('js/sidebar.js') }}"></script>
</body>

</html>
