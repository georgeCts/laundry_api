@section('title', 'Marcas')

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
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Marcas</h4>
                    <p class="card-description">Lista de marcas existentes</p>
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Modelos registrados</th>
                                    <th>Fecha modificación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lstBrands as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ sizeOf($item->models)}}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <a href="/panel/brands/{{ $item->id }}/models" class="btn btn-sm btn-primary">Modelos</a>
                                            <a href="/panel/brands/brand-editar/{{ $item->id }}" class="btn btn-sm btn-warning">Editar</a>
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