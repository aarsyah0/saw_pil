<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: url('{{ asset('images/polije.png') }}') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
        }

        .login-container {
            position: relative;
            background: rgba(255, 255, 255, 0.8);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 90%;
            text-align: center;
            z-index: 1;
        }

        .login-container input {
            background: rgba(255, 255, 255, 0.95);
        }

        .login-container .btn-primary {
            background-color: #3b82f6;
            border: none;
            font-size: 18px;
            padding: 12px;
        }

        .login-container .btn-primary:hover {
            background-color: #2563eb;
        }
    </style>
</head>

<body>
    <div class="overlay"></div>
    <div class="login-container">
        <div class="mb-2 text-start">
            <a href="{{ url('/') }}" class="btn btn-secondary">&larr;</a>
        </div>
        <img src="{{ asset('images/pilmapres.png') }}" alt="Logo" width="100" class="mb-3">
        <form action="{{ route('login.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="text" name="email" class="form-control" placeholder="NIM atau Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">LOGIN</button>
            </div>
            <div class="text-center mt-3">
                Belum memiliki akun? <a href="{{ route('register') }}">Daftar disini</a>
            </div>
        </form>
    </div>
</body>

</html>
