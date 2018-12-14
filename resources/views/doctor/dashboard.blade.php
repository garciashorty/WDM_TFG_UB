@extends('layouts.app_doctor')
@section('title')
Doctor Dashboard
@endsection

@section('content')

    <a class="btn btn-primary btn-lg btn-block" href="{{ route('doctor_users') }}">
        Ver usuarios
    </a>
    <br>
    <a class="btn btn-success btn-lg btn-block" href="#">
        Ver consultas no resueltas
    </a>
@endsection
