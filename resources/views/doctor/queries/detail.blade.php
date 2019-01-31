@extends('layouts.app_doctor')

@section('title')
    Doctor: Detalle de consulta
@endsection

@section('content')
    <h1>Ver detalle de consulta: {{ $query->id }}</h1>
    <hr>
    <div class="row">
            <div class="col"><h4>Image:</h4> <br> <img src="{{ route('doctor_image_queries', $query) }}" class="img-thumbnail" alt="imagen" width="50%"></div>
            <div class="col"><h4>Image Mod:</h4> <br> <img src="/images/{{$query->image}}" class="img-thumbnail" alt="imagen" width="50%"></div>
    </div>
    <br>
    <hr>
    <br>
    <div class="table-responsive">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">Related Query</th>
                    <th scope="col">Zone</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Result</th>
                    <th scope="col">Resolved</th>
                </tr>
            </thead>
            <tbody id="users_table">
                <tr>
                    <th scope="row">{{ $query->user_id }}</th>
                    <td>{{ $query->relatedQuery_id }}</td>
                    <td>{{ $query->area_id }}</td>
                    <td>{{ $query->created_at }}</td>
                    @if ($query->result == 1 )
                        <td style="color: #009921;">{{ $result }}</td>
                    @elseif ($query->result == 2)
                        <td style="color: #ffbb00;">{{ $result }}</td>
                    @else
                        <td style="color: #c60600;">{{ $result }}</td>
                    @endif
                    <td>
                        @if ($query->resolved == 0)
                            No
                        @else
                            Sí
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col">
            <h4>Comment</h4> <br>
            {{ $query->comment }}
        </div>
    </div>
    <br>

    <a class="btn btn-primary" href="{{ route('doctor_update_queries', $query) }}">Resolver consulta</a>
    <a href="{{ route('doctor_queries') }}">Volver al listado</a>
@endsection
