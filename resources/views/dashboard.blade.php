@extends('layouts.main')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>


    <!-- Area Chart -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jumlah Barang Masuk Per-Bulan</h6>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="chart-barang-masuk"></canvas>
            </div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jumlah Barang Keluar Per-Bulan</h6>
        </div>
        <div class="card-body">
            <div class="chart-area">
                <canvas id="chart-barang-keluar"></canvas>
            </div>
        </div>
    </div>
@endsection
