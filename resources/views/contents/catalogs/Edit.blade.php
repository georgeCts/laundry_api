@section('title', 'Catálogos')

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

    {!! Form::open(['route' => 'update-catalog', 'method' => 'PUT', 'files' => true]) !!}
        <input type="hidden" id="hddIdProduct" name="hddIdCatalog" value="{{$objCatalog->id}}" />

        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Modificar catálogo</h4>
                        <p class="card-description">El catálogo modificado se mostrará en la página web</p>

                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del catálogo" value="{{$objCatalog->name}}" required />
                        </div>

                        <div class="form-group">
                            <label for="brand_id">Marca</label>
                            <select class="form-control form-control-sm" id="brand_id" name="brand_id" required>
                                @foreach ($lstBrands as $item)
                                    @if($item->id == $objCatalog->brand_id)
                                        <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                    @else
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Categoría</label>
                            <select class="form-control form-control-sm" id="category_id" name="category_id" required>
                                @foreach ($lstCategories as $item)
                                    @if ($item->id == $objCatalog->category_id)
                                        <option value="{{$item->id}}" selected>{{$item->name}}</option>
                                    @else
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endif
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
                                @if ($objCatalog->file != null)
                                    <img src="{{Storage::url($objCatalog->file)}}" alt="catálogo" style="width: 250px;" />
                                @endif
                                <p class="card-description">La imagen deben ser (200 x 250)</p>
                                <div class="form-group">
                                    <label>Imágen</label>
                                    <input type="file" name="image" class="form-control" />
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
                                    <input type="file" name="pdf" class="form-control" />
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