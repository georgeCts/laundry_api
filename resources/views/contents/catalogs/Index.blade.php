@section('title', 'Catálogo de servicios')

@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
        @if(Session::has('success_message'))
            <div class="alert alert-success col-md-12 col-sm-12 alert-dismissible fade show" role="alert">
                {{ Session::get('success_message' )}}
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
                    <h4 class="card-title">Catálogo de servicios</h4>
                    <p class="card-description">
                        Lista de servicios que serán mostrados en la app
                        <a href="/panel/servicios-catalogo/crear" class="btn btn-sm btn-primary float-right"><i class="menu-icon mdi mdi-plus-circle"></i>Crear</a>
                    </p>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Unidad</th>
                                    <th>Nombre</th>
                                    <th>Precio básico</th>
                                    <th>Precio express</th>
                                    <th>Fecha modificación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lstServices as $item)
                                    <tr>
                                        <td>{{ $item->unitType->name }}</td>
                                        <td>{{ $item->name_es }}</td>
                                        <td>${{ number_format($item->basic_price, 2)}}</td>
                                        <td>${{ number_format($item->express_price, 2)}}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <a href="/panel/servicios-catalogo/editar/{{ $item->id }}" class="btn btn-sm btn-warning">Editar</a>
                                            <a href="/panel/servicios-catalogo/eliminar/{{ $item->id }}" class="btn btn-sm btn-danger">Eliminar</a>
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

@section('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready( function () {
            $('.table').DataTable({
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No se encontró información - vuelva a intentar",
                    "info": "Mostranto página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ total de registros)",
                    "search": "Buscar:",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Último",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    },
                }
            } );
        });
    </script>
@endsection

@include('components.Navbar')
@include('components.Sidebar')
@include('components.Footer')
@include('components.Scripts')
@include('components.Stylesheets')

@extends('components.Main')