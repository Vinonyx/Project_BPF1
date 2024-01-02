@extends('layouts.main')

@section('content')
    <h1 class="h3 mb-4 text-gray-800">Barang Keluar</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="#modalTambah" class="btn btn-primary btn-icon-split" data-bs-toggle="modal">
                <span class="icon text-white-50">
                    <i class="bi bi-plus-lg"></i>
                </span>
                <span class="text">Tambah</span>
            </a>
            <button class="btn btn-danger btn-icon-split float-right" onclick="printTable()">
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
                            <th>Tanggal Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($barang_keluar as $b)
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

        <!-- Modal Tambah-->
        <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Barang Keluar</h1>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @foreach ($barang as $bar)
                            <form action="/barang-keluar/store/{{ $bar->nama }}" method="POST">
                        @endforeach
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="col-form-label">Nama Barang</label>
                            <select name="nama" id="nama" class="form-control" required>
                                <option value="">Pilih Barang</option>
                                @foreach ($barang as $br)
                                    <option value="{{ $br->nama }}">{{ $br->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="satuan" class="col-form-label">Satuan</label>
                            <input type="text" class="form-control" name="satuan" id="satuan_result" value=""
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="col-form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="quantity">
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_keluar" class="col-form-label">Tanggal Keluar</label>
                            <input type="date" class="form-control" name="tanggal_keluar" id="tanggal_keluar" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @section('js')
        <!-- Pastikan Anda telah menyertakan pustaka jQuery sebelum menggunakan kode ini -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#nama').on('change', function() { // Change the event listener to target the 'nama' select box
                    var selectedBarang = $(this).val(); // Retrieve the selected value

                    if (selectedBarang !== '') {
                        $.ajax({
                            url: '/getSatuan', // Ensure this URL is correct for your backend route
                            method: 'GET',
                            data: {
                                nama: selectedBarang
                            },
                            success: function(response) {
                                $('#satuan_result').val(response.satuan);
                                // Set the value to the 'satuan_result' input field
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    } else {
                        $('#satuan_result').val('');
                        // If no item is selected, clear the 'satuan_result' input field
                    }
                });
            });

            function printTable() {
                var printContents = document.getElementById('dataTable').outerHTML;
                var originalContents = document.body.innerHTML;

                // Menambahkan judul di atas halaman cetak
                var title = '<h1 class="text-center mb-4">Laporan Barang Keluar</h1>';
                printContents = title + printContents;

                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }
        </script>
    @endsection
