@section('title', 'Configuraciones')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if ($errors->any())
            <div class="alert alert-danger col-md-12 col-sm-12 alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
        </div>
    </div>

    {!! Form::open(['route' => 'update-configuration', 'method' => 'PUT']) !!}
        <input type="hidden" id="id" name="id" value="{{$objConfiguration->id}}" />

        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Editar configuraci&oacute;n</h4>
                        <p class="card-description">La configuraci&oacute;n editada afectar&aacute; la app</p>
                        
                        <div class="form-group">
                            <label for="key">Identificador</label>
                            <input type="text" class="form-control" id="key" name="key" value="{{$objConfiguration->key}}" required readonly />
                        </div>

                        <div class="form-group">
                            <label for="description">Descripci&oacute;n</label>
                            <input type="text" class="form-control" id="description" name="description" value="{{$objConfiguration->description}}" required readonly />
                        </div>

                        <div class="form-group">
                            <label for="value">Valor</label>
                            <input type="number" class="form-control" step=".01" min="0.01" id="value" name="value" placeholder="Valor de la configuración" value="{{$objConfiguration->value}}" required />
                        </div>

                        <button type="submit" class="btn btn-success mr-2">Guardar</button>
                        <a href="/panel/configuraciones" role="button" class="btn btn-light">Cancelar</a>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@include('components.Navbar')
@include('components.Sidebar')
@include('components.Footer')
@include('components.Scripts')
@include('components.Stylesheets')

@extends('components.Main')