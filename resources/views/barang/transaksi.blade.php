@extends('layouts.main')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Transaksi</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button class="btn btn-success btn-icon-split" data-bs-toggle="modal" data-bs-target="#modalKeranjang">
                <span class="icon text-white-50">
                    <i class="bi bi-cart-fill"></i>
                </span>
                <span class="text">Cart</span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th class="col-1">Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($barang as $b)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $b->nama }}</td>
                                <td>{{ $b->satuan }}</td>
                                <td>Rp. {{ $b->harga }}</td>
                                <td>
                                    <input type="number" class="form-control quantity-input" min="1">
                                </td>
                                <td>
                                    <button class="btn btn-primary add-to-cart" data-barang-id="{{ $b->id }}"
                                        data-nama="{{ $b->nama }}" data-satuan="{{ $b->satuan }}"
                                        data-harga="{{ $b->harga }}">
                                        Add to Cart
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Keranjang-->
        <div class="modal fade bd-example-modal-lg" id="modalKeranjang" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Keranjang</h1>
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
                                            <th>Harga</th>
                                            <th class="col-1">Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        @foreach ($cart as $c)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $c->nama }}</td>
                                                <td>{{ $c->satuan }}</td>
                                                <td>Rp. {{ $c->harga }}</td>
                                                <td>{{ $c->quantity }}</td>
                                                <td>
                                                    <a href="#modalHapus{{ $c->id }}" class="btn btn-danger"
                                                        data-bs-toggle="modal">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @foreach ($cart as $ca)
                <!-- Modal Hapus-->
                <div class="modal fade" id="modalHapus{{ $ca->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Hapus Barang</h5>
                                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Apakah ingin menghapus barang ini?</div>
                            <form action="/list/destroy/{{ $ca->id }}" method="GET">
                                @csrf
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-danger" type="submit">
                                        Hapus
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endsection

        @section('js')
            <script>
                $(document).ready(function() {
                    $('.add-to-cart').on('click', function() {
                        var barangId = $(this).data('barang-id');
                        var nama = $(this).data('nama');
                        var satuan = $(this).data('satuan');
                        var harga = $(this).data('harga');
                        var quantity = $(this).closest('tr').find('.quantity-input').val();

                        // Kirim data ke controller menggunakan AJAX
                        $.ajax({
                            type: 'POST',
                            url: '/addToCart', // Sesuaikan dengan URL Anda
                            data: {
                                id_barang: barangId,
                                nama: nama,
                                satuan: satuan,
                                harga: harga,
                                quantity: quantity,
                                _token: '{{ csrf_token() }}' // Diperlukan untuk verifikasi CSRF di Laravel
                            },
                            success: function(response) {
                                // Tindakan setelah data dikirim ke controller
                                console.log(response);
                                // Misalnya, tampilkan pesan sukses kepada pengguna
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: 'Barang berhasil ditambahkan ke keranjang!',
                                });
                            },
                            error: function(err) {
                                // Tindakan jika terjadi kesalahan
                                console.error(err);
                                // Misalnya, tampilkan pesan error kepada pengguna
                                alert(
                                    'Terjadi kesalahan. Data barang tidak dapat ditambahkan ke keranjang'
                                );
                            }
                        });
                    });
                });
            </script>
        @endsection
