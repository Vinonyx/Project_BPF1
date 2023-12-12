<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
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
        );

        return view('dashboard', $data);
    }

    public function barang_masuk()
    {
        $stocks = BarangMasuk::select(DB::raw('SUM(quantity) as total_quantity'), DB::raw('MONTH(created_at) as month'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        $months = [];
        $quantities = [];

        foreach ($stocks as $stock) {
            $months[] = $stock->month;
            $quantities[] = $stock->total_quantity;
        }

        $chartData = [
            'months' => $months,
            'quantities' => $quantities,
        ];

        return response()->json($chartData); // Mengirim data sebagai respons JSON
    }
}
