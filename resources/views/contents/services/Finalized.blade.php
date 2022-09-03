@section('title', 'Servicios')

@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Servicios Finalizados y Cancelados</h4>
                    <p class="card-description">Lista de servicios que se encuentran finalizados y cancelados</p>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Direcci&oacute;n</th>
                                    <th>Referencias</th>
                                    <th>Estatus</th>
                                    <th>Total</th>
                                    <th>Fecha/Hora</th>
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
                                        <td>{{ $item->address }}</td>
                                        <td>{{ $item->reference }}</td>
                                        <td>
                                            @if($item->status == "FINISHED" && $item->delivered)
                                                <label class="badge badge-success">Finalizado</label>
                                            @endif

                                            @if($item->status == "FINISHED" && !$item->delivered)
                                                <label class="badge badge-warning">Falta entregar</label>
                                            @endif

                                            @if($item->cancelled)
                                                <label class="badge badge-danger">Cancelado</label>
                                            @endif
                                        </td>
                                        <td>${{ number_format($item->total, 2) }}</td>
                                        <td>
                                            @if($item->status == "FINISHED" && $item->delivered)
                                                Concluy&oacute;: <strong>{{ $item->dt_finalized }}</strong>
                                            @endif

                                            @if($item->status == "FINISHED" && !$item->delivered)
                                                -
                                            @endif

                                            @if($item->cancelled)
                                             Cancelado: <strong>{{ $item->dt_cancelled }}</strong>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status == "FINISHED" && !$item->delivered)
                                                <a href="/panel/servicios/procesar/{{ $item->id }}/FINISHED" class="btn btn-sm btn-success">Entregar servicio</a>
                                            @else
                                                -
                                            @endif
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