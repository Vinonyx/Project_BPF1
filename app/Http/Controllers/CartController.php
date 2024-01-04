<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Simpan data ke dalam database
        $cart = new Cart(); // Sesuaikan dengan model yang digunakan
        $cart->id_barang = $request->id_barang;
        $cart->nama = $request->nama;
        $cart->satuan = $request->satuan;
        $cart->harga = $request->harga;
        $cart->quantity = $request->quantity;
        $cart->save();

        // Response atau redirect sesuai kebutuhan
        return response()->json(['message' => 'Data Ditambahkan ke Keranjang']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart, $id)
    {
        $cart = Cart::find($id);

        $cart->delete();

        Alert::success('Berhasil', 'Barang Berhasil Dihapus dari Keranjang!');

        return redirect('/transaksi');
    }
}
