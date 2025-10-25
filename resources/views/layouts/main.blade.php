<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Font: Rethink Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Rethink+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlRent - @yield('title')</title>

    <style>
        body {
            margin: 0;
            font-family: 'Rethink Sans', sans-serif;
            background: #111;
            color: #f5f5f5;
            line-height: 1.6;
        }

        nav {
            background: #2b2b2b;
            padding: 25px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #444;
            position: relative;
            box-shadow: 0 2px 10px rgba(0,0,0,0.4);
        }

        nav a {
            color: #eee;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
            transition: 0.3s;
        }

        nav a:hover {
            color: #FFD700;
        }

        /* Desktop menu */
        .nav-links {
            display: flex;
            align-items: center;
        }

        /* Tombol titik tiga (mobile) */
        #menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #FFD700;
            font-size: 26px;
            cursor: pointer;
        }

        /* Dropdown mobile */
        #mobile-menu {
            display: none;
            flex-direction: column;
            background: #1a1a1a;
            position: absolute;
            top: 75px;
            right: 20px;
            border: 1px solid #333;
            border-radius: 10px;
            padding: 12px;
            width: 170px;
            text-align: right;
            box-shadow: 0 0 12px rgba(255,215,0,0.25);
            animation: fadeIn 0.3s ease-in-out;
        }

        #mobile-menu a {
            color: white;
            text-decoration: none;
            margin: 8px 0;
            display: block;
        }

        #mobile-menu a:hover {
            color: #FFD700;
        }

        .container {
            padding: 30px 20px;
            max-width: 1100px;
            margin: auto;
        }

        footer {
            text-align: center;
            padding: 18px;
            margin-top: 60px;
            background: #1a1a1a;
            border-top: 1px solid #333;
            color: #bbb;
            font-size: 14px;
            letter-spacing: 0.3px;
        }

        .card {
            background: #1a1a1a;
            border: 1px solid #333;
            border-radius: 10px;
            padding: 15px;
            width: 220px;
            transition: 0.2s;
        }

        .card:hover {
            transform: translateY(-4px);
            border-color: #FFD700;
        }

        .card img {
            width: 100%;
            border-radius: 6px;
        }

        .btn-primary {
            background: #FFD700;
            border: none;
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
            font-weight: bold;
            color: #111;
            transition: 0.2s;
        }

        .btn-primary:hover {
            background: #ffea00;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsif untuk HP */
        @media (max-width: 768px) 
        {
            .nav-links {
                display: none;
            }
            #menu-toggle {
                display: block;
            }
        }
    </style>

    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                background: '#1a1a1a',
                color: '#FFD700'
            });
        });
    </script>
    @endif
</head>

<body>

    <!-- NAVBAR -->
    <nav>
        <!-- LOGO -->
        <div style="display:flex; align-items:center;">
            <strong style="color:#FFD700; font-size:22px;">AlRent</strong>
        </div>

        <!-- MENU (DESKTOP) -->
        <div class="nav-links">
            <a href="/">Home</a>
            <a href="/ht">Daftar HT</a>
            <a href="/cart">Keranjang</a>

            @auth
                <span style="color:#FFD700; margin:0 25px 0 35px; font-weight:500:">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:white; font-weight:bold; cursor:pointer;">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" style="background:#FFD700; color:black; padding:6px 12px; border-radius:6px; font-weight:bold;">
                    Login
                </a>
            @endauth
        </div>

        <!-- TOMBOL TITIK TIGA -->
        <button id="menu-toggle">☰</button>

        <!-- MENU UNTUK MOBILE -->
        <div id="mobile-menu">
            <a href="/">Home</a>
            <a href="/ht">Daftar HT</a>
            <a href="/cart">Keranjang</a>

            @auth
                <form action="{{ route('logout') }}" method="POST" style="margin:5px 0;">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:#FFD700; font-weight:bold; cursor:pointer;">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" style="background:#FFD700; color:black; padding:6px 12px; border-radius:6px; font-weight:bold; display:inline-block;">
                    Login
                </a>
            @endauth
        </div>
    </nav>

    <!-- SCRIPT: Toggle menu -->
    <script>
        const toggle = document.getElementById('menu-toggle');
        const menu = document.getElementById('mobile-menu');
        toggle.addEventListener('click', () => {
            menu.style.display = (menu.style.display === 'flex') ? 'none' : 'flex';
        });
    </script>

    <!-- CONTENT -->
    <div class="container">
        @yield('content')
    </div>

    <!-- FOOTER -->
<footer id="footer-date" style="
    text-align:center;
    padding:18px;
    margin-top:60px;
    background:#1a1a1a;
    border-top:1px solid #333;
    color:#bbb;
    font-size:14px;
    letter-spacing:0.3px;
    opacity:0;
    transform:translateY(10px);
    animation: fadeUp 1s ease-in-out forwards;
">
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Format tanggal dalam bahasa Indonesia
    const footer = document.getElementById('footer-date');
    const date = new Date();
    const options = { day: '2-digit', month: 'long', year: 'numeric' };
    const formattedDate = date.toLocaleDateString('id-ID', options);

    // Isi teks footer dengan tanggal dinamis
    footer.innerHTML = `© ${formattedDate} — 
        <strong style="color:#FFD700;">AlRent</strong> |
        Design by <strong style="color:#FFD700;">Najib</strong>`;
});

// Tambahkan animasi halus untuk fade-in dari bawah
const style = document.createElement('style');
style.innerHTML = `
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}`;
document.head.appendChild(style);
</script>


</body>
</html>
