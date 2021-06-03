@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">

            <div class="row justify-content-left">
                <div class="col-lg-6 border-right">
                    <h5>Filter</h5>
                    <form action="{{ route('kas.show') }}" method="get">
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-3 col-form-label">Tanggal</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="date" name="tanggal" id="tanggal">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12" align="left">
                                <button class="btn btn-primary" type="submit">FILTER</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6">
                    <h5>Transaksi Baru</h5>
                    <form action="{{ route('kas.store') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-4 col-form-label">Tanggal</label>
                            <div class="col-sm-8">
                                <input class="form-control @error('tanggal') is-invalid @enderror" type="date" name="tanggal" id="tanggal" value="{{ Carbon\Carbon::today()->format('Y-m-d') }}" readonly>
                                @error('tanggal')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-4 col-form-label">Jenis Transaksi</label>
                            <div class="col-sm-8">
                                <div class="form-check">
                                    <input class="form-check-input @error('jenisTransaksi') is-invalid @enderror" type="radio" name="jenisTransaksi" id="kasMasuk" value="kasMasuk">
                                    <label class="form-check-label" for="kasMasuk">Kas Masuk</label>
                                    @error('jenisTransaksi')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input @error('jenisTransaksi') is-invalid @enderror" type="radio" name="jenisTransaksi" id="kasKeluar" value="kasKeluar">
                                    <label class="form-check-label" for="kasKeluar">Kas Keluar</label>
                                    @error('jenisTransaksi')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="detailTransaksi" class="col-sm-4 col-form-label">Detail Transaksi</label>
                            <div class="col-sm-8">
                                <input class="form-control @error('detailTransaksi') is-invalid @enderror" type="text" name="detailTransaksi" id="detailTransaksi">
                                @error('detailTransaksi')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="totalSaldo" class="col-sm-4 col-form-label">Total Saldo</label>
                            <div class="col-sm-8">
                                <input class="form-control @error('totalSaldo') is-invalid @enderror" type="text" name="totalSaldo" id="totalSaldo">
                                @error('totalSaldo')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12" align="right">
                                <button class="btn btn-primary col-sm-2" type="submit">SAVE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><center>No</th>
                        <th><center>Detail Transaksi</th>
                        <th><center>Debit</th>
                        <th><center>Kredit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><center></td>
                        <td></td>
                        <td><center></td>
                        <td><center></td>
                    </tr>
                    <tr>
                        <th colspan="2"><div class="text-center"><strong>TOTAL SALDO</strong></div></th>
                        <th><center></th>
                        <th><center></th>
                    </tr>
                    <tr>
                        <th colspan="2"><div class="text-center"><strong>PERSENTASE KEUNTUNGAN</strong></div></th>
                        <th colspan="2"><center></th>
                    </tr>
                    <tr>
                        <th colspan="2"><div class="text-center"><strong>TOTAL LABA RUGI</strong></div></th>
                        <th colspan="2"><center></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection