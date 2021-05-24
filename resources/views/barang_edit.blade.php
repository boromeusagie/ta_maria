@extends('layouts.app')

@section('content')
    @foreach($barang as $barang)
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('barang.update', $barang->id) }}" method="POST">
                            @csrf
                                <div class="form-group">
                                    <label for="kodeBarang">Kode Barang</label>
                                    <input class="form-control @error('kodeBarang') is-invalid @enderror" type="text" name="kodeBarang" id="kodeBarang" value="{{ $barang->kodeBarang }}" readonly>
                                    @error('kodeBarang')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="namaBarang">Nama Barang</label>
                                    <input class="form-control @error('namaBarang') is-invalid @enderror" type="text" name="namaBarang" id="namaBarang" value="{{ $barang->namaBarang }}">
                                    @error('namaBarang')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="hargaBeli">Satuan</label>
                                    <input class="form-control @error('satuan') is-invalid @enderror" type="text" name="satuan" id="satuan" value="{{ $barang->satuan }}">
                                    @error('satuan')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="hargaBeli">Harga Beli</label>
                                    <input class="form-control @error('hargaBeli') is-invalid @enderror" type="text" name="hargaBeli" id="hargaBeli" value="{{ $barang->hargaBeli }}">
                                    @error('hargaBeli')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="hargaJual">Harga Jual</label>
                                    <input class="form-control @error('hargaJual') is-invalid @enderror" type="text" name="hargaJual" id="hargaJual" value="{{ $barang->hargaJual }}">
                                    @error('hargaJual')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
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