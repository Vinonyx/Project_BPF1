@extends('layouts.main')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">History Transaksi</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3"></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Transaksi</th>
                            <th>Total Harga</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($transaksi as $t)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $t->tanggal_transaksi }}</td>
                                <td>Rp. {{ $t->total_harga }}</td>
                                <td>
                                    <button class="btn btn-primary btn-icon-split" data-bs-toggle="modal"
                                        data-bs-target="#modalDetail{{ $t->id }}">
                                        <span class="icon text-white-50">
                                            <i class="bi bi-info-circle-fill"></i>
                                        </span>
                                        <span class="text">Detail</span>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modals -->
    @foreach ($transaksi as $tr)
        <div class="modal fade bd-example-modal-lg" id="modalDetail{{ $tr->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Transaksi</h1>
                        <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Satuan</th>
                                            <th>Quantity</th>
                                            <th>Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                            $totalHarga = 0;
                                        @endphp
                                        @foreach ($tr->detailTransaksi as $detail)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $detail->barang->nama }}</td>
                                                <td>{{ $detail->barang->satuan }}</td>
                                                <td>{{ $detail->quantity }}</td>
                                                <td>Rp. {{ $detail->barang->harga * $detail->quantity }}</td>
                                            </tr>
                                            @php $totalHarga += $detail->barang->harga * $detail->quantity; @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-center"><strong>Total</strong></td>
                                            <td><strong>Rp. {{ $totalHarga }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
