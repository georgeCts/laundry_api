@section('title', 'Productos')

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

    {!! Form::open(['route' => 'new-product', 'method' => 'POST', 'files' => true]) !!}
        <div class="row" id="panel-product-app">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Crear producto</h4>
                        <p class="card-description">El producto creado se mostrará en el catálogo de productos de la página web</p>
                        
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del producto" required />
                        </div>

                        <div class="form-group">
                            <label for="part_number">SKU</label>
                            <input type="text" class="form-control" id="part_number" name="part_number" placeholder="Número de parte" required />
                        </div>
                        
                        <div class="form-group">
                            <label for="brand_id">Marca</label>
                            <select class="form-control form-control-sm" id="brand_id" name="brand_id" v-model="brand_id">
                                <option value="0" selected> - </option>
                                <template v-for="brand in brands">
                                    <option :key="brand.id" :value="brand.id">@{{brand.name}}</option>
                                </template>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="brand_model_id">Modelo</label>
                            <select class="form-control form-control-sm" id="brand_model_id" name="brand_model_id" v-model="brand_model_id">
                                <option value="0" selected> - </option>
                                <template v-for="model in models">
                                    <option :key="model.id" :value="model.id">@{{model.name}}</option>
                                </template>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="product_year_id">Año</label>
                            <select class="form-control form-control-sm" id="product_year_id" name="product_year_id" v-model="product_year">
                                <option value="0" selected> - </option>
                                <template v-for="item in years">
                                    <option :key="item.id" :value="item.id">@{{item.year}}</option>
                                </template>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="product_engine_id">Motor</label>
                            <select class="form-control form-control-sm" id="product_engine_id" name="product_engine_id" v-model="product_engine">
                                <option value="0" selected> - </option>
                                <template v-for="item in engines">
                                    <option :key="item.id" :value="item.id">@{{item.engine}}</option>
                                </template>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea class="form-control" id="description" name="description" rows="5"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success mr-2">Guardar</button>
                        <a href="/panel/productos" role="button" class="btn btn-light">Cancelar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 d-flex align-items-stretch grid-margin">
                <div class="row flex-grow">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Imagen del producto</h4>
                                <p class="card-description">La imagen deben ser (250 x 80)</p>
                                <div class="form-group">
                                    <label>Imágen</label>
                                    <input type="file" name="image" class="form-control" required />
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