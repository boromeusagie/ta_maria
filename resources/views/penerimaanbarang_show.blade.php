@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form name="show" method="get">
                        <div class="form-group row">
                            <label for="noFaktur" class="col-sm-4 col-form-label">No Faktur</label>
                            <div class="col-sm-8">
                                <select class="custom-select" name="noFaktur" id="noFaktur">
                                    @foreach ($pembelians as $item)
                                        <option value="{{ $item->id }}" {{ $pembelian->id === $item->id ? 'selected' : '' }}>{{ $item->noFaktur }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>

                    <div class="form-group row">
                        <label for="supplier" class="col-sm-4 col-form-label">Supplier</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="supplier" id="supplier" value="{{ $pembelian->supplier->namaSupplier }}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-4 col-form-label">Tanggal Terima</label>
                        <div class="col-sm-8">
                            <input class="form-control @error('tanggal') is-invalid @enderror" type="date" name="tanggal" id="tanggal" value="{{ Carbon\Carbon::today()->format('Y-m-d') }}" readonly>
                            @error('tanggal')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
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
                                <th><center>Harga</th>
                                <th><center>Total Harga</th>
                                <th><center>Status</th>
                                <th><center>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembelian->items as $index => $item)
                                <tr>
                                    <td><center>{{ $index + 1 }}</td>
                                    <td>{{ $item->barang->namaBarang }}</td>
                                    <td><center>{{ $item->qty }} {{ $item->barang->satuan }}</td>
                                    <td><center>Rp {{ number_format($item->barang->hargaBeli, 2) }}</td>
                                    <td><center>Rp {{ number_format($item->totalHarga, 2) }}</td>
                                    <td><center>
                                        @if ($item->status->status === 'Belum Diterima')
                                            <p class="text-muted">
                                                {{ $item->status->status }}
                                            </p>
                                        @elseif ($item->status->status === 'Sudah Diterima')
                                            <p class="text-success">
                                                {{ $item->status->status }}
                                            </p>
                                        @else
                                            <p class="text-danger">
                                                {{ $item->status->status }}
                                            </p>
                                        @endif
                                    </td>
                                    <td><center>
                                        @if ($item->status->status === 'Belum Diterima')
                                            <a href="{{ route('penerimaan-barang.terima', ['id' => $pembelian->id, 'idItem' => $item->id]) }}" class="btn btn-primary btn-sm">TERIMA</a></td>
                                        @endif
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

@section('script')
    <script type="text/javascript">
        $(function() {
            $('#noFaktur').change(function () {
                var val = $(this).val();
                let url = "{{ route('penerimaan-barang.show', ['id' => ':id']) }}";
                url = url.replace(':id', val);
                console.log(url);
                
                function get_action() {
                    return url;
                }

                document.show.action = get_action();
                $('form').submit();

            })
        });
    </script>
@endsection