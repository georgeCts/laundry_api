@section('title', 'Marcas de prestigio')

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

    {!! Form::open(['route' => 'new-prestige-brand', 'method' => 'POST', 'files' => true]) !!}
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Crear Marca de prestigio</h4>
                        <p class="card-description">La marca de prestigio creada se mostrará en el slider de marcas de la página web</p>
                        
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la marca" />
                        </div>

                        <button type="submit" class="btn btn-success mr-2">Guardar</button>
                        <a href="/panel/marcas-prestigio" role="button" class="btn btn-light">Cancelar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex align-items-stretch grid-margin">
                <div class="row flex-grow">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Imagen de la marca</h4>
                                <p class="card-description">La imagen deben ser (250 x 80)</p>
                                <div class="form-group">
                                    <label>Imágen</label>
                                    <input type="file" name="image" class="form-control" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Estatus</h4>
                                <p class="card-description">Selecciona el estatus que tendrá la marca al ser creada</p>

                                <div class="form-group">
                                    <div class="form-radio">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="status" value="PUBLISHED" checked> Publicado
                                        </label>
                                    </div>
                                    <div class="form-radio">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="status" value="DRAFT"> Borrador
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
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