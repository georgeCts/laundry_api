@section('title', 'Modelos')

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            @if(Session::has('success_message'))
                <div class="alert alert-success col-md-12 col-sm-12 alert-dismissible fade show" role="alert">
                    <strong>{{ Session::get('success_title' )}}!</strong> {{ Session::get('success_message' )}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>

        <div class="col-md-6 text-right mb-3">
            <a href="/panel/brands" class="btn btn-sm btn-info">Ver Marcas</a>
            <a href="/panel/brands/{{ $objBrand->id }}/models/model-crear" class="btn btn-sm btn-primary">Crear Modelo</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Modelos de la marca {{$objBrand->name}}</h4>
                    <p class="card-description">Lista de mmodelos existentes</p>
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Fecha modificación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lstModels as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <a href="{{ route('model.edit', ['id' => $item->id])}}" class="btn btn-sm btn-warning">Editar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('panel.components.Navbar')
@include('panel.components.Sidebar')
@include('panel.components.Footer')
@include('panel.components.Scripts')
@include('panel.components.Stylesheets')

@extends('panel.components.Main')