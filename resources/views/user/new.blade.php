@extends('home')
@section('sub-content')
    <div class="container">
        <form id="form" class="form-horizontal" >
            <legend class="text-center header">
                <b>Listado</b>
            </legend>
            <div class="row">
                <div class="form-group mb-4">
                    <legend class="text-center header">1. Ingrese Nombre</legend>
                    <div class="row">
                        <div class="col-6 offset-3 col align-column-center" >
                            <input required id="name" name="name" type="text" placeholder="Nombre" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <legend class="text-center header">2. Ingrese Email</legend>
                    <div class="row">
                        <div class="col-6 offset-3 col align-column-center" >
                            <input required id="email" name="email" type="text" placeholder="Email" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <legend class="text-center header">3. Ingrese Password</legend>
                    <div class="row">
                        <div class="col-6 offset-3 col align-column-center" >
                            <input required id="password" name="password" type="text" placeholder="Password" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <legend class="text-center header">4. Seleccione Rol</legend>
                    <div class="row">
                        <div class="col-6 offset-3 col align-column-center" >
                            <select class="form-control" name="role" id="role" form="form" >
                                @foreach($roles as $r)
                                    <option value="{{$r->id}}">{{$r->name}}</option>
                                @endforeach
                            </select>
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
                    url: "{{ route('user.create') }}",
                    data: $("#form").serialize(),
                    success: function (response) {
                        $('#loading').hide();
                        alert(response.message);
                    }
                });
            });
        });
    </script>
@endsection








