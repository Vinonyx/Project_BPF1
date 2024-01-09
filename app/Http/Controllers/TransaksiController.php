<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Cart;
use App\Models\User;
use App\Models\Barang;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'title' => 'Transaksi',
            'barang' => Barang::all(),
            'cart' => Cart::all(),
            'profile' => User::all(),
        );

        return view('barang.transaksi', $data);
    }

    public function history()
    {
        $data = array(
            'title' => 'History Transaksi',
            'barang' => Barang::all(),
            'transaksi' => Transaksi::with('detailTransaksi')->get(),
            'profile' => User::all(),
        );

        return view('barang.history-transaksi', $data);
    }

    public function detail($id_transaksi)
    {
        $data = array(
            'detailTransaksi' => DetailTransaksi::select('detail_transaksis.*', 'barangs.nama', 'barangs.harga')
                ->join('barangs', 'detail_transaksis.id_barang', '=', 'barangs.id')
                ->where('detail_transaksis.id_transaksi', $id_transaksi)
                ->get(),
        );

        return view('barang.history-transaksi', $data);
    }

    public function addToCart(Request $request)
    {
        // Pastikan quantity yang dimasukkan lebih besar dari 0
        if ($request->quantity > 0) {
            // Cek apakah barang sudah ada di keranjang berdasarkan id_barang
            $existingCart = Cart::where('id_barang', $request->id_barang)->first();

            if ($existingCart) {
                // Jika barang sudah ada, tambahkan quantity
                $existingCart->quantity += $request->quantity;
                $existingCart->save();

                // Response atau redirect sesuai kebutuhan
                Session::flash('cart', 'Barang Ditambahkan ke Keranjang!');
                return response()->json(['message' => 'Data Ditambahkan ke Keranjang']);
            } else {
                // Jika barang belum ada, buat entry baru di keranjang
                $cart = new Cart();
                $cart->id_barang = $request->id_barang;
                $cart->nama = $request->nama;
                $cart->satuan = $request->satuan;
                $cart->harga = $request->harga;
                $cart->quantity = $request->quantity;
                $cart->save();

                // Response atau redirect sesuai kebutuhan
                Session::flash('cart', 'Barang Ditambahkan ke Keranjang!');
                return response()->json(['message' => 'Data Ditambahkan ke Keranjang']);
            }
        } else {
            Session::flash('cart', 'Tidak ada quantity yang dimasukkan.');
        }
    }

    public function destroyCart($id)
    {
        $cart = Cart::find($id);

        if ($cart) {
            $cart->delete();
            Session::flash('cart', 'Barang Berhasil Dihapus!');
            return redirect()->back();
        } else {
            Session::flash('cart', 'Barang Gagal Dihapus!');
            return redirect()->back();
        }
    }

    public function checkout()
    {
        $transaksi = Transaksi::create([
            'total_harga' => 0,
        ]);

        $totalHargaTransaksi = 0;

        $cartItems = Cart::all();

        foreach ($cartItems as $item) {
            $totalHargaBarang = $item->harga * $item->quantity;

            $totalHargaTransaksi += $totalHargaBarang;

            DetailTransaksi::create([
                'id_transaksi' => $transaksi->id,
                'id_barang' => $item->id_barang,
                'quantity' => $item->quantity,
            ]);
        }

        $transaksi->update(['total_harga' => $totalHargaTransaksi]);

        Session::flash('cart', 'Berhasil Checkout!');
        Cart::truncate();

        return redirect()->back();
    }
}
