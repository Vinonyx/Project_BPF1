<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\BarangNotification;
use Illuminate\Support\Facades\Notification;

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
            'profile' => User::all(),
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
        Notification::send(auth()->user(), new BarangNotification('barang'));

        return redirect()->back();
    }

    public function markAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
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
    public function edit($id)
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
        // $title = 'Delete User!';
        // $text = "Are you sure you want to delete?";
        // confirmDelete($title, $text);

        return redirect('/list');
    }
}
