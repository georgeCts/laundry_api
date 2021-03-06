@section('title', 'Servicios')

@section('stylesheets')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Servicios Aceptados y En Progreso</h4>
                    <p class="card-description">Lista de servicios que se encuentran aceptados y en progreso</p>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Tipo</th>
                                    <th>Estatus</th>
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
                                        <td>
                                            @if($item->express)
                                                <label class="badge badge-dark">Express</label>
                                            @else
                                                <label class="badge badge-ligh">Normal</label>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status == "ACCEPTED")
                                                <label class="badge badge-success">Aceptado</label>
                                            @else
                                                <label class="badge badge-warning">En progreso</label>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status == "ACCEPTED")
                                                Solicitud: {{ $item->created_at }}
                                            @else
                                                Finalizaci&oacute;n: <strong>{{ $item->dt_end }}</strong>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status == "ACCEPTED")
                                                <a href="/panel/servicios/configurar/{{ $item->id }}" class="btn btn-sm btn-dark">Configurar solicitud</a>
                                            @else
                                                <a href="/panel/servicios/procesar/{{ $item->id }}/FINISHED" class="btn btn-sm btn-light">Finalizar servicio</a>
                                            @endif

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
                    "lengthMenu": "Mostrar _MENU_ registros por p??gina",
                    "zeroRecords": "No se encontr?? informaci??n - vuelva a intentar",
                    "info": "Mostranto p??gina _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ total de registros)",
                    "search": "Buscar:",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "??ltimo",
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