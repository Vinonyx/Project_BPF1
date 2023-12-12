@extends('layouts.main')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">History Barang Masuk</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button class="btn btn-danger btn-icon-split float-right" onclick="window.print()">
                <span class="icon text-white-50">
                    <i class="bi bi-filetype-pdf"></i>
                </span>
                <span class="text">Cetak Laporan</span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Quantity</th>
                            <th>Satuan</th>
                            <th>Tanggal Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($barang_masuk as $b)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $b->nama }}</td>
                                <td>{{ $b->quantity }}</td>
                                <td>{{ $b->satuan }}</td>
                                <td>{{ $b->tanggal_masuk }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
