@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card">
                <div class="card-body">
                    <form action="{{ route('barang.store') }}" method="post">
                    @csrf
                        <div class="form-group">
                            <label for="kodeBarang">Kode Barang</label>
                            <input class="form-control @error('kodeBarang') is-invalid @enderror" type="text" name="kodeBarang" id="kodeBarang">
                            @error('kodeBarang')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="namaBarang">Nama Barang</label>
                            <input class="form-control @error('namaBarang') is-invalid @enderror" type="text" name="namaBarang" id="namaBarang">
                            @error('namaBarang')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="qty">Quantity</label>
                            <input class="form-control @error('qty') is-invalid @enderror" type="text" name="qty" id="qty">
                            @error('qty')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <input class="form-control @error('satuan') is-invalid @enderror" type="text" name="satuan" id="satuan">
                            @error('satuan')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="hargaBeli">Harga Beli</label>
                            <input class="form-control @error('hargaBeli') is-invalid @enderror" type="text" name="hargaBeli" id="hargaBeli">
                            @error('hargaBeli')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="hargaJual">Harga Jual</label>
                            <input class="form-control @error('hargaJual') is-invalid @enderror" type="text" name="hargaJual" id="hargaJual">
                            @error('hargaJual')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-primary" type="submit">SAVE</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Daftar Barang') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><center>No</center></th>
                                <th><center>Kode Barang</center></th>
                                <th><center>Nama Barang</center></th>
                                <th><center>Quantity</center></th>
                                <th><center>Satuan</center></th>
                                <th><center>Harga Jual</center></th>
                                <th><center>Harga Beli</center></th>
                                <th colspan = "2"><center>Action</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1; @endphp
                            @foreach($barangs as $barang)
                                <tr>
                                    <td><center>{{ $no++ }}</td>
                                    <td>{{ $barang->kodeBarang }}</td>
                                    <td>{{ $barang->namaBarang }}</td>
                                    <td><center>{{ $barang->qty }}</td>
                                    <td><center>{{ $barang->satuan }}</td>
                                    <td>{{ $barang->hargaBeli }}</td>
                                    <td>{{ $barang->hargaJual }}</td>
                                    <td>
                                        <a href="{{ route('barang.edit', $barang->id) }}">
                                            <button class="btn btn-primary" type="submit">EDIT</button>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('barang.destroy', $barang->id) }}" method="POST">
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