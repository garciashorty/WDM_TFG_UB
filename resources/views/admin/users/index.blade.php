@extends('layouts.app_admin')

@section('title')
    Admin: Users List
@endsection

@section('content')
    <h1>{{ $title }}</h1>

    <hr>

    <ul>
        @forelse ($users as $user)
            <li>
                {{ $user->name }}, {{ $user->email }}, {{ $user->id }}
                <a href="{{ route('admin_show_users', ['id' => $user->id]) }}">Ver detalles</a>
            </li>
        @empty
            <li>No hay usuarios registrados</li>
        @endforelse ($users as $user)
    </ul>
@endsection
