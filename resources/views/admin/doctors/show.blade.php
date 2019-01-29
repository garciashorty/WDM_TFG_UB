@extends('layouts.app_admin')

@section('title')
    Admin: Show doctor
@endsection

@section('content')
    <h1>Ver detalle de doctor</h1>
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
                    <th scope="row">{{ $doctor->id }}</th>
                    <td>{{ $doctor->name }}</td>
                    <td>{{ $doctor->surname }}</td>
                    <td>{{ $doctor->email }}</td>
                    <td>{{ $doctor->phone }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <a href="{{ route('admin_doctors') }}">Volver al listado</a>
@endsection
