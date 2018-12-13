@extends('layouts.app_admin')

@section('title')
    Admin: Users List
@endsection

@section('content')
    <h1>Ver usuario: {{ $user->id }}</h1>
    <hr>
    <p>Nombre del usuario: {{ $user->name }}</p>
    <p>Email del usuario: {{ $user->email }}</p>

    <a href="{{ route('admin_users') }}">Volver al listado</a>
@endsection
