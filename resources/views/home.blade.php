@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @php
                        $url = url()->current();
                        $home =  Str::contains($url,'/home');
                    @endphp
                    @if($home or (config('app.url') == $url))
                    <div class="row">
                        <div class="card col" style="width: 18rem;">
                            <img src="{{asset('imagenes/excel.png')}}" class="card-img-top" alt="Excel">
                            <div class="card-body">
                                <h5 class="card-title">Importador de clientes</h5>
                                <form method="post" action="{{route('client.importador')}}" enctype="multipart/form-data" >
                                    @csrf
                                    <input type="file" name="file" />
                                    <input class="btn btn-success mt-2" type="submit" value="Importar" />
                                </form>
                            </div>
                        </div>
                        <div class="card col" style="width: 18rem;">
                            <img src="{{asset('imagenes/excel.png')}}" class="card-img-top" alt="Excel">
                            <div class="card-body">
                                <h5 class="card-title">Exportar clientes</h5>
                                <form method="post" action="{{route('client.exportador')}}" enctype="multipart/form-data" >
                                    @csrf
                                    <input class="btn btn-success mt-2" type="submit" value="Exportar" />
                                </form>
                            </div>
                        </div>
                    </div>

                    @else
                        @yield('sub-content')
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
    <script>
        $("#import").on("submit", function(e){
            e.preventDefault()
            var archivo = $('input[name=excel]').val();
            var extension = archivo.split(".").pop().toLowerCase();
            var retornarError = false;
            var data;
            $.each($('input[type=file]')[0].files, function(i, file) {
                data = file;
            });
            //console.log(data)
            if(archivo ==""){
                alert('Debe seleccionar un archivo')
                $('#excel').addClass('error');
                retornarError = true;
                $('#excel').focus();
                return false;
            }else if(extension != 'xlsx' && extension != 'csv'){
                alert("¡El archivo que esta tratando de subir es invalido!");
                retornarError = true;
                $('#excel').val("");
                return false;
            }else{
                $.post("{{route('client.importador')}}",$("#import").serialize() ).
                    then(function(res){
                        console.log(res)
                    }
                )
            }


        })
    </script>
@stop

