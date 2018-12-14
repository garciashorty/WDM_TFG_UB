@extends('layouts.app_user')

@section('title')
    User Dashboard
@endsection

@section('content')
    <a class="btn btn-danger btn-lg btn-block" href="#">
        Ver consultas
    </a>
    <br>
    <a class="btn btn-success btn-lg" href="#">
        Nueva consulta
    </a>
    <a class="btn btn-primary btn-lg" href="#">
        Repetir consulta
    </a>
@endsection
