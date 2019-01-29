@extends('layouts.app_doctor')

@section('title')
    Doctor: Lista de usuarios
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-2">
        <h1 class="pb-2">{{ $title }}</h1>
        <p>
            <a href="{{ route('doctor_create_users') }}" class="btn btn-primary">Nuevo usuario</a>
        </p>
    </div>

    @if ($users->isNotEmpty())
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
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="users_table">
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <form action="{{ route('doctor_delete_users', $user) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <a href="{{ route('doctor_show_users', $user) }}" class="btn btn-link"><span class="oi oi-eye"></span></a>
                                    <a href="{{ route('doctor_edit_users', $user)}}" class="btn btn-link"><span class="oi oi-pencil"></span></a>
                                    <button type="submit" class="btn btn-link"><span class="oi oi-trash"></span></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $users->render() }}
        <a href="{{ route('doctor_dashboard') }}">Volver al listado</a>
    @else
        <p>No hay usuarios registrados.</p>
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
