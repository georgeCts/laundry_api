@section('title', 'Catálogo de servicios')

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

    {!! Form::open(['route' => 'new-service-catalog', 'method' => 'POST']) !!}
        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Crear catálogo de servicio</h4>
                        <p class="card-description">El servicio creado se mostrará en la app</p>
                        
                        <div class="form-group">
                            <label for="name_es">Nombre (ES)</label>
                            <input type="text" class="form-control" id="name_es" name="name_es" placeholder="Nombre del servicio en español" required />
                        </div>

                        <div class="form-group">
                            <label for="name_en">Nombre (EN)</label>
                            <input type="text" class="form-control" id="name_en" name="name_en" placeholder="Nombre del servicio en inglés" required />
                        </div>

                        <div class="form-group">
                            <label for="basic_price">Precio básico</label>
                            <input type="number" class="form-control" step=".01" min="0.01" id="basic_price" name="basic_price" placeholder="Precio del servicio básico" required />
                        </div>

                        <div class="form-group">
                            <label for="express_price">Precio express</label>
                            <input type="number" class="form-control" step=".01" min="0.01" id="express_price" name="express_price" placeholder="Precio del servicio express" required />
                        </div>

                        <div class="form-group">
                            <label for="unit_type_id">Tipo de unidad</label>
                            <select class="form-control form-control-sm" id="unit_type_id" name="unit_type_id" required>
                                @foreach ($lstUnitTypes as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success mr-2">Guardar</button>
                        <a href="/panel/servicios-catalogo" role="button" class="btn btn-light">Cancelar</a>
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