@extends('layouts.main')

@section('title', 'Keranjang')

@section('content')
<h1 style="color:#FFD700;">🛒 Keranjang Kamu</h1>

@if(session('success'))
    <p style="color:#00ff88; margin-bottom:15px;">{{ session('success') }}</p>
@endif

@if($carts->count() == 0)
    <p style="color:#ccc;">Belum ada barang di keranjang   </p>
@else
    <table cellpadding="10" cellspacing="0" style="width:100%; color:#f5f5f5; border-collapse:collapse; margin-top:15px;">
        <thead style="background:#2b2b2b; color:#FFD700;">
            <tr>
                <th style="padding:12px;">Nama HT</th>
                <th style="padding:12px;">Harga</th>
                <th style="padding:12px;">Jumlah</th>
                <th style="padding:12px;">Total</th>
                <th style="padding:12px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($carts as $cart)
                @php $total = $cart->harga * $cart->jumlah; $grandTotal += $total; @endphp
                <tr style="border-bottom:1px solid #333;">
                    <td style="padding:12px;">{{ $cart->nama_ht }}</td>
                    <td style="padding:12px;">Rp {{ number_format($cart->harga,0,',','.') }}</td>
                    <td style="padding:12px;">
                        <form action="{{ route('cart.update', $cart->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="jumlah" value="{{ $cart->jumlah }}" min="1"
                                   style="width:60px; background:#1a1a1a; border:1px solid #555; color:#f5f5f5; text-align:center; border-radius:4px;">
                            <button type="submit" class="btn-primary" style="padding:5px 10px; margin-left:5px;">Update</button>
                        </form>
                    </td>
                    <td style="padding:12px;">Rp {{ number_format($total,0,',','.') }}</td>
                    <td style="padding:12px;">
                        <form action="{{ route('cart.delete', $cart->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-primary"
                                    style="background:#ff4d4d; padding:6px 12px; border:none; border-radius:5px; color:white;">
                                    Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <tr style="background:#2b2b2b;">
                <td colspan="3" style="text-align:right; font-weight:bold; padding:12px;">Grand Total:</td>
                <td colspan="2" style="font-weight:bold; color:#FFD700; padding:12px;">Rp {{ number_format($grandTotal,0,',','.') }}</td>
            </tr>
        </tbody>
    </table>

    <form action="{{ route('cart.checkout') }}" method="POST" style="margin-top:25px; text-align:right;">
        @csrf
        <button type="submit" class="btn-primary"
                style="background:#FFD700; color:#111; padding:10px 18px; font-weight:bold; border:none; border-radius:6px;">
            Checkout Sekarang
        </button>
    </form>
@endif
@endsection
