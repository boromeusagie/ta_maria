@extends('layouts.app')

@section('content')
    @foreach($penjualan as $penjualan)
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('penjualan.store') }}" method="post">
                        @csrf
                            <div class="form-group">
                                <label for="namaBarang">Nama Barang</label>
                                <input class="form-control" type="text" name="namaBarang" id="namaBarang">
                            </div>

                            <div class="form-group">
                                <label for="satuan">Satuan</label>
                                <input class="form-control" type="text" name="satuan" id="satuan">
                            </div>

                            <div class="form-group">
                                <label for="qty">Quantity</label>
                                <input class="form-control" type="text" name="qty" id="qty">
                            </div>

                            <div class="form-group">
                                <label for="disc">Discount</label>
                                <input class="form-control" type="text" name="disc" id="disc">
                            </div>

                            <div class="form-group">
                                <label for="totalPembayaran">Total Pembayaran</label>
                                <input class="form-control" type="text" name="totalPembayaran" id="totalPembayaran">
                            </div>

                            <button class="btn btn-primary" type="submit">SAVE</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
	@endforeach
@endsection