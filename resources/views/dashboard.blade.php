@extends('layouts.main')

@section('content')
    @if (session()->has('login'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('login') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

    <div class="row">
        <!-- Barang Masuk Card  -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Barang Masuk
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ isset($barang_masuk[0]->total_barang_masuk) ? $barang_masuk[0]->total_barang_masuk : 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box-fill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Barang Masuk Terakhir</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                                        {{ $latestDataMasuk ? $latestDataMasuk['nama'] : 'Tidak Ada' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                             <i class="bi bi-box-fill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Barang Keluar Card  -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Jumlah Barang Keluar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ isset($barang_keluar[0]->total_barang_keluar) ? $barang_keluar[0]->total_barang_keluar : 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box-seam fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Barang Keluar Terakhir
                            </div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                {{ $latestDataKeluar ? $latestDataKeluar['nama'] : 'Tidak Ada' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-box-seam fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
