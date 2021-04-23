@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('supplier.store') }}" method="post">
                    @csrf
                        <div class="form-group">
                            <label for="kodeSupplier">Kode Supplier</label>
                            <input class="form-control @error('kodeSupplier') is-invalid @enderror" type="text" name="kodeSupplier" id="kodeSupplier">
                            @error('kodeSupplier')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="namaSupplier">Nama Supplier</label>
                            <input class="form-control @error('namaSupplier') is-invalid @enderror" type="text" name="namaSupplier" id="namaSupplier">
                            @error('namaSupplier')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="almtSupplier">Alamat</label>
                            <input class="form-control @error('almtSupplier') is-invalid @enderror" type="text" name="almtSupplier" id="almtSupplier">
                            @error('almtSupplier')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tlpSupplier">Telephone</label>
                            <input class="form-control @error('tlpSupplier') is-invalid @enderror" type="text" name="tlpSupplier" id="tlpSupplier">
                            @error('tlpSupplier')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-primary" type="submit">SAVE</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Daftar Supplier') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><center>No</center></th>
                                <th><center>Kode Supplier</center></th>
                                <th><center>Nama Supplier</center></th>
                                <th><center>Alamat</center></th>
                                <th><center>Telephone</center></th>
                                <th colspan="2"><center>Action</center></th>
                            </tr>
                        </thead>
                        <tbody>
                        @php $no = 1; @endphp
                            @foreach($supplier as $supplier)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $supplier->kodeSupplier }}</td>
                                    <td>{{ $supplier->namaSupplier }}</td>
                                    <td>{{ $supplier->almtSupplier }}</td>
                                    <td>{{ $supplier->tlpSupplier }}</td>
                                    <td>
                                        <a href="{{ route('supplier.edit', $supplier->id) }}">
                                            <button class="btn btn-primary" type="submit">EDIT</button>
                                        </a>
                                    </td>
                                    <td>
                                        <form action="{{ route('supplier.destroy', $supplier->id) }}" method="POST">
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