@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Detail Transaksi') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><center>No</th>
                                <th><center>No Faktur</th>
                                <th><center>Quantity</th>
                                <th><center>Satuan</th>
                                <th><center>Harga</th>
                                <th><center>Total Harga</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pembelian as $index => $value)
                                <tr>
                                    <td><center>{{ $index + 1 }}</td>
                                    <td><center>{{ $value->namaBarang }}</td>
                                    <td><center>{{ $value->qty }}</td>
                                    <td><center>{{ $value->satuan }}</td>
                                    <td><center>{{ $value->harga }}</td>
                                    <td><center>{{ $value->totalHarga }}</td>
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