@extends('layouts.app')

@section('title')
    Bienvenido
@endsection

@section('content')
<div class="jumbotron">
    <h1>Hospital Italiano de Buenos Aires</h1>
    <p class="lead">Bienvenido al proyecto de estudio dermatológico del Hospital Italiano de Buenos Aires. En la siguiente plataforma usted
        podrá tener el control sobre la evolución de las imperfecciones de su piel, con el objetivo de prevenir y anticiparse a posibles melanomas.
    </p>
</div>
<div class="card-deck mb-3 text-center">
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h4 class="my-0 font-weight-normal">¿Dónde estamos?</h4>
        </div>
        <div class="card-body">
            <h3 class="card-title pricing-card-title">Nos puedes encontrar en</h3>
            <ul class="list-unstyled mt-3 mb-4">
                <div>Pres. Tte. Gral. Juan Domingo Perón 4190, C1199 ABH, Buenos Aires, Argentina</div>
            </ul>
            <a href="https://goo.gl/maps/ZVQoX7LPvk22"><button type="button" class="btn btn-lg btn-block btn-primary">Ver en Google Maps</button></a>
        </div>
    </div>
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h4 class="my-0 font-weight-normal">¿Qué hacemos?</h4>
        </div>
        <div class="card-body">
            <h3 class="card-title pricing-card-title">Nuestro objetivo</h3>
            <ul class="list-unstyled mt-3 mb-4">
                <div>Este proyecto tiene como objetivo poder prevenir o detectar cualquier tipo de melanoma para actuar lo antes posible.</div>
            </ul>
            <a href="{{ route('user_dashboard') }}"><button type="button" class="btn btn-lg btn-block btn-primary">Ir al panel de usuario</button></a>
        </div>
    </div>
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h4 class="my-0 font-weight-normal">App móvil</h4>
        </div>
        <div class="card-body">
            <h3 class="card-title pricing-card-title">Accede desde donde quieras</h3>
            <ul class="list-unstyled mt-3 mb-4">
                <div>Gracias a nuestra app móvil es posible acceder a la plataforma directamente desde el dispositivo que desees.</div>
            </ul>
            <button type="button" class="btn btn-lg btn-block btn-primary" disabled>Descargar app</button>
        </div>
    </div>
</div>
@endsection
