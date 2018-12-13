@extends('layouts.app_admin')

@section('title')
    Admin: Edit users
@endsection

@section('content')
    <h1>Editando usuario: {{ $user->id }}</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <h6>Corrige los errores mostrados</h6>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url("admin/users/{$user->id}") }}" method="post">
        {{ method_field('PUT') }}
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Victor Garcia" value="{{ old('name', $user->name) }}">
        </div>

        <div class="form-group">
            <label for="name">Surname</label>
            <input type="text" name="surname" class="form-control" id="surname" placeholder="Garcia" value="{{ old('surname', $user->surname) }}">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="victor@victor.com" value="{{ old('email', $user->email) }}">
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Su contraseña">
        </div>

        <div class="form-group">
            <label for="name">Phone</label>
            <input type="text" name="phone" class="form-control" id="phone" placeholder="+34666555444" value="{{ old('phone', $user->phone) }}">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar usuario</button>
        <a href="{{ route('admin_users') }}" class="btn btn-link">Volver al listado</a>
    </form>
@endsection
