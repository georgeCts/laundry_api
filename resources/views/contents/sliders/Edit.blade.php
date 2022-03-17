@section('title', 'Sliders')

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

{!! Form::open(['route' => 'update-slider', 'method' => 'POST', 'files' => true]) !!}
    <input type="hidden" name="hddIdSlider" value="{{$objSlider->id}}" />

    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Modificar Slider</h4>
                    <p class="card-description">La imágen cargada se mostrará en el slider principal de la página web</p>
                    
                    <div class="form-group">
                        <label for="title">Título</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Título del slider" value="{{ $objSlider->title }}" />
                    </div>
                
                    <div class="form-group">
                        <label for="body">Contenido</label>
                        <textarea class="form-control" id="body" name="body" rows="2">{!! $objSlider->body !!}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="txtUrl">URL (Opcional)</label>
                        <input class="form-control" id="url_redirect" name="url_redirect" placeholder="http://www.dominio.com/ejemplo" />
                    </div>
                    
                    <button type="submit" class="btn btn-success mr-2">Guardar</button>
                    <button class="btn btn-light">Cancelar</button>
                </div>
            </div>
        </div>

        <div class="col-md-4 d-flex align-items-stretch grid-margin">
            <div class="row flex-grow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Imagen del Slider</h4>
                            @if ($objSlider->file != null)
                                    <img src="{{Storage::url($objSlider->file)}}" alt="imagen" style="width: 250px;" />
                                @endif
                            <p class="card-description">La imagen debe ser (1920 x 790)</p>
                            <div class="form-group">
                                <label>Imágen</label>
                                <input type="file" name="image" class="form-control" />
                            </div> 
                            
                            <hr />

                            <h4 class="card-title">Estatus</h4>
                            <p class="card-description">Selecciona el estatus que tendrá la publicación al ser creada</p>

                            <div class="form-group">
                                <div class="form-radio">
                                    <label class="form-check-label">
                                        @if($objSlider->status == 'PUBLISHED')
                                            <input type="radio" class="form-check-input" name="status" value="PUBLISHED" checked> Publicado
                                        @else
                                            <input type="radio" class="form-check-input" name="status" value="PUBLISHED"> Publicado
                                        @endif
                                    </label>
                                </div>
                                <div class="form-radio">
                                    <label class="form-check-label">
                                        @if($objSlider->status == 'DRAFT')
                                            <input type="radio" class="form-check-input" name="status" value="DRAFT" checked> Borrador
                                        @else
                                            <input type="radio" class="form-check-input" name="status" value="DRAFT"> Borrador
                                        @endif
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

@include('panel.components.Navbar')
@include('panel.components.Sidebar')
@include('panel.components.Footer')
@include('panel.components.Scripts')
@include('panel.components.Stylesheets')

@extends('panel.components.Main')