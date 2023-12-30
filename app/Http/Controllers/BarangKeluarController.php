<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\BarangNotification;
use Illuminate\Support\Facades\Notification;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'title' => 'Halaman Barang Keluar',
            'barang' => Barang::all(),
            'profile' => User::all(),
        );

        return view('barang.barang-keluar', $data);
    }

    public function history()
    {
        $data = array(
            'title' => 'History Barang Keluar',
            'barang_keluar' => BarangKeluar::orderBy('created_at', 'desc')->get(),
            'profile' => User::all(),
        );

        return view('barang.history-barang-keluar', $data);
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
    public function store(Request $request, $id)
    {
        $barang = Barang::find($id);

        if ($barang) {
            if ($barang->stok >= $request->jumlah_keluar && $request->jumlah_keluar > 0) {
                $barangKeluar = new BarangKeluar([
                    'nama' => $request->nama,
                    'quantity' => $request->stock_keluar,
                    'satuan' => $request->satuan,
                    'tanggal_keluar' => $request->tanggal_keluar,
                ]);
                $barangKeluar->save();

                $barang->stok -= $request->jumlah_keluar;
                $barang->save();

                $data = array(
                    'title' => 'Barang Masuk | Inv-Cafe',
                    'barang_keluar' => BarangKeluar::all(),
                    'data_barang' => Barang::all(),
                );

                Alert::success('Berhasil', 'Data berhasil dikurangi!');
                return view('gudang.barang_keluar', $data);
            } elseif ($barang->stok < $request->jumlah_keluar) {
                Alert::error('Gagal', 'Jumlah Permintaan Lebih Dari Stok');
            } else {
                Alert::error('Gagal', 'Jumlah Barang yang Dikeluarkan Tidak Valid');
            }
        } else {
            Alert::error('Gagal', 'Barang Tidak Ditemukan!');
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(BarangKeluar $barangKeluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarangKeluar $barangKeluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BarangKeluar $barangKeluar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangKeluar $barangKeluar)
    {
        //
    }
}
