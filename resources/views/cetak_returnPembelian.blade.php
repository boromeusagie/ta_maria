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
                <h1 class="text-center"><center>TOKO ANDATU 5758</h1>
                <h3 class="text-center"><center>LAPORAN RETURN PEMBELIAN</h3>
                <p>Tanggal Print: {{ date('d-m-Y', strtotime(now())) }}</p>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
            
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><center>No</center></th>
                                            <th><center>Tanggal</center></th>
                                            <th><center>No. Return</center></th>
                                            <th><center>No. Faktur</center></th>
                                            <th><center>Supplier</center></th>
                                            <th><center>Total Return</center></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($returnPembelian as $index => $item)
                                            <tr>
                                                <td><center>{{ $index + 1 }}</td>
                                                <td><center>{{ $item->tanggal }}</td>
                                                <td><center>{{ $item->noReturn }}</td>
                                                <td><center>{{ $item->noFaktur }}</td>
                                                <td><center>{{ $item->supplier }}</td>
                                                <td><center>{{ $item->totalReturn }}</td>
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
