@extends('layouts.main')

@section('title', 'Checkout Success')

@section('content')
<div style="text-align:center; margin-top:50px;">
    <div id="checkmark-container" style="display:inline-block;">
        <svg viewBox="0 0 52 52" style="width:100px; height:100px;">
            <circle cx="26" cy="26" r="25" fill="none" stroke="#00ff88" stroke-width="3" />
            <path fill="none" stroke="#00ff88" stroke-width="4" d="M14 27l7 7 17-17" />
        </svg>
    </div>

    <h1 style="color:#00ff88; margin-top:20px;">Checkout Berhasil!</h1>
    <p style="color:#ccc;">Terima kasih sudah menyewa di <strong>AlRent</strong> 🎉</p>

    <a href="/ht" 
       style="background:#00aaff; color:white; text-decoration:none; padding:12px 20px; border-radius:8px; display:inline-block; margin-top:30px;">
       Kembali ke Daftar HT
    </a>
</div>

<style>
@keyframes checkmark {
    0% { stroke-dashoffset: 48; opacity: 0; }
    50% { opacity: 1; }
    100% { stroke-dashoffset: 0; opacity: 1; }
}

@keyframes pop {
    0% { transform: scale(0); opacity: 0; }
    80% { transform: scale(1.2); opacity: 1; }
    100% { transform: scale(1); }
}

#checkmark-container svg path {
    stroke-dasharray: 48;
    stroke-dashoffset: 48;
    animation: checkmark 1s ease forwards;
}

#checkmark-container svg circle {
    stroke-dasharray: 160;
    stroke-dashoffset: 160;
    animation: checkmark 1s ease forwards;
}

#checkmark-container {
    animation: pop 0.6s ease forwards;
}
</style>
@endsection
