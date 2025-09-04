<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تسجيل الدخول</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@500;700&display=swap" rel="stylesheet" />
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Cairo', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #000428;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
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

        .login-container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 420px;
            color: #fff;
            animation: fadeIn 1s ease;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 30px;
            color: #00c6ff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            outline: none;
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            transition: 0.3s ease;
        }

        .form-group input:focus {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 0 0 2px #00c6ff;
        }

        .error-message {
            color: #ff4d4d;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            background-color: #00c6ff;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #000;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
        }

        .login-btn:hover {
            background-color: #0072ff;
            color: #fff;
            transform: scale(1.03);
        }

        .extra-links {
            text-align: center;
            margin-top: 20px;
        }

        .extra-links a {
            color: #ccc;
            text-decoration: none;
            font-size: 15px;
            transition: color 0.3s;
        }

        .extra-links a:hover {
            color: #00c6ff;
        }

        .home-link {
            display: inline-block;
            margin-top: 10px;
            color: #00c6ff;
            font-weight: bold;
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

        @media (max-width: 500px) {
            .login-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>

    <img src="/images/biology-bg.gif" class="background-gif" alt="خلفية متحركة" />

    @auth
    @if (auth()->user()->role === 'teacher')
    <script>
        window.location.href = "{{ route('dashboard.teacher') }}";
    </script>
    @else
    <script>
        window.location.href = "{{ route('dashboard') }}";
    </script>
    @endif
    @endauth

    @guest
    <div class="login-container">
        <h2>تسجيل الدخول</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    placeholder="example@email.com" required>
                @error('email')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">كلمة المرور</label>
                <input type="password" id="password" name="password" placeholder="********" required>
                @error('password')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="login-btn">دخول</button>
        </form>
        <div class="extra-links">
            <p><a href="{{ route('contact') }}">نسيت كلمة المرور؟</a></p>
            <p><a href="{{ route('contact') }}">إنشاء حساب جديد</a></p>
            <p><a href="{{ route('welcome') }}" class="home-link">العودة إلى الصفحة الرئيسية</a></p>
        </div>
    </div>
    @endguest

</body>

</html>
