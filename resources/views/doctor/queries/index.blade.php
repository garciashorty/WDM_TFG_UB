@extends('layouts.app_doctor')

@section('title')
    Doctor: Lista de consultas
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-2">
        <h2 class="pb-2">{{ $title }}</h2>
    </div>

    @if ($queries->isNotEmpty())
        <div class="input-group input-group-sm mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-sm">Filtrar</span>
            </div>
            <input id="myInput" type="text" placeholder="Filtrar..." class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">User ID</th>
                        <th scope="col">Related Query</th>
                        <th scope="col">Area</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="users_table">
                    @foreach ($queries as $query)
                        <tr>
                            <th scope="row">{{ $query->id }}</th>
                            <td>{{ $query->user_id }}</td>
                            <td>{{ $query->relatedQuery_id }}</td>
                            <td>{{ $query->area_id }}</td>
                            <td>{{ $query->created_at }}</td>
                            <td>
                                <a href="{{ route('doctor_show_detail_queries', $query) }}" class="btn btn-link"><span class="oi oi-eye"></span></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $queries->render() }}
        <a href="{{ route('doctor_dashboard') }}">Volver al listado</a>
    @else
        <p>No hay consultas registradas.</p>
    @endif
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#users_table tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
        });
    </script>
@endsection
