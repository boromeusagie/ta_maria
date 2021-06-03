@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form id="show1" name="show" method="get">
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
                    <form action="{{ route('return-pembelian.return', $pembelian->id) }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="noReturn" class="col-sm-4 col-form-label">No Return</label>
                            <div class="col-sm-8">
                                <input class="form-control @error('noReturn') is-invalid @enderror" type="text" name="noReturn" id="noReturn">
                            </div>
                            @error('noReturn')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="text" name="noFaktur" value="{{ $pembelian->noFaktur }}" hidden>
                        <input class="form-control @error('tanggal') is-invalid @enderror" type="date" name="tanggal" id="tanggal" value="{{ Carbon\Carbon::today()->format('Y-m-d') }}" hidden>
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
                                    <tr style="font-size: 12px;">
                                        <td><center>{{ $index + 1 }}</td>
                                        <td>{{ $item->barang->namaBarang }}</td>
                                        @if ($item->status === 'Belum Diterima')
                                            <td><center><input type="number" name="{{ 'qty'.$item->noItemPembelian }}" value="{{ $item->qty }}" min="1" max="{{ $item->qty }}" style="width: 60px"> {{ $item->barang->satuan }}</td>
                                            <td><center>Rp <input type="text" name="{{ 'harga'.$item->noItemPembelian }}" value="{{ $item->barang->hargaBeli }}" style="width: 50px"></td>
                                            <td><center>Rp {{ number_format($item->totalHarga, 2) }}</td>
                                            <td><center>{{ $item->status }}</td>
                                            <td><center>
                                                <input class="@error('checks') is-invalid @enderror" type="checkbox" name="checks[{{ $item->id }}]" value="{{ $item->id }}">
                                                @error('checks')
                                                    <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        @elseif ($item->status === 'Sudah Diterima')
                                            <td><center>{{ $item->terima->qty }} {{ $item->barang->satuan }}</td>
                                            <td><center>Rp {{ number_format($item->terima->harga, 2) }}</td>
                                            <td><center>Rp {{ number_format($item->terima->totalHarga, 2) }}</td>
                                            <td><center>
                                                <div class="text-success">
                                                    {{ $item->status }}
                                                </div>
                                            </td>
                                            <td></td>
                                        @else
                                            <td><center>{{ $item->return->qty }} {{ $item->barang->satuan }}</td>
                                            <td><center>Rp {{ number_format($item->return->harga, 2) }}</td>
                                            <td><center>Rp {{ number_format($item->return->totalHarga, 2) }}</td>
                                            <td><center>
                                                <div class="text-danger">
                                                    {{ $item->status }}
                                                </div>
                                            </td>
                                            <td></td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <center><button id="submit" type="submit" class="btn btn-primary">SAVE RETURN</button>
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
            $('#noFaktur').change(function () {
                var val = $(this).val();
                let url = "{{ route('return-pembelian.show', ['id' => ':id']) }}";
                url = url.replace(':id', val);
                console.log(url);
                
                function get_action() {
                    return url;
                }

                document.show.action = get_action();
                $('form#show1').submit();

            });

            $('#submit').click(function () {
                var noReturn = $('#noReturn').val();
                var pembelian = "{{ $pembelian->id }}"
                let url = "{{ route('return-pembelian.printreturn', ['pembelian' => ':pembelian', 'return', ':return']) }}"
                url = url.replace([':pembelian' => pembelian, ':return' => noReturn])
                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(data) {
                        console.log(data);
                    }
                });
            });
        });
    </script>
@endsection