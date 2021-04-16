@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('returnPembelian.store') }}" method="post">
                    @csrf
                        <div class="form-group row">
                            <label for="tanggal" class="col-sm-4 col-form-label">Tanggal</label>
                            <div class="col-sm-8">
                                <input class="form-control @error('tanggal') is-invalid @enderror" type="date" name="tanggal" id="tanggal">
                                @error('tanggal')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="noReturn" class="col-sm-4 col-form-label">No. Return</label>
                            <div class="col-sm-8">
                                <input class="form-control @error('noReturn') is-invalid @enderror" type="text" name="noReturn" id="noReturn">
                                @error('noReturn')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="noFaktur" class="col-sm-4 col-form-label">No. Faktur</label>
                            <div class="col-sm-8">
                                <select class="custom-select @error('noFaktur') is-invalid @enderror" name="noFaktur" id="noFaktur">
                                    <option selected disabled>Pilih No. Faktur Pembelian....</option>
                                    @foreach ($pembelian as $pembelian)
                                        <option value="{{ $pembelian->noFaktur }}">{{ $pembelian->noFaktur }}</option>
                                    @endforeach
                                </select>
                                @error('noFaktur')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="qty" class="col-sm-4 col-form-label">Supplier</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" name="namaSupplier" id="namasupplier" value="" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-10"></div>
                            <button class="btn btn-primary col-sm-2" type="submit">ADD</button>
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
                                <th><center>Harga</th>
                                <th><center>Total Harga</th>
                                <th><center>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembelian->items as $index => $item)
                                <tr>
                                    <td><center>{{ $index + 1 }}</td>
                                    <td>{{ $item->barang->namaBarang }}</td>
                                    <td><center>{{ $item->qty }} {{ $item->barang->satuan }}</td>
                                    <td>Rp {{ $item->totalHarga }}</td>
                                    <td><center>
                                        <form action="{{ route('returnPembelian.itemdestroy', ['id' => $pembelian->id, 'itemId' => $item->id]) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-sm btn-danger" type="submit">DELETE</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <th colspan="3"><div class="text-center"><strong>TOTAL</strong></div></th>
                                <td>Rp {{ $returnPembelian->items->sum('totalHarga') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-10"></div>
                        <div class="col-sm-2">
                            <a href="{{ route('returnPembelian.order') }}" class="btn btn-primary">SAVE</a>
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
                let url = "{{ route('pembelian.getsatuan',['kodeBarang' => ':kodeBarang']) }}";
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