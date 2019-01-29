@extends('layouts.app_admin')

@section('title')
    Admin: Show user
@endsection

@section('content')
    <h1>Ver detalle de usuario</h1>
    <hr>
    <div class="table-responsive">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Surname</th>
                    <th scope="col">email</th>
                    <th scope="col">phone</th>
                </tr>
            </thead>
            <tbody id="users_table">
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->surname }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <a href="{{ route('admin_users') }}">Volver al listado</a>
@endsection
