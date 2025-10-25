<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan semua item keranjang milik user
    public function index()
    {
        $carts = Cart::where('user_id', Auth::id())->get();
        return view('cart', compact('carts'));
    }

    // Menambahkan barang ke keranjang
    public function add(Request $request)
    {
        Cart::create([
            'user_id' => Auth::id(),
            'nama_ht' => $request->nama_ht,
            'harga' => $request->harga,
            'jumlah' => 1,
        ]);

        return redirect('/cart')->with('success', 'Barang berhasil ditambahkan ke keranjang!');
    }

    // Menghapus barang dari keranjang
    public function delete($id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->first();
        if ($cart) {
            $cart->delete();
        }

        return redirect('/cart')->with('success', 'Barang berhasil dihapus dari keranjang!');
    }

    // Update jumlah barang
    public function update(Request $request, $id)
    {
    $cart = Cart::where('user_id', Auth::id())->where('id', $id)->first();
    if ($cart) {
        $cart->jumlah = $request->jumlah;
        $cart->save();
    }

    return redirect('/cart')->with('success', 'Jumlah barang diperbarui!');
    }

// Simulasi checkout (hapus semua item user)
    public function checkout()
    {
    // hapus semua item user setelah checkout
        Cart::where('user_id', Auth::id())->delete();
        return redirect('/checkout-success');
    }



    
}
