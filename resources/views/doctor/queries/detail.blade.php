@extends('layouts.app_doctor')

@section('title')
    Doctor: Detalle de consulta
@endsection

@section('content')
    <h1>Ver consulta: {{ $query->id }}</h1>
    <hr>
    <p>Consulta relacionada: {{ $query->relatedQuery_id }}</p>
    <p>Area de la consulta: {{ $query->area_id }}</p>
    <p>Fecha de creación: {{ $query->created_at }}</p>
    <p>Resultado: {{ $result }}</p>
    <p>Estado: {{ $resolved }}</p>
    <p>Comentario: {{ $query->comment }}</p>

    <a class="btn btn-primary" href="{{ route('doctor_update_queries', $query) }}">Resolver consulta</a>
    <a href="{{ route('user_queries') }}">Volver al listado</a>
@endsection
