@extends('layouts.app')

@section('content')
    @foreach($supplier as $supplier)
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
                            {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="kodeSupplier">Kode Supplier</label>
                                    <input class="form-control @error('kodeSupplier') is-invalid @enderror" type="text" name="kodeSupplier" id="kodeSupplier" value="{{ $supplier->kodeSupplier }}" readonly>
                                    @error('kodeSupplier')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="namaSupplier">Nama Supplier</label>
                                    <input class="form-control @error('namaSupplier') is-invalid @enderror" type="text" name="namaSupplier" id="namaSupplier" value="{{ $supplier->namaSupplier }}">
                                    @error('namaSupplier')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="almtSupplier">Alamat</label>
                                    <input class="form-control @error('almtSupplier') is-invalid @enderror" type="text" name="almtSupplier" id="almtSupplier" value="{{ $supplier->almtSupplier }}">
                                    @error('almtSupplier')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="tlpSupplier">Telephone</label>
                                    <input class="form-control @error('tlpSupplier') is-invalid @enderror" type="text" name="tlpSupplier" id="tlpSupplier" value="{{ $supplier->tlpSupplier }}">
                                    @error('tlpSupplier')
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