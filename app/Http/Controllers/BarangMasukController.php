<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\BarangNotification;
use Illuminate\Support\Facades\Notification;

class BarangMasukController extends Controller
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
            'title' => 'Halaman Barang Masuk',
            'barang' => Barang::all(),
            'barang_masuk' => BarangMasuk::orderBy('tanggal_masuk', 'desc')->get(),
            'profile' => User::all(),
        );

        return view('barang.barang-masuk', $data);
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
        BarangMasuk::create([
            'nama' => $request->nama,
            'quantity' => $request->quantity,
            'satuan' => $request->satuan,
            'tanggal_masuk' => $request->tanggal_masuk,
        ]);

        $barang = Barang::where('nama', $nama)->first();

        if ($barang) {
            $barang->quantity += $request->quantity;
            $barang->save();
        }
        Alert::success('Success', 'Data Berhasil Ditambah!');
        Notification::send(auth()->user(), new BarangNotification('barang_masuk'));

        return redirect('/barang-masuk');
    }

    public function getSatuan(Request $request)
    {
        $namaBarang = $request->input('nama');

        // Ambil data satuan berdasarkan nama barang dari database
        $satuan = Barang::where('nama', $namaBarang)->value('satuan');

        // Mengembalikan respons JSON dengan data satuan
        return response()->json(['satuan' => $satuan]);
    }

    /**3
     *Display the specified resource.
     */
    public function show(BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BarangMasuk $barangMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BarangMasuk $barangMasuk)
    {
        //
    }
}
