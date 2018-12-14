@extends('layouts.app_admin')

@section('title')
    Admin Dashboard
@endsection

@section('content')
    <a class="btn btn-primary btn-lg btn-block" href="{{ route('admin_users') }}">
        Ver usuarios
    </a>
    <br>
    <a class="btn btn-success btn-lg btn-block" href="{{ route('admin_doctors') }}">
        Ver doctores
    </a>
@endsection
