@extends('layouts.app_doctor')

@section('title')
    Doctor: Detalle de usuario
@endsection

@section('content')
    <h1>Ver usuario: {{ $user->id }}</h1>
    <hr>
    <p>Nombre del usuario: {{ $user->name }}</p>
    <p>Email del usuario: {{ $user->email }}</p>

    <a href="{{ route('doctor_users') }}">Volver al listado</a>
@endsection
