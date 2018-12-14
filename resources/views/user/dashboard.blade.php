@extends('layouts.app_user')

@section('title')
    User Dashboard
@endsection

@section('content')
    <a class="btn btn-danger btn-lg btn-block" href="{{ route('user_queries') }}">
        Ver consultas
    </a>
    <br>
    <a class="btn btn-success btn-lg btn-block" href="{{ route('user_create_queries') }}">
        Nueva consulta
    </a>
@endsection
