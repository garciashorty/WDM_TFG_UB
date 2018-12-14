@extends('layouts.app_user')

@section('title')
    Usuario: Crear consulta relacionada
@endsection

@section('content')
    <h1>Creando consulta relacionada.</h1>
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

    <form action="{{ url('user/queries/success') }}" method="post">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="name">Subir imagen: </label>
            <input type="file" name="imagen" class="form-control" id="imagen" disabled>
        </div>

        <div class="form-group">
            <label for="name">ID de la conulta relacionada: </label>
            <input type="text" class="form-control" placeholder="{{ $query->relatedQuery_id }}" value="{{ $query->relatedQuery_id }}" disabled>
            <input type="hidden" name="relatedQuery_id" value="{{ $query->relatedQuery_id }}">
        </div>

        @if ($areas != null)
            <div class="form-group">
                <label for="name">Area de la imagen: </label>
                <select name="area">
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif

        <button type="submit" class="btn btn-primary">Crear consulta</button>
        <a href="{{ route('user_show_detail_queries', $query) }}" class="btn btn-link">Volver atrás</a>
    </form>
@endsection
