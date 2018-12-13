@extends('layouts.app')

@section('title')
    Bienvenido
@endsection

@section('content')
<div class="jumbotron">
    <h1>Hospital Italiano de Buenos Aires</h1>
    <p class="lead">This example is a quick exercise to illustrate how the top-aligned navbar works. As you scroll,
        this navbar remains in its original position and moves with the rest of the page.</p>
    <a class="btn btn-lg btn-primary" href="#" role="button">View navbar docs &raquo;</a>
</div>
<div class="card-deck mb-3 text-center">
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h4 class="my-0 font-weight-normal">¿Dónde estamos?</h4>
        </div>
        <div class="card-body">
            <h1 class="card-title pricing-card-title">$0 </h1>
            <ul class="list-unstyled mt-3 mb-4">
                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras suscipit turpis eu neque aliquam
                    rhoncus. Proin consequat augue vitae quam consectetur cursus. Suspendisse non ante ornare,
                    malesuada lorem ac, rhoncus lectus. Proin ac nisl in ex finibus commodo. Praesent suscipit ac eros
                    et aliquam.</div>
            </ul>
            <button type="button" class="btn btn-lg btn-block btn-outline-primary">Sign up for free</button>
        </div>
    </div>
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h4 class="my-0 font-weight-normal">¿Qué hacemos?</h4>
        </div>
        <div class="card-body">
            <h1 class="card-title pricing-card-title">$15 </h1>
            <ul class="list-unstyled mt-3 mb-4">
                <div>Sed finibus dignissim ex ut mollis. Nulla facilisi. Aliquam efficitur odio a vestibulum suscipit.
                    Proin orci tellus, varius a eleifend sollicitudin, luctus non sem. Nam luctus ligula non dui
                    lobortis, at sagittis turpis vulputate. Duis eu ipsum volutpat, efficitur lectus quis, faucibus
                    purus. Fusce vitae imperdiet arcu.</div>
            </ul>
            <button type="button" class="btn btn-lg btn-block btn-primary">Get started</button>
        </div>
    </div>
    <div class="card mb-4 shadow-sm">
        <div class="card-header">
            <h4 class="my-0 font-weight-normal">App móvil</h4>
        </div>
        <div class="card-body">
            <h1 class="card-title pricing-card-title">$29 </h1>
            <ul class="list-unstyled mt-3 mb-4">
                <div>Ut at ligula ut erat elementum blandit. Morbi egestas justo nec ante suscipit, et facilisis nulla
                    venenatis. Morbi tincidunt nulla nec nibh euismod eleifend.</div>
            </ul>
            <button type="button" class="btn btn-lg btn-block btn-primary">Contact us</button>
        </div>
    </div>
</div>
@endsection
