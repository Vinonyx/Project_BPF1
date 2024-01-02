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
            'barang_keluar' => BarangKeluar::orderBy('tanggal_keluar', 'desc')->get(),
            'profile' => User::all(),
        );

        return view('barang.barang-keluar', $data);
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
    public function store(Request $request, $nama)
    {
        $barang = Barang::where('nama', $nama)->first();

        if ($barang && $barang->quantity >= $request->quantity && $barang->quantity > 0) {
            BarangKeluar::create([
                'nama' => $request->nama,
                'quantity' => $request->quantity,
                'satuan' => $request->satuan,
                'tanggal_keluar' => $request->tanggal_keluar,
            ]);

            $barang->quantity -= $request->quantity;
            $barang->save();

            Alert::success('Success', 'Data Berhasil Ditambah!');
            Notification::send(auth()->user(), new BarangNotification('barang_keluar'));

            return redirect('/barang-keluar');
        } else {
            Alert::error('Error', 'Stok barang tidak mencukupi atau barang tidak tersedia!');
            return redirect('/barang-keluar');
        }
    }

    public function getSatuan(Request $request)
    {
        $namaBarang = $request->input('nama');

        // Ambil data satuan berdasarkan nama barang dari database
        $satuan = Barang::where('nama', $namaBarang)->value('satuan');

        // Mengembalikan respons JSON dengan data satuan
        return response()->json(['satuan' => $satuan]);
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
