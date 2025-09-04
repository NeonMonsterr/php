<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>الدعم الفني</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@500;700&family=Tajawal:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Tajawal', 'Cairo', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #0f0c29;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .background-gif {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.07;
            z-index: -1;
            pointer-events: none;
        }

        .support-box {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            max-width: 650px;
            text-align: center;
            color: #ffffff;
            animation: fadeIn 1s ease-in-out;
        }

        .support-box h1 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #00ffc6;
        }

        .support-box p {
            font-size: 18px;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .whatsapp-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #25D366;
            color: #fff;
            padding: 14px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            transition: transform 0.3s ease, background 0.3s ease;
        }

        .whatsapp-btn:hover {
            background: #1ebe5d;
            transform: scale(1.05);
        }

        .whatsapp-btn i {
            font-size: 22px;
        }

        .home-link {
            display: inline-block;
            padding: 12px 20px;
            margin-top: 20px;
            border: 2px solid #00ffc6;
            color: #00ffc6;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .home-link:hover {
            background-color: #00ffc6;
            color: #000;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 600px) {
            .support-box {
                padding: 30px 20px;
            }

            .support-box h1 {
                font-size: 26px;
            }

            .support-box p {
                font-size: 16px;
            }

            .whatsapp-btn {
                font-size: 16px;
                padding: 12px 20px;
            }
        }
    </style>
</head>

<body>

    <img src="/images/biology-bg.gif" class="background-gif" alt="Background GIF">

    <div class="support-box">
        <h1>مرحبا بك في صفحة الدعم الفني</h1>
        <p>
            إذا كنت تواجه أي مشكلة في تسجيل الدخول، أو نسيت كلمة المرور، أو حتى إذا كنت ترغب في فتح حساب جديد — لا تقلق،
            فريق الدعم جاهز لمساعدتك دائمًا! 💪
        </p>
        <p>
            تواصل معنا مباشرة عبر الواتساب وسنقوم بمساعدتك في أسرع وقت ممكن. هدفنا هو راحتك، وسعادتك تعني لنا الكثير.
            لا تتردد، نحن هنا من أجلك ✨
        </p>

        <a href="https://wa.me/201090474881?text=مرحبًا،%20أحتاج%20مساعدة%20في%20الموقع" target="_blank"
            class="whatsapp-btn">
            <i class="fab fa-whatsapp"></i> تواصل معنا على واتساب
        </a>

        <div>
            <a href="{{ route('welcome') }}" class="home-link">العودة إلى الصفحة الرئيسية</a>
        </div>
    </div>

</body>

</html>
