@extends('layouts.app_admin')

@section('title')
    Admin: Doctors List
@endsection

@section('content')
    <h1>{{ $title }}</h1>

    <hr>

    <ul>
        @forelse ($doctors as $doctor)
            <li>
                {{ $doctor->name }}, {{ $doctor->email }}, {{ $doctor->email }}
                <a href="{{ route('admin_show_doctors', ['id' => $doctor->id]) }}">Ver detalles</a>
            </li>
        @empty
            <li>No hay doctores registrados</li>
        @endforelse ($doctors as $doctor)
    </ul>
@endsection
