@section('title', 'Sucursales')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
        @if(Session::has('error_message'))
            <div class="alert alert-danger col-md-12 col-sm-12 alert-dismissible fade show" role="alert">
                <strong>{{ Session::get('error_title' )}}!</strong> {{ Session::get('error_message' )}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        </div>
    </div>

    {!! Form::open(['route' => 'update-location', 'method' => 'PUT']) !!}
        <input type="hidden" name="hddIdLocation" value="{{$objLocation->id}}" />
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Modificar sucursal</h4>
                        <p class="card-description">La sucursal modificada se mostrará en el listado de sucursales de la página web</p>
                        
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la sucursal" value="{{$objLocation->name}}" />
                        </div>

                        <div class="form-group">
                            <label for="address">Dirección</label>
                            <textarea class="form-control" id="address" name="address" rows="2" required>{{$objLocation->address}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="latitude">Latitud</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" placeholder="21.9876" value="{{$objLocation->latitude}}" />
                        </div>

                        <div class="form-group">
                            <label for="longitude">Longitud</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" placeholder="-89.1234" value="{{$objLocation->longitude}}" />
                        </div>

                        <div class="form-group">
                            <label for="phone">Teléfono</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="(999) 999-9999" value="{{$objLocation->phone}}" />
                        </div>

                        <div class="form-group">
                            <label for="whatsapp1">Whatsapp 1</label>
                            <input type="text" class="form-control" id="whatsapp1" name="whatsapp1" placeholder="(999) 999-9999" value="{{$objLocation->whatsapp1}}" />
                        </div>

                        <div class="form-group">
                            <label for="whatsapp2">Whatsapp 2</label>
                            <input type="text" class="form-control" id="whatsapp2" name="whatsapp2" placeholder="(999) 999-9999" value="{{$objLocation->whatsapp2}}" />
                        </div>

                        <button type="submit" class="btn btn-success mr-2">Guardar</button>
                        <a href="/panel/sucursales" role="button" class="btn btn-light">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection

@include('panel.components.Navbar')
@include('panel.components.Sidebar')
@include('panel.components.Footer')
@include('panel.components.Scripts')
@include('panel.components.Stylesheets')

@extends('panel.components.Main')