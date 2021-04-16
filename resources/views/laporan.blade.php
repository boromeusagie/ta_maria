@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('laporan.cetak') }}" method="get">
                    @csrf
                        <div class="form-group row">
                            <label for="namaLaporan" class="col-sm-3 col-form-label">Nama Laporan</label>
                            <div class="col-sm-9">
                                <select class="custom-select @error('namaLaporan') is-invalid @enderror" name="namaLaporan" id="namaLaporan">
                                    <option selected disabled>Pilih laporan.....</option>
                                    <option value="barang">Laporan Persediaan Barang</option>
                                    <option value="pembelian">Laporan Pembelian</option>
                                    <option value="return-pembelian">Laporan Return Pembelian</option>
                                    <option value="penjualan">Laporan Penjualan</option>
                                    <option value="kas">Laporan Kas</option>
                                </select>
                                @error('namaLaporan')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dari" class="col-sm-3 col-form-label">dari tanggal</label>
                            <div class="col-sm-3">
                                <input class="form-control @error('dari') is-invalid @enderror" type="date" name="dari" id="dari">
                                @error('dari')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <label for="sampai" class="col-sm-3 col-form-label">sampai tanggal</label>
                            <div class="col-sm-3">
                                <input class="form-control @error('sampai') is-invalid @enderror" type="date" name="sampai" id="sampai">
                                @error('sampai')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            {{-- <div class="col-sm-4"></div> --}}
                            <div class="col-sm-4">
                                <center><button class="btn btn-primary" type="submit">PRINT</button>
                            </div>
                            {{-- <div class="col-sm-4"></div> --}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            $('#namaLaporan').change(function () {
                if ($(this).val() === 'barang') {
                    $('#dari').attr('disabled', true);
                    $('#sampai').attr('disabled', true);
                } else {
                    $('#dari').attr('disabled', false);
                    $('#sampai').attr('disabled', false);
                }
            })
        });
    </script>
@endsection