<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = array(
            'title' => 'Dashboard',
            'profile' => User::all(),
            'latestDataMasuk' => BarangMasuk::latest()->first(),
            'latestDataKeluar' => BarangKeluar::latest()->first(),
            'barang_masuk' => BarangMasuk::select(DB::raw("SUM(quantity) as total_barang_masuk"))->get(),
            'barang_keluar' => BarangKeluar::select(DB::raw("SUM(quantity) as total_barang_keluar"))->get(),
            'loggedInUserEmail' => Auth::user()->email,
        );

        return view('dashboard', $data);
    }

    public function barang_masuk(Request $request)
    {
        $selectedYear = $request->input('year', Carbon::now()->year);
        $stocks = BarangMasuk::select(DB::raw('SUM(quantity) as total_quantity'), DB::raw('MONTH(tanggal_masuk) as month'))
            ->whereYear('tanggal_masuk', $selectedYear)
            ->groupBy(DB::raw('MONTH(tanggal_masuk)'))
            ->get();

        return response()->json($stocks);
    }


    public function barang_keluar(Request $request)
    {
        $selectedYear = $request->input('year', Carbon::now()->year);
        $stocks = BarangKeluar::select(DB::raw('SUM(quantity) as total_quantity'), DB::raw('MONTH(tanggal_keluar) as month'))
            ->whereYear('tanggal_keluar', $selectedYear)
            ->groupBy(DB::raw('MONTH(tanggal_keluar)'))
            ->get();

        return response()->json($stocks);
    }

    public function editNama(Request $request, $id)
    {
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
        ]);
        Alert::success('Success', 'Nama Berhasil Diubah!');

        return redirect()->back();
    }

    public function editEmail(Request $request, $id)
    {
        $user = User::find($id);
        $user->update([
            'email' => $request->email,
        ]);
        Alert::success('Success', 'Email Berhasil Diubah!');

        return redirect()->back();
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        Alert::success('Success', 'Data User Berhasil Ditambah!');

        return redirect()->back();
    }

    public function destroyUser($id)
    {
        $user = User::find($id);

        $user->delete();

        Alert::success('Berhasil', 'User Berhasil Dihapus!');
        // $title = 'Delete User!';
        // $text = "Are you sure you want to delete?";
        // confirmDelete($title, $text);

        return redirect()->back();
    }
}
