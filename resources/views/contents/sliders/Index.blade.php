@section('title', 'Sliders')

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
                    <h4 class="card-title">Sliders</h4>
                    <p class="card-description">Entradas creadas en la página web</p>
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título</th>
                                    <th>Estatus</th>
                                    <th>Imágen</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lstSliders as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ (($item->title != null)?$item->title:'-') }}</td>
                                        <td>
                                            @if($item->status != 'PUBLISHED')
                                                <label class="badge badge-info">{{ $item->status }}</label>
                                            @else
                                                <label class="badge badge-success">{{ $item->status }}</label>
                                            @endif
                                        </td>
                                        <td class="py-1">
                                            <img src="{{ Storage::url($item->file) }}" alt="slider" />
                                        </td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <a href="/panel/sliders/slider-editar/{{ $item->id }}" class="btn btn-sm btn-warning">Editar</a>
                                            <a href="{{ Storage::url($item->file) }}" target="_blank" class="btn btn-sm btn-primary">Ver</a>
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