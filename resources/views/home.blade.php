@extends('layouts.main')

@section('title', 'Home')

@section('content')

{{-- 🔹 AUTHENTIKASI USER WELCOME --}}
@if(Auth::check())
<div style="text-align:center; margin-top:40px; margin-bottom:20px;">
    <h2 style="
        color:#fff; 
        font-size:28px; 
        font-weight:600; 
        margin-top:10px;
        text-shadow:0 0 15px rgba(255,255,255,0.3);
    ">
        Halo, <span id="userName" style="color:#FFD700; border-right:2px solid #FFD700;"></span> 
    </h2>

</div>

{{-- 🔹 ANIMASI NGETIK NAMA --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const text = @json(Auth::user()->name); // ✅ ini cara aman untuk parsing data Laravel ke JS
    const target = document.getElementById('userName');
    let i = 0;

    function typeWriter() {
        if (i < text.length) {
            target.textContent += text.charAt(i);
            i++;
            setTimeout(typeWriter, 120); // kecepatan ketik
        } else {
            setTimeout(() => {
                target.textContent = '';
                i = 0;
                typeWriter();
            }, 2000); // jeda sebelum replay
        }
    }

    typeWriter();
});
</script>
@endif

{{-- 🔹 HERO SECTION --}}
<div style="text-align: center; margin-top: 30px;">
    <h1 style="font-size: 34px; color: #FFD700; margin-bottom: 10px; font-weight:700;">
        Selamat Datang di <span style="color:white;">AlRent!</span>
    </h1>

    <img src="/images/hero-ht.jpg" 
         alt="Hero AlRent"
         style="width: 80%; max-width: 850px; border-radius: 15px; border: 2px solid #FFD700; box-shadow:0 0 20px rgba(255,215,0,0.3); margin-top:25px;">

    <br><br>

    <a href="/ht" 
       style="background: #FFD700; padding: 14px 25px; border-radius: 10px; 
              text-decoration: none; font-weight: bold; color: #111; font-size: 18px; transition:0.2s;">
        Lihat Daftar HT
    </a>
</div>

{{-- 🔹 SECTION ALASAN (MINI CONTAINER STYLE) --}}
<div style="margin-top: 70px; text-align: center;">
    <h2 style="
        color: #FFD700;
        margin-bottom: 25px;
        font-size: 24px;
        letter-spacing: 1px;
        font-weight: 600;
    ">
        Kenapa Memilih <span style="color:#f5f5f5;">AlRent?</span>
    </h2>

    <div style="
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 15px;
    ">
        <div style="
            background: #1a1a1a;
            border: 1px solid #333;
            color: #f5f5f5;
            border-radius: 8px;
            padding: 10px 18px;
            font-size: 15px;
            transition: 0.3s;
            cursor: default;
        " onmouseover="this.style.borderColor='#FFD700'; this.style.transform='scale(1.05)';"
          onmouseout="this.style.borderColor='#333'; this.style.transform='none';">
            💰 Harga terjangkau dan transparan
        </div>

        <div style="
            background: #1a1a1a;
            border: 1px solid #333;
            color: #f5f5f5;
            border-radius: 8px;
            padding: 10px 18px;
            font-size: 15px;
            transition: 0.3s;
        " onmouseover="this.style.borderColor='#FFD700'; this.style.transform='scale(1.05)';"
          onmouseout="this.style.borderColor='#333'; this.style.transform='none';">
            📻 Perangkat berkualitas tinggi
        </div>

        <div style="
            background: #1a1a1a;
            border: 1px solid #333;
            color: #f5f5f5;
            border-radius: 8px;
            padding: 10px 18px;
            font-size: 15px;
            transition: 0.3s;
        " onmouseover="this.style.borderColor='#FFD700'; this.style.transform='scale(1.05)';"
          onmouseout="this.style.borderColor='#333'; this.style.transform='none';">
            ⚡ Proses cepat & mudah
        </div>

        <div style="
            background: #1a1a1a;
            border: 1px solid #333;
            color: #f5f5f5;
            border-radius: 8px;
            padding: 10px 18px;
            font-size: 15px;
            transition: 0.3s;
        " onmouseover="this.style.borderColor='#FFD700'; this.style.transform='scale(1.05)';"
          onmouseout="this.style.borderColor='#333'; this.style.transform='none';">
            🎪 Cocok untuk berbagai event
        </div>
    </div>
</div>

    </div>
</div>


@endsection
