<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Puskesmas Kluwut</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', Arial, sans-serif;
            background: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: #11894A;
            height: 50vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .header img {
            width: 100px;
            height: 100px;
            margin-bottom: 10px;
        }

        .header h1 {
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
            margin: 5;
        }

        .login-container {
            background: #fff;
            width: 450px;
            max-width: 90%;
            margin: -60px auto 0 auto;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            position: relative;
        }

        .form-group {
            margin-bottom: 20px;
            width: 100%;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 8px;
            background: #f3f3f3;
            font-size: 1rem;
            font-family: 'Montserrat', Arial, sans-serif;
            box-sizing: border-box;
        }

        .login-container button {
            width: 100%;
            padding: 16px 0;
            background: #11894A;
            color: #fff;
            font-weight: 700;
            font-size: 1.1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .login-container button:hover {
            background: #0a7a50;
        }

        .alert {
            width: 100%;
            color: #721c24;
            background-color: #f8d7da;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            text-align: center;
            box-sizing: border-box;
        }

        .error-message {
            color: #721c24;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        @media (max-width: 500px) {
            .login-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ asset('assets/img/logo-puskesmas.png') }}" alt="Logo Puskesmas"
            onerror="this.src='https://via.placeholder.com/100?text=PUSKESMAS'" />
        <h1>Puskesmas Kluwut</h1>
    </div>
    <div class="login-container">
        @if (session('error'))
        <div class="alert">
            {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required autofocus
                    value="{{ old('username') }}">
                @error('username')
                <div class="error-message">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
                @error('password')
                <div class="error-message">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <button type="submit">LOGIN</button>
        </form>
    </div>
</body>

</html>