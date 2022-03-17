@section('title', 'Catalogos')

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

    {!! Form::open(['route' => 'new-catalog', 'method' => 'POST', 'files' => true]) !!}
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Crear catálogo</h4>
                        <p class="card-description">El catálogo creado se mostrará en la página web</p>
                        
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del catálogo" required />
                        </div>

                        <div class="form-group">
                            <label for="brand_id">Marca</label>
                            <select class="form-control form-control-sm" id="brand_id" name="brand_id" required>
                                @foreach ($lstBrands as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Categoría</label>
                            <select class="form-control form-control-sm" id="category_id" name="category_id" required>
                                @foreach ($lstCategories as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success mr-2">Guardar</button>
                        <a href="/panel/catalogos" role="button" class="btn btn-light">Cancelar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex align-items-stretch grid-margin">
                <div class="row flex-grow">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Imagen del catálogo</h4>
                                <p class="card-description">La imagen deben ser (200 x 250)</p>
                                <div class="form-group">
                                    <label>Imágen</label>
                                    <input type="file" name="image" class="form-control" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">PDF del catálogo</h4>
                                <p class="card-description">El tamaño máximo del archivo es 5MB</p>
                                <div class="form-group">
                                    <label>Archivo</label>
                                    <input type="file" name="pdf" class="form-control" required />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@include('panel.components.Navbar')
@include('panel.components.Sidebar')
@include('panel.components.Footer')
@include('panel.components.Scripts')
@include('panel.components.Stylesheets')

@extends('panel.components.Main')