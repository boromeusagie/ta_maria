@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('laporanKas.store') }}" method="post">
                    @csrf
                        <div class="form-group">
                            <label for="dariTanggal">Dari Tanggal</label>
                            <input class="form-control" type="date" name="dariTanggal" id="dariTanggal">
                        </div>
                        <div class="form-group">
                            <label for="sampaiTanggal">Sampai Tanggal</label>
                            <input class="form-control" type="date" name="sampaiTanggal" id="sampaiTanggal">
                        </div>
                        <td>
                            <a href="{{ route('supplier.edit', $supplier->id) }}">
                                <button class="btn btn-primary" type="submit">OK</button>
                            </a>
                        </td>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>