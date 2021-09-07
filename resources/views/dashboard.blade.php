@extends('home')
@section('sub-content')
    <div class="container">
        <div class="card" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Importador</h5>
                <p class="card-text">Importador de clientes.</p>
                <a href="#" class="btn btn-primary">
                    <img src="{{asset('imagenes/excel.png')}}" class="d-block w-100" alt="...">
                </a>
            </div>
        </div>
    </div>

@stop

