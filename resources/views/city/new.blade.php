@extends('home')
@section('sub-content')
    <div class="container">
        <form id="form" class="form-horizontal" >
            <legend class="text-center header">
                <b>Listado</b>
            </legend>
            <div class="row">
                <div class="form-group mb-4">
                    <legend class="text-center header">1. Ingrese Codigo</legend>
                    <div class="row">
                        <div class="col-6 offset-3 col align-column-center" >
                            <input required id="codigo" name="codigo" type="text" placeholder="Codigo" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <legend class="text-center header">2. Ingrese Nombre</legend>
                    <div class="row">
                        <div class="col-6 offset-3 col align-column-center" >
                            <input required id="nombre" name="nombre" type="text" placeholder="Nombre" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <div class="row">
                        <div class="col-6 offset-3 d-grid" >
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                <div style="display:none;" id="loading">
                    <p><img src="{{asset('imagenes/loading.gif') }}" /></p>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready( () => {
            $("#form").on("submit",function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('city.create') }}",
                    data: $("#form").serialize(),
                    success: function (response) {
                        $('#loading').hide();
                        if(response.code == 200){
                            alert('Ciudad Creada con exito');
                        }else{
                            alert('Hubo un problema en la creacion de la ciudad');
                        }
                    }
                });
            });
        });
    </script>
@endsection








