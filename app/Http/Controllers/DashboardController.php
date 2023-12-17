<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
        );
        $data['barang_masuk'] = BarangMasuk::select(DB::raw('SUM(quantity) as total_barang_masuk'))->get();
        $data['barang_keluar'] = BarangKeluar::select(DB::raw('SUM(quantity) as total_barang_keluar'))->get();

        return view('dashboard', $data);
    }

    public function barang_masuk()
    {
        $currentYear = Carbon::now()->year;
        $stocks = BarangMasuk::select(DB::raw('SUM(quantity) as total_quantity'), DB::raw('MONTH(tanggal_masuk) as month'))
            ->whereYear('tanggal_masuk', $currentYear)
            ->groupBy(DB::raw('MONTH(tanggal_masuk)'))
            ->get();

        return response()->json($stocks);
    }

    public function barang_keluar()
    {
        $currentYear = Carbon::now()->year;
        $stocks = BarangKeluar::select(DB::raw('SUM(quantity) as total_quantity'), DB::raw('MONTH(tanggal_keluar) as month'))
            ->whereYear('tanggal_keluar', $currentYear)
            ->groupBy(DB::raw('MONTH(tanggal_keluar)'))
            ->get();

        return response()->json($stocks);
    }
}
