@extends('layouts.app')

@section('content')
    @foreach($barang as $barang)
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('barang.update', $barang->id) }}" method="POST">
                            {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="kodeBarang">Kode Barang</label>
                                    <input class="form-control" type="text" name="kodeBarang" id="kodeBarang" value="{{ $barang->kodeBarang }}">
                                </div>

                                <div class="form-group">
                                    <label for="namaBarang">Nama Barang</label>
                                    <input class="form-control" type="text" name="namaBarang" id="namaBarang" value="{{ $barang->namaBarang }}">
                                </div>

                                <div class="form-group">
                                    <label for="hargaBeli">Harga Beli</label>
                                    <input class="form-control" type="text" name="hargaBeli" id="hargaBeli" value="{{ $barang->hargaBeli }}">
                                </div>

                                <div class="form-group">
                                    <label for="hargaJual">Harga Jual</label>
                                    <input class="form-control" type="text" name="hargaJual" id="hargaJual" value="{{ $barang->hargaJual }}">
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