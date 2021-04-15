@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.store') }}" method="post">
                    @csrf
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input class="form-control" type="text" name="username" id="username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input class="form-control" type="password" name="password" id="password">
                        </div>
                        <button class="btn btn-primary" type="submit">SAVE</button>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header">{{ __('Daftar User') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><center>No</center></th>
                                <th><center>Username</center></th>
                                <th><center>Password</center></th>
                                <th><center>Action</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($users as $user)
                                <tr>
                                    <td><center>{{ $no++ }}</td>
                                    <td><center>{{ $user->username }}</td>
                                    <td><center>**********</td>
                                    <td><center>
                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger" type="submit">DELETE</button>
                                        </form>
                                    </td>
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