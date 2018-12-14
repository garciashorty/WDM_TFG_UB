@extends('layouts.app_doctor')

@section('title')
    Doctor: Resolver una consulta
@endsection

@section('content')
    <h1>Resolviendo la consulta: {{ $query->id }} (ID)</h1>
    <hr>

    @if ($errors->any())
        <div class="alert alert-danger">
            <h6>Corrige los errores mostrados</h6>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url("doctor/queries/{$query->id}") }}" method="post">
        {{ method_field('PUT') }}
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">Consulta con ID: </label>
            <input type="text" name="id" class="form-control" placeholder="{{ $query->id }}" id="id" value="{{ $query->id }}" disabled>
        </div>

        <div class="form-group">
            <label for="name">Relacionada con la consulta ID: </label>
            <input type="text" name="relatedQuery_id" class="form-control" placeholder="{{ $query->relatedQuery_id }}" id="relatedQuery_id" value="{{ $query->relatedQuery_id }}" disabled>
        </div>

        <div class="form-group">
            <label for="name">Área: </label>
            <input type="text" name="area" class="form-control" placeholder="{{ $query->area_id }}" id="area" value="{{ $query->area_id }}" disabled>
        </div>

        <div class="form-group">
            <label for="name">Fecha de creación: </label>
            <input type="text" name="created_at" class="form-control" placeholder="{{ $query->created_at }}" id="created_at" value="{{ $query->created_at }}" disabled>
        </div>

        <div class="form-group">
            <label for="name">Resultado: </label>
            <input type="text" name="result" class="form-control" placeholder="{{ $result }}" id="result" value="{{ $query->result }}" disabled>
        </div>

        <div class="form-group">
            <label for="name">Estado: </label>
            <input type="text" name="resolved" class="form-control" placeholder="{{ $resolved }}" id="resolved" value="{{ $query->resolved }}" disabled>
        </div>

        <label for="name">Comentario: </label>
        <div class="form-group">
            <textarea name="comment" id="comment" cols="60" rows="5"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Resolver consulta</button>
        <a href="{{ route('doctor_show_detail_queries', $back_id) }}" class="btn btn-link">Volver atrás</a>
    </form>
@endsection
