@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('penjualan.orderstore', $penjualan->id) }}" method="post">
                    @csrf
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-4 col-form-label">Tanggal</label>
                            <div class="col-sm-8">
                                <input class="form-control @error('tanggal') is-invalid @enderror" type="date" name="tanggal" id="tanggal" value="{{ $penjualan->tanggal }}" disabled>
                                @error('tanggal')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="noPenjualan" class="col-sm-4 col-form-label">No. Penjualan</label>
                            <div class="col-sm-8">
                                <input class="form-control @error('noPenjualan') is-invalid @enderror" type="text" name="noPenjualan" id="noPenjualan" value="{{ $penjualan->noPenjualan }}" disabled>
                                @error('noPenjualan')
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
                                <th><center>Action</th>
                            </tr>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualan->items as $index => $item)
                                <tr>
                                    <td><center>{{ $index + 1 }}</td>
                                    <td>{{ $item->barang->namaBarang }}</td>
                                    <td><center>{{ $item->qty }} {{ $item->barang->satuan }}</td>
                                    <td>Rp {{ $item->totalHarga }}</td>
                                    <td><center>
                                        <form action="{{ route('penjualan.itemdestroy', ['id' => $penjualan->id, 'itemId' => $item->id]) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-sm btn-danger" type="submit">DELETE</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            
                            <tr>
                                <div class="form-group row">
                                    <label for="disc" class="col-sm-4 col-form-label">Discount</label>
                                    <div class="col-sm-8">
                                        <input class="form-control @error('disc') is-invalid @enderror" type="text" name="disc" id="disc" value="{{ $penjualan->disc }}">
                                        @error('disc')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </tr>
                                <div class="form-group row">
                                    <label for="totalPembayaran" class="col-sm-4 col-form-label">Total Pembayaran</label>
                                    <div class="col-sm-8">
                                        <input class="form-control @error('totalPembayaran') is-invalid @enderror" type="text" name="totalPembayaran" id="totalPembayaran" value="{{ $penjualan->totalPembayaran }}">
                                        @error('totalPembayaran')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10"></div>
                                    <button class="btn btn-primary col-sm-2" type="submit">CASHIER</button>
                                 </div>
                            <tr>
                                <th colspan="3"><div class="text-center"><strong>TOTAL</strong></div></th>
                                <td>Rp {{ $penjualan->items->sum('totalHarga') }}</td>
                            </tr>
                            <tr>
                                <th colspan="3"><div class="text-center"><strong>KEMBALIAN</strong></div></th>
                                <td>Rp {{ isset($penjualan->totalPembayaran) ? ($penjualan->totalPembayaran - (($penjualan->items->sum('totalHarga')) - ($penjualan->items->sum('totalHarga') * $penjualan->disc))) : 0 }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-10"></div>
                        <div class="col-sm-2">
                            <a href="{{ route('penjualan.order') }}" class="btn btn-primary">SAVE</a>
                        </div>
                    </div>
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
                console.log(url);
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        var str = '';
                        str = data.satuan;
                        console.log(data);
                        $('#satuan').val(data.satuan);
                    }
                });
            });
        });
    </script>
@endsection