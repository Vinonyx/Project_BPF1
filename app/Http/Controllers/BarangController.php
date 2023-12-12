<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'title' => 'List Barang',
            'barang' => Barang::all(),
        );

        return view('barang.list', $data);
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
        Barang::create([
            'quantity' => $request->quantity,
            'nama' => $request->nama,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
        ]);
        Alert::success('Success', 'Data Berhasil Ditambah!');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);
        $barang->update([
            'quantity' => $request->quantity,
            'nama' => $request->nama,
            'satuan' => $request->satuan,
            'harga' => $request->harga,
        ]);
        Alert::success('Success', 'Data Berhasil Diubah!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barang = Barang::find($id);

        $barang->delete();

        Alert::success('Berhasil', 'Data Berhasil Dihapus!');

        return redirect('/list');
    }

    public function barangMasuk()
    {
        $currentYear = Carbon::now()->year;
        $stocks = BarangMasuk::select(DB::raw('SUM(quantity) as total_quantity'), DB::raw('MONTH(tanggal_masuk) as month'))
            ->whereYear('tanggal_masuk', $currentYear)
            ->groupBy(DB::raw('MONTH(tanggal_masuk)'))
            ->get();
        
        return response()->json($stocks);
    }
}
