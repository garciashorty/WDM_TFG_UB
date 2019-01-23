@extends('layouts.app_user')

@section('title')
    Usuario: Detalle de consulta
@endsection

@section('content')
    <h1>Ver consulta: {{ $query->id }}</h1>
    <hr>
    <p>Image: <img src="{{ route('user_image_queries', $query) }}" alt="imagen" width="50%"> </p>
    <p>Mod Image: <a href="/images/{{$query->image}}">Image</a></p>
    <p>User ID: {{ $query->user_id }}</p>
    <p>Consulta relacionada: {{ $query->relatedQuery_id }}</p>
    <p>Area de la consulta: {{ $query->area_id }}</p>
    <p>Fecha de creación: {{ $query->created_at }}</p>
    <p>Resultado: {{ $result }}</p>
    <p>Estado: {{ $resolved }}</p>
    <p>Comentario: {{ $query->comment }}</p>

    <a class="btn btn-primary" href="{{ route('user_update_queries', $query) }}">Generar consulta relacionada</a>
    <a href="{{ route('user_show_queries', $back_id) }}">Volver al listado</a>
@endsection
