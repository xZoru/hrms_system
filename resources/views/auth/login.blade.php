<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Larkin Enterprises Ltd') }} - Login</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 50%, #2a0a0a 100%);
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(220,38,38,0.15) 0%, transparent 70%);
            top: -200px;
            right: -100px;
            border-radius: 50%;
        }
        body::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(220,38,38,0.1) 0%, transparent 70%);
            bottom: -50px;
            left: -50px;
            border-radius: 50%;
        }
        .login-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 400px;
            padding: 45px 35px;
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 28px;
            border: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 30px 60px rgba(0,0,0,0.5);
        }
        .login-card h1 {
            font-size: 26px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 6px;
            background: linear-gradient(135deg, #ffffff 0%, #fca5a5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .login-card .subtitle {
            text-align: center;
            color: rgba(255,255,255,0.5);
            font-size: 14px;
            margin-bottom: 35px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: rgba(255,255,255,0.7);
            margin-bottom: 6px;
        }
        .form-group input {
            width: 100%;
            padding: 14px 16px;
            background: rgba(255,255,255,0.05);
            border: 1.5px solid rgba(255,255,255,0.08);
            border-radius: 14px;
            color: #ffffff;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: 0.3s;
            outline: none;
        }
        .form-group input::placeholder { color: rgba(255,255,255,0.25); }
        .form-group input:focus {
            border-color: #dc2626;
            background: rgba(255,255,255,0.08);
            box-shadow: 0 0 0 4px rgba(220,38,38,0.1);
        }
        .btn-login {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            border: none;
            border-radius: 14px;
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            font-family: 'Inter', sans-serif;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(220,38,38,0.3);
        }
        .remember-group {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }
        .remember-group label {
            color: rgba(255,255,255,0.6);
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }
        .remember-group input[type="checkbox"] { accent-color: #dc2626; }
        .remember-group a {
            color: rgba(255,255,255,0.5);
            font-size: 13px;
            text-decoration: none;
        }
        .remember-group a:hover { color: #ffffff; }
        .register-link {
            text-align: center;
            margin-top: 22px;
            color: rgba(255,255,255,0.4);
            font-size: 14px;
        }
        .register-link a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-weight: 500;
        }
        .register-link a:hover { color: #ffffff; }
        .error-message {
            color: #fca5a5;
            font-size: 12px;
            margin-top: 5px;
        }
        .session-status {
            padding: 12px 16px;
            background: rgba(220,38,38,0.1);
            border: 1px solid rgba(220,38,38,0.15);
            border-radius: 12px;
            color: #fca5a5;
            font-size: 13px;
            margin-bottom: 20px;
            text-align: center;
        }
        @media (max-width: 480px) {
            .login-card { padding: 30px 20px; }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h1>🏢 Larkin Group</h1>
        <p class="subtitle">Sign in to your account</p>
        @if (session('status'))
            <div class="session-status">{{ session('status') }}</div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="admin@hrms.com" required autofocus />
                @error('email') <div class="error-message">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="••••••••" required />
                @error('password') <div class="error-message">{{ $message }}</div> @enderror
            </div>
            <div class="remember-group">
                <label><input type="checkbox" name="remember"> Remember me</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                @endif
            </div>
            <button type="submit" class="btn-login">Sign In</button>
            @if (Route::has('register'))
                <div class="register-link">Don't have an account? <a href="{{ route('register') }}">Create one</a></div>
            @endif
        </form>
    </div>
</body>
</html>