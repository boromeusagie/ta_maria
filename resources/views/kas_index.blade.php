@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">

            <div class="row justify-content-left">
                <div class="col-lg-6">
                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-4 col-form-label">Tanggal</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="date" name="tanggal" id="tanggal">
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <label>Kas Masuk</label>
                    <div class="form-group row">
                        <label for="tanggalKasMasukStart" class="col-sm-3 col-form-label">Penjualan Tanggal</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="date" name="tanggalKasMasukStart" id="tanggalKasMasukStart">
                        </div>
                        <label for="tanggalKasMasukEnd" class="col-sm-1 col-form-label">-</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="date" name="tanggalKasMasukEnd" id="tanggalKasMasukEnd">
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <label>Kas Keluar</label>
                    <div class="form-group row">
                        <label for="tanggalKasKeluarStart" class="col-sm-3 col-form-label">Pembelian Tanggal</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="date" name="tanggalKasKeluarStart" id="tanggalKasKeluarStart">
                        </div>
                        <label for="tanggalKasKeluarEnd" class="col-sm-1 col-form-label">-</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="date" name="tanggalKasKeluarEnd" id="tanggalKasKeluarEnd">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Transaksi Lain</label>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                            <label class="form-check-label" for="inlineRadio1">Kas Masuk</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
                            <label class="form-check-label" for="inlineRadio2">Kas Keluar</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="detailTransaksi" class="col-sm-4 col-form-label">Detail Transaksi</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="detailTransaksi" id="detailTransaksi">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="totalSaldo" class="col-sm-4 col-form-label">Total Saldo</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="totalSaldo" id="totalSaldo">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10"></div>
                        <button class="btn btn-primary col-sm-2" type="submit">SAVE</button>
                    </div>
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
                    @foreach ($kas as $index => $item)
                    <tr>
                        <td><center>{{ $index + 1 }}</td>
                        <td>{{ $item->detailTransaksi }}</td>
                        <td><center>{{ isset($item->kasKeluar) ? 'Rp '.number_format($item->kasKeluar, 2) : '' }}</td>
                        <td><center>{{ isset($item->kasMasuk) ? 'Rp '.number_format($item->kasMasuk, 2) : '' }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="2"><div class="text-center"><strong>TOTAL SALDO</strong></div></th>
                        <th><center>{{ 'Rp '.number_format($item->sum('kasKeluar'), 2) }}</th>
                        <th><center>{{ 'Rp '.number_format($item->sum('kasMasuk'), 2) }}</th>
                    </tr>
                    <tr>
                        <th colspan="2"><div class="text-center"><strong>PERSENTASE KEUNTUNGAN</strong></div></th>
                        <th colspan="2"><center>{{ $kas->sum('kasKeluar') > 0 && $kas->sum('kasMasuk') > 0 ? number_format(($kas->sum('kasMasuk') - $kas->sum('kasKeluar')) / $kas->sum('kasKeluar') * 100).'%' : '' }}</th>
                    </tr>
                    <tr>
                        <th colspan="2"><div class="text-center"><strong>TOTAL LABA RUGI</strong></div></th>
                        <th colspan="2"><center>{{ 'Rp '.number_format($item->sum('kasMasuk') - $item->sum('kasKeluar'), 2) }}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection