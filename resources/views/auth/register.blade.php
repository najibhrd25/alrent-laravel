<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - AlRent</title>
    <link href="https://fonts.googleapis.com/css2?family=Rethink+Sans:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #111;
            font-family: 'Rethink Sans', sans-serif;
            color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-box {
            background: #1a1a1a;
            border: 1px solid #333;
            border-radius: 12px;
            padding: 35px 40px;
            width: 360px;
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.15);
            text-align: center;
        }
        h2 {
            color: #FFD700;
            margin-bottom: 25px;
        }
        input {
            width: 100%;
            padding: 10px;
            background: #111;
            border: 1px solid #333;
            border-radius: 6px;
            color: #f5f5f5;
            margin-bottom: 15px;
        }
        input:focus {
            border-color: #FFD700;
            outline: none;
        }
        button {
            background: #FFD700;
            border: none;
            color: #111;
            font-weight: bold;
            padding: 10px;
            width: 100%;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.2s;
        }
        button:hover {
            background: #ffea00;
        }
        a {
            color: #FFD700;
            text-decoration: none;
            font-size: 14px;
        }
        a:hover {
            text-decoration: underline;
        }
        .footer {
            margin-top: 20px;
            font-size: 13px;
            color: #aaa;
        }
    </style>
</head>
<body>

<div class="register-box">
    <h2>📝 Daftar Akun Baru</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="text" name="name" placeholder="Nama Lengkap" required autofocus>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>

        <button type="submit">Daftar</button>
    </form>

    <div class="footer">
        <p>Sudah punya akun? <a href="{{ route('login') }}">Login Sekarang</a></p>
    </div>
</div>

</body>
</html>
