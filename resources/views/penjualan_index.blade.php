@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('penjualan.store') }}" method="post">
                    @csrf
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input class="form-control" type="date" name="tanggal" id="tanggal">
                        </div>

                        <div class="form-group">
                            <label for="noPenjualan">No. Penjualan</label>
                            <input class="form-control" type="text" name="noPenjualan" id="noPenjualan">
                        </div>

                        <div class="form-group">
                            <label for="namaBarang">Nama Barang</label>
                            <input class="form-control" type="text" name="namaBarang" id="namaBarang">
                        </div>

                        <div class="form-group">
                            <label for="qty">Quantity</label>
                            <input class="form-control" type="text" name="qty" id="qty">
                        </div>

                        <div class="form-group">
                            <label for="totalBayar">Total Bayar</label>
                            <input class="form-control" type="text" name="totalBayar" id="totalBayar">
                        </div>

                        <div class="form-group">
                            <label for="disc">Discount</label>
                            <input class="form-control" type="text" name="disc" id="disc">
                        </div>

                        <div class="form-group">
                            <label for="totalPembayaran">Total Pembayaran</label>
                            <input class="form-control" type="text" name="totalPembayaran" id="totalPembayaran">
                        </div>

                        <div class="form-group">
                            <label for="kembalian">Kembalian</label>
                            <input class="form-control" type="text" name="kembalian" id="kembalian">
                        </div>

                        <button class="btn btn-primary" type="submit">SAVE</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Detail Transaksi') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><center>No</th>
                                <th><center>Nama Barang</th>
                                <th><center>Quantity</th>
                                <th><center>Satuan</th>
                                <th><center>Harga</th>
                                <th><center>Total Harga</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($penjualan as $penjualan)
                                <tr>
                                    <td><center>{{ $no++ }}</td>
                                    <td><center>{{ $penjualan->namaBarang }}</td>
                                    <td><center>{{ $penjualan->qty }}</td>
                                    <td><center>{{ $penjualan->satuan }}</td>
                                    <td><center>{{ $penjualan->harga }}</td>
                                    <td><center>{{ $penjualan->totalHarga }}</td>
                                    <td>
                                        <a href="penjualan_edit/{{ $penjualan->id }}">
                                            <button class="btn btn-primary" type="submit">EDIT</button>
                                        </a>
                                    </td>
                                    <td><center>
                                        <form action="{{ route('penjualan.destroy', $penjualan->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger" type="submit">DELETE</button>
                                        </form>
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
@endsection