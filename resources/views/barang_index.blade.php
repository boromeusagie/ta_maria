@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
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