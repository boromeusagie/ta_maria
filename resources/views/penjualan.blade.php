@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('penjualan.store') }}" method="post">
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
                            <label for="noPenjualan" class="col-sm-4 col-form-label">No. Penjualan</label>
                            <div class="col-sm-8">
                                <input class="form-control @error('noPenjualan') is-invalid @enderror" type="text" name="noPenjualan" id="noPenjualan">
                                @error('noFaktur')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="dropdown-divider"></div>

                        <div class="form-group row">
                            <label for="namaBarang" class="col-sm-4 col-form-label">Nama Barang</label>
                            <div class="col-sm-8">
                                <select class="custom-select @error('namaBarang') is-invalid @enderror" name="namaBarang" id="namaBarang">
                                    <option selected disabled>Pilih barang....</option>
                                    @foreach ($barangs as $barang)
                                        <option value="{{ $barang->kodeBarang }}">{{ $barang->namaBarang }}</option>
                                    @endforeach
                                </select>
                                @error('namaBarang')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="qty" class="col-sm-4 col-form-label">Quantity</label>
                            <div class="col-sm-4">
                                <input class="form-control @error('qty') is-invalid @enderror" type="text" name="qty" id="qty">
                                @error('qty')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" name="satuan" id="satuan" value="" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10"></div>
                            <button class="btn btn-primary col-sm-2" type="submit">ADD ORDER</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Detail Transaksi') }}</div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><center>No</th>
                                <th><center>Nama Barang</th>
                                <th><center>Quantity</th>
                                <th><center>Total Harga</th>
                            </tr>
                            
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            $('#namaBarang').change(function() {
                var val = $(this).val();
                let url = "{{ route('penjualan.getsatuan',['kodeBarang' => ':kodeBarang']) }}";
                url = url.replace(':kodeBarang', val);
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        var str = '';
                        str = data.satuan;
                        $('#satuan').val(data.satuan);
                    }
                });
            });
        });
    </script>
@endsection