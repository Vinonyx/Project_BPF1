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
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        if ($barang && $barang->quantity >= $request->stock_keluar && $barang->quantity > 0) {
            BarangKeluar::create([
                'nama' => $request->nama,
                'quantity' => $request->stock_keluar,
                'satuan' => $request->satuan,
                'tanggal_keluar' => $request->tanggal_keluar,
            ]);

            $barang->quantity -= $request->stock_keluar;
            $barang->save();

            Alert::success('Success', 'Data Berhasil Ditambah!');
            Notification::send(auth()->user(), new BarangNotification('barang_keluar'));

            return redirect('/barang-keluar');
        } else {
            Alert::error('Error', 'Stok barang tidak mencukupi atau barang tidak tersedia!');
            return redirect('/barang-keluar');
        }

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
