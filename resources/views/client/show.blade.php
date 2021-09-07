@extends('adminlte::page')
@section('css')
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!--{{ Form::open(array('url' => '/', 'method' => 'GET')) }}
            {{ Form::submit('Submit')}}
            {{ Form::close() }}-->
        </div>
        <div class="col-md-12">
            <div style="margin-left:15px;" class="row col-md-10 dashboard">
                <div class="form-group col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Datos Cp Cordon</div>
                        <div class="panel-body">
                            <span id="id">
                                <div class="form-group col-md-12">
                                    <label>Id:  {{ $cpcordon->id }}</label>
                                </div>
                            </span>
                            <span id="cod_servicio">
                                <div class="form-group col-md-12">
                                    <label>Cordon:   {{$cpcordon->cordon_id}}</label>
                                </div>
                            </span>
                            <span id="descripcion">
                                <div class="form-group col-md-12">
                                    <label>Codigo Postal:  {{$cpcordon->cp}}</label>
                                </div>
                            </span>
                            <span id="detalle_servicio">
                                <div class="form-group col-md-12">
                                    <label>Localidad:  {{ $cpcordon->localidad }}</label>
                                </div>
                            </span>
                            <span id="activo">
                                <div class="form-group col-md-12">
                                    <label>Provincia: {{ $cpcordon->provincia }}</label>
                                </div>
                            </span>
                            <span id="activo">
                                <div class="form-group col-md-12">
                                    <label>Fecha Modificacion: {{ $cpcordon->updated_at }}</label>
                                </div>
                            </span>
                            <span id="activo">
                                <div class="form-group col-md-12">
                                    <label>Fecha Creacion: {{ $cpcordon->created_at }}</label>
                                </div>
                            </span>
                            <div class="form-group col-md-12">
                            <a href="{{route('cpCordon_index')}}" style="font-size: 16px;" type="button" id="search" class="btn btn-primary btn-sm">Volver</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>

@endsection
@section('js')
@routes
    <script type="text/javascript">
    
    function acciones(value, row){
        var url  ="{{route('servicioShow', '::')}}";
        url = url.replace('::', row.id);
        return '<a href="'+url+'" title="Ver" class="btn btn-warning ver btn-sm" id="'+row.id+'"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>';
    }
 
    function queryParams(params) {
        params._token = "{{csrf_token()}}";
        return params;
    }

    
    $(document).ready(function(){
        
        $table = $("#table");
        $table.bootstrapTable('refresh', {
            url: "{{route('ajaxUsers')}}"   
        });

        /*$('#table_usuarios').DataTable({
                "dom": 'T<"clear">lfrtip',
                "responsive": true,
                "ajax":'{{ route('ajaxUsers') }}',
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/a5734b29083/i18n/Spanish.json"
                },
                "columnDefs": [
                    {
                    "targets": 5,
                    "data": "id",
                    "render": function (data, type, full, meta) {
                        return "<a href="#"><i class='fa fa-sign-in fa-2x' title='Activar/Desactivar'></i></a><a href="#"><i class='fa fa-pencil-square-o fa-2x' title='Editar registro'></i> </a><a href="#"><i class='fa fa-eye fa-2x' title='Ver detalles'></i></a>";
                        }
                    },
                    {
                    "targets": 4,
                    "data": "activoShipro",
                    "render": function (data, type, row) {       
                        return (data === false) ? '<span class="activo glyphicon glyphicon-thumbs-down"></span>'  : '<span class="activo glyphicon glyphicon-thumbs-up"></span>';
                        },
                    
                    },
                    {
                    "targets": 0,
                    "data": "descripcion",
                    "render": function (data, type, row) {       
                         data = '<a href="../sucursal">' + data + '</a>';
                        return data;
                        }
                    
                    },
                    {
                    "targets": 4,
                    "data": "empresa",
                    "render": function (data, type, row) {       
                         data = '<a href="../cliente/index">' + data + '</a>';
                        return data;
                        }
                    
                    }
                    
                
                ],
                "columns": [
                    {
                        "data":"descripcion",
                        "defaultContent": "N/A"
                    },
                    {"data":"username"},
                    {
                        "data":"email",
                        "defaultContent": "N/A",
                        "target":2
                    },
                    {"data":"roles","target":3},
                    {
                        "data":"empresa",
                        "defaultContent": "N/A",
                        "target":4
                    },
                  
                ]

            });*/
    
    })
    </script>
@endsection



