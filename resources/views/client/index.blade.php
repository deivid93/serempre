@extends('home')
@section('sub-content')
<div class="row">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div style="margin-left: 30px;">
        <a href="{{ route('client.new') }}" class="btn btn-success"><span style="margin-rigth:4px;" id="" class="glyphicon glyphicon-user"></span><span style="margin-left:10px;">Nuevos Clientes</span></a>
        <div class="clearboth">&nbsp;</div>
    </div>

    <div class="modal fade" id="base" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <form id="form" class="form-horizontal" >
                            <input name="_token" type="hidden" value="{{csrf_token()}}">
                            <div class="row">
                                <div class="form-group mb-4">
                                    <legend class="text-center header">1.Codigo</legend>
                                    <input id="id" name="id" type="hidden">
                                    <div class="row">
                                        <div class="col-6 offset-3 col align-column-center" >
                                            <input required id="codigo" name="codigo" type="text" placeholder="Codigo" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <legend class="text-center header">2.Nombre</legend>
                                    <div class="row">
                                        <div class="col-6 offset-3 col align-column-center" >
                                            <input required id="nombre" name="nombre" type="text" placeholder="Nombre" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <legend class="text-center header">3. Seleccione Ciudad</legend>
                                    <div class="row">
                                        <div class="col-6 offset-3 col align-column-center" >
                                            <select class="form-control" name="city" id="city">
                                                @foreach($ciudades as $c)
                                                    <option value="{{$c->id}}">{{$c->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <div class="row">
                                        <div class="col-6 offset-3 d-grid" >
                                            <button type="button" class="btn btn-primary update">Actualizar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body print">
        <div class="col-md-12">
            <form name="f1">
                <table id="client" class="table table-striped table-bordered bulk_action dt-responsive nowrap"
                        data-toggle="table"
                        data-height="460"
                        data-ajax="ajaxRequest"
                        data-pagination="true"
                        data-side-pagination="server"
                        data-page-list="[5, 10, 20, 50, 100, 200]"
                        data-search="true"
                        data-detail-formatter="detailFormatter"
                        data-detail-view="true"
                        data-click-to-select="true"
                        data-id-field="id"
                        data-response-handler="responseHandler"
                        >
                        <thead>
                            <tr>
                              <th data-field="id" data-sortable="true">Id</th>
                              <th data-field="cod" data-sortable="true" data-filter-control="select">Codigo</th>
                              <th data-field="name" data-sortable="true" data-filter-control="select">Nombre</th>
                              <th data-field="cities.name" data-sortable="true" data-filter-control="select">Ciudad</th>
                              <th data-field="updated_at" data-sortable="true" data-filter-control="select">Fecha Modificacion</th>
                              <th data-field="created_at" data-sortable="true" data-filter-control="select">Fecha Creacion</th>
                              <th data-formatter="acciones" data-events="window.operateEvents" >Acciones</th>
                            </tr>
                        </thead>
                    </table>
            </form>
        </div>
    </div>
</div>
@endsection
@section('js')
  <script type="text/javascript">
    $table = $("#client");
    var $remove = $('#remove')
    var selections = []

    //modal
    $("")
    function getIdSelections() {
        return $.map($table.bootstrapTable('getSelections'), function (row) {
            return row.id
        })
    }

    function ajaxRequest(params){
        var url = "{{route('client.ajax')}}"
        $.get(url + '?' + $.param(params.data)).then(function (res) {
            console.log(res);
            params.success(res)
        })
    }
    var cargarOn = function(op){
        var offset;
        if(op == 'delete'){
            var page = parseInt($(".active > .page-link").text()) - 1
            offset = page * 10 - 10
        }else{
            offset = 0
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
        });
        $.ajax({
            type: "GET",
            data: {offset: offset , limit:10},
            url: "{{route('client.ajax')}}",
            success: function(data)
            {
                $table.bootstrapTable('load', data);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
                alert('Error : ' + errorThrown);
            }
        });
    }
    function responseHandler(res) {
        $.each(res.rows, function (i, row) {
            row.state = $.inArray(row.id, selections) !== -1
        })
        return res
    }
    function detailFormatter(index, row) {
        var html = []
        $.each(row, function (key, value) {
            html.push('<p><b>' + key + ':</b> ' + value + '</p>')
        })
        return html.join('')
    }
    function acciones(value, row, index) {
        return [
            '<a class="edit" href="javascript:void(0)" title="Like" data-bs-toggle="modal" data-bs-target="#base" >',
            '<i class="bi bi-pencil-square"></i>',
            '</a>  ',
            '<a class="remove" href="javascript:void(0)" title="Remove">',
            '<i class="bi bi-trash"></i>',
            '</a>'
        ].join('')
    }

    window.operateEvents = {
        'click .edit': function(e, value,row, index){
            getCiudades(row);
            var modal = $("#base")
            $(".modal-title").text('Editar Clientes')
            $("#id").val(row.id)
            $("#codigo").val(row.cod)
            $("#nombre").val(row.name)
            $(".update").one('click', function(e){
                e.preventDefault()
               $.post('{{route('client.update')}}',$("#form").serialize(), function (res){
                    alert('datos actualizados con exito!')
                   cargarOn('update')
                   modal.modal('hide');
               })
            })
        },
        'click .remove': function(e, value, row, index){
            borrar(row.id)
            if(index == 0){
                cargarOn('delete');
            }
        }
    }
    function borrar(id){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{csrf_token()}}"
            }
        });
        $.ajax({
            url: "{{route('client.delete')}}",
            type: 'POST',
            data:{
                'id': id
            },
            success: function(data){
                alert(data.message)
                $table.bootstrapTable('remove', {
                    field: 'id',
                    values: [id]
                })
            },
            error: function(err){
                alert(err)
            }
        })
    }
    function getCiudades(row){
        var city = row.cities.name
        var ciudades = $("#city")[0];
        for (i=0;i<=ciudades.length -1; i++){
            if(ciudades[i].text == city){
                ciudades[i].setAttribute("selected","selected")
            }
        }

    }
    $(document).ready(function(){

    })
  </script>
@endsection
