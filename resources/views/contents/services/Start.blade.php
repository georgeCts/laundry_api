@section('title', 'Servicios')

@section('stylesheets')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tempus Dominus Styles -->
    <link href="https://cdn.jsdelivr.net/gh/Eonasdan/tempus-dominus@master/dist/css/tempus-dominus.css" rel="stylesheet" crossorigin="anonymous" />
@endsection

@section('content')
    {!! Form::open(['route' => 'start-service', 'method' => 'POST']) !!}
        <input type="hidden" name="serviceId" value="{{$objService->id}}" />

        <div class="row">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Configurar servicio #{{$objService->id}}</h4>
                        <p class="card-description">El servicio se iniciará con los detalles que se ingresen.</p>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="id_start_datetime">Fecha y Hora de finalizaci&oacute;n:</label>
                                    <div class='input-group' id='datetimepicker' data-td-target-input='nearest' data-td-target-toggle='nearest'>
                                        <input id='id_start_datetime' name="dateHourFinalized" type='text' class='form-control' data-td-target='#datetimepicker' required />
                                        <span class='input-group-text' style="cursor: pointer;" data-td-target='#datetimepicker' data-td-toggle='datetimepicker'>
                                            <span class='mdi mdi-calendar'></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="service_catalog">Cat&aacute;logo de servicios</label>
                                <select class="form-control form-control-sm" id="service_catalog">
                                    @foreach ($lstServices as $item)
                                        <option value="{{$item->id}}" data-service="{{$item->name_es}}" data-tipo="{{$item->unitType->name}}">{{$item->name_es}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="quantity">Cantidad</label>
                                <input class="form-control" type="number" step="1" min="1" max="99" id="quantity" value="1" />
                            </div>

                            <div class="col-md-2 align-self-center">
                                <a href="#" class="btn btn-info mr-2 addRow">Agregar</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="table-responsive">
                                <table id="tbServices" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cantidad</th>
                                            <th>Servicio</th>
                                            <th>Tipo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-success mr-2">Iniciar Servicio</button>
                                <a href="/panel/servicios/aceptados" role="button" class="btn btn-light">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" integrity="sha512-RXf+QSDCUQs5uwRKaDoXt55jygZZm2V++WUZduaU/Ui/9EGp3f/2KZVahFZBKGH0s774sd3HmrhUy+SgOFQLVQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Popperjs -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<!-- Tempus Dominus JavaScript -->
<script src="https://cdn.jsdelivr.net/gh/Eonasdan/tempus-dominus@master/dist/js/tempus-dominus.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/Eonasdan/tempus-dominus@master/dist/plugins/customDateFormat.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/Eonasdan/tempus-dominus@master/dist/js/jQuery-provider.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        tempusDominus.extend(window.tempusDominus.plugins.customDateFormat);
        const datetimepicker = new tempusDominus.TempusDominus(document.getElementById('datetimepicker'), {
            localization: {
                locale: 'es',
                format: 'dd/MM/yyyy HH:mm'
            },
            restrictions: {
                minDate: new Date(),
            },
            display: {
                icons: {
                    type: 'icons',
                    date: 'mdi mdi-calendar',
                    time: 'mdi mdi-clock',
                    up: 'mdi mdi-chevron-up',
                    down: 'mdi mdi-chevron-down',
                    previous: 'mdi mdi-arrow-left',
                    next: 'mdi mdi-arrow-right',
                },
                components: {
                    useTwentyfourHour: true
                },
            },
        });

        $('.addRow').on('click', function () {
            var serviceId = $("#service_catalog option:selected").val();
            var serviceName = $("#service_catalog option:selected").attr('data-service');
            var serviceType = $("#service_catalog option:selected").attr('data-tipo');
            var cantidad = $("#quantity").val();

            var addRow = '<tr>' +
                '<td><input type="text" name="quantity[]" class="form-control" value="'+cantidad+'" readonly /><input type="hidden" name="catalog[]" value="'+serviceId+'" /></td>' +
                '<td><input type="text" class="form-control" value="'+serviceName+'" readonly /></td>' +
                '<td><input type="text" class="form-control" value="'+serviceType+'" readonly /></td>' +
                '<td><a href="#" class="btn btn-danger remove"><i class="mdi mdi-close-circle"></i></a></td>' +
            '</tr>';
            $('tbody').append(addRow);
        });

        $("#tbServices").on('click', '.remove', function () {
            $(this).closest('tr').remove();
        });
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