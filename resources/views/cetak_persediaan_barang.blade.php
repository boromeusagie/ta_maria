<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Toko Andatu') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    @toastr_css
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <main class="py-4">
            <div class="container">
                <h1 class="text-center"><center>TOKO ANDATU</h1>
                <h3 class="text-center"><center>LAPORAN PERSEDIAAN BARANG</h3>
                <p>Tanggal Print: {{ date('d-m-Y', strtotime(now())) }}</p>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
            
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><center>No</center></th>
                                            <th><center>Kode Barang</center></th>
                                            <th><center>Nama Barang</center></th>
                                            <th><center>Qty</center></th>
                                            <th><center>Harga Beli</center></th>
                                            <th><center>Harga Jual</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($barangs as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->kodeBarang }}</td>
                                                <td>{{ $item->namaBarang }}</td>
                                                <td>{{ $item->qty }} {{ $item->satuan }}</td>
                                                <td>{{ $item->hargaBeli }}</td>
                                                <td>{{ $item->hargaJual }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="/js/jquery.min.js"></script>
    @toastr_js
    @toastr_render
    @yield('script')
</body>
</html>
