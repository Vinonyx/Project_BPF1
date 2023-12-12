@extends('layouts.main')

@section('content')

<h1 class="h3 mb-4 text-gray-800">History Barang Keluar</h1>
<div class="card shadow mb-4">
    <div class="card-header py-3"></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Quantity</th>
                        <th>Satuan</th>
                        <th>Tanggal Keluar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach($barang_keluar as $b)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $b->nama }}</td>
                        <td>{{ $b->quantity }}</td>
                        <td>{{ $b->satuan }}</td>
                        <td>{{ $b->tanggal_keluar }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection