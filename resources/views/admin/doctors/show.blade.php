@extends('layouts.app_admin')

@section('title')
    Admin: Show doctor
@endsection

@section('content')
    <h1>Ver doctor: {{ $doctor->id }}</h1>
    <hr>
    <p>Nombre del doctor: {{ $doctor->name }}</p>
    <p>Email del doctor: {{ $doctor->email }}</p>

    <a href="{{ route('admin_doctors') }}">Volver al listado</a>
@endsection
