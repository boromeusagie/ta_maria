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
                                    <option selected disabled>Pilih No Faktur....</option>
                                    @foreach ($pembelian as $item)
                                        <option value="{{ $item->id }}">{{ $item->noFaktur }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>

                    
                    <div class="form-group row">
                        <label for="supplier" class="col-sm-4 col-form-label">Supplier</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="text" name="supplier" id="supplier" disabled>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-4 col-form-label">Tanggal Terima</label>
                        <div class="col-sm-8">
                            <input class="form-control" type="date" name="tanggal" id="tanggal"  value="{{ Carbon\Carbon::today()->format('Y-m-d') }}" readonly>
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
            $('#noFaktur').change(function () {
                var val = $(this).val();
                let url = "{{ route('return-pembelian.show', ['id' => ':id']) }}";
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