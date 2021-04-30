@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="#" method="get">
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
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Detail Transaksi') }}</div>

                <div class="card-body">
                    <form action="#" method="get">
                        <div class="form-group row">
                            <label for="disc" class="col-sm-4 col-form-label">Discount</label>
                            <div class="col-sm-7">
                                <input class="form-control @error('disc') is-invalid @enderror" type="text" name="disc" id="disc">
                                @error('disc')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-sm-1">
                                <p>%</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="totalPembayaran" class="col-sm-4 col-form-label">Total Pembayaran</label>
                            <div class="col-sm-8">
                                <input class="form-control @error('totalPembayaran') is-invalid @enderror" type="text" name="totalPembayaran" id="totalPembayaran">
                                @error('totalPembayaran')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12" align="right">
                                <button class="btn btn-primary" type="submit">CASHIER</button>
                            </div>
                        </div>
                    </form>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><center>No</th>
                                <th><center>Nama Barang</th>
                                <th><center>Quantity</th>
                                <th><center>Total Harga</th>
                                @if (!isset($penjualan->totalPembayaran))
                                    <th><center>Action</th>
                                @endif
                            </tr>
                            <tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualan->items as $index => $item)
                                <tr>
                                    <td><center>{{ $index + 1 }}</td>
                                    <td>{{ $item->barang->namaBarang }}</td>
                                    <td><center>{{ $item->qty }} {{ $item->barang->satuan }}</td>
                                    <td>Rp {{ number_format($item->totalHarga, 2) }}</td>
                                    @if (!isset($penjualan->totalPembayaran))
                                        <td><center>
                                            <form action="{{ route('penjualan.itemdestroy', ['id' => $penjualan->id, 'itemId' => $item->id]) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" type="submit">DELETE</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                                <th colspan="3"><div class="text-center"><strong>TOTAL</strong></div></th>
                                <td>Rp {{ number_format($penjualan->totalBayar, 2) }}</td>
                            </tr>
                            <tr>
                                <th colspan="3"><div class="text-center"><strong>DISCOUNT</strong></div></th>
                                <td>{{ isset($penjualan->totalPembayaran) ? 'Rp '.number_format($penjualan->disc, 2) : '' }}</td>
                            </tr>
                            <tr>
                                <th colspan="3"><div class="text-center"><strong>TOTAL PEMBAYARAN</strong></div></th>
                                <td>{{ isset($penjualan->totalPembayaran) ? 'Rp '.number_format($penjualan->totalPembayaran, 2) : '' }}</td>
                            </tr>
                            <tr>
                                <th colspan="3"><div class="text-center"><strong>KEMBALIAN</strong></div></th>
                                <td>{{ isset($penjualan->totalPembayaran) ? 'Rp '.number_format($penjualan->kembalian, 2) : '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-10"></div>
                        <div class="col-sm-2">
                            @if (isset($penjualan->totalPembayaran))
                                <a href="{{ route('penjualan.order') }}" class="btn btn-primary">SAVE</a>
                            @endif
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