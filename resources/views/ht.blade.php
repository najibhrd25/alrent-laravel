@extends('layouts.main')

@section('title', 'Daftar HT')

@section('content')
<div style="text-align:center; margin-top:30px;">
    <h1 style="
        color:#FFD700;
        font-size:28px;
        font-weight:600;
        margin-bottom:10px;
        letter-spacing:0.5px;
    ">
        📡 Daftar HT Tersedia
    </h1>

    <p style="
        color:#ccc;
        font-size:16px;
        margin-bottom:40px;
    ">
        Pilih alat komunikasi terbaik untuk eventmu dengan kualitas premium dari 
        <strong style="color:#FFD700;">AlRent</strong>.
    </p>

    @php
        $hts = [
            ['nama' => 'Model WLN', 'harga' => 10000, 'gambar' => 'h1.jpeg'],
            ['nama' => 'Comtect Analog', 'harga' => 5000, 'gambar' => 'h2.jpeg'],
            ['nama' => 'Comtect Digital', 'harga' => 8000, 'gambar' => 'h3.jpeg'],
        ];
    @endphp

    <div style="
        display:flex;
        justify-content:center;
        align-items:center;
        flex-wrap:wrap;
        gap:25px;
        max-width:1000px;
        margin:auto;
    ">

        @foreach($hts as $ht)
            <div style="
                background:#1a1a1a;
                border:1px solid #333;
                border-radius:12px;
                padding:18px;
                width:240px;
                text-align:center;
                transition:0.3s;
            " 
            onmouseover="this.style.borderColor='#FFD700'; this.style.transform='translateY(-6px)';"
            onmouseout="this.style.borderColor='#333'; this.style.transform='none';">

                <img src="/images/{{ $ht['gambar'] }}" 
                     alt="{{ $ht['nama'] }}" 
                     style="width:100%; border-radius:10px; margin-bottom:10px;">
                
                <h3 style="color:#f5f5f5; margin-bottom:8px;">{{ $ht['nama'] }}</h3>
                <p style="color:#ccc; margin-bottom:15px;">Rp {{ number_format($ht['harga'], 0, ',', '.') }} / hari</p>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="nama_ht" value="{{ $ht['nama'] }}">
                    <input type="hidden" name="harga" value="{{ $ht['harga'] }}">
                    <button type="submit" style="
                        background:#FFD700;
                        border:none;
                        padding:10px 14px;
                        border-radius:8px;
                        font-weight:bold;
                        color:#111;
                        cursor:pointer;
                        transition:0.2s;
                    "
                    onmouseover="this.style.background='#ffea00';"
                    onmouseout="this.style.background='#FFD700';">
                        Tambah ke Keranjang
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
