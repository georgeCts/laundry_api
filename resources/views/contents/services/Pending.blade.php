@section('title', 'Servicios')

@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Servicios Pendientes</h4>
                    <p class="card-description">Lista de servicios que se encuentran pendientes de aceptar</p>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Tipo</th>
                                    <th>Dirección</th>
                                    <th>Fecha/Hora Solicitud</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lstServices as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>
                                            @if($item->user->is_guest)
                                                Invitado
                                            @else
                                                {{$item->user->name}} {{$item->user->last_name}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->express)
                                                <label class="badge badge-dark">Express</label>
                                            @else
                                                <label class="badge badge-info">Normal</label>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <a href="/panel/servicios/procesar/{{ $item->id }}/ACCEPTED" class="btn btn-sm btn-success">Aceptar</a>
                                            <a href="/panel/servicios/procesar/{{ $item->id }}/CANCELLED" class="btn btn-sm btn-danger">Cancelar</a>
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
@include('components.Alerts')
@include('components.Sidebar')
@include('components.Footer')
@include('components.Scripts')
@include('components.Stylesheets')

@extends('components.Main')