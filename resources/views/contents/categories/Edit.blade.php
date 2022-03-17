@section('title', 'Categorias')

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

    {!! Form::open(['route' => 'update-category', 'method' => 'PUT', 'files' => true]) !!}
        <input type="hidden" name="hddIdCategory" value="{{$objCategory->id}}" />
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Modificar categoría</h4>
                        <p class="card-description">El categoría modificada se mostrará en la página web</p>
                        
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la categoría" value="{{$objCategory->name}}" required />
                        </div>

                        <div class="form-group">
                            <label for="slug">URL Amigable</label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="esto-es-un-ejemplo" value="{{$objCategory->slug}}" required />
                        </div>

                        <button type="submit" class="btn btn-success mr-2">Guardar</button>
                        <a href="/panel/categorias" role="button" class="btn btn-light">Cancelar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex align-items-stretch grid-margin">
                <div class="row flex-grow">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Imagen de la categoría</h4>
                                @if ($objCategory->file != null)
                                    <img src="{{Storage::url($objCategory->file)}}" alt="categoría" style="width: 250px;" />
                                @endif
                                <p class="card-description">La imagen deben ser (650 x 600)</p>
                                <div class="form-group">
                                    <label>Imágen</label>
                                    <input type="file" name="image" class="form-control" />
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
    <script src="{{ asset('assets/vendors/jquery-stringtoslug-1.3/jquery.stringToSlug.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#name, #slug").stringToSlug({
                callback: function(text) {
                    $("#slug").val(text);
                }
            })
        });
    </script>
@endsection

@include('panel.components.Navbar')
@include('panel.components.Sidebar')
@include('panel.components.Footer')
@include('panel.components.Scripts')
@include('panel.components.Stylesheets')

@extends('panel.components.Main')